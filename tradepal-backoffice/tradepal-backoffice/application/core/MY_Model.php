<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_now() {
        return date('Y-m-d H:i:s');
    }
    
    public function get_client_ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
  
  public function get_allfield_models($table = '', $except = [])
  {
    if (is_array($except) && count($except) > 0) {
      $result = $this->db->query('SHOW FIELDS FROM `' . $table . '` WHERE FIELD NOT IN (\'' . implode('\',\'', $except) . '\');');
    } else {
      $result = $this->db->query('SHOW FIELDS FROM `' . $table . '`;');
    }
    # set for return
    $fields = [];
    foreach($result->result_array() as $key => $row) {
      $fields[] = $row['Field'];
    }
    return implode(',', (array) $fields);
  }

}
