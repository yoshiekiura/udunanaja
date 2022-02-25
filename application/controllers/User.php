<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function index()
    {
        $this->Authentication->is_login();
        $email = $this->session->userdata('email');
        $search_data = $this->db->query("SELECT * FROM patungan WHERE email='$email' ORDER BY id DESC LIMIT 10")->result_array();
        
        $data = [
            'title' => "Dashboard - UdunanAja",
            'navbar' => 'home',
            'history'=>$search_data,
            'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function udunan()
    {
        $this->Authentication->is_login();
        $rules = [
            [
                'field' => 'nama_udunan',
                'label' => 'Nama Udunan',
                'rules' => 'required|min_length[3]|max_length[100]|alpha_numeric_spaces|is_unique[patungan.judul]',
                'errors' => [
                    'required' => '{field} Harus diisi ya.',
                    'min_length' => '{field} Minimal 6 Karakter.',
                    'max_length' => '{field} Maximal 50 Karakter.',
                    'alpha_numeric_spaces' => '{field} Karakter Spesial Tidak Di Izinkan !.',
                    'is_unique' => '{field} sudah digunakan oleh user lain.',
                ]
            ],
            [
                'field' => 'keterangan',
                'label' => 'Keterangan',
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => '{field} Harus diisi ya.',
                    'min_length' => '{field} Minimal 6 Karakter.',
                ]
            ],
            [
                'field' => 'nominal',
                'label' => 'Nominal',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} Harus diisi ya.',
                    'numeric' => '{field} Harap Isi Oleh Angka Saja.',
                ]
            ],
            [
                'field' => 'jumlah',
                'label' => 'Jumlah',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} Harus diisi ya.',
                    'numeric' => '{field} Harap Isi Oleh Angka Saja.',
                ]
            ],
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == false) {
            $data = [
                'title' => "Udunan - UdunanAja",
                'navbar' => 'wallet',
                'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
            ];
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('user/udunan', $data);
            $this->load->view('templates/footer');
        } else {
            $slug = str_replace(" ", "-", strtolower(htmlspecialchars($this->input->post('nama_udunan', true))));
            $data = [
                'email' => htmlspecialchars($this->session->userdata('email')),
                'slug' => $slug,
                'judul' => htmlspecialchars($this->input->post('nama_udunan', true)),
                'keterangan' =>  htmlspecialchars($this->input->post('keterangan', true)),
                'nominal' => htmlspecialchars($this->input->post('nominal', true)),
                'terkumpul' => 0,
                'max_user' => htmlspecialchars($this->input->post('jumlah', true)),
                'status' => 'active',
                'created_at' => date("Y-m-d H:i:s"),
            ];

            if ($this->db->insert('patungan', $data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Patungan Baru Berhasil Di Buat !</div>');
                redirect('share/' . $slug);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Terjadi Kesalahan Saat Pembuatan patungan!</div>');
            }
        }
    }

    public function share($slug)
    {
        $this->Authentication->is_login();
        $data_slug = $this->db->get_where('patungan', ['slug' => $slug])->row_array();
        if (!$data_slug and $data_slug['email'] == $this->session->userdata('email')) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">kode patungan tidak valid!</div>');
            redirect('user/udunan');
        } else {
            $data = [
                'title' => "Dashboard - UdunanAja",
                'navbar' => 'wallet',
                'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
                'campaign' => $data_slug
            ];
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('user/share-udunan', $data);
            $this->load->view('templates/footer');
        }
    }
    public function profile()
    {
        $this->Authentication->is_login();

        if ($this->input->post('save_profile', true)) {
            $id = html_escape($this->input->post('id', true));
            $name = html_escape($this->input->post('name', true));
            $email = html_escape($this->input->post('email', true));
            $phone = html_escape($this->input->post('phone', true));
            $data_user = $this->db->query("SELECT * FROM user WHERE id='$id'")->row_array();
            if (!$data_user) {
                $this->session->set_flashdata('message', '<br /><div class="alert alert-danger" role="alert"> Kesalahan Kode Refference! </div>');
                redirect("user/profile");
            } else {
                if ($this->db->update("user", ['name' => $name, 'email' => $email, 'phone' => $phone, 'updated_at' => date("Y-m-d H:i:s")], "id='$id'")) {
                    $this->session->set_flashdata('message', '<br /><div class="alert alert-success" role="alert"> Informasi Profile Anda Berhasil Di Update! </div>');
                    redirect("user/profile");
                }
            }
        }

        $data = [
            'title' => "Profile - UdunanAja",
            'navbar' => 'profile',
            'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('user/profile', $data);
        $this->load->view('templates/footer');
    }

    public function edit_profile($reffid)
    {
        $this->Authentication->is_login();
        $reffid = base64_decode($reffid);
        $search_data = $this->db->query("SELECT * FROM user WHERE id='$reffid'")->row_array();
        if ($this->input->is_ajax_request() == false) {
            echo "no direct script access allowed";
            die();
        } else if (!$search_data) {
            echo "no direct script access allowed";
            die();
        } else {
            $data = [
                'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
            ];
            $this->load->view('user/edit-profile', $data);
        }
    }
}
