<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dealers_model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_itemlist($field = '', $order = 'desc') {
        $this->db->select('*,
            ( SELECT count(`case`.ID) FROM `case` WHERE `case`.RootID = dealer.ID ) as cnt_case,
            ( SELECT count(`case`.ID) FROM `case` WHERE `case`.RootID = dealer.ID and `case`.`Status` < 6 ) as cnt_wait_accept,
            ( SELECT count(`case`.ID) FROM `case` WHERE `case`.RootID = dealer.ID and `case`.`Status` >= 6 and `case`.`Status` <> 7 and `case`.`Status` < 23 ) as cnt_accept,
            ( SELECT count(`case`.ID) FROM `case` WHERE `case`.RootID = dealer.ID and `case`.`Status` = 7 ) as cnt_reject,
            ( SELECT count(`case`.ID) FROM `case` WHERE `case`.RootID = dealer.ID and `case`.`Status` >= 23 ) as cnt_handover
            from dealer
            where dealer.`delete` <> 1
          and dealer.RoleID = 0
        ');
        
        $this->db->order_by($field, $order);
        $query = $this->db->get();
        
        $rows = $query->result_array();
        
        foreach ($rows as &$row) {
            unset($row['Password']);
        }
        return $rows;
    }
    
    public function get_dealer_detail($field = '', $cid, $order = 'desc') {
        
        $result = $this->db->query('
                  SELECT dealer.CompanyName as StaffName,
                   case_status.NameTradepal as StatusTradepal,
                   `case`.*,
        if( `case`.`Status` < 6, NULL, ( select max(status_log.INS) from status_log where status_log.CaseID = `case`.ID and status_log.StatusID = 6 ORDER BY status_log.INS DESC limit 0,1 ) ) as Request_date,
        if( `case`.`Status` < 11, NULL, ( select status_log.BankAmount from status_log where status_log.CaseID = `case`.ID and status_log.StatusID = 11 ORDER BY status_log.INS DESC limit 0,1 ) ) as Amount_to_dealer,
        if( `case`.`Status` < 12, NULL, ( select max(status_log.INS) from status_log where status_log.CaseID = `case`.ID and status_log.StatusID = 12 ) ) as Accept_Amount,
        if( `case`.`Status` < 14, NULL, ( select max(status_log.INS) from status_log where status_log.CaseID = `case`.ID and status_log.StatusID = 14 ) ) as Reject_Amount,
         if( `case`.`Status` < 21, NULL, ( select max(status_log.INS) from status_log where status_log.CaseID = `case`.ID and status_log.StatusID = 21 ) ) as Start_Date_of_Advance,
         if( `case`.`Status` < 26, NULL, ( select max(status_log.INS) from status_log where status_log.CaseID = `case`.ID and status_log.StatusID = 26 ) ) as Complete,
        if( `case`.`Status` < 10,
            NULL,
            IF( `case`.`Status`= 14,
                "Reject",
                IF( `case`.`Status` < 23, "on process", "Handed over" )
            )
        ) as Handover_Status,
        "xxx" as Sold_date
        FROM `case`
        LEFT JOIN dealer on ( `case`.DealerID = dealer.ID )
        LEFT JOIN case_status on ( `case`.Status =  case_status.ID)
        WHERE `case`.RootID = ' . $cid . '
        ORDER BY  ' . $field .' '.  $order . '
        ');
       
        $rows = $result->result_array();
        
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
    
    public function get_itemtinfo_detail($id = '') {
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
					//            $this->db->delete('dealer', array('ID' => $id));
	
					$arraySet = [
						'delete' => 1,
						'MOD'    => $this->get_now()
					];
	
					$this->db->where('id', $id);
					$this->db->update('dealer', $arraySet);
            return true;
        else:
            return false;
        endif;
    }
}
