<?php

class Curl {

    const POST = 1;
    const GET = 2;
    const JSON = 3;
    const APP = 4;

    private $curlObj = '';
    private $webLink;
    private $curlCookies = '';
    private $tor = 0;

    public function __construct($website, $cookies, $tor = 0) {
        $this->curlObj = curl_init();
        $this->curlCookies = $cookies;
        $this->webLink = $website;
        $this->tor = $tor;
        if (!$tor)
            $this->sendCurl($website);
    }

    public function __destruct() {
        curl_close($this->curlObj);
    }

    public function sendCurl($url, $type = self::GET, $data = '') {
        $ip = '127.0.0.1:9050';
        curl_setopt($this->curlObj, CURLOPT_URL, $url);
        if ($this->tor) {
            curl_setopt($this->curlObj, CURLOPT_PROXY, $ip);
            curl_setopt($this->curlObj, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        }
        curl_setopt($this->curlObj, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->curlObj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curlObj, CURLOPT_ENCODING, "");
        curl_setopt($this->curlObj, CURLOPT_COOKIEJAR, getcwd() . '/' . $this->curlCookies);
        curl_setopt($this->curlObj, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)"); //Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0
        if ((strlen($data) > 0) || ( $type == self::POST )) {
            curl_setopt($this->curlObj, CURLOPT_HEADER, false);
            curl_setopt($this->curlObj, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($this->curlObj, CURLOPT_POSTFIELDS, ($data));
            curl_setopt($this->curlObj, CURLOPT_POST, 1);
            if ($type == self::JSON) {
                curl_setopt($this->curlObj, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data)));
                curl_setopt($this->curlObj, CURLOPT_CUSTOMREQUEST, "POST");
            } else {
                curl_setopt($this->curlObj, CURLOPT_HTTPHEADER, array(
                    'Content-Length: ' . strlen($data)));
            }
            curl_setopt($this->curlObj, CURLOPT_COOKIEFILE, getcwd() . '/' . $this->curlCookies);
        }
        $curlData = curl_exec($this->curlObj);
        if ($curlData === false) {
            return false;
        } else {
            return $curlData;
        }
    }

}
