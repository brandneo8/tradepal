<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ForceSSL {

    private $CI;

    function __construct() {
        $this->CI = & get_instance();
    }

    function ssl() {
        $class = $this->CI->router->fetch_class();
        # add more controller name to exclude ssl.
        $exclude = array('client');
        if (!in_array($class, $exclude)) {
            # redirecting to ssl.
            $this->CI->config->config['base_url'] = str_replace('http://', 'https://', $this->CI->config->config['base_url']);
            if ($_SERVER['SERVER_PORT'] != 443)
                redirect($this->CI->uri->uri_string());
        } else {
            # redirecting with no ssl.
            $this->CI->config->config['base_url'] = str_replace('https://', 'http://', $this->CI->config->config['base_url']);
            if ($_SERVER['SERVER_PORT'] == 443)
                redirect($this->CI->uri->uri_string());
        }
    }

}

/* End of file forcessl.php */
/* Location: ./application/hooks/forcessl.php */