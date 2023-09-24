<?php

use Carbon\Carbon;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class CaseStatus_model extends Api_model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function create($data = array()) {
		$insert = [
			'CaseID'                   => $data['CaseID'],
			'DealerID'                 => $data['DealerID'],
			'SellerID'                 => $data['SellerID'],
			'TradpalID'                => $data['TradpalID'],
			'StatusID'                 => $data['StatusID'],
			'HPDepositType'            => $data['HPDepositType'],
			'HPChequeNo'               => $data['HPChequeNo'],
			'HPAmount'                 => $data['HPAmount'],
			'HPBalanceDue'             => $data['HPBalanceDue'],
			'HPDeliveredOn'            => $data['HPDeliveredOn'],
			'BankAmount'               => $data['BankAmount'],
			'SellerBankAccount'        => $data['SellerBankAccount'],
			'AppointmentDate'          => $data['AppointmentDate'],
			'AppointmentTime'          => $data['AppointmentTime'],
			'AppointmentTimeTo'        => $data['AppointmentTimeTo'],
			'AppointmentPlace'         => $data['AppointmentPlace'],
			'AppointmentLat'           => $data['AppointmentLat'],
			'AppointmentLng'           => $data['AppointmentLng'],
			'AppointmentDescription'   => $data['AppointmentDescription'],
			'LoanDocument1'            => $data['LoanDocument1'],
			'LoanDocument2'            => $data['LoanDocument2'],
			'LoanDocument3'            => $data['LoanDocument3'],
			'LoanDocument4'            => $data['LoanDocument4'],
			'LoanDocument5'            => $data['LoanDocument5'],
			'DocAgreement1'            => $data['DocAgreement1'],
			'DocAgreement2'            => $data['DocAgreement2'],
			'DocAgreement3'            => $data['DocAgreement3'],
			'DocAgreement4'            => $data['DocAgreement4'],
			'SignedFullSettlement'     => $data['SignedFullSettlement'],
			'MoneyTransferredCarOwner' => $data['MoneyTransferredCarOwner'],
			'BankName'                 => $data['BankName'],
			'FrontIDPhoto'             => $data['FrontIDPhoto'],
			'BackIDPhoto'              => $data['BackIDPhoto'],
			'LoanRequested'            => $data['LoanRequested'],
			'TermAndConditionAccept'   => $data['TermAndConditionAccept'],
			'IP'                       => $data['IP'],
			'AmountDue'                => $data['AmountDue'],
			'CarOwnerBankName'         => $data['CarOwnerBankName'],
			'CarOwnerBankAccountNo'    => $data['CarOwnerBankAccountNo'],
			'Remark'                   => $data['Remark'],
			'INS'                      => $this->get_now(),
			'MOD'                      => $this->get_now(),
		];
		
		$this->db->insert('status_log', $insert);
		
		$id = $this->db->insert_id();
		
		$arraySet = [
			'Status' => $data['StatusID'],
			'MOD'    => $this->get_now(),
		];
		
		$this->db->where('id', $data['CaseID']);
		return $this->db->update('case', $arraySet);
	}
	
	public function create_logs($data = array()) {
		$insert = [
			'CaseID'                   => $data['CaseID'],
			'DealerID'                 => $data['DealerID'],
			'SellerID'                 => $data['SellerID'],
			'TradpalID'                => $data['TradpalID'],
			'StatusID'                 => $data['StatusID'],
			'HPDepositType'            => $data['HPDepositType'],
			'HPChequeNo'               => $data['HPChequeNo'],
			'HPAmount'                 => $data['HPAmount'],
			'HPBalanceDue'             => $data['HPBalanceDue'],
			'HPDeliveredOn'            => $data['HPDeliveredOn'],
			'BankAmount'               => $data['BankAmount'],
			'SellerBankAccount'        => $data['SellerBankAccount'],
			'AppointmentDate'          => $data['AppointmentDate'],
			'AppointmentTime'          => $data['AppointmentTime'],
			'AppointmentTimeTo'        => $data['AppointmentTimeTo'],
			'AppointmentPlace'         => $data['AppointmentPlace'],
			'AppointmentLat'           => $data['AppointmentLat'],
			'AppointmentLng'           => $data['AppointmentLng'],
			'AppointmentDescription'   => $data['AppointmentDescription'],
			'LoanDocument1'            => $data['LoanDocument1'],
			'LoanDocument2'            => $data['LoanDocument2'],
			'LoanDocument3'            => $data['LoanDocument3'],
			'LoanDocument4'            => $data['LoanDocument4'],
			'LoanDocument5'            => $data['LoanDocument5'],
			'DocAgreement1'            => $data['DocAgreement1'],
			'DocAgreement2'            => $data['DocAgreement2'],
			'DocAgreement3'            => $data['DocAgreement3'],
			'DocAgreement4'            => $data['DocAgreement4'],
			'SignedFullSettlement'     => $data['SignedFullSettlement'],
			'MoneyTransferredCarOwner' => $data['MoneyTransferredCarOwner'],
			'BankName'                 => $data['BankName'],
			'FrontIDPhoto'             => $data['FrontIDPhoto'],
			'BackIDPhoto'              => $data['BackIDPhoto'],
			'LoanRequested'            => $data['LoanRequested'],
			'TermAndConditionAccept'   => $data['TermAndConditionAccept'],
			'IP'                       => $data['IP'],
			'AmountDue'                => $data['AmountDue'],
			'CarOwnerBankName'         => $data['CarOwnerBankName'],
			'CarOwnerBankAccountNo'    => $data['CarOwnerBankAccountNo'],
			'Remark'                   => $data['Remark'],
			'INS'                      => $this->get_now(),
			'MOD'                      => $this->get_now(),
		];
		
		$this->db->insert('status_log', $insert);
		
		$id = $this->db->insert_id();
		

		return 	$id;
	}
	
	public function create_log($data = array()) {
		$insert = [
			'CaseID'                   => $data['CaseID'],
			'StatusID'                 => $data['StatusID'],
			'INS'                      => $this->get_now(),
			'MOD'                      => $this->get_now(),
		];
		
		$this->db->insert('status_log', $insert);
		
		$id = $this->db->insert_id();
		
	
		return $id;
	}
	
	public function create_insert_input_ba($data = array()) {
		$insert = [
			'CaseID'                   => $data['CaseID'],
			'DealerID'                 => $data['DealerID'],
			'SellerID'                 => $data['SellerID'],
			'TradpalID'                => $data['TradpalID'],
			'StatusID'                 => 8,
			'HPDepositType'            => $data['HPDepositType'],
			'HPChequeNo'               => $data['HPChequeNo'],
			'HPAmount'                 => $data['HPAmount'],
			'HPBalanceDue'             => $data['HPBalanceDue'],
			'HPDeliveredOn'            => $data['HPDeliveredOn'],
			'BankAmount'               => $data['BankAmount'],
			'SellerBankAccount'        => $data['SellerBankAccount'],
			'AppointmentDate'          => $data['AppointmentDate'],
			'AppointmentTime'          => $data['AppointmentTime'],
			'AppointmentTimeTo'        => $data['AppointmentTimeTo'],
			'AppointmentPlace'         => $data['AppointmentPlace'],
			'AppointmentLat'           => $data['AppointmentLat'],
			'AppointmentLng'           => $data['AppointmentLng'],
			'AppointmentDescription'   => $data['AppointmentDescription'],
			'LoanDocument1'            => $data['LoanDocument1'],
			'LoanDocument2'            => $data['LoanDocument2'],
			'LoanDocument3'            => $data['LoanDocument3'],
			'LoanDocument4'            => $data['LoanDocument4'],
			'LoanDocument5'            => $data['LoanDocument5'],
			'DocAgreement1'            => $data['DocAgreement1'],
			'DocAgreement2'            => $data['DocAgreement2'],
			'DocAgreement3'            => $data['DocAgreement3'],
			'DocAgreement4'            => $data['DocAgreement4'],
			'SignedFullSettlement'     => $data['SignedFullSettlement'],
			'MoneyTransferredCarOwner' => $data['MoneyTransferredCarOwner'],
			'BankName'                 => $data['BankName'],
			'FrontIDPhoto'             => $data['FrontIDPhoto'],
			'BackIDPhoto'              => $data['BackIDPhoto'],
			'LoanRequested'            => $data['LoanRequested'],
			'TermAndConditionAccept'   => $data['TermAndConditionAccept'],
			'IP'                       => $data['IP'],
			'AmountDue'                => $data['AmountDue'],
			'CarOwnerBankName'         => $data['CarOwnerBankName'],
			'CarOwnerBankAccountNo'    => $data['CarOwnerBankAccountNo'],
			'Remark'                   => $data['Remark'],
			'INS'                      => $this->get_now(),
			'MOD'                      => $this->get_now(),
		];
		
		$this->db->insert('status_log', $insert);
		
		$id = $this->db->insert_id();
		if ($data['StatusID'] == 6) {
			$arraySet = [
				'Status' => 8,
				'MOD'    => $this->get_now(),
			];
			$this->db->where('id', $data['CaseID']);
			$this->db->update('case', $arraySet);
		}
		
		return $id;
		
	}
	
	public function send_dealer_reject_hp_mail($case, $root) {
		$to = [];
		foreach ($this->get_tradpal_email() as $email) $to[] = $email;
		
		$subject = "Case {$case->ID}: {$root['UserName']} reject hire purchase";
		$body = $this->load->view('dealer_reject_hp_mail', compact('case', 'root'), true);
		$this->models->mailer($to, $subject, $body);
	}
	
	public function send_dealer_accept_bank_amount_mail($case, $root) {
		$to = [];
		foreach ($this->get_tradpal_email() as $email) $to[] = $email;
		
		$subject = "Case {$case->ID}: {$root['UserName']} accept bank amount";
		$body = $this->load->view('dealer_accept_bank_amount_mail', compact('case', 'root'), true);
		$this->models->mailer($to, $subject, $body);
	}
	
	public function send_dealer_reject_bank_amount_mail($case, $root) {
		$to = [];
		foreach ($this->get_tradpal_email() as $email) $to[] = $email;
		
		$subject = "Case {$case->ID}: {$root['UserName']} reject bank amount";
		$body = $this->load->view('dealer_reject_bank_amount_mail', compact('case', 'root'), true);
		$this->models->mailer($to, $subject, $body);
	}
	
	public function get_tradpal_email() {
		$select_field = $this->get_allfield('notification_email', []);
		$result = $this->db->select($select_field)->from('notification_email')->where('Type', 'tradepal')->get();
		$row = $result->row_array();
		
		return $row;
	}
	
	public function get_today_appointment() {
		$today = new Carbon();
		$select_field = $this->get_allfield('status_log', []);
		$result = $this->db->select($select_field)->from('status_log')->where('order_date >=', $today->startOfDay())->where('order_date <=', $today->endOfDay())->get();
		$row = $result->row_array();
		
		return $row;
	}
	
	public function get_case_status_noti_conf($status_id) {
		$select_field = $this->get_allfield('case_status', []);
		$result = $this->db->select($select_field)->from('case_status')->where('ID', $status_id)->get();
		$row = $result->row_array();
		
		return $row;
	}
	
	public function send_noti_mail($to, $subject, $detail) {
		$to = explode(',', $to);
		foreach ($to as &$i) $i = trim($i);
		$body = $this->load->view('noti_mail', compact('detail'), true);
		$this->models->mailer($to, $subject, $body);
	}
	
	public function updateAppointment($data = array()) {
		$arraySet = [
			'AppointmentDate'   => $data['AppointmentDate'],
			'AppointmentTime'   => $data['AppointmentTime'],
			'AppointmentTimeTo' => $data['AppointmentTimeTo'],
			'AppointmentPlace'  => $data['AppointmentPlace'],
			'SellerBankAccount' => $data['SellerBankAccount'],
			'BankName'          => $data['BankName'],
			'MOD'               => $this->get_now(),
		];
		
		$this->db->where('ID', $data['StatusID']);
		return $this->db->update('status_log', $arraySet);
		
//
//		$arraySet2 = [
//			'Status' => 15,
//			'MOD'    => $this->get_now(),
//		];
//
//		$this->db->where('id', $data['CaseID']);
//		return $this->db->update('case', $arraySet2);
	}
	
	public function get_status_by_id($status_id) {
		$select_field = $this->get_allfield('status_log', []);
		$result = $this->db->select($select_field)->from('status_log')->where('ID', $status_id)->get();
		$row = $result->row_array();
		
		return $row;
	}
}
