<?php

use Carbon\Carbon;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Noti_model extends Api_model {
	
	function __construct() {
		parent::__construct();
	}
	
	// ----------------------------------------------------------------------------------------------------------------
	// Seller
	
	public function create_noti_seller($data = array()) {
		$insert = [
			'CaseID'   => $data['CaseID'],
			'SellerID' => $data['SellerID'],
			'Subject'  => $data['Subject'],
			'Detail'   => $data['Detail'],
			'read'     => 0,
			'readdate' => null,
			'INS'      => $this->get_now(),
			'MOD'      => $this->get_now(),
		];
		
		$this->db->insert('notification_seller', $insert);
		
		return $this->db->insert_id();
	}
	
	public function list_noti_seller($seller_id, $unread, $page, $per_page) {
		$offset = ($page - 1) * $per_page;
		
		$this->db->from('notification_seller');
		$this->db->where('SellerID', $seller_id);
		$where = ['SellerID' => $seller_id];
		
		if (!empty($unread)) {
			$this->db->where('read', 0);
			$where['read'] = 0;
		}
		
		$total = $this->db->count_all_results();
		$items = $this->db->order_by('read', 'ASC')->get_where('notification_seller', $where, $per_page, $offset)->result();
		
		return ['total' => $total, 'items' => $items];
	}
	
	public function seller_mark_as_read($noti_id, $seller_id) {
		$arraySet = [
			'read'     => 1,
			'readdate' => $this->get_now(),
			'MOD'      => $this->get_now(),
		];
		
		$this->db->where('id', $noti_id)->where('SellerID', $seller_id);
		return $this->db->update('notification_seller', $arraySet);
	}
	
	// ----------------------------------------------------------------------------------------------------------------
	// Dealer
	
	public function create_noti_dealer($data = array()) {
		$insert = [
			'CaseID'   => $data['CaseID'],
			'DealerID' => $data['DealerID'],
			'Subject'  => $data['Subject'],
			'Detail'   => $data['Detail'],
			'read'     => 0,
			'readdate' => null,
			'INS'      => $this->get_now(),
			'MOD'      => $this->get_now(),
		];
		
		$this->db->insert('notification_dealer', $insert);
		
		return $this->db->insert_id();
	}
	
	public function create_noti_admin($data = array()) {
		$insert = [
			'CaseID'   => $data['CaseID'],
			'Subject'  => $data['Subject'],
			'Detail'   => $data['Detail'],
			'read'     => 0,
			'readdate' => null,
			'INS'      => $this->get_now(),
			'MOD'      => $this->get_now(),
		];
		
		$this->db->insert('notification_admin', $insert);
		
		return $this->db->insert_id();
	}
	
	public function list_noti_admin($unread, $page, $per_page) {
		$offset = ($page - 1) * $per_page;
		
		$this->db->from('notification_admin');
		
		if (!empty($unread)) {
			$this->db->where('read', 0);
			$where['read'] = 0;
		}
		
		$total = $this->db->count_all_results();
		$items = $this->db->order_by('MOD', 'DESC')->get_where('notification_admin', $where, $per_page, $offset)->result();
		
		return ['total' => $total, 'items' => $items];
	}
	
	public function admin_mark_as_read($noti_id) {
		$arraySet = [
			'read'     => 1,
			'readdate' => $this->get_now(),
			'MOD'      => $this->get_now(),
		];
		
		$this->db->where('id', $noti_id);
		return $this->db->update('notification_admin', $arraySet);
	}
	
	public function list_noti_dealer($dealer_id, $unread, $page, $per_page) {
		$offset = ($page - 1) * $per_page;
		
		$this->db->from('notification_dealer');
		$this->db->where('DealerID', $dealer_id);
		$where = ['DealerID' => $dealer_id];
		
		if (!empty($unread)) {
			$this->db->where('read', 0);
			$where['read'] = 0;
		}
		
		$total = $this->db->count_all_results();
		$items = $this->db->order_by('read', 'ASC')->get_where('notification_dealer', $where, $per_page, $offset)->result();
		
		return ['total' => $total, 'items' => $items];
	}
	
	public function dealer_mark_as_read($noti_id, $dealer_id) {
		$arraySet = [
			'read'     => 1,
			'readdate' => $this->get_now(),
			'MOD'      => $this->get_now(),
		];
		
		$this->db->where('id', $noti_id)->where('DealerID', $dealer_id);
		return $this->db->update('notification_dealer', $arraySet);
	}
}
