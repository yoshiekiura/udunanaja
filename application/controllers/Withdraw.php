<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Withdraw extends CI_Controller
{
    public function index()
    {
        $this->Authentication->is_login();
        $rules = [
            [
                'field' => 'keterangan',
                'label' => 'Keterangan',
                'rules' => 'required|min_length[3]|max_length[100]|alpha_numeric_spaces',
                'errors' => [
                    'required' => '{field} Harus diisi ya.',
                    'min_length' => '{field} Minimal 6 Karakter.',
                    'max_length' => '{field} Maximal 50 Karakter.',
                    'alpha_numeric_spaces' => '{field} Karakter Spesial Tidak Di Izinkan !.',
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
                'field' => 'norek',
                'label' => 'Nomer Pencairan',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} Harus diisi ya.',
                    'numeric' => '{field} Harap Isi Oleh Angka Saja.',
                ]
            ]
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == false) {
            $data = [
                'title' => "Withdraw - UdunanAja",
                'navbar' => 'withdraw',
                'type' => $this->db->get("withdraw_type")->result_array(),
                'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
            ];
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('withdraw/index', $data);
            $this->load->view('templates/footer');
        } else {
            $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $keterangan = html_escape($this->input->post('keterangan', true));
            $nominal = html_escape($this->input->post('nominal', true));
            $norek = html_escape($this->input->post('norek', true));
            $bank = html_escape($this->input->post('metode', true));
            if (!$bank || !$nominal) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Harap isi semua data !</div>');
                redirect('withdraw');
            } else if ($nominal < 12500) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Minimal Penarikan Rp 12.500</div>');
                redirect('withdraw');
            } else if ($nominal > 50000000) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maximal Penarikan Rp 50.000.000</div>');
                redirect('withdraw');
            } else if ($user['balance'] < $nominal) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Saldo Anda Kurang!.</br>Periksa Kembali Saldo Anda</div>');
                redirect('withdraw');
            } else {
                $token = random_string('alnum', 45);
                $get_balance = $nominal - 2500;
                $email = $this->session->userdata('email');
                $data = [
                    'reffid' => $token,
                    'email' => $email,
                    'keterangan' => $keterangan,
                    'quantity' => $nominal,
                    'fee' => 2500,
                    'get_balance' => $get_balance,
                    'tujuan' => $norek,
                    'metode' => $bank,
                    'status' => 'pending',
                    'created_at' => date("y-m-d H:i:s")
                ];
                if ($this->db->query("UPDATE user SET balance = balance-$nominal WHERE email='$email'")) {
                    $this->db->insert('withdraw_history', $data);
                    if ($bank == "OVO") {
                        $norek = "9" . $this->Helper->filter_phone("0", $norek);
                        $bank = "NATIONALNOBU";
                    } else if ($bank == "GOPAY") {
                        $norek = "2849" . $this->Helper->filter_phone("0", $norek);
                        $bank = "CIMB_NIAGA";
                    } else if ($bank == "SHOPEEPAY") {
                        $norek = "893" . $this->Helper->filter_phone("0", $norek);
                        $bank = "MANDIRI";
                    } else if ($bank == "LINKAJA") {
                        $norek = "09110" . $this->Helper->filter_phone("0", $norek);
                        $bank = "BCA";
                    } else {
                        $norek = $norek;
                    }
                    $data_request = ['key' => "6abf78d0563bef0a66f4968c9f8f2fdc868d7b056d7e9cb500f54e8e8e76bd9e", 'action' => 'transfer', 'accountNumber' => $norek, 'bankCode' => $bank, 'transfer_amount' => $nominal];
                    $respon_atlantic = $this->Curl->connectPost("https://atlantic-pedia.co.id/api/bank", $data_request);
                    $data_log = [
                        'reffid' => $token,
                        'request' => json_encode($data_request, JSON_PRETTY_PRINT),
                        'response' => json_encode($respon_atlantic, JSON_PRETTY_PRINT),
                        'provider' => 'ATLANTIC-TRANSFER'
                    ];
                    $this->Helper->log_request($data_log);
                    if ($respon_atlantic['result'] == true) {
                        $update = $this->db->update("withdraw_history", ['pid' => $respon_atlantic['data']['trxid']], "reffid = '$token'");
                        if ($update) {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Detail Transfer</div>');
                            redirect('withdraw/invoice/' . $token);
                        }
                    } else {
                        $update = $this->db->update("withdraw_history", ['status' => 'error'], "reffid = '$token'");
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Terjadi Kesalahan Sistem Transfer</br>Reff : ' . $token . '</div>');
                        redirect('withdraw');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Terjadi Kesalahan Sistem</div>');
                    redirect('withdraw');
                }
            }
        }
    }
    public function invoice($reffid)
    {

        $this->Authentication->is_login();
        $payment = $this->db->get_where('withdraw_history', ['reffid' => $reffid])->row_array();
        if (!$payment) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Nomer Referensi Tidak Dikenali ! </div>');
            redirect("withdraw");
        } else {
            $data = [
                'title' => "Invoice - UdunanAja",
                'navbar' => 'withdraw',
                'payment' => $payment,
                'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
            ];
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('withdraw/invoice', $data);
            $this->load->view('templates/footer');
        }
    }

    public function detailrekening($norek, $bank)
    {
        $this->Authentication->is_login();
        if ($this->input->is_ajax_request() == false) {
            echo "no direct script access allowed";
            die();
        } else {
            if ($norek and $bank) {
                $norek = html_escape($norek);
                $bank = html_escape($bank);
                if (strlen($norek) > 7) {
                    if ($bank == "OVO") {
                        $norek = "9" . $this->Helper->filter_phone("0", $norek);
                        $bank = "NATIONALNOBU";
                    } else if ($bank == "GOPAY") {
                        $norek = "2849" . $this->Helper->filter_phone("0", $norek);
                        $bank = "CIMB_NIAGA";
                    } else if ($bank == "SHOPEEPAY") {
                        $norek = "893" . $this->Helper->filter_phone("0", $norek);
                        $bank = "MANDIRI";
                    } else if ($bank == "LINKAJA") {
                        $norek = "09110" . $this->Helper->filter_phone("0", $norek);
                        $bank = "BCA";
                    } else {
                        $norek = $norek;
                    }
                    $respon = $this->Curl->connectPost("https://atlantic-pedia.co.id/api/bank", ['key' => "6abf78d0563bef0a66f4968c9f8f2fdc868d7b056d7e9cb500f54e8e8e76bd9e", 'action' => 'validation', 'accountNumber' => $norek, 'bankCode' => $bank]);
                    if ($respon['result'] ==  true) {
                        echo json_encode(['result' => true, 'name' => $respon['data']['accountName']]);
                    } else {
                        echo json_encode(['result' => true, 'name' => 'Nomer Rekening tidak ditemukan']);
                    }
                }
            }
        }
    }
    public function method($type)
    {
        $this->Authentication->is_login();
        if ($this->input->is_ajax_request() == false) {
            echo "no direct script access allowed";
            die();
        } else {
            if ($type) {
                $type = html_escape($type);
                $row = $this->db->query("SELECT * FROM withdraw_method WHERE type='$type'")->result_array();
                echo "<option value=' ' disabled='true' selected>--Pilih Metode--</option>";
                foreach ($row as $data) {
                    echo "<option value='" . $data['code'] . "'>" . $data['name'] . "</option>";
                }
            }
        }
    }

    public function status($reffid)
    {
        $this->Authentication->is_login();
        if ($this->input->is_ajax_request() == false) {
            echo "no direct script access allowed";
            die();
        } else {
            $payment = $this->db->get_where('withdraw_history', ['reffid' => $reffid])->row_array();
            if (!$payment) {
                echo json_encode(['status' => false, "msg" => "Refference Id Tidak Diketahui!"]);
            } else {
                if ($payment['status'] <> "pending") {
                    echo json_encode(['status' => true, "msg" => "Refference Id Telah di DiUpdate !"]);
                } else {
                    echo json_encode(['status' => false, "msg" => "Refference Id Belum DiUpdate!"]);
                }
            }
        }
    }

    public function history()
    {

        $this->Authentication->is_login();
        $email = $this->session->userdata('email');
        $serch = false;
        if ($this->input->post('search', true)) {
            $serch = html_escape($this->input->post('search', true));

            $search_data = $this->db->query("SELECT * FROM withdraw_history WHERE email='$email' AND keterangan LIKE '%$serch%' ORDER BY id DESC")->result_array();
        } else {
            $search_data = $this->db->query("SELECT * FROM withdraw_history WHERE email='$email'  ORDER BY id DESC")->result_array();
        }
        $data = [
            'title' => "History Withdraw - UdunanAja",
            'navbar' => 'transd',
            'history' => $search_data,
            'search' => $serch,
            'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('withdraw/history', $data);
        $this->load->view('templates/footer');
    }
    
    public function detail_history($reffid)
    {
        $this->Authentication->is_login();
        $reffid = base64_decode($reffid);
        $search_data = $this->db->query("SELECT * FROM withdraw_history WHERE reffid='$reffid'")->row_array();
        if ($this->input->is_ajax_request() == false) {
            echo "no direct script access allowed";
            die();
        } else if (!$search_data) {
            echo "no direct script access allowed";
            die();
        } else {
            $data = [
                'title' => "Detail - UdunanAja",
                'history' => $search_data,
                'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array()
            ];
            $this->load->view('withdraw/detail-history', $data);
        }
    }
}
