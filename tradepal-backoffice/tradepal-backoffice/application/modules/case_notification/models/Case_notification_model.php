<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Case_notification_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_itemlist($field = '', $order = 'desc') {
        $this->db->select('*');
        $this->db->from('case_status');
        $this->db->where('deleted', 0);
        $this->db->order_by($field, $order);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_itemtinfo($id = '') {
        if (!empty($id)) {
            $this->db->select('*');
            $this->db->from('case_status');
            $this->db->where('ID', $id);
            $this->db->limit(1);
            $query = $this->db->get();
            return $query->row_array();
        } else {
            return null;
        }
    }

    public function delete($id = '') {
        if ($id != ''):
            $this->db->delete('case_status', array('ID' => $id));
            return true;
        else:
            return false;
        endif;
    }

}
