<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Helper extends CI_Model
{
    function check_image()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        if ($this->form_validation->valid_url($data['user']['image']) == false) {
            return base_url('assets/img/profile/') . $data['user']['image'];
        } else {
            return $data['user']['image'];
        }
    }

    function update_status_user($id, $status = 'unpaid')
    {
        $this->db->set('status', $status);
        $this->db->where('id', $id);
        if ($this->db->update('patungan_user')) {
            return true;
        } else {
            return false;
        }
    }

    function log_callback($data)
    {
        file_put_contents('.respon_payment', $data . "\n", FILE_APPEND);
    }
    function log_request($data)
    {
        return $this->db->insert('log_request', $data);
    }
    function get_method_name($shortkode)
    {
        return $this->db->get_where("withdraw_method", ['short_kode' => $shortkode])->row_array()['name'];
    }

    function filter_phone($type, $number)
    {
        $phone = preg_replace("/[^0-9]/", '', html_escape($number));
        if ($type == '0') {
            if (substr($phone, 0, 3) == '+62') {
                $change = '0' . substr($phone, 3);
            } else if (substr($phone, 0, 2) == '62') {
                $change = '0' . substr($phone, 2);
            } else if (substr($phone, 0, 1) == '0') {
                $change = $phone;
            }
        } else {
            if (substr($phone, 0, 3) == '+62') {
                $change = substr($phone, 1);
            } else if (substr($phone, 0, 2) == '62') {
                $change = $phone;
            } else if (substr($phone, 0, 1) == '0') {
                $change = '62' . substr($phone, 1);
            } else {
                $change = false;
            }
        }
        return $change;
    }

    function check_role($role_id)
    {
        return $this->db->get_where("user_role", ['id' => $role_id])->row_array()['role'];
    }

    function user_email($email)
    {
        return $this->db->get_where("user", ['email' => $email])->row_array();
    }
}
