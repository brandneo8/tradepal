<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Rest_Model extends CI_Model
{
    public $api_url = "http://admin.wpncenter.com/";
    public $api_key = "";

    function __construct() {
        parent::__construct();

        $this->load->library('Zend');
		$this->zend->load('Zend/Loader');
		Zend_Loader::loadClass('Zend_Http_Client');
    }

    public function auth($renew = false) {
        if(($this->session->access_token && $renew) || !$this->session->access_token) {
            $auth = $this->guzzle('POST', '/api/login', array(
                'email' => 'apiadmin@apiwpn.com',
                'password' => 'aa112233'
            ));
            $auth = json_decode($auth);
            if($auth->status) {
                $this->session->unset_userdata('access_token');
                $this->session->set_userdata('access_token', $auth->data->access_token);
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function guzzle($type = 'POST', $method = '', $params = array(), $headers = []) {
        #guzzle library add to use guzzle
        $this->load->library('guzzle');

        # guzzle client define
        $client = new GuzzleHttp\Client();
        
        #This url define speific Target for guzzle
        $url = $this->api_url . $method;

        #guzzle
        try {
            # guzzle post request example with form parameter
            $response = $client->request($type, $url, ['headers' => $headers, 'form_params' => $params]);
            #guzzle repose for future use
            // echo $response->getStatusCode(); // 200
            // echo $response->getReasonPhrase(); // OK
            // echo $response->getProtocolVersion(); // 1.1
            return $response->getBody()->getContents();
        } catch (GuzzleHttp\Exception\BadResponseException $e) {
            #guzzle repose for future use
            $response = $e->getResponse();
            return $response->getBody()->getContents();
        }
    }
    public function call($type = 'POST', $method = '', $headers = array(), $data = array(), $getarray = true)
    {

        $client = new Zend_Http_Client($this->api_url . $method, array(
            'maxredirects' => 3,
            'timeout' => 30
        ));

        $client->setHeaders($headers);
        $response = $client->setRawData(json_encode($data), 'application/json')->request($type);

        if ($response->isSuccessful())
            return json_decode($response->getBody(), $getarray);
        else
            return json_decode($response->getRawBody(), $getarray);
    }

    public function callform($type = 'POST', $method = '', $headers = array(), $data = array(), $getarray = true) {

        $client = new Zend_Http_Client($this->api_url . $method, array(
            'maxredirects' => 3,
            'timeout' => 30
        ));

        $client->setHeaders($headers);

        if (strtolower($type) == 'get') {
            $client->setParameterGet($data);
        } else if (strtolower($type) == 'post') {
            $client->setParameterPost($data);
        }

        $response = $client->request($type);

        if ($response->isSuccessful())
            return json_decode($response->getBody(), $getarray);
        else
            return json_decode($response->getRawBody(), $getarray);
    }

    public function callformoth($type = 'POST', $method = '', $headers = array(), $data = array(), $getarray = true) {

        $client = new Zend_Http_Client($method, array(
            'maxredirects' => 3,
            'timeout' => 30
        ));

        $client->setHeaders($headers);

        if (strtolower($type) == 'get') {
            $client->setParameterGet($data);
        } else if (strtolower($type) == 'post') {
            $client->setParameterPost($data);
        }

        $response = $client->request($type);

        if ($response->isSuccessful())
            return json_decode($response->getBody(), $getarray);
        else
            return json_decode($response->getRawBody(), $getarray);
    }

    public function getJson($method = '', $json = true) {
        $contents = file_get_contents($this->api_url . $method);
        return json_decode($contents, $json);
    }

    public function postJson($method = '', $data = array(), $json = true) {
        $post_data = http_build_query($data);
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $post_data
            )
        );
        
        $context  = stream_context_create($opts);
        $contents = file_get_contents($this->api_url . $method, false, $context);

        return json_decode($contents, $json);
    }

    public function postJsonOth($method = '', $headers = '', $data = array(), $json = true) {
        $post_data = http_build_query($data);
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => $headers,
                'content' => $post_data
            )
        );
        
        $context  = stream_context_create($opts);
        $contents = file_get_contents($method, false, $context);

        return json_decode($contents, $json);
    }

    public function uploadform($type = 'POST', $method = '', $headers = array(), $data = array(), $getarray = true) {
        $client = new Zend_Http_Client($this->api_url . $method, array(
            'maxredirects' => 3,
            'timeout' => 30
        ));
        $client->setHeaders($headers);

        if(count($data) > 0) {
            foreach ($data as $key => $row) {
                if($row != "") {
                    $client->setFileUpload($row, $key);
                }
            }
        }
        
         // this must be either POST or PUT
         $response = $client->request($type);

         if ($response->isSuccessful())
             return json_decode($response->getBody(), $getarray);
         else
             return json_decode($response->getRawBody(), $getarray);
    }


    
}
