<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sch_lang {

    private $CI;
    private $_get_lang;

    function __construct() {
        $this->CI = & get_instance();
        if (!isset($this->CI->session)) {
            $this->CI->load->library('session');
        }
    }

    function set_lang() {
        $queryString = $_SERVER['QUERY_STRING'];
        $arrayQueryString = array();
        $lang = '';
        parse_str($queryString, $arrayQueryString);
        if (count($arrayQueryString) > 0) {
            if (isset($arrayQueryString["lang"])) {
                switch ($arrayQueryString['lang']) {
                    case 'th' : $lang = $arrayQueryString['lang'];
                        break;
                    case 'en': $lang = $arrayQueryString['lang'];
                        break;
                    default : $lang = 'en';
                }
                $this->CI->session->set_userdata('lang', $lang);
            } else {
                $lang = 'en';
                $this->CI->session->set_userdata('lang', $lang);
            }
            $this->_get_lang = $lang;
        } else {
            if ($this->CI->session->userdata('lang') == '') {
                $this->_get_lang = 'en';
                $this->CI->session->set_userdata('lang', 'en');
            } else {
                $this->_get_lang = $this->CI->session->userdata('lang');
            }
        }
        $this->CI->lang->load('global', $this->_get_lang);
    }

}

/* End of file set_lang.php */
/* Location: ./application/hooks/set_lang.php */