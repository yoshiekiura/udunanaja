<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Authentication extends CI_Model
{
    function sendEmail($token, $type)
    {
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.mailketing.id',
            'smtp_user' => 'mailketing5964',
            'smtp_pass' => 'Aigd2q09',
            'smtp_port' => 587,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n",
        ];

        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->from('no-reply@udunanaja.com', 'UdunanAja!');
        $this->email->to($this->input->post('email',true));
        if ($type == 'verify') {
            $this->email->subject('Account Verification !');
            $url_verification = base_url() . 'verify/' . urlencode($token);
            $this->email->message('Click This Link to verify Your account : <a href="' . $url_verification . '">Activate Here!</a> ');
        } else if ($type == 'reset') {
            $this->email->subject('Reset Password - UdunanAja');
            $url_verification = base_url() . 'reset/' .  urlencode($token);
            $this->email->message('Click This Link to Reset Your Password : <a href="' . $url_verification . '">Reset Now!</a><br />Please ignore this email if you did not reset your password ');
        }

        if ($this->email->send()) {
            return true;
        } else {
            return false;
        }
    }

    function sendEmailcustom($data)
    {
        
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.mailketing.id',
            'smtp_user' => 'mailketing5964',
            'smtp_pass' => 'Aigd2q09',
            'smtp_port' => 587,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n",
        ];

        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->from('no-reply@udunanaja.com', 'UdunanAja!');
        $this->email->to($data['to']);
        $this->email->subject($data['subject']);
        $this->email->message($data['message']);
        if ($this->email->send()) {
            return true;
        } else {
            return false;
        }
    }
    function is_login()
    {
        if ($this->session->userdata('email') == False) {
            redirect('auth');
        }
    }

    function check_login()
    {
        if ($this->session->userdata('email') == True) {
            redirect('user');
        }
    }
    function is_admin()
    {
        if ($this->session->userdata('email') == False) {
            redirect('auth');
        } else if ($this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()['role_id'] <> 1) {
            redirect('user');
        }
    }

    function data_user()
    {
        $this->is_login();
        return $this->db->get_where("user", ['email' => $this->session->userdata('email')])->result_array();
    }
}
