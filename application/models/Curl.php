<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Curl extends CI_Model
{
    function connectHeader($end_point, $header, $reqout = 'decode')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $end_point);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $chresult = curl_exec($ch);
        return ($reqout == 'decode') ? json_decode($chresult, true) : $chresult;
    }
    function connectPost($end_point, $postdata, $reqout = 'decode')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $end_point);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $chresult = curl_exec($ch);
        curl_close($ch);
        if (!$chresult) $chresult = $this->connectHeaderPost($end_point, ['content-type: multipart/form-data;'], $postdata, 'original');
        return ($reqout == 'decode') ? json_decode($chresult, true) : $chresult;
    }
    function connectHeaderPost($end_point, $header, $postdata, $reqout = 'decode')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $end_point);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        $chresult = curl_exec($ch);
        return ($reqout == 'decode') ? json_decode($chresult, true) : $chresult;
    }
    function connectGet($end_point, $getdata, $reqout = 'decode')
    {
        $link = (is_array($getdata)) ? $end_point . '?' . http_build_query($getdata) : $end_point;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.47 Safari/537.36');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $chresult = curl_exec($ch);
        curl_close($ch);
        return ($reqout == 'decode') ? json_decode($chresult, true) : $chresult;
    }

    function ipaymu($data)
    {
        $va           = '1179001322207701'; //get on iPaymu dashboard
        $secret       = 'mMOl9oe0mfYbSTAz601mM5nHHidGC1'; //get on iPaymu dashboard

        $url          = 'https://my.ipaymu.com/api/v2/payment/direct'; //url
        $method       = 'POST'; //method

        //Request Body//
        $body['referenceId']  = $data['reffid'];
        $body['notifyUrl']  = 'https://udunanaja.com/callback';
        $body['paymentChannel']  = $data['paymentChannel'];
        $body['paymentMethod']  = $data['paymentMethod'];
        $body['name']  = $data['name'];
        $body['phone']  = $data['phone'];
        $body['email']  = $data['email'];
        $body['amount']  = $data['amount'];
        //End Request Body//

        //Generate Signature
        // *Don't change this
        $jsonBody     = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody  = strtolower(hash('sha256', $jsonBody));
        $stringToSign = strtoupper($method) . ':' . $va . ':' . $requestBody . ':' . $secret;
        $signature    = hash_hmac('sha256', $stringToSign, $secret);
        $timestamp    = Date('YmdHis');
        //End Generate Signature


        $ch = curl_init($url);

        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'va: ' . $va,
            'signature: ' . $signature,
            'timestamp: ' . $timestamp
        );

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_POST, count($body));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $err = curl_error($ch);
        $ret = curl_exec($ch);
        curl_close($ch);

        return json_decode($ret, true);
    }
}
