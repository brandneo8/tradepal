<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Seller_model extends Api_model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function seller_register($data = array()) {
		$status = 'registered';
		$verify_token = bin2hex(openssl_random_pseudo_bytes(64));
		if (!empty($data['facebook_id']) || !empty($data['google_id'])) {
			$status = 'verified';
			$verify_token = null;
		}
		
		$this->db->insert('seller', [
			'SellerTypeID' => $data['SellerTypeID'],
			'Email'        => $data['Email'],
			'UserName'     => $data['UserName'],
			'Password'     => md5($data['Password']),
			'facebook_id'  => $data['facebook_id'],
			'google_id'    => $data['google_id'],
			'Status'       => $status,
			'VerifyToken'  => $verify_token,
			'INS'          => $this->get_now(),
			'MOD'          => $this->get_now(),
		]);
		
		if ($status === 'registered') $this->send_verify_mail($data['Email'], $verify_token);
		
		return $this->db->insert_id();
	}
	
	public function update_seller_social_id($email = '', $type = '', $social_id = '') {
		if ($type == 'facebook') {
			$this->db->where('Email', $email);
			$this->db->update('seller', ['facebook_id' => $social_id]);
			return true;
		} else if ($type == 'google') {
			$this->db->where('Email', $email);
			$this->db->update('seller', ['google_id' => $social_id]);
			return true;
		} else {
			return false;
		}
	}
	
	public function send_verify_mail($to, $verify_token) {
		$subject = 'Please verify your email.';
		$verify_link = "https://tradepal.sg/verify/s/{$verify_token}";
		$body = $this->load->view('verify_mail', compact('verify_link'), true);
		$this->models->mailer(array($to), $subject, $body);
	}
	

	
	public function seller_confirm_email($verify_token) {
		$select_field = $this->get_allfield('seller', ['Password']);
		$result = $this->db->select($select_field)->from('seller')->where('VerifyToken', $verify_token)->get();
		$row = $result->row_array();
		
		if (empty($row)) throw new Exception("Invalid verify token", 400);
		
		$arraySet = [
			'Status'      => 'verified',
			'VerifyToken' => null,
			'MOD'         => $this->get_now()
		];
		
		$this->db->where('VerifyToken', $verify_token);
		return $this->db->update('seller', $arraySet);
	}
	
	public function seller_login($username = '', $password = '') {
		$select_field = $this->get_allfield('seller', ['Password', 'VerifyToken']);
		$result = $this->db->select($select_field)->from('seller')->where('UserName', $username)->where('Password', md5($password))->where('delete', '0')->get();
		$row = $result->row_array();
		
		if (empty($row)) throw new Exception("Invalid username or password", 401);
		
		$row['access_token'] = $this->create_seller_token($row['ID']);
		unset($row['Password']);
		unset($row['VerifyToken']);
		unset($row['PassRecoveryToken']);
		unset($row['facebook_id']);
		unset($row['google_id']);
		
		return $row;
	}
	
	public function seller_login_social($type = '', $social_id = '') {
		$select_field = $this->get_allfield('seller', ['Password']);
		$this->db->select($select_field);
		$this->db->from('seller');
		($type == 'facebook' ? $this->db->where('facebook_id', $social_id) : '');
		($type == 'google' ? $this->db->where('google_id', $social_id) : '');
		$result = $this->db->get();
		$row = $result->row_array();
		
		if ($row) {
			$row['access_token'] = $this->create_seller_token($row['ID']);
			unset($row['Password']);
		}
		
		return ($row ? $row : false);
	}
	
	public function create_seller_token($seller_id) {
		$now = Carbon\Carbon::now();
		$token = bin2hex(openssl_random_pseudo_bytes(64));
		$this->db->insert('seller_access_tokens', [
			'seller_id'  => $seller_id,
			'token'      => $token,
			'expired_at' => $now->addDays(7)->toDateTimeString(),
		]);
		return $token;
	}
	
	public function check_access_token($access_token) {
		$select_field = $this->get_allfield('seller_access_tokens');
		$result = $this->db->select($select_field)->from('seller_access_tokens')->where('token', $access_token)->get();
		
		$row = $result->row_array();
		if (empty($row)) throw new Exception("Invalid token", 401);
		
		
		$now = new Carbon\Carbon();
		$expired_at = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $row['expired_at']);
		
		if ($now->greaterThan($expired_at)) throw new Exception("Invalid token", 401);
		return $row;
	}
	
	public function seller_update_info_complete_individual($data, $seller_id) {
		$arraySet = [
			'IDType'       => $data['IDType'],
			'IDNo'         => $data['IDNo'],
			'Name'         => $data['Name'],
			'TelephoneNo'  => $data['TelephoneNo'],
			'BlkHseNo'     => $data['BlkHseNo'],
			'Street'       => $data['Street'],
			'Unit'         => $data['Unit'],
			'BuildingName' => $data['BuildingName'],
			'PostalCode'   => $data['PostalCode'],
			'Status'       => 'completed',
			'MOD'          => $this->get_now()
		];
		
		if (!empty($data['ProfileImage'])) {
			$arraySet['ProfileImage'] = $this->saveBase64Image($data['ProfileImage']);
		}
		
		if (!empty($data['BuildingName'])) {
			$arraySet['BuildingName'] = $data['BuildingName'];
		}
		
		if (!empty($data['Password'])) {
			$arraySet['Password'] = md5($data['Password']);
		}
		
		$this->db->where('id', $seller_id);
		return $this->db->update('seller', $arraySet);
	}
	
	public function seller_update_info_complete_company($data, $seller_id) {
		$arraySet = [
			'IDType'        => $data['IDType'],
			'IDNo'          => $data['IDNo'],
			'Name'          => $data['Name'],
			'TelephoneNo'   => $data['TelephoneNo'],
			'FaxNo'         => $data['FaxNo'],
			'BlkHseNo'      => $data['BlkHseNo'],
			'Street'        => $data['Street'],
			'Unit'          => $data['Unit'],
			'PostalCode'    => $data['PostalCode'],
			'ContactName'   => $data['ContactName'],
			'ContactMobile' => $data['ContactMobile'],
			'Status'        => 'completed',
			'MOD'           => $this->get_now()
		];
		
		if (!empty($data['ProfileImage'])) {
			$arraySet['ProfileImage'] = $this->saveBase64Image($data['ProfileImage']);
		}
		
		if (!empty($data['BuildingName'])) {
			$arraySet['BuildingName'] = $data['BuildingName'];
		}
		
		if (!empty($data['Password'])) {
			$arraySet['Password'] = md5($data['Password']);
		}
		
		
		$this->db->where('id', $seller_id);
		return $this->db->update('seller', $arraySet);
	}
	
	public function seller_set_player_id($player_id, $seller_id) {
		$arraySet = [
			'PlayerID' => $player_id,
			'MOD'      => $this->get_now()
		];
		
		$this->db->where('id', $seller_id);
		return $this->db->update('seller', $arraySet);
	}
	
	public function seller_get($seller_id) {
		if (empty($seller_id)) return array('ID' => null);
		$select_field = $this->get_allfield('seller', ['Password', 'VerifyToken']);
		$result = $this->db->select($select_field)->from('seller')->where('id', $seller_id)->get();
		$row = $result->row_array();
		
		if (empty($row)) throw new Exception("Seller not found", 404);
		
		unset($row['Password']);
		unset($row['VerifyToken']);
		unset($row['PassRecoveryToken']);
		unset($row['facebook_id']);
		unset($row['google_id']);
		
		return $row;
	}
	
	public function get_seller_types() {
		return $this->db->get('seller_type')->result();
	}
	
	public function seller_get_by_nric($seller_nric) {
		$select_field = $this->get_allfield('seller', ['Password', 'VerifyToken']);
		$result = $this->db->select($select_field)->from('seller')->where('IDNo', $seller_nric)->get();
		$row = $result->row_array();
		
		if (!empty($row)) {
			unset($row['Password']);
			unset($row['VerifyToken']);
			unset($row['facebook_id']);
			unset($row['google_id']);
			
			return $row;
		}
		
		return array();
		
	}
	
	public function seller_get_by_name($name) {
		$select_field = $this->get_allfield('seller', ['Password', 'VerifyToken']);
		$result = $this->db->select($select_field)->from('seller')->like('FirstName', $name, 'both')->or_like('LastName', $name, 'both')->get();
		$row = $result->result();
		
		if (empty($row)) throw new Exception("Seller not found", 404);
		
		return $row;
	}
	
	public function seller_send_forgot_password_mail($email) {
		$select_field = $this->get_allfield('seller', ['Password', 'VerifyToken']);
		$result = $this->db->select($select_field)->from('seller')->where('Email', $email)->get();
		$row = $result->row_array();
		
		if (empty($row)) throw new Exception("Email cannot be found.", 404);
		
		$token = bin2hex(openssl_random_pseudo_bytes(64));
		$arraySet = ['PassRecoveryToken' => $token];
		
		$this->db->where('Email', $email);
		$this->db->update('seller', $arraySet);
		
		$subject = 'Forgot your password?';
		
		$pass_recv_link = "https://tradepal.sg/password-recovery/s/{$token}";
		$body = $this->load->view('pass_recv_mail', compact('pass_recv_link'), true);
		$this->models->mailer(array($email), $subject, $body);
	}
	
	public function seller_reset_password($pass_recv_token, $password) {
		$select_field = $this->get_allfield('seller', ['Password', 'VerifyToken']);
		$result = $this->db->select($select_field)->from('seller')->where('PassRecoveryToken', $pass_recv_token)->get();
		$row = $result->row_array();
		
		if (empty($row)) throw new Exception("Invalid token.", 401);
		
		$arraySet = [
			'Password'          => md5($password),
			'PassRecoveryToken' => null,
		];
		
		$this->db->where('id', $row['ID']);
		$this->db->update('seller', $arraySet);
	}
	
	public function seller_delete($seller_id) {
		$this->db->where('id', $seller_id);
		$this->db->delete('seller');
	}
	
	public function seller_update_id_photo($data, $seller_id) {
		$arraySet = [
			'IDPhoto' => $this->saveBase64Image($data),
			'MOD'     => $this->get_now()
		];
		
		$this->db->where('id', $seller_id);
		return $this->db->update('seller', $arraySet);
	}
	
	public function seller_check_dup_id_no($id_no, $id) {
		$select_field = $this->get_allfield('seller', ['Password', 'VerifyToken']);
		$result = $this->db->select($select_field)->from('seller')->where('IDNo', $id_no)->where('ID !=', $id)->get();
		$row = $result->row_array();
		
		return count($row) > 0;
	}
}
