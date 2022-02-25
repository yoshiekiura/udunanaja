<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Callback extends CI_Controller
{
    function index()
    {
        parse_str(file_get_contents("php://input"), $get_array);
        $reff_id = $get_array['reference_id'];
        $status = $get_array['status'];
        $payment = $this->db->get_where("patungan_user", ['reffid' => $reff_id])->row_array();
        if (!$payment) {
            $this->Helper->log_callback("Data $reff_id Tidak ditemukan log :" . json_encode($get_array));
        } else {
            $t_patungan = $payment['amount'];
            $id_patungan = $payment['patungan_id'];
            $user_email = $this->db->get_where("patungan", ['id' => $id_patungan])->row_array()['email'];
            if ($status == "berhasil") {
                $update = $this->db->update("patungan_user", ['status' => 'paid'], "reffid = '$reff_id'");
                $update = $this->db->query("UPDATE patungan SET terkumpul = terkumpul+$t_patungan WHERE id='$id_patungan'");
                $update = $this->db->query("UPDATE user SET balance = balance+$t_patungan WHERE email='$user_email'");
                if ($update) {
                    print "Sukses $user_email | $id_patungan | $t_patungan" . json_encode($get_array);
                } else {
                    print "Gagal " . json_encode($get_array);
                }
            }
        }

        $data_log = [
            'reffid' => $reff_id,
            'request' => "CALLBACK",
            'response' => json_encode($get_array, JSON_PRETTY_PRINT),
            'provider' => 'IPAYMU'
        ];
        $this->Helper->log_request($data_log);
    }
    
    function xendit()
    {
        $data   = json_decode(file_get_contents("php://input"), true)['data'];
        $reff_id = $data['reference_id'];
        $status = $data['status'];
        $payment = $this->db->get_where("patungan_user", ['reffid' => $reff_id])->row_array();
        if (!$payment) {
            $this->Helper->log_callback("Data $reff_id Tidak ditemukan log :" . json_encode($data));
        } else {
            $t_patungan = $payment['amount'];
            $id_patungan = $payment['patungan_id'];
            $user_email = $this->db->get_where("patungan", ['id' => $id_patungan])->row_array()['email'];
            if ($status == "SUCCEEDED") {
                $update = $this->db->update("patungan_user", ['status' => 'paid'], "reffid = '$reff_id'");
                $update = $this->db->query("UPDATE patungan SET terkumpul = terkumpul+$t_patungan WHERE id='$id_patungan'");
                $update = $this->db->query("UPDATE user SET balance = balance+$t_patungan WHERE email='$user_email'");
                if ($update) {
                    print "Sukses $user_email | $id_patungan | $t_patungan" . json_encode($data);
                } else {
                    print "Gagal " . json_encode($data);
                }
            }
        }

        $data_log = [
            'reffid' => $reff_id,
            'request' => "CALLBACK",
            'response' => json_encode($data, JSON_PRETTY_PRINT),
            'provider' => 'XENDIT'
        ];
        $this->Helper->log_request($data_log);
    }
    function transfer()
    {
        $data   = json_decode(file_get_contents("php://input"), true)['data'];
        $reff_id = $data['id'];
        $status = $data['status'];
        $payment = $this->db->get_where("withdraw_history", ['pid' => $reff_id])->row_array();
        if (!$payment) {
            $this->Helper->log_callback("Data $reff_id Tidak ditemukan log :" . json_encode($data));
        } else {
            $t_patungan = $payment['quantity'];
            $user_email = $payment['email'];
            if ($status == "success") {
                $update = $this->db->update("withdraw_history", ['status' => 'success'], "pid = '$reff_id'");
                if ($update) {
                    print "Sukses $user_email | $reff_id " . json_encode($data);
                } else {
                    print "Gagal " . json_encode($data);
                }
            } else {
                $update = $this->db->update("withdraw_history", ['status' => 'error'], "pid = '$reff_id'");
                $update = $this->db->query("UPDATE user SET balance = balance+$t_patungan WHERE email='$user_email'");
            }
        }

        $data_log = [
            'reffid' => $reff_id,
            'request' => "CALLBACK",
            'response' => json_encode($data, JSON_PRETTY_PRINT),
            'provider' => 'ATLANTIC'
        ];
        $this->Helper->log_request($data_log);
    }

    function add_method()
    {
        $json = $this->Curl->connectPost("https://atlantic-pedia.co.id/api/bank", ['key' => "6abf78d0563bef0a66f4968c9f8f2fdc868d7b056d7e9cb500f54e8e8e76bd9e", 'action' => 'list_bank']);
        $this->db->truncate("withdraw_method");
        foreach ($json['data'] as $row) {
            $name = $row['bankName'];
            $code = $row['bankCode'];
            $type = $row['category'];

            $data = [
                'code' => $code,
                'name' => $name,
                'type' => $type
            ];
            if ($this->db->insert("withdraw_method", $data))
                echo "BERHASIL INPUT DATA $code </br >";
        }
    }
}
