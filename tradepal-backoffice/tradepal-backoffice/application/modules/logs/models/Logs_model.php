<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Logs_model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_itemlist($field = '', $order = 'desc', $filter) {
        $this->db->select('log.*,
         CONCAT(s.FirstName, " ", s.LastName) as SellerFullname,
        s.Username as SellerName,
        s.IDNo as SellerCode,
        d.CompanyName as DealerName,
        d.CompanyRegistertionNo as DealerCode,
        admin.full_name as AdminName,
        cs.Name as StatusName
        ');
        $this->db->from('status_log as log');
        $this->db->join('case_status as cs', 'cs.ID = log.StatusID', 'left');
        $this->db->join('dealer as d', 'd.ID = log.DealerID', 'left');
        $this->db->join('seller as s', 's.ID = log.SellerID', 'left');
        $this->db->join('admin_users as admin', 'admin.user_id = log.TradpalID', 'left');
        $this->db->where_in('log.StatusID', [2,5]);
        $this->db->order_by($field, $order);
    
    
        if (!empty($filter['StatusID'])) $this->db->where('log.StatusID', $filter['StatusID']);
       
        
        $query = $this->db->get();
        
        $rows = $query->result_array();
        
        
        return $rows;
    }
    
   
    
    public function get_itemtinfo($id = '') {
        if (!empty($id)) {
            $this->db->select('*');
            $this->db->from('dealer');
            $this->db->where('ID', $id);
            $this->db->limit(1);
            $query = $this->db->get();
            $row = $query->row_array();
            unset($row['Password']);
            return $row;
        } else {
            return null;
        }
    }
    
    public function save_advancequantum($dealer_id, $data = array()) {
        $arraySet = [
            'AdvanceQuantum' => $data['AdvanceQuantum'],
            'MOD' => $this->get_now()
        ];
        
        $this->db->where('id', $dealer_id);
        return $this->db->update('dealer', $arraySet);
        
    }
    

    
    public function get_datatable($table = '', $order = '', $sort = 'asc') {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($order, $sort);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_datatablew($table = '', $where = '', $order = '', $sort = 'asc') {
        $this->db->select('*');
        $this->db->from($table);
        ($where) ? $this->db->where($where) : '';
        $this->db->order_by($order, $sort);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_usertable($table = '', $order = '', $sort = 'asc') {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($order, $sort);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_usertable_byid($table = '', $key = '', $id = '', $order = '', $sort = 'asc') {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($key, $id);
        $this->db->order_by($order, $sort);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function delete($id = '') {
        if ($id != ''):
            $this->db->delete('case', array('ID' => $id));
            return true;
        else:
            return false;
        endif;
    }
}
