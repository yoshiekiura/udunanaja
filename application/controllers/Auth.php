<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {

        $this->Authentication->check_login();
        $rules = [
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|min_length[6]|max_length[50]|valid_email',
                'errors' => [
                    'required' => '{field} Harus diisi ya.',
                    'min_length' => '{field} Minimal 6 Karakter.',
                    'max_length' => '{field} Maximal 50 Karakter.',
                    'valid_email' => '{field} harus di isi dengan benar.',
                ]
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|min_length[6]|max_length[200]',
                'errors' => [
                    'required' => '{field} Harus diisi ya.',
                    'min_length' => '{field} Minimal 6 Karakter.',
                    'max_length' => '{field} Maximal 200 Karakter.',
                ]
            ],
        ];
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == false) {
            $data = ['title' => "Login - UdunanAja"];
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            //validasi sukses

            $email = $this->input->post('email', true);
            $password = $this->input->post('password');

            $user = $this->db->get_where('user', ['email' => $email])->row_array();
            if ($user) {
                if ($user['status'] == 'active') {

                    //cek password
                    if (password_verify($password, $user['password'])) {
                        $data = [
                            'email' => $user['email'],
                            'phone' => $user['phone'],
                            'name' => $user['name'],
                            'role_id' => $user['role_id']
                        ];

                        $this->session->set_userdata($data);
                        redirect('user');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Password Salah !</div>');
                        redirect('auth');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Akun Belum di aktivasi !</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> User tidak ditemukan !</div>');
                redirect('auth');
            }
        }
    }

    public function registration()
    {
        $this->Authentication->check_login();
        $rules = [
            [
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|min_length[3]|max_length[25]|alpha_numeric_spaces',
                'errors' => [
                    'required' => 'Nama Harus diisi ya.',
                    'min_length' => 'Nama Minimal 3 Karakter.',
                    'max_length' => 'Nama Maximal 25 Karakter.',
                    'alpha_numeric_spaces' => 'Nama hanya dapat diisi oleh Huruf saja.',
                ]
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[user.email]',
                'errors' => [
                    'required' => '{field} Harus diisi ya.',
                    'min_length' => '{field} Minimal 6 Karakter.',
                    'max_length' => '{field} Maximal 50 Karakter.',
                    'valid_email' => '{field} harus di isi dengan benar.',
                    'is_unique' => '{field} sudah digunakan pengguna lain,coba yang lain ya.',
                ]
            ],
            [
                'field' => 'phone',
                'label' => 'Phone',
                'rules' => 'required|min_length[6]|max_length[15]|is_unique[user.phone]|numeric',
                'errors' => [
                    'required' => '{field} Harus diisi ya.',
                    'min_length' => '{field} Minimal 6 Karakter.',
                    'max_length' => '{field} Maximal 50 Karakter.',
                    'is_unique' => '{field} sudah digunakan pengguna lain,coba yang lain ya.',
                    'numeric' => '{field} hanya boleh diisi oleh angka saja.',
                ]
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|min_length[6]|max_length[200]',
                'errors' => [
                    'required' => '{field} Harus diisi ya.',
                    'min_length' => '{field} Minimal 6 Karakter.',
                    'max_length' => '{field} Maximal 200 Karakter.',
                ]
            ],

            [
                'field' => 'confirm_password',
                'label' => 'Konfirmasi Password',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi Password Harus diisi ya.',
                    'matches' => 'Konfirmasi Password wajib sama dengan password yang di masukan.',
                ]
            ],
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == false) {
            $data = ['title' => "Registration - UdunanAja"];
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $phone = $this->Helper->filter_phone('62', htmlspecialchars($this->input->post('phone', true)));
            $email = htmlspecialchars($this->input->post('email', true));
            if ($this->db->get_where("user", ['phone' => $phone])->num_rows() > 0) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Nomer Telfon sudah digunakan user lain!</div>');
                redirect('auth/register');
            } else if ($this->db->get_where("user", ['email' => $email])->num_rows() > 0) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email sudah digunakan user lain!</div>');
                redirect('auth/register');
            } else {
                $data = [
                    'name' => htmlspecialchars($this->input->post('name', true)),
                    'email' => $email,
                    'phone' => $phone,
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'role_id' => 2,
                    'status' => 'not active',
                    'balance' => 0,
                ];

                //token generate
                $token = sha1(random_bytes(32));
                $user_token = [
                    'email' => htmlspecialchars($this->input->post('email', true)),
                    'token' => $token
                ];
                $data_user = [
                        'token' => $token,
                        'user' => $data
                    ];
                $data_smtp = [
                        'to' => $email,
                        'subject' => "Activate Your Account - UdunanAja!",
                        'message' => $this->load->view("email/activation", $data_user,TRUE),
                    ];
                $insert = $this->db->insert('user', $data);
                $insert = $this->db->insert('user_token', $user_token);
                if ($insert) {
                    if ($this->Authentication->sendEmailcustom($data_smtp)) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Akun Anda Berhasil di Daftarkan!. Silahkan Cek Email untuk Verifikasi Akun !</div>');
                        redirect('auth');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">SMTP Error !</div>');
                        redirect('auth');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Akun Anda Gagal di Daftarkan!. Silahkan Hub Admin </div>');
                    redirect('auth');
                }
            }
        }
    }

    public function verify($token = false)
    {
        $email = $this->db->get_where('user_token', ['token' => $token])->row_array()['email'];
        if ($this->session->userdata('email') == false) {
            $user = $this->db->get_where('user', ['email' => $email])->row_array();
            if ($user) {
                $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
                if ($user_token) {
                    $this->db->set('status', 'active');
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $this->db->delete('user_token', ['token' => $token]);

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $email . ' Berhasil di Aktifasi!,Silahkan Login !.</div>');
                    redirect('auth');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal Aktivasi, Token tidak dikenal</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Email user Tidak Ditemukan! </div>');
                redirect('auth');
            }
        } else {
            redirect('user');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('phone');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Anda Berhasil Logout !</div>');
        redirect('auth');
    }

    public function forgot_password()
    {

        $this->Authentication->check_login();
        $rules = [
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|min_length[6]|max_length[50]|valid_email',
                'errors' => [
                    'required' => '{field} Harus diisi ya.',
                    'min_length' => '{field} Minimal 6 Karakter.',
                    'max_length' => '{field} Maximal 50 Karakter.',
                    'valid_email' => '{field} harus di isi dengan benar.',
                ]
            ]
        ];
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == false) {
            $data = ['title' => "Lupa Password - UdunanAja"];
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgot-password');
            $this->load->view('templates/auth_footer');
        } else {
            //jika validasi sukses
            $email = htmlspecialchars($this->input->post('email', true));
            $user = $this->db->get_where('user', ['email' => $email])->row_array();
            if ($user) {
                if ($user['status'] == "active") {
                    $token = sha1(random_bytes(32));
                    $data = [
                        'email' => $email,
                        'token' => $token,
                    ];
                    $data_user = [
                        'token' => $token,
                        'user' => $user
                    ];

                    $data_smtp = [
                        'to' => $email,
                        'subject' => "Reset Password - UdunanAja!",
                        'message' => $this->load->view("email/reset-password", $data_user,TRUE),
                    ];
                    if ($this->Authentication->sendEmailcustom($data_smtp) && $this->db->insert('user_token', $data)) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Silahkan Cek Email Anda Untuk Melanjutkan Proses Reset Password!.</div>');
                        redirect('auth/forgot_password');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Terjadi Kesalahan dengan Email Service!.</br>Silahkan Kontak Admin</div>');
                        redirect('auth/forgot_password');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> ' . $email . ' Belum di Aktivasi!.</br>Silahkan Aktivasi Dulu Akun Anda. </div>');
                    redirect('auth/forgot_password');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $email . 'Tidak Ditemukan!.</br>Silahkan cek Kembali. </div>');
                redirect('auth/forgot_password');
            }
        }
    }

    public function reset($token = false)
    {
        $data_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
        $this->Authentication->check_login();
        $rules = [
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|min_length[6]|max_length[200]',
                'errors' => [
                    'required' => '{field} Harus diisi ya.',
                    'min_length' => '{field} Minimal 6 Karakter.',
                    'max_length' => '{field} Maximal 200 Karakter.',
                ]
            ],

            [
                'field' => 'confirm_password',
                'label' => 'Konfirmasi Password',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi Password Harus diisi ya.',
                    'matches' => 'Konfirmasi Password wajib sama dengan password yang di masukan.',
                ]
            ],
        ];
        $this->form_validation->set_rules($rules);
        if (!$token || !$data_token) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Kesalahan Token !</div>');
            redirect('auth');
        } else {
            if ($this->form_validation->run() == false) {
                $data = ['title' => "New Password - UdunanAja"];
                $this->load->view('templates/auth_header', $data);
                $this->load->view('auth/reset');
                $this->load->view('templates/auth_footer');
            } else {
                //jika validasi sukses
                $password = htmlspecialchars($this->input->post('password', true));
                $new_password = password_hash($password, PASSWORD_DEFAULT);
                $this->db->set('password', $new_password);
                $this->db->where('email', $data_token['email']);
                $this->db->update('user');

                $this->db->delete('user_token', ['token' => $token]);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Password berhasil diganti.</br> Silahkan Login!</div>');
                redirect('auth');
            }
        }
    }
}
