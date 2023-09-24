<?php

use Carbon\Carbon;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dealer_model extends Api_model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function dealer_login_social($type = '', $social_id = '') {
		$select_field = $this->get_allfield('dealer', ['Password', 'VerifyToken']);
		$this->db->select($select_field);
		$this->db->from('dealer');
		($type == 'facebook' ? $this->db->where('facebook_id', $social_id) : '');
		($type == 'google' ? $this->db->where('google_id', $social_id) : '');
		$result = $this->db->get();
		$row = $result->row_array();
		
		if (empty($row)) throw new Exception("Invalid social id", 401);
		
		$row['access_token'] = $this->create_dealer_token($row['ID']);
		unset($row['Password']);
		unset($row['VerifyToken']);
		unset($row['facebook_id']);
		unset($row['google_id']);
		
		return $row;
	}
	
	public function update_dealer_social_id($email = '', $type = '', $social_id = '') {
		if ($type == 'facebook') {
			$this->db->where('Email', $email);
			$this->db->update('dealer', ['facebook_id' => $social_id]);
			return true;
		} else if ($type == 'google') {
			$this->db->where('Email', $email);
			$this->db->update('dealer', ['google_id' => $social_id]);
			return true;
		} else {
			return false;
		}
	}
	
	public function dealer_register($data = array()) {
		$status = 'registered';
		$verify_token = bin2hex(openssl_random_pseudo_bytes(64));
		if (!empty($data['facebook_id']) || !empty($data['google_id'])) {
			$status = 'verified';
			$verify_token = null;
		}
		
		$this->db->insert('dealer', [
			'Email'       => $data['Email'],
			'UserName'    => $data['UserName'],
			'Password'    => md5($data['Password']),
			'facebook_id' => $data['facebook_id'],
			'google_id'   => $data['google_id'],
			'Status'      => $status,
			'RoleID'      => '0',
			'VerifyToken' => $verify_token,
			'INS'         => $this->get_now(),
			'MOD'         => $this->get_now(),
		]);
		
		if ($status === 'registered') $this->send_verify_mail($data['Email'], $verify_token);
		
		$id = $this->db->insert_id();
		$arraySet = ['root_id' => $id];
		$this->db->where('id', $id);
		$this->db->update('dealer', $arraySet);
		
		$this->db->insert('branch', [
			'DealerID'   => $id,
			'BranchName' => "Main",
			'INS'        => $this->get_now(),
			'MOD'        => $this->get_now(),
		]);
		
		$arraySet = ['branch_id' => $this->db->insert_id()];
		$this->db->where('id', $id);
		$this->db->update('dealer', $arraySet);
		
		return $id;
	}
	
	public function send_verify_mail($to, $verify_token) {
		$subject = 'Please verify your email.';
		$verify_link = "https://tradepal.sg/verify/d/{$verify_token}";
		$body = $this->load->view('verify_mail', compact('verify_link'), true);
		$this->models->mailer(array($to), $subject, $body);
	}
	
	public function dealer_confirm_email($verify_token) {
		$select_field = $this->get_allfield('dealer', ['Password']);
		$result = $this->db->select($select_field)->from('dealer')->where('VerifyToken', $verify_token)->get();
		$row = $result->row_array();
		
		if (empty($row)) throw new Exception("Invalid verify token", 400);
		
		$arraySet = [
			'Status'      => 'verified',
			'VerifyToken' => null,
			'MOD'         => $this->get_now()
		];
		
		$this->db->where('VerifyToken', $verify_token);
		return $this->db->update('dealer', $arraySet);
	}
	
	public function dealer_login($username = '', $password = '') {
		$select_field = $this->get_allfield('dealer', ['Password', 'VerifyToken']);
		$result = $this->db->select($select_field)->from('dealer')->where('UserName', $username)->where('Password', md5($password))->where('Status !=', 'disable')->where('delete', '0')->get();
		$row = $result->row_array();
		
		if (empty($row)) throw new Exception("Invalid username or password", 401);
		
		$row['access_token'] = $this->create_dealer_token($row['ID']);
		unset($row['Password']);
		unset($row['VerifyToken']);
		unset($row['PassRecoveryToken']);
		unset($row['facebook_id']);
		unset($row['google_id']);
		
		return $row;
	}
	
	public function create_dealer_token($dealer_id) {
		$now = Carbon::now();
		$token = bin2hex(openssl_random_pseudo_bytes(64));
		$this->db->insert('dealer_access_tokens', [
			'dealer_id'  => $dealer_id,
			'token'      => $token,
			'expired_at' => $now->addDays(7)->toDateTimeString(),
		]);
		return $token;
	}
	
	public function check_access_token($access_token) {
		$select_field = $this->get_allfield('dealer_access_tokens');
		$result = $this->db->select($select_field)->from('dealer_access_tokens')->where('token', $access_token)->get();
		
		$row = $result->row_array();
		if (empty($row)) throw new Exception("Invalid token", 401);
		
		$now = new Carbon();
		$expired_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['expired_at']);
		
		if ($now->greaterThan($expired_at)) throw new Exception("Invalid token", 401);
		return $row;
	}
	
	public function dealer_update_info_complete($data, $dealer_id) {
		$arraySet = [
			'CompanyName'           => $data['CompanyName'],
			'CompanyRegistertionNo' => $data['CompanyRegistertionNo'],
			'CompanyEmail'          => $data['CompanyEmail'],
			'BlockHouseNo'          => $data['BlockHouseNo'],
			'Street'                => $data['Street'],
			'Poscode'               => $data['Poscode'],
			'MobileNo'              => $data['MobileNo'],
			'FaxNo'                 => $data['FaxNo'],
			'TelHome'               => $data['TelHome'],
			'Status'                => 'completed',
			'MOD'                   => $this->get_now()
		];
		
		if (!empty($data['Unit'])) {
			$arraySet['Unit'] = $data['Unit'];
		}
		
		if (!empty($data['BuildingName'])) {
			$arraySet['BuildingName'] = $data['BuildingName'];
		}
		
		if (!empty($data['UseForeignAdd'])) {
			$arraySet['UseForeignAdd'] = $data['UseForeignAdd'];
		}
		
		if (!empty($data['Logo'])) {
			$arraySet['Logo'] = $this->saveBase64Image($data['Logo']);
		}
		
		if (!empty($data['Icon'])) {
			$arraySet['Icon'] = $this->saveBase64Image($data['Icon']);
		}
		
		if (!empty($data['Password'])) {
			$arraySet['Password'] = md5($data['Password']);
		}
		
		
		$this->db->where('id', $dealer_id);
		return $this->db->update('dealer', $arraySet);
	}
	
	public function dealer_set_player_id($player_id, $dealer_id) {
		$arraySet = [
			'PlayerID' => $player_id,
			'MOD'      => $this->get_now()
		];
		
		$this->db->where('id', $dealer_id);
		return $this->db->update('dealer', $arraySet);
	}
	
	public function dealer_get($dealer_id) {
		$select_field = $this->get_allfield('dealer', ['Password', 'VerifyToken']);
		$result = $this->db->select($select_field)->from('dealer')->where('id', $dealer_id)->get();
		$row = $result->row_array();
		
		if (empty($row)) throw new Exception("Dealer not found", 404);
		
		unset($row['Password']);
		unset($row['VerifyToken']);
		unset($row['facebook_id']);
		unset($row['google_id']);
		
		return $row;
	}
	
	public function dealer_send_forgot_password_mail($email) {
		$select_field = $this->get_allfield('dealer', ['Password', 'VerifyToken']);
		$result = $this->db->select($select_field)->from('dealer')->where('Email', $email)->get();
		$row = $result->row_array();
		
		if (empty($row)) throw new Exception("Email cannot be found.", 404);
		
		$token = bin2hex(openssl_random_pseudo_bytes(64));
		$arraySet = ['PassRecoveryToken' => $token];
		
		$this->db->where('Email', $email);
		$this->db->update('dealer', $arraySet);
		
		$subject = 'Forgot your password?';
		
		$pass_recv_link = "https://tradepal.sg/password-recovery/d/{$token}";
		$body = $this->load->view('pass_recv_mail', compact('pass_recv_link'), true);
		$this->models->mailer(array($email), $subject, $body);
	}
	
	public function dealer_reset_password($pass_recv_token, $password) {
		$select_field = $this->get_allfield('dealer', ['Password', 'VerifyToken']);
		$result = $this->db->select($select_field)->from('dealer')->where('PassRecoveryToken', $pass_recv_token)->get();
		$row = $result->row_array();
		
		if (empty($row)) throw new Exception("Invalid token.", 401);
		
		$arraySet = [
			'Password'          => md5($password),
			'PassRecoveryToken' => null,
		];
		
		$this->db->where('id', $row['ID']);
		$this->db->update('dealer', $arraySet);
	}
	
	public function dealer_delete($dealer_id) {
		$this->db->where('id', $dealer_id);
		$this->db->delete('dealer');
	}
	
	public function delele_staff($id = '') {
		$this->db->where('ID', $id);
		$this->db->update('dealer', ['delete' => 1]);
	}
	
	public function dealerstaff_register($data = array()) {
		$status = 'active';
		$verify_token = null;
		
		$arraySet = [
			'root_id'     => $data['root_id'],
			'CompanyName' => $data['CompanyName'],
			'UserName'    => $data['UserName'],
			'Password'    => md5($data['Password']),
			'MobileNo'    => $data['MobileNo'],
			'Email'       => $data['Email'],
			'branch_id'   => $data['branch_id'],
			'Status'      => $status,
			'VerifyToken' => $verify_token,
			'RoleID'      => 1,
			'INS'         => $this->get_now(),
			'MOD'         => $this->get_now(),
		];
		
		if (!empty($data['Logo'])) {
			$arraySet['Logo'] = $this->saveBase64Image($data['Logo']);
		}
		
		$this->db->insert('dealer', $arraySet);
		
		return $this->db->insert_id();
	}
	
	public function save_staff($data = [], $id = '') {
		if ($data && $id) {
			
			$arraySet = [
				'CompanyName' => $data['CompanyName'],
				'MobileNo'    => $data['MobileNo'],
				'Email'       => $data['Email'],
				'branch_id'   => $data['branch_id'],
				'MOD'         => $this->get_now()
			];
			
			if (!empty($data['Logo'])) {
				$arraySet['Logo'] = $this->saveBase64Image($data['Logo']);
			}
			if (!empty($data['Status'])) {
				$arraySet['Status'] = $data['Status'];
			}
			
			
			if (!empty($data['Password'])) {
				$arraySet['Password'] = md5($data['Password']);
			}
			
			$this->db->where('ID', $id);
			$this->db->update('dealer', $arraySet);
			return true;
		} else {
			return false;
		}
	}
}
