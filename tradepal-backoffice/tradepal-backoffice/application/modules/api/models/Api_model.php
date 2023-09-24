<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function get_idbydomain($domain = '') {
		$result = $this->db->select('user_id')->from('admin_users')->where('user_name', $domain)->get();
		$row = $result->row_array();
		return ($row ? $row['user_id'] : false);
	}
	
	public function get_allfield($table = '', $except = []) {
		if (is_array($except) && count($except) > 0) {
			$result = $this->db->query('SHOW FIELDS FROM `' . $table . '` WHERE FIELD NOT IN (\'' . implode('\',\'', $except) . '\');');
		} else {
			$result = $this->db->query('SHOW FIELDS FROM `' . $table . '`;');
		}
		# set for return
		$fields = [];
		foreach ($result->result_array() as $key => $row) {
			$fields[] = $row['Field'];
		}
		return implode(',', (array)$fields);
	}
	
	public function get_list($table = '', $data = array(), $field = '', $order = 'desc', $except = array()) {
		$select_field = $this->get_allfield($table, $except);
		$this->db->select($select_field);
		$this->db->from($table);
		if (!empty($data)) :
			if (is_array($data)) :
				foreach ($data as $key => $rows) :
					$this->db->where($key, $rows);
				endforeach;
			endif;
		endif;
		$this->db->order_by($field, $order);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_listwj($table = '', $data = array(), $join_table, $join_data, $join_left, $select = '', $field = '', $order = 'desc') {
		$this->db->select($select);
		$this->db->from($table);
		if (!empty($data)) :
			if (is_array($data)) :
				foreach ($data as $key => $rows) :
					$this->db->where($key, $rows);
				endforeach;
			endif;
		endif;
		if ($join_table) {
			$this->db->join($join_table, $join_data, $join_left);
		}
		$this->db->order_by($field, $order);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_info($table = '', $data = array(), $except = array()) {
		$select_field = $this->get_allfield($table, $except);
		$this->db->select($select_field);
		$this->db->from($table);
		if (!empty($data)) :
			if (is_array($data)) :
				foreach ($data as $key => $rows) :
					$this->db->where($key, $rows);
				endforeach;
			endif;
		endif;
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function get_info_sl($table = '', $data = array(), $field = '*') {
		$this->db->select($field);
		$this->db->from($table);
		if (!empty($data)) :
			if (is_array($data)) :
				foreach ($data as $key => $rows) :
					$this->db->where($key, $rows);
				endforeach;
			endif;
		endif;
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function get_info_wj($table = '', $data = array(), $select = '*', $join_table = '', $join_con = '', $join_type = 'left') {
		$this->db->select($select);
		$this->db->from($table);
		if ($join_table) {
			$this->db->join($join_table, $join_con, $join_type);
		}
		if (!empty($data)) :
			if (is_array($data)) :
				foreach ($data as $key => $rows) :
					$this->db->where($key, $rows);
				endforeach;
			endif;
		endif;
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function mailer($arr_email, $subject, $body, $cc = '') {
		$this->load->library('Mailer');
		
		# set time zone
		$timezone = "Asia/Singapore";
		if (function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
		
		$arr_email = (array)$arr_email;
		$arr_subject = $subject;
		$arr_body = $body;
		
		# Create a new PHPMailer instance
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->CharSet = "utf-8";
		# Enable SMTP debugging
		# 0 = off (for production use)
		# 1 = client messages
		# 2 = client and server messages
//		 $mail->Debugoutput = 'html';
		$mail->SMTPDebug = 0;
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Username = "cs.tradpal@gmail.com";
		$mail->Password = 'blairqhcfqjzqpqz';
		$mail->setFrom('cs.tradpal@gmail.com', 'Tradepal');
		$mail->addReplyTo('cs.tradpal@gmail.com', 'Tradepal');
		
//		        $mail->Username = "siamsoft.dev@gmail.com";
//		        $mail->Password = 'siamsoft2012';
//		        $mail->setFrom('siamsoft.dev@gmail.com', 'siamsoft');
//		        $mail->addReplyTo('siamsoft.dev@gmail.com', 'siamsoft');
		        
		        
		        
		
		foreach ($arr_email as $email) {
			$mail->addAddress($email);
		}
		
		if ($cc != "") $mail->addCC($cc);
		
		$mail->Subject = $arr_subject;
		$mail->msgHTML($arr_body);
		
		if (!$mail->send()) throw new Exception($mail->ErrorInfo, 400);
	}
	
	
	public function mailer_file($arr_email, $subject, $body, $files, $cc = '') {
		$this->load->library('Mailer');
		
		# set time zone
		$timezone = "Asia/Singapore";
		if (function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
		
		$arr_email = (array)$arr_email;
		$arr_subject = $subject;
		$arr_body = $body;
		
		# Create a new PHPMailer instance
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->CharSet = "utf-8";
		# Enable SMTP debugging
		# 0 = off (for production use)
		# 1 = client messages
		# 2 = client and server messages
		// $mail->Debugoutput = 'html';
		$mail->SMTPDebug = 0;
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Username = "cs.tradpal@gmail.com";
		$mail->Password = 'blairqhcfqjzqpqz';
//		$mail->Password = '$$$Tradpal';
		$mail->setFrom('cs.tradpal@gmail.com', 'Tradepal');
		$mail->addReplyTo('cs.tradpal@gmail.com', 'Tradepal');
		
		foreach ($arr_email as $email) {
			$mail->addAddress($email);
		}
		
		foreach ($files as $file) {
			$mail->AddAttachment($file['path'], $file['name']);
		}
		
		if ($cc != "") $mail->addCC($cc);
		
		$mail->Subject = $arr_subject;
		$mail->msgHTML($arr_body);
		
		if (!$mail->send()) throw new Exception($mail->ErrorInfo, 400);
	}
	
	public function mailer_string_attachment($arr_email, $subject, $body, $attachments, $cc = '') {
		$this->load->library('Mailer');
		
		# set time zone
		$timezone = "Asia/Singapore";
		if (function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
		
		$arr_email = (array)$arr_email;
		$arr_subject = $subject;
		$arr_body = $body;
		
		# Create a new PHPMailer instance
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->CharSet = "utf-8";
		# Enable SMTP debugging
		# 0 = off (for production use)
		# 1 = client messages
		# 2 = client and server messages
		// $mail->Debugoutput = 'html';
		$mail->SMTPDebug = 0;
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Username = "cs.tradpal@gmail.com";
		$mail->Password = 'blairqhcfqjzqpqz';
		$mail->setFrom('cs.tradpal@gmail.com', 'Tradepal');
		$mail->addReplyTo('cs.tradpal@gmail.com', 'Tradepal');
		
		foreach ($arr_email as $email) {
			$mail->addAddress($email);
		}
		
		foreach ($attachments as $attachment) {
			$mail->addStringAttachment($attachment['content'], $attachment['name']);
		}
		
		if ($cc != "") $mail->addCC($cc);
		
		$mail->Subject = $arr_subject;
		$mail->msgHTML($arr_body);
		
		if (!$mail->send()) throw new Exception($mail->ErrorInfo, 400);
	}
	
	public function saveBase64Image($base64_image) {
		$image_parts = explode(";base64,", $base64_image);
		$image_type_aux = explode("image/", $image_parts[0]);
		$image_type = $image_type_aux[1];
		
//		$allow_type = ['gif', 'jpg', 'png', 'jpeg'];
//		if (!in_array($image_type, $allow_type)) throw new Exception("Invalid image type.", 400);
		
		$image_base64 = base64_decode($image_parts[1]);
		$file_name = uniqid() . '.' . $image_type;
		$file = APPPATH . '../uploads/' . $file_name;
		file_put_contents($file, $image_base64);
		
		return "/uploads/{$file_name}";
	}
	
	public function saveBase64($base64_image) {
		$image_parts = explode(";base64,", $base64_image);
		$image_type_aux = explode("image/", $image_parts[0]);
		$image_type = $image_type_aux[1];
		
		//		$allow_type = ['gif', 'jpg', 'png', 'jpeg'];
		//		if (!in_array($image_type, $allow_type)) throw new Exception("Invalid image type.", 400);
		
		$image_base64 = base64_decode($image_parts[1]);
		$file_name = uniqid() . '.' . $image_type;
		$file = APPPATH . '../uploads/' . $file_name;
		file_put_contents($file, $image_base64);
		
		return "{$file_name}";
	}
}
