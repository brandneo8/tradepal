<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Carowner_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function get_itemlist($field = '', $order = 'desc') {
		$this->db->select('*');
		$this->db->from('seller');
		$this->db->where('delete', '0');
		$this->db->order_by($field, $order);
		$query = $this->db->get();
		
		$rows = $query->result_array();
		
		foreach ($rows as &$row) {
			unset($row['Password']);
		}
		return $rows;
	}
	
	
	public function get_itemtinfo($id = '') {
		if (!empty($id)) {
			$this->db->select('*');
			$this->db->from('seller');
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
			$this->db->update('seller', $arraySet);
			return true;
		else:
			return false;
		endif;
	}
}
