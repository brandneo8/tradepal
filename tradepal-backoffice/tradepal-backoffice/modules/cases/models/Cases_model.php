<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cases_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_itemlist($field = '', $order = 'desc', $filter) {
        $this->db->select('c.*,
        CONCAT(s.FirstName, " ", s.LastName) as seller_fullname,
        s.Username as seller_name,
        d.CompanyName as dealer_name,
        cs.Name as status_name');
        $this->db->from('case as c');
        $this->db->join('case_status as cs', 'cs.ID = c.Status', 'left');
        $this->db->join('dealer as d', 'd.ID = c.DealerID', 'left');
        $this->db->join('seller as s', 's.ID = c.SellerID', 'left');
//        $this->db->where_not_in('c.Status', [1,2,3,5,7]);
	
			$this->db->where('c.Deleted', 0);
        $this->db->order_by('c.MOD', $order);
        if ($field) {
            $this->db->order_by($field, $order);
        }
    
        if (!empty($filter['Type'])) $this->db->like('c.Type', $filter['Type'], 'both');
        if (!empty($filter['dealer_name'])) $this->db->like('d.CompanyName', $filter['dealer_name'], 'both');
        if (!empty($filter['VehicleNo'])) $this->db->like('c.VehicleNo', $filter['VehicleNo'], 'both');
        if (!empty($filter['VehicleMake'])) $this->db->like('c.VehicleMake', $filter['VehicleMake'], 'both');
        if (!empty($filter['VehicleModel'])) $this->db->like('c.VehicleModel', $filter['VehicleModel'], 'both');
        if (!empty($filter['YearOfManufacture'])) $this->db->like('c.YearOfManufacture', $filter['YearOfManufacture'], 'both');
        
       
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_itemtinfo($id = '') {
        if (!empty($id)) {
            $this->db->select('c.*,
            CONCAT(s.FirstName, " ", s.LastName) as seller_fullname,
            s.Username as seller_name,
            d.CompanyName as dealer_name,
            cs.Name as status_name');
            $this->db->from('case as c');
            $this->db->join('case_status as cs', 'cs.ID = c.Status', 'left');
            $this->db->join('dealer as d', 'd.ID = c.DealerID', 'left');
            $this->db->join('seller as s', 's.ID = c.SellerID', 'left');
            $this->db->where('c.ID', $id);
					$this->db->where('c.Deleted', 0);
            $this->db->limit(1);
            $query = $this->db->get();
            return $query->row_array();
        } else {
            return null;
        }
    }
  
    public function log($data = array()) {
      $insert = [
        'CaseID' => $data['CaseID'],
        'DealerID' => $data['DealerID'],
        'SellerID' => $data['SellerID'],
        'TradpalID' => $data['TradpalID'],
        'StatusID' => $data['StatusID'],
        'HPDepositType' => $data['HPDepositType'],
        'HPChequeNo' => $data['HPChequeNo'],
        'HPAmount' => $data['HPAmount'],
        'HPBalanceDue' => $data['HPBalanceDue'],
        'HPDeliveredOn' => $data['HPDeliveredOn'],
        'BankAmount' => $data['BankAmount'],
        'SellerBankAccount' => $data['SellerBankAccount'],
        'AppointmentDate' => $data['AppointmentDate'],
        'AppointmentTime' => $data['AppointmentTime'],
        'AppointmentTimeTo' => $data['AppointmentTimeTo'],
        'AppointmentPlace' => $data['AppointmentPlace'],
        'AppointmentDescription' => $data['AppointmentDescription'],
        'LoanDocument1' => $data['LoanDocument1'],
        'LoanDocument2' => $data['LoanDocument2'],
        'LoanDocument3' => $data['LoanDocument3'],
        'LoanDocument4' => $data['LoanDocument4'],
        'LoanDocument5' => $data['LoanDocument5'],
        'DocAgreement1' => $data['DocAgreement1'],
        'DocAgreement2' => $data['DocAgreement2'],
        'DocAgreement3' => $data['DocAgreement3'],
        'DocAgreement4' => $data['DocAgreement4'],
        'SignedFullSettlement' => $data['SignedFullSettlement'],
        'MoneyTransferredCarOwner' => $data['MoneyTransferredCarOwner'],
        'AmountDue' => $data['AmountDue'],
        'IP' => $this->get_client_ip(),
        'INS' => $this->get_now(),
        'MOD' => $this->get_now(),
      ];
      
      $this->db->insert('status_log', $insert);
      
      $id = $this->db->insert_id();
      
      
      if ($data['StatusID'] == 11 || $data['StatusID'] == 21 ) {
        $arraySet = [
          'Status' => $data['StatusID'],
          'MOD' => $this->get_now(),
        ];
        
        $this->db->where('id', $data['CaseID']);
        return $this->db->update('case', $arraySet);
      }
      
      return $id;
    }

    public function get_datatable($table = '', $order = '',$sort = 'asc') {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($order, $sort);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_datatablew($table = '', $where = '', $order = '',$sort = 'asc') {
        $this->db->select('*');
        $this->db->from($table);
        ($where) ? $this->db->where($where) : '';
        $this->db->order_by($order, $sort);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_usertable($table = '', $order = '',$sort = 'asc') {
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
