<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends CI_Controller
{

    public function form($slug)
    {
        if ($slug == true) {
            $slug = html_escape($slug);
            $result = $this->db->get_where('patungan', ['slug' => $slug])->row_array();
            if (!$result) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Data Udunan tidak ditemukan !.
               </div>');
                redirect('auth/');
            } else {
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
                        'rules' => 'required|min_length[6]|max_length[50]|valid_email',
                        'errors' => [
                            'required' => '{field} Harus diisi ya.',
                            'min_length' => '{field} Minimal 6 Karakter.',
                            'max_length' => '{field} Maximal 50 Karakter.',
                            'valid_email' => '{field} harus di isi dengan benar.',
                        ]
                    ],
                    [
                        'field' => 'phone',
                        'label' => 'Phone',
                        'rules' => 'required|min_length[6]|max_length[15]|numeric',
                        'errors' => [
                            'required' => '{field} Harus diisi ya.',
                            'min_length' => '{field} Minimal 6 Karakter.',
                            'max_length' => '{field} Maximal 50 Karakter.',
                            'numeric' => '{field} hanya boleh diisi oleh angka saja.',
                        ]
                    ],
                ];
                $this->form_validation->set_rules($rules);
                if ($this->form_validation->run() == false) {
                    $data = [
                        'title' => "Udunan " . $result['judul'],
                        'campaign' => $result,
                        'max_user' => $this->db->query("SELECT * FROM patungan_user WHERE patungan_id='" . $result['id'] . "'")->num_rows,
                        'author' => $this->db->get_where('user', ['email' => $result['email']])->row_array()
                    ];
                    $this->load->view('templates/pay_header', $data);
                    $this->load->view("payment/form", $data);
                    $this->load->view('templates/pay_footer');
                } else {
                    $name = html_escape($this->input->post('name', true));
                    $email = html_escape($this->input->post('email', true));
                    $phone = $this->Helper->filter_phone('62', html_escape($this->input->post('phone', true)));
                    $reffid =  strtoupper(random_string('alnum', 20));
                    if ($phone == false) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Nomer HP Tidak Sesuai,Harap Periksa Kembali! </div>');
                        redirect("pay/$slug");
                    } else {
                        if ($this->input->post('bca', true)) {
                            $method = "BANK BCA";
                            $fee = 4000;
                            $total_transfer = $fee + $result['nominal'];
                            $data_request = [
                                'reffid' => $reffid,
                                'paymentMethod' => "va",
                                'paymentChannel' => "bca",
                                'amount' => $total_transfer,
                                'name' => $name,
                                'email' => $email,
                                'phone' => $phone,
                            ];
                            $respon_ipaymu = $this->Curl->ipaymu($data_request);
                        } else if ($this->input->post('bni', true)) {
                            $method = "BANK BNI";
                            $fee = 4000;
                            $total_transfer = $fee + $result['nominal'];
                            $data_request = [
                                'reffid' => $reffid,
                                'paymentMethod' => "va",
                                'paymentChannel' => "bni",
                                'amount' => $total_transfer,
                                'name' => $name,
                                'email' => $email,
                                'phone' => $phone,
                            ];
                            $respon_ipaymu = $this->Curl->ipaymu($data_request);
                        } else if ($this->input->post('bri', true)) {
                            $method = "BANK BRI";
                            $fee = 4000;
                            $total_transfer = $fee + $result['nominal'];
                            $data_request = [
                                'reffid' => $reffid,
                                'paymentMethod' => "va",
                                'paymentChannel' => "bri",
                                'amount' => $total_transfer,
                                'name' => $name,
                                'email' => $email,
                                'phone' => $phone,
                            ];
                            $respon_ipaymu = $this->Curl->ipaymu($data_request);
                        } else if ($this->input->post('mandiri', true)) {
                            $method = "BANK MANDIRI";
                            $fee = 4000;
                            $total_transfer = $fee + $result['nominal'];
                            $data_request = [
                                'reffid' => $reffid,
                                'paymentMethod' => "va",
                                'paymentChannel' => "mandiri",
                                'amount' => $total_transfer,
                                'name' => $name,
                                'email' => $email,
                                'phone' => $phone,
                            ];
                            $respon_ipaymu = $this->Curl->ipaymu($data_request);
                        } else if ($this->input->post('artagraha', true)) {
                            $method = "BANK ARTA GRAHA";
                            $fee = 4000;
                            $total_transfer = $fee + $result['nominal'];
                            $data_request = [
                                'reffid' => $reffid,
                                'paymentMethod' => "va",
                                'paymentChannel' => "bag",
                                'amount' => $total_transfer,
                                'name' => $name,
                                'email' => $email,
                                'phone' => $phone,
                            ];
                            $respon_ipaymu = $this->Curl->ipaymu($data_request);
                        } else if ($this->input->post('muamalat', true)) {
                            $method = "BANK MUAMALAT";
                            $fee = 4000;
                            $total_transfer = $fee + $result['nominal'];
                            $data_request = [
                                'reffid' => $reffid,
                                'paymentMethod' => "va",
                                'paymentChannel' => "bmi",
                                'amount' => $total_transfer,
                                'name' => $name,
                                'email' => $email,
                                'phone' => $phone,
                            ];
                            $respon_ipaymu = $this->Curl->ipaymu($data_request);
                        } else if ($this->input->post('cimbniaga', true)) {
                            $method = "BANK CIMB NIAGA";
                            $fee = 4000;
                            $total_transfer = $fee + $result['nominal'];
                            $data_request = [
                                'reffid' => $reffid,
                                'paymentMethod' => "va",
                                'paymentChannel' => "cimb",
                                'amount' => $total_transfer,
                                'name' => $name,
                                'email' => $email,
                                'phone' => $phone,
                            ];
                            $respon_ipaymu = $this->Curl->ipaymu($data_request);
                        } else if ($this->input->post('alfamart', true)) {
                            $method = "ALFAMART";
                            $fee = 4500;
                            $total_transfer = $fee + $result['nominal'];
                            $data_request = [
                                'reffid' => $reffid,
                                'paymentMethod' => "cstore",
                                'paymentChannel' => "alfamart",
                                'amount' => $total_transfer,
                                'name' => $name,
                                'email' => $email,
                                'phone' => $phone,
                            ];
                            $respon_ipaymu = $this->Curl->ipaymu($data_request);
                        } else if ($this->input->post('indomaret', true)) {
                            $method = "INDOMARET";
                            $fee = 4500;
                            $total_transfer = $fee + $result['nominal'];
                            $data_request = [
                                'reffid' => $reffid,
                                'paymentMethod' => "cstore",
                                'paymentChannel' => "indomaret",
                                'amount' => $total_transfer,
                                'name' => $name,
                                'email' => $email,
                                'phone' => $phone,
                            ];
                            $respon_ipaymu = $this->Curl->ipaymu($data_request);
                        } else if ($this->input->post('qris', true)) {
                            $method = "QRIS";
                            $fee = $result['nominal'] * 0.008;
                            $total_transfer = $fee + $result['nominal'];
                            $data_request = [
                                'reffid' => $reffid,
                                'paymentMethod' => "qris",
                                'paymentChannel' => "linkaja",
                                'amount' => $total_transfer,
                                'name' => $name,
                                'email' => $email,
                                'phone' => $phone,
                            ];
                            $respon_ipaymu = $this->Curl->ipaymu($data_request);
                        } else if ($this->input->post('cod', true)) {
                            $method = "CASH TO BANDAR";
                            $fee = 0;
                            $total_transfer = $fee + $result['nominal'];
                            $respon_ipaymu['Status'] = 200;
                            $respon_ipaymu['Data']['PaymentNo']="CTB";
                            $respon_ipaymu['Data']['PaymentName']="CTB";
                            $respon_ipaymu['Data']['Expired'] = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") . ' +1 day'));
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Methode Pembayaran Tidak Dikenal </div>');
                            redirect("pay/$slug");
                        }

                        if ($respon_ipaymu['Status'] == 200) {
                            $data_db = [
                                'patungan_id' => $result['id'],
                                'reffid' => $reffid,
                                'name' => $name,
                                'email' => $email,
                                'phone' => $phone,
                                'method' => $method,
                                'amount' => $result['nominal'],
                                'tujuan_tf' => $respon_ipaymu['Data']['PaymentNo'],
                                'bank_name' => $respon_ipaymu['Data']['PaymentName'],
                                'fee' => $fee,
                                'transfer' => $total_transfer,
                                'expired_at' => $respon_ipaymu['Data']['Expired'],
                                'status' => 'unpaid',
                                'created_at' => date("Y-m-d H:i:s"),
                            ];
                            if ($data_request) {
                                $data_log = [
                                    'reffid' => $reffid,
                                    'request' => json_encode($data_request, JSON_PRETTY_PRINT),
                                    'response' => json_encode($respon_ipaymu, JSON_PRETTY_PRINT),
                                    'provider' => 'IPAYMU'
                                ];
                                $this->Helper->log_request($data_log);
                            }
                            if ($this->db->insert('patungan_user', $data_db)) {
                                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Silahkan Lakukan Pembayaran Sesuai Dibawah ini </div>');
                                redirect("pay/detail/$reffid");
                            } else {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Terjadi Kesalahan sistem,Harap hubungi admin ! </div>');
                                redirect("pay/$slug");
                            }
                        } else {
                            $data_log = [
                                'reffid' => $reffid,
                                'request' => json_encode($data_request, JSON_PRETTY_PRINT),
                                'response' => json_encode($respon_ipaymu, JSON_PRETTY_PRINT),
                                'provider' => 'IPAYMU'
                            ];
                            $this->Helper->log_request($data_log);
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Terjadi Kesalahan Pada Methode Pembayaran ini,Silahkan Coba Method Pembayaran lain! </div>');
                            redirect("pay/$slug");
                        }
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }
    public function detail($reffid)
    {
        $payment = $this->db->get_where('patungan_user', ['reffid' => $reffid])->row_array();
        if (!$payment) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> No Refference Tidak Dikenali ! </div>');
            redirect("auth/");
        } else if ($payment['status'] == "paid") {
            redirect("pay/invoice/$reffid");
        } else {
            $campaign = $this->db->get_where('patungan', ['id' => $payment['patungan_id']])->row_array();
            $data = [
                'title' => "Detail Pembayaran - UdunanAja",
                'author' => $this->db->get_where('user', ['email' => $campaign['email']])->row_array(),
                'payment' => $payment,
                'campaign' => $campaign,
            ];
            $this->load->view('templates/pay_header', $data);
            if ($payment['method'] == "QRIS") {
                $this->load->view("payment/detail-qr", $data);
            } else if ($payment['method'] == "CASH TO BANDAR") {
                $this->load->view("payment/detail-cod", $data);
            } else {
                $this->load->view("payment/detail", $data);
            }
            $this->load->view('templates/pay_footer');
        }
    }

    public function status($reffid)
    {

        if ($this->input->is_ajax_request() == false) {
            echo "no direct script access allowed";
            die();
        } else {
            $payment = $this->db->get_where('patungan_user', ['reffid' => $reffid])->row_array();
            if (!$payment) {
                echo json_encode(['status' => false, "msg" => "Refference Id Tidak Diketahui!"]);
            } else {
                if ($payment['status'] == "paid") {
                    echo json_encode(['status' => true, "msg" => "Refference Id Telah di Bayar !"]);
                } else {
                    echo json_encode(['status' => false, "msg" => "Refference Id Belum Dibayarkan!"]);
                }
            }
        }
    }

    public function invoice($reffid)
    {
        $payment = $this->db->get_where('patungan_user', ['reffid' => $reffid])->row_array();
        if (!$payment) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> No Refference Tidak Dikenali ! </div>');
            redirect("auth/");
        } else {
            $campaign = $this->db->get_where('patungan', ['id' => $payment['patungan_id']])->row_array();
            $data = [
                'title' => "Invoice Pembayaran - UdunanAja",
                'author' => $this->db->get_where('user', ['email' => $campaign['email']])->row_array(),
                'payment' => $payment,
                'campaign' => $campaign,
            ];
            $this->load->view('templates/pay_header', $data);
            $this->load->view("payment/invoice", $data);
            $this->load->view('templates/pay_footer');
        }
    }
}
