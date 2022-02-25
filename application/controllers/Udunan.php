<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Udunan extends CI_Controller
{
    public function index(){
        redirect('/');
    }
    public function history()
    {
        $this->Authentication->is_login();
        $email = $this->session->userdata('email');
        $serch = false;
        if ($this->input->post('search', true)) {
            $serch = html_escape($this->input->post('search', true));

            $search_data = $this->db->query("SELECT * FROM patungan WHERE email='$email' AND judul LIKE '%$serch%' ORDER BY id DESC")->result_array();
        } else {
            $search_data = $this->db->query("SELECT * FROM patungan WHERE email='$email'  ORDER BY id DESC")->result_array();
        }


        //EDIT USER HISTORY
            if($this->input->post('save_history', true)){
                $tid=html_escape($this->input->post('reffid', true));
                $status_update=html_escape($this->input->post('status', true));
                $max_user=html_escape($this->input->post('max_user', true));
                $nominal=html_escape($this->input->post('nominal', true));
                $data_patungan = $this->db->query("SELECT * FROM patungan WHERE id='$tid'")->row_array();
                if(!$data_patungan){
                $this->session->set_flashdata('message', '<br /><div class="alert alert-danger" role="alert"> Kesalahan Kode Refference! </div>');
                redirect("udunan/history");
                }else{
                    if($this->db->update("patungan",['status'=>$status_update,'max_user'=>$max_user,'nominal'=>$nominal,'updated_at'=> date("Y-m-d H:i:s")],"id='$tid'")){
                        $this->session->set_flashdata('message', '<br /><div class="alert alert-success" role="alert"> Judul : '.$data_patungan['judul'].'<br />Max User : '.$max_user.'<br />Nominal Udunan : Rp '.number_format($nominal).'<br />Berhasil  Update Status ke <strong>'.strtoupper($status_update).'</strong></div>');
                        redirect("udunan/history");
                    }
                }
            }
        $data = [
            'title' => "History Udunan - UdunanAja",
            'navbar' => 'history',
            'history' => $search_data,
            'search' => $serch,
            'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('udunan/history', $data);
        $this->load->view('templates/footer');
    }

    public function detail($reffid)
    {
        $this->Authentication->is_login();
        $email = $this->session->userdata('email');
        $reffid_encrypt = $reffid;
        $reffid = base64_decode($reffid);
        $serch = false;
        if (!$this->db->query("SELECT * FROM patungan_user WHERE patungan_id='$reffid'")->result_array()) {
            $this->session->set_flashdata('message', '<br /><div class="alert alert-danger" role="alert"> Belum Ada User Yang Mengikuti Udunan </div>');
            redirect("udunan/history");
        } else {
            if ($this->input->post('search', true)) {
                $serch = html_escape($this->input->post('search', true));
                $search_data = $this->db->query("SELECT * FROM patungan_user WHERE patungan_id='$reffid' AND (name LIKE '%$serch%' OR reffid LIKE '%$serch%')")->result_array();
            } else {
                $search_data = $this->db->query("SELECT * FROM patungan_user WHERE patungan_id='$reffid'")->result_array();
            }
            
            
            //EDIT USER HISTORY
            if($this->input->post('save_history_user', true)){
                $tid=html_escape($this->input->post('reffid', true));
                $status_update=html_escape($this->input->post('status', true));
                $data_patungan = $this->db->query("SELECT * FROM patungan_user WHERE reffid='$tid'")->row_array();
                if(!$data_patungan){
                $this->session->set_flashdata('message', '<br /><div class="alert alert-danger" role="alert"> Kesalahan Kode Refference! </div>');
                redirect("udunan/detail/$reffid_encrypt");
                }else{
                    if($this->db->update("patungan_user",['status'=>$status_update,'updated_at'=> date("Y-m-d H:i:s")],"reffid='$tid'")){
                        $this->session->set_flashdata('message', '<br /><div class="alert alert-success" role="alert"> User : '.$data_patungan['name'].'<br />Berhasil  Update Status ke <strong>'.$status_update.'</strong></div>');
                        redirect("udunan/detail/$reffid_encrypt");
                    }
                }
            }
            
            //DELETE USER HISTORY
             if($this->input->post('delete_history_user', true)){
                $tid=html_escape($this->input->post('reffid', true));
                $data_patungan = $this->db->query("SELECT * FROM patungan_user WHERE reffid='$tid'")->row_array();
                if(!$data_patungan){
                $this->session->set_flashdata('message', '<br /><div class="alert alert-danger" role="alert"> Kesalahan Kode Refference! </div>');
                redirect("udunan/detail/$reffid_encrypt");
                }else{
                    if($this->db->delete('patungan_user', ['reffid' => $tid])){
                        $this->session->set_flashdata('message', '<br /><div class="alert alert-success" role="alert"> User : '.$data_patungan['name'].'<br />Berhasil  <strong>Dihapus</strong> !</div>');
                        redirect("udunan/detail/$reffid_encrypt");
                    }
                }
            }
            
            $data = [
                'title' => "Detail Udunan- UdunanAja",
                'navbar' => 'history',
                'history' => $search_data,
                'search' => $serch,
                'patungan' => $this->db->get_where("patungan", ['id' => $reffid])->row_array(),
                'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
            ];
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('udunan/detail', $data);
            $this->load->view('templates/footer');
        }
    }

    public function detail_user($reffid)
    {
        $this->Authentication->is_login();
        $reffid = base64_decode($reffid);
        $search_data = $this->db->query("SELECT * FROM patungan_user WHERE id='$reffid'")->row_array();
        if ($this->input->is_ajax_request() == false) {
            echo "no direct script access allowed";
            die();
        } else if (!$search_data) {
            echo "no direct script access allowed";
            die();
        } else {
            $data = [
                'title' => "Detail - UdunanAja",
                'navbar' => 'history',
                'history' => $search_data,
                'patungan' => $this->db->get_where("patungan", ['id' => $reffid])->row_array(),
                'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
            ];
            $this->load->view('udunan/detail-history-user', $data);
        }
    }
    
     public function edit_user($reffid)
    {
        $this->Authentication->is_login();
        $reffid = base64_decode($reffid);
        $search_data = $this->db->query("SELECT * FROM patungan_user WHERE id='$reffid'")->row_array();
        if ($this->input->is_ajax_request() == false) {
            echo "no direct script access allowed";
            die();
        } else if (!$search_data) {
            echo "no direct script access allowed";
            die();
        } else {
            $data = [
                'title' => "Detail - UdunanAja",
                'navbar' => 'history',
                'history' => $search_data,
                'patungan' => $this->db->get_where("patungan", ['id' => $reffid])->row_array(),
                'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
            ];
            $this->load->view('udunan/edit-history-user', $data);
        }
    }
         public function delete_user($reffid)
    {
        $this->Authentication->is_login();
        $reffid = base64_decode($reffid);
        $search_data = $this->db->query("SELECT * FROM patungan_user WHERE id='$reffid'")->row_array();
        if ($this->input->is_ajax_request() == false) {
            echo "no direct script access allowed";
            die();
        } else if (!$search_data) {
            echo "no direct script access allowed";
            die();
        } else {
            $data = [
                'title' => "Detail - UdunanAja",
                'navbar' => 'history',
                'history' => $search_data,
                'patungan' => $this->db->get_where("patungan", ['id' => $reffid])->row_array(),
                'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
            ];
            $this->load->view('udunan/delete-history-user', $data);
        }
    }
    
      public function edit_history($reffid)
    {
        $this->Authentication->is_login();
        $reffid = base64_decode($reffid);
        $search_data = $this->db->query("SELECT * FROM patungan WHERE id='$reffid'")->row_array();
        if ($this->input->is_ajax_request() == false) {
            echo "no direct script access allowed";
            die();
        } else if (!$search_data) {
            echo "no direct script access allowed";
            die();
        } else {
            $data = [
                'history' => $search_data,
                'patungan' => $this->db->get_where("patungan", ['id' => $reffid])->row_array(),
                'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
            ];
            $this->load->view('udunan/edit-history', $data);
        }
    }
    
        public function detail_history($reffid)
    {
        $this->Authentication->is_login();
        $reffid = base64_decode($reffid);
        $search_data = $this->db->query("SELECT * FROM patungan WHERE id='$reffid'")->row_array();
        if ($this->input->is_ajax_request() == false) {
            echo "no direct script access allowed";
            die();
        } else if (!$search_data) {
            echo "no direct script access allowed";
            die();
        } else {
            $data = [
                'title' => "Detail - UdunanAja",
                'navbar' => 'history',
                'history' => $search_data,
                'join_user'=>$this->db->query("SELECT * FROM patungan_user WHERE patungan_id='$reffid'")->num_rows(),
                'patungan' => $this->db->get_where("patungan", ['id' => $reffid])->row_array(),
                'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
            ];
            $this->load->view('udunan/detail-history', $data);
        }
    }
}
