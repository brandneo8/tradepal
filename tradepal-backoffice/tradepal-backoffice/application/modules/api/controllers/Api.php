<?php

use Carbon\Carbon;

defined('BASEPATH') or exit('No direct script access allowed');
require_once dirname(__FILE__) . '/../../../libraries/mpdf-6.0.0/mpdf.php';

class Api extends MY_Controller {
	
	var $request = 'get';
	var $model_name = 'Api_model';
	var $page_title = "api";
	var $output_data = array();
	var $user_id;
	
	public function __construct() {
		parent::__construct();
		$this->load->library('user_agent');
		//        $this->load->library('mpdf');
		$this->load->model($this->model_name, 'models');
		$this->load->model('Other_model', 'oth_model');
		$this->load->model('SGAddress_model', 'sgaddress_models');
		$this->load->model('Dealer_model', 'dealer_models');
		$this->load->model('Seller_model', 'seller_models');
		$this->load->model('Case_model', 'case_models');
		$this->load->model('CaseStatus_model', 'case_status_models');
		$this->load->model('Onesignal_model', 'onesignal_models');
		$this->load->model('Noti_model', 'noti_models');
		$this->load->model('Survey_model', 'survey_models');
		$this->load->model('main_model', 'mainm');
		$this->load->model('resp_model', 'resp');
		
		# Define value by Dynamic
		foreach ($this->raw_data as $key => $row) {
			$this->{$key} = $row;
		}
		
		# Initial message
		$this->data->status = 1;
		$this->data->message = 'no data found.';
		$this->data->reason = '';
		$this->data->data = [];
	}
	
	public function test_mails() {
		$subject = 'email template';
		$body = $this->load->view('api/test-mail.php', null, true);
		$this->models->mailer(array('songwut.p@gmail.com'), $subject, $body);
		
	}
	
	// ----------------------------------------------------------------------------------------------------------------
	// Seller: Por
	
	public function seller_login_withsocial() {
		# require permission or not
		$this->checkPermissionJson(1, $this->raw_data);
		
		# SET Required field
		$this->required_field = array('social_type', 'social_id', 'email');
		
		# Validate
		$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
		
		# Checkpont and process
		if ($validate_result['check_point'] > 0) :
			$this->data->message = $validate_result['message'];
		else :
			
			$get_hasemail = $this->models->get_info('seller', ['Email' => $this->email]);
			if ($get_hasemail) {
				$this->seller_models->update_seller_social_id($this->email, $this->social_type, $this->social_id);
			}
			
			$get_result = $this->seller_models->seller_login_social($this->social_type, $this->social_id);
			if ($get_result) :
				$this->data->status = 0;
				$this->data->message = 'login_success';
				$this->data->data = $get_result;
			else :
				$this->data->status = 1;
				$this->data->message = 'login_false';
			endif;
		endif;
		
		$this->renderJson($this->data, $this->data->header);
	}
	

	
	
	// ----------------------------------------------------------------------------------------------------------------
	// Seller: Eak
	
	public function seller_register() {
		try {
			$this->checkPermissionJson(1, $this->raw_data);
			$this->required_field = [
				'Email',
				'UserName',
				'Password',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$get_email = $this->mains->sumdataRepeat('seller', ['Email' => $this->Email]);
			if ($get_email) throw new Exception('The email has been taken by another users.', 400);
			
			$get_username = $this->mains->sumdataRepeat('seller', ['UserName' => $this->UserName]);
			if ($get_username) throw new Exception('The username has been taken by another users.', 400);
			
			$result_register = $this->seller_models->seller_register($this->raw_data);
			
			if (empty($result_register)) throw new Exception('Can\'t save data into database.', 500);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully registered!';
			$this->data->data = $result_register;
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function seller_confirm_email() {
		try {
			$input = $this->input->get();
			$this->required_field = array('verify_token');
			$validate_result = $this->mains->re_validate($this->required_field, $input);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$this->seller_models->seller_confirm_email($input['verify_token']);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully confirm your email.';
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function seller_login() {
		try {
			$this->checkPermissionJson(1, $this->raw_data);
			
			$this->required_field = array('UserName', 'Password');
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$get_result = $this->seller_models->seller_login($this->UserName, $this->Password);
			if ($get_result['Status'] === 'registered') throw new Exception("Please verify your email", 403);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully logged-in';
			$this->data->data = $get_result;
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function seller_get_me() {
		try {
			$this->required_field = [
				'access_token',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$access_token = $this->seller_models->check_access_token($this->raw_data['access_token']);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully get seller profile';
			$this->data->data = $this->seller_models->seller_get($access_token['seller_id']);;
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function seller_view() {
		try {
			$this->required_field = [
				'id',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			
			$this->data->status = 0;
			$this->data->message = 'Successfully get seller profile';
			$this->data->data = $this->seller_models->seller_get($this->raw_data['id']);
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function seller_update_info_complete_individual() {
		try {
			$access_token = array();
			if (!empty($this->raw_data['access_token'])) {
				$access_token = $this->seller_models->check_access_token($this->raw_data['access_token']);
			} else {
				$access_token['seller_id'] = $this->raw_data['seller_id'];
			}
			$this->required_field = [
				'IDType',
				'IDNo',
				'Name',
				'TelephoneNo',
				'BlkHseNo',
				'Street',
				'Unit',
				'PostalCode',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$dup_id_no = $this->seller_models->seller_check_dup_id_no($this->raw_data['IDNo'], $access_token['seller_id']);
			if ($dup_id_no) throw new Exception('The ID number has been taken by another users.', 400);
			
			$seller = $this->seller_models->seller_get($access_token['seller_id']);
			if ($seller['SellerTypeID'] !== '1') throw new Exception('Invalid seller type.', 400);
			
			$this->seller_models->seller_update_info_complete_individual($this->raw_data, $access_token['seller_id']);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully updated Individual Seller Info';
			$this->data->data = $seller;
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function seller_update_info_complete_company() {
		try {
	
			$access_token = array();
			if (!empty($this->raw_data['access_token'])) {
				$access_token = $this->seller_models->check_access_token($this->raw_data['access_token']);
			} else {
				$access_token['seller_id'] = $this->raw_data['seller_id'];
			}
			
			$this->required_field = [
				'IDType',
				'IDNo',
				'Name',
				'TelephoneNo',
				'FaxNo',
				'BlkHseNo',
				'Street',
				'Unit',
				'PostalCode',
				'ContactName',
				'ContactMobile',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$dup_id_no = $this->seller_models->seller_check_dup_id_no($this->raw_data['IDNo'], $access_token['seller_id']);
			if ($dup_id_no) throw new Exception('The ID number has been taken by another users.', 400);
			
			$seller = $this->seller_models->seller_get($access_token['seller_id']);
			if ($seller['SellerTypeID'] !== '2') throw new Exception('Invalid seller type.', 400);
			
			$this->seller_models->seller_update_info_complete_company($this->raw_data, $access_token['seller_id']);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully updated Company Seller Info';
			$this->data->data = $this->seller_models->seller_get($access_token['seller_id']);
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function get_seller_types() {
		try {
			$this->data->status = 0;
			$this->data->message = 'Successfully retrieve seller types';
			$this->data->data = $this->seller_models->get_seller_types();
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function seller_set_player_id() {
		try {
			$access_token = $this->seller_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'PlayerID',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$this->seller_models->seller_set_player_id($this->raw_data['PlayerID'], $access_token['seller_id']);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully update seller individual info';
			$this->data->data = $this->seller_models->seller_get($access_token['seller_id']);
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function seller_send_forgot_password_mail() {
		try {
			$this->checkPermissionJson(1, $this->raw_data);
			$this->required_field = [
				'Email',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$this->seller_models->seller_send_forgot_password_mail($this->raw_data['Email']);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully send password recovery email.';
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function seller_reset_password() {
		try {
			$this->checkPermissionJson(1, $this->raw_data);
			$this->required_field = [
				'Password',
				'PassRecoveryToken',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$this->seller_models->seller_reset_password($this->raw_data['PassRecoveryToken'], $this->raw_data['Password']);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully reset password.';
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function seller_delete() {
		try {
			$this->checkPermissionJson(1, $this->raw_data);
			
			$this->required_field = array('id');
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$id = $this->raw_data['id'];
			$this->seller_models->seller_delete($id);
			$this->data->status = 0;
			$this->data->message = "Successfully delete seller id {$id}";
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function seller_update_id_photo() {
		try {
			$access_token = $this->seller_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'IDPhoto',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$seller = $this->seller_models->seller_get($access_token['seller_id']);
			if ($seller['SellerTypeID'] !== '2') throw new Exception('Invalid seller type.', 400);
			
			$this->seller_models->seller_update_id_photo($this->raw_data['IDPhoto'], $access_token['seller_id']);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully update seller company info';
			$this->data->data = $this->seller_models->seller_get($access_token['seller_id']);
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	// ----------------------------------------------------------------------------------------------------------------
	// Dealer: Por
	
	public function dealer_login_withsocial() {
		try {
			$this->checkPermissionJson(1, $this->raw_data);
			
			$this->required_field = array('social_type', 'social_id', 'email');
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$get_hasemail = $this->models->get_info('dealer', ['Email' => $this->email]);
			if ($get_hasemail) {
				$this->dealer_models->update_dealer_social_id($this->email, $this->social_type, $this->social_id);
			}
			
			$get_result = $this->dealer_models->dealer_login_social($this->social_type, $this->social_id);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully logged-in';
			$this->data->data = $get_result;
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	// ----------------------------------------------------------------------------------------------------------------
	// Dealer: Eak
	
	public function dealer_register() {
		try {
			$this->checkPermissionJson(1, $this->raw_data);
			$this->required_field = [
				'Email',
				'UserName',
				'Password',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$get_email = $this->mains->sumdataRepeat('dealer', ['Email' => $this->Email]);
			if ($get_email) throw new Exception('The email has been taken by another users.', 400);
			
			$get_username = $this->mains->sumdataRepeat('dealer', ['UserName' => $this->UserName]);
			if ($get_username) throw new Exception('The username has been taken by another users.', 400);
			
			$result_register = $this->dealer_models->dealer_register($this->raw_data);
			
			if (empty($result_register)) throw new Exception('Can\'t save data into database.', 500);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully registered!';
			$this->data->data = $result_register;
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_confirm_email() {
		try {
			$input = $this->input->get();
			$this->required_field = array('verify_token');
			$validate_result = $this->mains->re_validate($this->required_field, $input);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$this->dealer_models->dealer_confirm_email($input['verify_token']);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully confirm your email.';
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_login() {
		try {
			$this->checkPermissionJson(1, $this->raw_data);
			
			$this->required_field = array('UserName', 'Password');
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$get_result = $this->dealer_models->dealer_login($this->UserName, $this->Password);
			if ($get_result['Status'] === 'registered') throw new Exception("Please verify your email", 403);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully logged-in';
			$this->data->data = $get_result;
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_get_me() {
		try {
			$this->required_field = [
				'access_token',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully get dealer profile';
			$this->data->data = $this->dealer_models->dealer_get($access_token['dealer_id']);;
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_view() {
		try {
			$this->required_field = [
				'id',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			
			$this->data->status = 0;
			$this->data->message = 'Successfully get dealer profile';
			$this->data->data = $this->dealer_models->dealer_get($this->raw_data['id']);
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_update_info_complete() {
		try {
			
			$access_token = array();
			if (!empty($this->raw_data['access_token'])) {
				$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			} else {
				$access_token['dealer_id'] = $this->raw_data['dealer_id'];
			}
			
			
			
			$this->required_field = [
				'CompanyName',
				'CompanyEmail',
				'CompanyRegistertionNo',
				'BlockHouseNo',
				'Street',
				'MobileNo',
				'TelHome',
				'FaxNo',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$this->dealer_models->dealer_update_info_complete($this->raw_data, $access_token['dealer_id']);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully updated Dealer info';
			$this->data->data = $this->dealer_models->dealer_get($access_token['dealer_id']);
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function staff_update_info() {
		

		
		
		$access_token = array();
		if (!empty($this->raw_data['access_token'])) {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
		} else {
			$access_token['dealer_id'] = $this->raw_data['dealer_id'];
		}
		# SET Required field
		$this->required_field = array('CompanyName', 'MobileNo', 'Email', 'branch_id');
		
		# Validate
		$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
		
		# Checkpont and process
		if ($validate_result['check_point'] > 0) :
			$this->data->message = $validate_result['message'];
		else :
			
			$get_data = $this->mains->sumdataRepeat('dealer', ['ID' => $access_token['dealer_id']]);
			if ($get_data) {
				try {
					
					$saveData = $this->dealer_models->save_staff($this->raw_data, $access_token['dealer_id']);
					
					if ($saveData) {
						$this->data->status = 0;
						$this->data->message = 'Successfully saved staff';
					} else {
						$this->data->status = 1;
						$this->data->message = 'Failed to saved staff';
					}
				} catch (Exception $e) {
					$this->data->status = $e->getCode();
					$this->data->message = $e->getMessage();
				}
			} else {
				$this->data->status = 1;
				$this->data->message = 'Staff not found';
			}
		
		endif;
		$this->renderJson($this->data, $this->data->header);
		
	}
	
	public function dealer_send_forgot_password_mail() {
		try {
			$this->checkPermissionJson(1, $this->raw_data);
			$this->required_field = [
				'Email',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$this->dealer_models->dealer_send_forgot_password_mail($this->raw_data['Email']);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully send password recovery email.';
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_set_player_id() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'PlayerID',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$this->dealer_models->dealer_set_player_id($this->raw_data['PlayerID'], $access_token['dealer_id']);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully update dealer player ID';
			$this->data->data = $this->dealer_models->dealer_get($access_token['dealer_id']);
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_reset_password() {
		try {
			$this->checkPermissionJson(1, $this->raw_data);
			$this->required_field = [
				'Password',
				'PassRecoveryToken',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$this->dealer_models->dealer_reset_password($this->raw_data['PassRecoveryToken'], $this->raw_data['Password']);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully reset password.';
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_delete() {
		try {
			$this->checkPermissionJson(1, $this->raw_data);
			
			$this->required_field = array('id');
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$id = $this->raw_data['id'];
			$this->dealer_models->dealer_delete($id);
			$this->data->status = 0;
			$this->data->message = "Successfully delete dealer id {$id}";
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	// ----------------------------------------------------------------------------------------------------------------
	// Case: Eak
	
	public function dealer_create_case() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'SellerID',
				'NRIC',
				'VehicleNo',
				'ChassisNo',
				'EngineNo',
				'OriginalRegnDate',
				'YearOfManufacture',
				'PriceAgreed',
				'DepositAmount',
				'Video',
				'Photo1',
				'Photo2',
				'Photo3',
				'Photo4',
				'Photo5',
				'Photo6',
				'VehicleMake',
				'VehicleModel',
				'PrimaryColour',
				'OutStandingHirePurchaseLoan',
				'BalancePayableToSellerByTrader',
				'TentativeDeliveryDate',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$dealer = $this->dealer_models->dealer_get($access_token['dealer_id']);
			$branch = $this->models->get_list('branch', ['DealerID' => $dealer['ID'], 'Delete' => 0]);
			
			$this->raw_data['BranchID'] = $branch[0]['ID'];
			$this->raw_data['RootID'] = $dealer['ID'];
			if ($dealer['ID'] !== $dealer['root_id']) $this->raw_data['RootID'] = $dealer['root_id'];
			
			$this->seller_models->seller_get($this->raw_data['SellerID']);
			
			$this->raw_data['DealerID'] = $access_token['dealer_id'];
			$this->raw_data['Type'] = 'BUY';
			
			$case_id = $this->case_models->dealer_create_case($this->raw_data);
			
//			$case = $this->case_models->find_case_by_id($case_id);
			
			$case = [
				'StatusOri' => '1',
				'SellerID' => $this->raw_data['SellerID'],
				'RootID' => $this->raw_data['RootID'],
				'ID' => $case_id
			];
			$this->_process_noti($case);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully create a new buy case.';
			$this->data->data = $case_id;
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_create_sell_case() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'VehicleNo',
				'OriginalRegnDate',
				'YearOfManufacture',
				'VehicleMake',
				'VehicleModel',
				'PrimaryColour',
				'ChassisNo',
				'EngineNo',
				'NRIC',
//				'SellerID',
				'PriceAgreed',
				'DepositAmount',
				'SellHirePurchaseLoan',
				'SellBalancePayableToDealer',
				'SellTentativeHandOverDate',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			if (!empty($this->raw_data['SellHirePurchaseLoan'])) {
				if (empty($this->raw_data['SellBankFinanceCompany'])) throw new Exception('Bank/Finance company is required');
				if (empty($this->raw_data['SellHowMuchHirePurchaseLoan'])) throw new Exception('Hire purchase load amount is required');
			}
			
			$dealer = $this->dealer_models->dealer_get($access_token['dealer_id']);
			$branch = $this->models->get_list('branch', ['DealerID' => $dealer['ID'], 'Delete' => 0]);
			
			$this->raw_data['BranchID'] = $branch[0]['ID'];
			$this->raw_data['RootID'] = $dealer['ID'];
			if ($dealer['ID'] !== $dealer['root_id']) $this->raw_data['RootID'] = $dealer['root_id'];
			
//			$this->seller_models->seller_get($this->raw_data['SellerID']);
			
			$this->raw_data['DealerID'] = $access_token['dealer_id'];
			$this->raw_data['Type'] = 'SELL';
			
			$this->case_models->dealer_check_vehicle_no($dealer['root_id'], $this->raw_data['VehicleNo']);
			
			$case_id = $this->case_models->dealer_create_sell_case($this->raw_data);
			
			$case = $this->case_models->find_case_by_id($case_id);
			$this->_process_noti($case);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully create a new sell case.';
			$this->data->data = $case_id;
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_view_cases() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			$this->dealer_models->dealer_get($access_token['dealer_id']);
			
			$page = $this->raw_data['page'];
			$per_page = $this->raw_data['per_page'];
			$sort_column = $this->raw_data['sort_column'];
			$sort_by = $this->raw_data['sort_by'];
			$dealer_id = $access_token['dealer_id'];
			
			$viewer = $this->dealer_models->dealer_get($dealer_id);
			$is_root = $viewer['RoleID'] === "0";
			
			$filters = $this->raw_data['filters'];
			if (!empty($filters['SellerName'])) {
				$sellers = $this->seller_models->seller_get_by_name($filters['SellerName']);
				$filters['SellerID'] = [];
				foreach ($sellers as $seller) $filters['SellerID'][] = $seller->ID;
			}
			
			unset($filters['SellerName']);
			
			$list = $this->case_models->dealer_view_cases($page, $per_page, $dealer_id, $is_root, $filters, $sort_column, $sort_by);
			foreach ($list['items'] as &$item) {
				if (!empty($item->SellerID)) {
					$item->Seller = $this->seller_models->seller_get($item->SellerID);
				}
				if (empty($item->SellerID)) {
					$item->Seller = [
						'Name'        => $item->SellerName,
						'IDNo'        => '-',
						'Email'       => $item->SellerEmail,
						'TelephoneNo' => $item->SellerMobile,
					];
				}
				$item->Dealer = $this->dealer_models->dealer_get($item->DealerID);
				$item->DealerRoot = $this->dealer_models->dealer_get($item->RootID);
			}
			
			$this->data->status = 0;
			$this->data->message = 'Successfully retrieve dealer cases';
			$this->data->data = $list;
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function seller_view_cases() {
		try {
			$access_token = $this->seller_models->check_access_token($this->raw_data['access_token']);
			$this->seller_models->seller_get($access_token['seller_id']);
			
			$page = $this->raw_data['page'];
			$per_page = $this->raw_data['per_page'];
			$seller_id = $access_token['seller_id'];
			$sort_column = $this->raw_data['sort_column'];
			$sort_by = $this->raw_data['sort_by'];
			$filters = $this->raw_data['filters'];
			$list = $this->case_models->seller_view_cases($page, $per_page, $seller_id, $filters, $sort_column, $sort_by);
			foreach ($list['items'] as &$item) {
				$item->Seller = $this->seller_models->seller_get($item->SellerID);
				$item->Dealer = $this->dealer_models->dealer_get($item->DealerID);
				$item->DealerRoot = $this->dealer_models->dealer_get($item->RootID);
			}
			
			$this->data->status = 0;
			$this->data->message = 'Successfully retrieve seller cases';
			$this->data->data = $list;
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function get_branch($dealer_id = '') {
		if ($dealer_id) {
			try {
				$this->data->status = 0;
				$this->data->message = 'Successfully retrieve branch';
				$this->data->data = $this->models->get_list('branch', ['DealerID' => $dealer_id, 'Delete' => 0]);
			} catch (Exception $e) {
				$this->data->status = $e->getCode();
				$this->data->message = $e->getMessage();
			}
		} else {
			try {
				$this->data->status = 0;
				$this->data->message = 'Successfully retrieve branch';
				$this->data->data = $this->models->get_list('branch', ['Delete' => 0]);
			} catch (Exception $e) {
				$this->data->status = $e->getCode();
				$this->data->message = $e->getMessage();
			}
		}
		$this->renderJson($this->data, $this->data->header);
	}
	
	public function get_branch_info($id = '') {
		try {
			$this->data->status = 0;
			$this->data->message = 'Successfully retrieve branch';
			$this->data->data = $this->models->get_info('branch', ['ID' => $id]);
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function create_branch() {
		$this->checkPermissionJson(1, $this->raw_data);
		# SET Required field
		$this->required_field = array('DealerID', 'BranchName', 'BranchAddress');
		
		# Validate
		$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
		
		# Checkpont and process
		if ($validate_result['check_point'] > 0) :
			$this->data->message = $validate_result['message'];
		else :
			
			try {
				
				$saveBranch = $this->oth_model->create_branch($this->raw_data);
				
				if ($saveBranch) {
					$this->data->status = 0;
					$this->data->message = 'Successfully created branch';
				} else {
					$this->data->status = 1;
					$this->data->message = 'Failed to create branch';
				}
			} catch (Exception $e) {
				$this->data->status = $e->getCode();
				$this->data->message = $e->getMessage();
			}
		
		endif;
		$this->renderJson($this->data, $this->data->header);
	}
	
	public function edit_branch() {
		$this->checkPermissionJson(1, $this->raw_data);
		# SET Required field
		$this->required_field = array('ID', 'BranchName', 'BranchAddress');
		
		# Validate
		$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
		
		# Checkpont and process
		if ($validate_result['check_point'] > 0) :
			$this->data->message = $validate_result['message'];
		else :
			
			try {
				
				$saveBranch = $this->oth_model->save_branch($this->raw_data, $this->ID);
				
				if ($saveBranch) {
					$this->data->status = 0;
					$this->data->message = 'Successfully saved branch';
				} else {
					$this->data->status = 1;
					$this->data->message = 'Failed to saved branch';
				}
			} catch (Exception $e) {
				$this->data->status = $e->getCode();
				$this->data->message = $e->getMessage();
			}
		
		endif;
		$this->renderJson($this->data, $this->data->header);
	}
	
	public function delete_branch() {
		$this->checkPermissionJson(1, $this->raw_data);
		# SET Required field
		$this->required_field = array('ID');
		
		# Validate
		$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
		
		# Checkpont and process
		if ($validate_result['check_point'] > 0) :
			$this->data->message = $validate_result['message'];
		else :
			try {
				
				$this->oth_model->delele_branch($this->ID);
				
				$this->data->status = 0;
				$this->data->message = 'Delete branch successfully';
				$this->data->data = [];
			} catch (Exception $e) {
				$this->data->status = $e->getCode();
				$this->data->message = $e->getMessage();
			}
		endif;
		$this->renderJson($this->data, $this->data->header);
	}
	
	public function get_staff($dealer_id = '') {
		if ($dealer_id) {
			try {
				$this->data->status = 0;
				$this->data->message = 'Successfully retrieve staff ';
				$this->data->data = $this->models->get_listwj('dealer as d', [
						'd.root_id' => $dealer_id,
						'd.RoleID'  => 1,
						'd.delete'  => 0
					], 'branch as b', '(b.ID = d.branch_id)', 'left', 'd.ID, d.UserName, d.CompanyName as Fullname, d.Email, d.MobileNo, d.Status, d.Logo, d.INS as JoinAt, b.BranchName', 'ID', 'desc');
			} catch (Exception $e) {
				$this->data->status = $e->getCode();
				$this->data->message = $e->getMessage();
			}
		} else {
			$this->data->status = 1;
			$this->data->message = 'No dealer id found';
		}
		$this->renderJson($this->data, $this->data->header);
	}
	
	public function get_staff_info($staff_id = '') {
		if ($staff_id) {
			try {
				$this->data->status = 0;
				$this->data->message = 'Successfully retrieve staff ';
				$this->data->data = $this->models->get_info_wj('dealer as d', [
						'd.ID' => $staff_id
					], 'd.ID, d.UserName, d.CompanyName as Fullname, d.Email, d.MobileNo, d.Status, d.Logo, d.INS as JoinAt, b.BranchName, d.branch_id', 'branch as b', '(b.ID = d.branch_id)', 'left');
			} catch (Exception $e) {
				$this->data->status = $e->getCode();
				$this->data->message = $e->getMessage();
			}
		} else {
			$this->data->status = 1;
			$this->data->message = 'No dealer id found';
		}
		$this->renderJson($this->data, $this->data->header);
	}
	
	public function create_staff() {
		$this->checkPermissionJson(1, $this->raw_data);
		# SET Required field
		$this->required_field = array('root_id', 'CompanyName', 'UserName', 'Password', 'MobileNo', 'Email', 'branch_id');
		
		# Validate
		$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
		
		# Checkpont and process
		if ($validate_result['check_point'] > 0) :
			$this->data->message = $validate_result['message'];
		else :
			
			$get_email = $this->mains->sumdataRepeat('dealer', ['Email' => $this->Email]);
			$get_username = $this->mains->sumdataRepeat('dealer', ['UserName' => $this->UserName]);
			
			if ($get_email) {
				$this->data->status = 1;
				$this->data->message = 'The email has been taken by another users.';
			} elseif ($get_username) {
				$this->data->status = 1;
				$this->data->message = 'The username has been taken by another users.';
			} else {
				try {
					$saveData = $this->dealer_models->dealerstaff_register($this->raw_data);
					
					if ($saveData) {
						$this->data->status = 0;
						$this->data->message = 'Successfully created staff';
					} else {
						$this->data->status = 1;
						$this->data->message = 'Failed to create staff';
					}
				} catch (Exception $e) {
					$this->data->status = $e->getCode();
					$this->data->message = $e->getMessage();
				}
			}
		
		endif;
		$this->renderJson($this->data, $this->data->header);
	}
	
	public function edit_staff() {
		$this->checkPermissionJson(1, $this->raw_data);
		# SET Required field
		$this->required_field = array('ID', 'CompanyName', 'MobileNo', 'Email', 'branch_id', 'Status');
		
		# Validate
		$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
		
		# Checkpont and process
		if ($validate_result['check_point'] > 0) :
			$this->data->message = $validate_result['message'];
		else :
			
			$get_data = $this->mains->sumdataRepeat('dealer', ['ID' => $this->ID]);
			if ($get_data) {
				try {
					
					$saveData = $this->dealer_models->save_staff($this->raw_data, $this->ID);
					
					if ($saveData) {
						$this->data->status = 0;
						$this->data->message = 'Successfully saved staff';
					} else {
						$this->data->status = 1;
						$this->data->message = 'Failed to saved staff';
					}
				} catch (Exception $e) {
					$this->data->status = $e->getCode();
					$this->data->message = $e->getMessage();
				}
			} else {
				$this->data->status = 1;
				$this->data->message = 'Staff not found';
			}
		
		endif;
		$this->renderJson($this->data, $this->data->header);
	}
	
	public function delete_staff() {
		$this->checkPermissionJson(1, $this->raw_data);
		# SET Required field
		$this->required_field = array('ID');
		
		# Validate
		$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
		
		# Checkpont and process
		if ($validate_result['check_point'] > 0) :
			$this->data->message = $validate_result['message'];
		else :
			try {
				
				$this->dealer_models->delele_staff($this->ID);
				
				$this->data->status = 0;
				$this->data->message = 'Delete staff successfully';
				$this->data->data = [];
			} catch (Exception $e) {
				$this->data->status = $e->getCode();
				$this->data->message = $e->getMessage();
			}
		endif;
		$this->renderJson($this->data, $this->data->header);
	}
	
	public function insert_input_hp() {
		$this->checkPermissionJson(1, $this->raw_data);
		# SET Required field
		$this->required_field = array('CaseID', 'TradpalID', 'StatusID', 'HPDepositType', 'HPAmount', 'HPBalanceDue', 'HPDeliveredOn');
		
		# Validate
		$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
		
		# Checkpont and process
		if ($validate_result['check_point'] > 0) :
			$this->data->message = $validate_result['message'];
		else :
			
			$get_case = $this->mains->sumdataRepeat('case', ['ID' => $this->CaseID]);
			
			if (!$get_case) {
				$this->data->status = 1;
				$this->data->message = 'The Case ID ' . $this->CaseID . ' not found.';
			} else {
				try {
					$saveData = $this->case_status_models->create($this->raw_data);
					
					if ($saveData) {
						$this->data->status = 0;
						$this->data->message = 'Successfully save status log';
					} else {
						$this->data->status = 1;
						$this->data->message = 'Failed to save status log';
					}
				} catch (Exception $e) {
					$this->data->status = $e->getCode();
					$this->data->message = $e->getMessage();
				}
			}
		
		endif;
		$this->renderJson($this->data, $this->data->header);
	}
	
	public function insert_input_ba() {
		$this->checkPermissionJson(1, $this->raw_data);
		# SET Required field
		$this->required_field = array('CaseID', 'TradpalID', 'StatusID', 'BankAmount');
		
		# Validate
		$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
		
		# Checkpont and process
		if ($validate_result['check_point'] > 0) :
			$this->data->message = $validate_result['message'];
		else :
			
			$get_case = $this->mains->sumdataRepeat('case', ['ID' => $this->CaseID]);
			
			if (!$get_case) {
				$this->data->status = 1;
				$this->data->message = 'The Case ID ' . $this->CaseID . ' not found.';
			} else {
				try {
					$saveData = $this->case_status_models->create_insert_input_ba($this->raw_data);
					
					if ($saveData) {
						$this->data->status = 0;
						$this->data->message = 'Successfully save status log';
					} else {
						$this->data->status = 1;
						$this->data->message = 'Failed to save status log';
					}
				} catch (Exception $e) {
					$this->data->status = $e->getCode();
					$this->data->message = $e->getMessage();
				}
			}
		
		endif;
		$this->renderJson($this->data, $this->data->header);
	}
	
	public function insert_input_doc() {
		try {
			$row = [];
			# require permission or not
			$this->checkPermissionJson(0, $this->raw_data);
			
			$_POST = $this->input->post();
			
			# SET Required field
			$this->required_field = array('CaseID', 'TradpalID', 'StatusID');
			
			# Validate
			$validate_result = $this->mains->re_validate($this->required_field, $_POST);
			$validate_result_files = $this->mains->re_validate_files(['LoanDocument1'], $_FILES);
			$error = 0;
			$errorMsg = '';
			
			# Checkpont and process
			if ($validate_result['check_point'] > 0) :
				$this->data->message = $validate_result['message'];
			elseif ($validate_result_files['check_point'] > 0) :
				$this->data->message = $validate_result_files['message'];
			else :
				# Check repeat
				for ($i = 1; $i <= 5; $i++) {
					if ($_FILES['LoanDocument' . $i]['tmp_name']) {
						# Update new Account
						$upload_data = $this->uploads('LoanDocument' . $i, '/uploads/loandoc', 5120000, '', '', false, 'pdf|jpg|png|gif');
						$upload_code = $upload_data['upload_code'];
						
						if ($upload_code == 0) {
							# set upload data
							$upload_data = $upload_data['upload_data'];
							$_POST['LoanDocument' . $i] = $upload_data['file_name'];
						} else {
							$error++;
							$errorMsg = strip_tags($upload_data['upload_data']);
						}
					}
				}
				
				if ($error > 0) {
					$this->data->status = 1;
					$this->data->message = 'upload_fail';
					$this->data->reason = $errorMsg;
				} else {
					
					$saveData = $this->case_status_models->create($_POST);
					
					# replace with url
					$_POST['LoanDocument1'] = ($row['LoanDocument1'] ? base_url('uploads/loandoc/' . $row['LoanDocument1']) : null);
					$_POST['LoanDocument2'] = ($row['LoanDocument2'] ? base_url('uploads/loandoc/' . $row['LoanDocument2']) : null);
					$_POST['LoanDocument3'] = ($row['LoanDocument3'] ? base_url('uploads/loandoc/' . $row['LoanDocument3']) : null);
					$_POST['LoanDocument4'] = ($row['LoanDocument4'] ? base_url('uploads/loandoc/' . $row['LoanDocument4']) : null);
					$_POST['LoanDocument5'] = ($row['LoanDocument5'] ? base_url('uploads/loandoc/' . $row['LoanDocument5']) : null);
					
					$this->data->status = 0;
					$this->data->message = 'Successfully save loan document';
					$this->data->data = $_POST;
					$this->data->reason = $errorMsg;
				}
			endif;
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
		}
		$this->renderJson($this->data, $this->data->header);
	}
	
	
	public function insert_doc_agreement() {
		try {
			
			$row = [];
			# require permission or not
			$this->checkPermissionJson(0, $this->raw_data);
			
			$_POST = $this->input->post();
			
			# SET Required field
			$this->required_field = array('CaseID',  'StatusID');
			
			# Validate
			$validate_result = $this->mains->re_validate($this->required_field, $_POST);
//			$validate_result_files = $this->mains->re_validate_files(['DocAgreement1'], $_FILES);
			$error = 0;
			$errorMsg = '';
			
			# Checkpont and process
			if ($validate_result['check_point'] > 0) :
				$this->data->message = $validate_result['message'];
			else :
				# Check repeat
				for ($i = 1; $i <= 4; $i++) {
					if ($_FILES['DocAgreement' . $i]['tmp_name']) {
						# Update new Account
						$upload_data = $this->uploads('DocAgreement' . $i, '/uploads/loandoc', 5120000, '', '', false, '*');
						$upload_code = $upload_data['upload_code'];
						
						if ($upload_code == 0) {
							# set upload data
							$upload_data = $upload_data['upload_data'];
							$_POST['DocAgreement' . $i] = $upload_data['file_name'];
						} else {
							$error++;
							$errorMsg = strip_tags($upload_data['upload_data']);
						}
					}
					
				}
				
				if ($error > 0) {
					$this->data->status = 1;
					$this->data->message = 'upload_fail';
					$this->data->reason = $errorMsg;
				} else {
					
					$saveData = $this->case_status_models->create_logs($_POST);
					
					# replace with url
					$_POST['DocAgreement1'] = ($row['DocAgreement1'] ? base_url('uploads/loandoc/' . $row['DocAgreement1']) : null);
					$_POST['DocAgreement2'] = ($row['DocAgreement2'] ? base_url('uploads/loandoc/' . $row['DocAgreement2']) : null);
					$_POST['DocAgreement3'] = ($row['DocAgreement3'] ? base_url('uploads/loandoc/' . $row['DocAgreement3']) : null);
					$_POST['DocAgreement4'] = ($row['DocAgreement4'] ? base_url('uploads/loandoc/' . $row['DocAgreement4']) : null);
					
					$this->data->status = 0;
					$this->data->message = 'Successfully save loan document';
					$this->data->data = $_POST;
					$this->data->reason = $errorMsg;
				}
			endif;
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
		}
		$this->renderJson($this->data, $this->data->header);
	}
	
	public function insert_doc_handover_acknowledgement() {
		try {
			$row = [];
			# require permission or not
			$this->checkPermissionJson(0, $this->raw_data);
			
			$_POST = $this->input->post();
			
			# SET Required field
			$this->required_field = array('CaseID');
			
			# Validate
			$validate_result = $this->mains->re_validate($this->required_field, $_POST);
			//			$validate_result_files = $this->mains->re_validate_files(['DocAgreement1'], $_FILES);
			$error = 0;
			$errorMsg = '';
			
			# Checkpont and process
			if ($validate_result['check_point'] > 0) :
				$this->data->message = $validate_result['message'];
			else :
				# Check repeat
		
					if ($_FILES['DocHandoverAcknowledgement']['tmp_name']) {
						# Update new Account
						$upload_data = $this->uploads('DocHandoverAcknowledgement', '/uploads/loandoc', 5120000, '', '', false, '*');
						$upload_code = $upload_data['upload_code'];
						
						if ($upload_code == 0) {
							# set upload data
							$upload_data = $upload_data['upload_data'];
							$_POST['DocHandoverAcknowledgement'] = $upload_data['file_name'];
						} else {
							$error++;
							$errorMsg = strip_tags($upload_data['upload_data']);
						}
					}
					
				
				
				if ($error > 0) {
					$this->data->status = 1;
					$this->data->message = 'upload_fail';
					$this->data->reason = $errorMsg;
				} else {
					
					$saveData = $this->case_models->save_doc_handover_acknowledgement($_POST);
					
					# replace with url
					$_POST['DocHandoverAcknowledgement'] = $upload_data['file_name'];
	
					
					$this->data->status = 0;
					$this->data->message = 'Successfully save loan document';
					$this->data->data = $_POST;
					$this->data->reason = $errorMsg;
				}
			endif;
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
		}
		$this->renderJson($this->data, $this->data->header);
	}
	
	public function insert_doc_agreement2() {
		try {
			$row = [];
			# require permission or not
			$this->checkPermissionJson(0, $this->raw_data);
			
			$_POST = $this->input->post();
			
			# SET Required field
			$this->required_field = array('CaseID',  'StatusID');
			
			# Validate
			$validate_result = $this->mains->re_validate($this->required_field, $_POST);
			//			$validate_result_files = $this->mains->re_validate_files(['DocAgreement1'], $_FILES);
			$error = 0;
			$errorMsg = '';
			
			# Checkpont and process
			if ($validate_result['check_point'] > 0) :
				$this->data->message = $validate_result['message'];
			else :
				
				$_POST['DocAgreement1'] =	$this->saveBase64Image($_POST['DocAgreement1']);
				$_POST['DocAgreement2'] =	$this->saveBase64Image($_POST['DocAgreement2']);
				$_POST['DocAgreement3'] =	$this->saveBase64Image($_POST['DocAgreement3']);
				$_POST['DocAgreement4'] =	$this->saveBase64Image($_POST['DocAgreement4']);
				
				$this->case_status_models->create($_POST);
				
				$this->data->status = 0;
				$this->data->message = 'Successfully save loan document';
				$this->data->data = $_POST;
				$this->data->reason = $errorMsg;
				
			endif;
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
		}
		$this->renderJson($this->data, $this->data->header);
	}
	
	
	public function get_car_brands() {
		try {
			$this->data->status = 0;
			$this->data->message = 'Successfully retrieve car brands';
			$this->data->data = $this->case_models->get_car_brands();
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_get_seller_by_nric() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			$this->dealer_models->dealer_get($access_token['dealer_id']);
			
			$nric = $this->raw_data['seller_nric'];
			
			$this->data->status = 0;
			$this->data->message = 'Successfully retrieve seller';
			$this->data->data = $this->seller_models->seller_get_by_nric($nric);
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_edit_reg_no() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
				'RegNo',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$case = $this->case_models->find_case_by_id($this->raw_data['CaseID']);
			$viewer = $this->dealer_models->dealer_get($access_token['dealer_id']);
			if ($viewer['RoleID'] === '0') {
				if ($case['RootID'] !== $access_token['dealer_id']) throw new Exception("Not allowed", 400);
			} else {
				if ($case['DealerID'] !== $access_token['dealer_id']) throw new Exception("Not allowed", 400);
			}
			
			$case_id = $this->case_models->dealer_edit_reg_no($this->raw_data['CaseID'], $this->raw_data['RegNo']);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully edit a registration number.';
			$this->data->data = $case_id;
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_edit_case() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
				'SellerID',
				'NRIC',
				'VehicleNo',
				'ChassisNo',
				'EngineNo',
				'OriginalRegnDate',
				'YearOfManufacture',
				'PriceAgreed',
				'DepositAmount',
				'Video',
				'Photo1',
				'Photo2',
				'Photo3',
				'Photo4',
				'Photo5',
				'Photo6',
				'VehicleMake',
				'VehicleModel',
				'PrimaryColour',
				'OutStandingHirePurchaseLoan',
				'BalancePayableToSellerByTrader',
				'TentativeDeliveryDate',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$this->seller_models->seller_get($this->raw_data['SellerID']);
			
			$this->raw_data['DealerID'] = $access_token['dealer_id'];
			
			$case = $this->case_models->find_case_by_id($this->raw_data['CaseID']);
			$viewer = $this->dealer_models->dealer_get($access_token['dealer_id']);
			if ($viewer['RoleID'] === '0') {
				if ($case['RootID'] !== $this->raw_data['DealerID']) throw new Exception("Not allowed", 400);
			} else {
				if ($case['DealerID'] !== $this->raw_data['DealerID']) throw new Exception("Not allowed", 400);
			}
			
			if ($case['Status'] !== "1" && $case['Status'] !== "3") throw new Exception("None initiated case is not allowed to be edited", 400);
			
			$case_id = $this->case_models->dealer_edit_case($this->raw_data);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully edit a case.';
			$this->data->data = $case_id;
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_edit_sell_case() {
		try {

			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
				'VehicleNo',
				'OriginalRegnDate',
				'YearOfManufacture',
				'VehicleMake',
				'VehicleModel',
				'PrimaryColour',
				'ChassisNo',
				'EngineNo',
				'NRIC',
//				'SellerID',
				'PriceAgreed',
				'DepositAmount',
				'SellHirePurchaseLoan',
				'SellBalancePayableToDealer',
				'SellTentativeHandOverDate',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
//			$this->seller_models->seller_get($this->raw_data['SellerID']);
			
			$this->raw_data['DealerID'] = $access_token['dealer_id'];
			
			$case = $this->case_models->find_case_by_id($this->raw_data['CaseID']);
			$viewer = $this->dealer_models->dealer_get($access_token['dealer_id']);
			if ($viewer['RoleID'] === '0') {
				if ($case['RootID'] !== $this->raw_data['DealerID']) throw new Exception("Not allowed", 400);
			} else {
				if ($case['DealerID'] !== $this->raw_data['DealerID']) throw new Exception("Not allowed", 400);
			}
			
//			if ($case['Status'] !== "102" && $case['Status'] !== "103") throw new Exception("Only initiated or rejected case is allowed to be edited", 400);
			
			$case_id = $this->case_models->dealer_edit_sell_case($this->raw_data);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully edit a sell case.';
			$this->data->data = $case_id;
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_delete_case() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$dealer = $this->dealer_models->dealer_get($access_token['dealer_id']);
			$this->raw_data['DealerID'] = $access_token['dealer_id'];
			
			$case = $this->case_models->find_case_by_id($this->raw_data['CaseID']);
			$viewer = $this->dealer_models->dealer_get($access_token['dealer_id']);
			if ($viewer['RoleID'] === '0') {
				if ($case['RootID'] !== $this->raw_data['DealerID']) throw new Exception("Not allowed", 400);
			} else {
				if ($case['DealerID'] !== $this->raw_data['DealerID']) throw new Exception("Not allowed", 400);
			}
			if ($case['Status'] !== "1") throw new Exception("None initiated case is not allowed to be deleted", 400);
			
			$case_id = $this->case_models->dealer_delete_case($this->raw_data['CaseID']);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully delete a case.';
			$this->data->data = $case_id;
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_read_case() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			$this->dealer_models->dealer_get($access_token['dealer_id']);
			
			$dealer_id = $access_token['dealer_id'];
			
			$viewer = $this->dealer_models->dealer_get($dealer_id);
			$is_root = $viewer['RoleID'] === "0";
			
			$case = $this->case_models->dealer_read_case($this->raw_data['CaseID'], $dealer_id, $is_root);
			if (!empty($case->SellerID)) $case->Seller = $this->seller_models->seller_get($case->SellerID);
			$case->Dealer = $this->dealer_models->dealer_get($case->DealerID);
			$case->DealerRoot = $this->dealer_models->dealer_get($case->RootID);
			$case->Survey = $this->survey_models->read($case->ID);
			
			if (empty($case->SellerID)) {
				$case->Seller = [
					'Name' => $case->SellerName,
					'IDNo' => '-',
					'Email' => $case->SellerEmail,
					'TelephoneNo' => $case->SellerMobile,
				];
			}
			
			$this->data->status = 0;
			$this->data->message = 'Successfully retrieve dealer case';
			$this->data->data = $case;
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function seller_read_case() {
		try {
			$access_token = $this->seller_models->check_access_token($this->raw_data['access_token']);
			$this->seller_models->seller_get($access_token['seller_id']);
			
			$seller_id = $access_token['seller_id'];
			
			$case = $this->case_models->seller_read_case($this->raw_data['CaseID'], $seller_id);
			
			$case->Seller = $this->seller_models->seller_get($case->SellerID);
			$case->Dealer = $this->dealer_models->dealer_get($case->DealerID);
			$case->DealerRoot = $this->dealer_models->dealer_get($case->RootID);
			$case->Survey = $this->survey_models->read($case->ID);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully retrieve seller case';
			$this->data->data = $case;
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function update_regno() {
		try {
		
			
			$this->required_field = [
				'CaseID',
				'RegNo',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$case_id = $this->case_models->dealer_edit_reg_no($this->raw_data['CaseID'], $this->raw_data['RegNo']);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully edit a registration number.';
			$this->data->data = $case_id;
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	// ----------------------------------------------------------------------------------------------------------------
	// SG Address: Eak
	
	public function get_address_by_postal_code() {
		try {
			$this->checkPermissionJson(1, $this->raw_data);
			
			$this->required_field = [
				'PostalCode',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$postal_code = $this->raw_data['PostalCode'];
			
			$this->data->status = 0;
			$this->data->message = 'Successfully retrieve address';
			$this->data->data = $this->sgaddress_models->get_address_by_postal_code($postal_code);
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function uploader() {
		try {
			# require permission or not
			$this->checkPermissionJson(0, $this->raw_data);
			
			# SET Required field
			$this->required_field = array();
			
			# Validate
			$validate_result = $this->mains->re_validate($this->required_field, $this->input->post());
			
			# Checkpont and process
			if ($validate_result['check_point'] > 0) :
				$this->data->message = $validate_result['message'];
			else :
				# Check repeat
				# Update new Account
				// $upload_data = $this->uploads('files', '/uploads/files', 5120000, '', '', false, 'gif|jpg|png|jpeg|mp4|mpg|avi');
				$upload_data = $this->uploads('files', '/uploads/files', 5120000, '', '', false, '*');
				$upload_code = $upload_data['upload_code'];
				
				if ($upload_code == 0) {
					
					# set upload data
					$upload_data = $upload_data['upload_data'];
					
					# file data set
					$file_data = [
						'file_name'    => $upload_data['file_name'],
						'file_type'    => $upload_data['file_type'],
						'file_ext'     => $upload_data['file_ext'],
						'file_size'    => $upload_data['file_size'],
						'image_width'  => $upload_data['image_width'],
						'image_height' => $upload_data['image_height'],
						'image_type'   => $upload_data['image_type'],
						'created_at'   => $this->get_now()
					];
					
					# update to database
					$this->db->insert('files_db', $file_data);
					
					# unset unuse & set optional
					unset($file_data['created_at']);
					$file_data['file_url'] = base_url('uploads/files/' . $upload_data['file_name']);
					
					$this->data->status = 0;
					$this->data->message = 'upload_success';
					$this->data->data = $file_data;
				} else {
					$this->data->status = 1;
					$this->data->message = 'upload_fail';
					$this->data->reason = strip_tags($upload_data['upload_data']);
				}
			endif;
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function delete_uploader() {
		# require permission or not
		$this->checkPermissionJson(1, $this->raw_data);
		
		# SET Required field
		$this->required_field = array('file_name');
		
		# Validate
		$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
		
		# Checkpont and process
		if ($validate_result['check_point'] > 0) :
			$this->data->message = $validate_result['message'];
		else :
			# Check repeat
			$get_filename = $this->models->get_info('files_db', ['file_name' => $this->file_name]);
			
			if (!$get_filename) {
				$this->data->status = 1;
				$this->data->message = 'delete_failed';
				$this->data->reason = 'File name \'' . $this->file_name . '\' not found.';
			} else {
				# update to database
				unlink(dirname($_SERVER["SCRIPT_FILENAME"]) . '/uploads/files/' . $get_filename['file_name']);
				$this->db->delete('files_db', ['id' => $get_filename['id']]);
				
				$this->data->status = 0;
				$this->data->message = 'delete_success';
				$this->data->data = [];
			}
		endif;
		
		$this->renderJson($this->data, $this->data->header);
	}
	
	// ----------------------------------------------------------------------------------------------------------------
	// Case status
	
	public function seller_create_accept_agreement_status() {
		try {
			$access_token = $this->seller_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
				'TermAndConditionAccept',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$case = $this->case_models->seller_read_case($this->raw_data['CaseID'], $access_token['seller_id']);
			if ($case->StatusOri !== '1') throw new Exception('Invalid state', 400);
			
			$this->raw_data['DealerID'] = $case->DealerID;
			$this->raw_data['SellerID'] = $access_token['seller_id'];
			$this->raw_data['IP'] = $this->input->ip_address();
			$case->StatusOri = $this->raw_data['StatusID'] = 2;
			
			$this->data->status = 0;
			$this->data->message = 'Successfully accept agreement.';
			$this->data->data = $this->case_status_models->create($this->raw_data);
			
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function seller_create_reject_agreement_status() {
		try {
			$access_token = $this->seller_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
				'Remark',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$case = $this->case_models->seller_read_case($this->raw_data['CaseID'], $access_token['seller_id']);
			if ($case->StatusOri !== '1') throw new Exception('Invalid state', 400);
			
			$this->raw_data['DealerID'] = $case->DealerID;
			$this->raw_data['SellerID'] = $access_token['seller_id'];
			$this->raw_data['IP'] = $this->input->ip_address();
			$case->StatusOri = $this->raw_data['StatusID'] = 3;
			
			$this->data->status = 0;
			$this->data->message = 'Successfully reject agreement.';
			$this->data->data = $this->case_status_models->create($this->raw_data);
			
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_upload_signed_full_settlement_status() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			//						$this->required_field = [
			//							'CaseID',
			//							'SignedFullSettlement',
			//							'FrontIDPhoto',
			//							'BackIDPhoto',
			//							'TermAndConditionAccept',
			//						];
			$this->required_field = [
				'CaseID',
				'TermAndConditionAccept',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$viewer = $this->dealer_models->dealer_get($access_token['dealer_id']);
			$is_root = $viewer['RoleID'] === "0";
			
			$case = $this->case_models->dealer_read_case($this->raw_data['CaseID'], $access_token['dealer_id'], $is_root);
			if ($case->StatusOri !== '2') throw new Exception('Invalid state', 400);
			
			$this->raw_data['DealerID'] = $access_token['dealer_id'];
			$this->raw_data['SellerID'] = $case->SellerID;
			$this->raw_data['IP'] = $this->input->ip_address();
			$case->StatusOri = $this->raw_data['StatusID'] = 5;
			
			$this->data->status = 0;
			$this->data->message = 'Successfully upload signed full settlement.';
			$this->data->data = $this->case_status_models->create($this->raw_data);
			
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_create_request_loan_status() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
				'LoanRequested',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$viewer = $this->dealer_models->dealer_get($access_token['dealer_id']);
			$is_root = $viewer['RoleID'] === "0";
			
			if (empty($is_root)) throw new Exception('Not allow', 400);
			
			$case = $this->case_models->dealer_read_case($this->raw_data['CaseID'], $access_token['dealer_id'], $is_root);
			if ($case->StatusOri !== '5') throw new Exception('Invalid state', 400);
			
			$price_agree = $case->PriceAgreed;
			$max_percent = $viewer['AdvanceQuantum'];
			$max_price = ($price_agree * $max_percent) / 100;
			if ($this->raw_data['LoanRequested'] > $max_price) throw new Exception('Invalid loan amount', 400);
			
			$this->raw_data['DealerID'] = $access_token['dealer_id'];
			$this->raw_data['SellerID'] = $case->SellerID;
			$case->StatusOri = $this->raw_data['StatusID'] = 6;
			
			$this->data->status = 0;
			$this->data->message = 'Successfully request loan.';
			$this->data->data = $this->case_status_models->create($this->raw_data);
			
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_create_not_request_loan_status() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$viewer = $this->dealer_models->dealer_get($access_token['dealer_id']);
			$is_root = $viewer['RoleID'] === "0";
			
			$case = $this->case_models->dealer_read_case($this->raw_data['CaseID'], $access_token['dealer_id'], $is_root);
			if ($case->StatusOri !== '2') throw new Exception('Invalid state', 400);
			
			$this->raw_data['DealerID'] = $access_token['dealer_id'];
			$this->raw_data['SellerID'] = $case->SellerID;
			$case->StatusOri = $this->raw_data['StatusID'] = 7;
			
			$this->data->status = 0;
			$this->data->message = 'Successfully not request loan.';
			$this->data->data = $this->case_status_models->create($this->raw_data);
			
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_create_accept_hp_status() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$viewer = $this->dealer_models->dealer_get($access_token['dealer_id']);
			$is_root = $viewer['RoleID'] === "0";
			
			$case = $this->case_models->dealer_read_case($this->raw_data['CaseID'], $access_token['dealer_id'], $is_root);
			if ($case->StatusOri !== '6') throw new Exception('Invalid state', 400);
			
			$this->raw_data['DealerID'] = $access_token['dealer_id'];
			$this->raw_data['SellerID'] = $case->SellerID;
			$case->StatusOri = $this->raw_data['StatusID'] = 7;
			
			$this->data->status = 0;
			$this->data->message = 'Successfully accept HP.';
			$this->data->data = $this->case_status_models->create($this->raw_data);
			
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_create_reject_hp_status() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$viewer = $this->dealer_models->dealer_get($access_token['dealer_id']);
			$root = $this->dealer_models->dealer_get($viewer['root_id']);
			$is_root = $viewer['RoleID'] === "0";
			
			$case = $this->case_models->dealer_read_case($this->raw_data['CaseID'], $access_token['dealer_id'], $is_root);
			if ($case->StatusOri !== '6') throw new Exception('Invalid state', 400);
			
			$this->raw_data['DealerID'] = $access_token['dealer_id'];
			$this->raw_data['SellerID'] = $case->SellerID;
			$case->StatusOri = $this->raw_data['StatusID'] = 8;
			
			$this->data->status = 0;
			$this->data->message = 'Successfully reject HP.';
			$this->data->data = $this->case_status_models->create($this->raw_data);
			
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_create_accept_tradpal_bank_amount_status() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$viewer = $this->dealer_models->dealer_get($access_token['dealer_id']);
			$root = $this->dealer_models->dealer_get($viewer['root_id']);
			$is_root = $viewer['RoleID'] === "0";
			
			$case = $this->case_models->dealer_read_case($this->raw_data['CaseID'], $access_token['dealer_id'], $is_root);
			if ($case->StatusOri !== '8') throw new Exception('Invalid state', 400);
			
			$this->raw_data['DealerID'] = $access_token['dealer_id'];
			$this->raw_data['SellerID'] = $case->SellerID;
			$case->StatusOri = $this->raw_data['StatusID'] = 9;
			
			$this->data->status = 0;
			$this->data->message = 'Successfully accept tradpal bank amount.';
			$this->data->data = $this->case_status_models->create($this->raw_data);
			
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_create_reject_tradpal_bank_amount_status() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$viewer = $this->dealer_models->dealer_get($access_token['dealer_id']);
			$root = $this->dealer_models->dealer_get($viewer['root_id']);
			$is_root = $viewer['RoleID'] === "0";
			
			$case = $this->case_models->dealer_read_case($this->raw_data['CaseID'], $access_token['dealer_id'], $is_root);
			if ($case->StatusOri !== '8') throw new Exception('Invalid state', 400);
			
			$this->raw_data['DealerID'] = $access_token['dealer_id'];
			$this->raw_data['SellerID'] = $case->SellerID;
			$case->StatusOri = $this->raw_data['StatusID'] = 10;
			
			$this->data->status = 0;
			$this->data->message = 'Successfully reject tradpal bank amount.';
			$this->data->data = $this->case_status_models->create($this->raw_data);
			
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	/* API Go */
	public function seller_create_accept_amount_due_status() {
		try {
			$access_token = $this->seller_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
				'CarOwnerBankName',
				'CarOwnerBankAccountNo',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$case = $this->case_models->seller_read_case($this->raw_data['CaseID'], $access_token['seller_id']);
			if ($case->StatusOri !== '11') throw new Exception('Invalid state', 400);
			
			$this->raw_data['DealerID'] = $case->DealerID;
			$this->raw_data['SellerID'] = $access_token['seller_id'];
			$this->raw_data['IP'] = $this->input->ip_address();
			$case->StatusOri = $this->raw_data['StatusID'] = 12;
			
			$this->data->status = 0;
			$this->data->message = 'Successfully accept agreement.';
			$this->data->data = $this->case_status_models->create($this->raw_data);
			
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	
	public function seller_create_input_appointment_status() {
		try {
			$access_token = $this->seller_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
				'AppointmentDate',
				'AppointmentTime',
				'AppointmentTimeTo',
				'AppointmentPlace',
				'SellerBankAccount',
				'BankName',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$date = Carbon::createFromFormat('Y-m-d', $this->raw_data['AppointmentDate']);
			if (!$date->isWeekday()) throw new Exception("Must be on weekday", 400);
			
			$time = Carbon::createFromFormat('H:i:s', $this->raw_data['AppointmentTime']);
			if ($time->hour < 9 || 16 < $time->hour) throw new Exception("Must be on work hour", 400);
			
			$timeto = Carbon::createFromFormat('H:i:s', $this->raw_data['AppointmentTimeTo']);
			if ($timeto->hour < 9 || 16 < $timeto->hour) throw new Exception("Must be on work hour", 400);
			
//			if ($time->hour >= $timeto->hour) throw new Exception("Invalid time period", 400);
			
			$case = $this->case_models->seller_read_case($this->raw_data['CaseID'], $access_token['seller_id']);
			if ($case->StatusOri !== '12') throw new Exception('Invalid state', 400);
			
			$this->raw_data['DealerID'] = $case->DealerID;
			$this->raw_data['SellerID'] = $access_token['seller_id'];
			$case->StatusOri = $this->raw_data['StatusID'] = 15;
			
			$this->data->status = 0;
			$this->data->message = 'Successfully input appointment.';
			$this->data->data = $this->case_status_models->create($this->raw_data);
			
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function seller_edit_appointment_status() {
		try {
//			$access_token = $this->seller_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'StatusID',
				'AppointmentDate',
				'AppointmentTime',
				'AppointmentTimeTo',
				'AppointmentPlace',
				'SellerBankAccount',
				'BankName',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$date = Carbon::createFromFormat('Y-m-d', $this->raw_data['AppointmentDate']);
			if (!$date->isWeekday()) throw new Exception("Must be on weekday", 400);
			
			$time = Carbon::createFromFormat('H:i:s', $this->raw_data['AppointmentTime']);
			if ($time->hour < 9 || 16 < $time->hour) throw new Exception("Must be on work hour", 400);
			
			$timeto = Carbon::createFromFormat('H:i:s', $this->raw_data['AppointmentTimeTo']);
			if ($timeto->hour < 9 || 16 < $timeto->hour) throw new Exception("Must be on work hour", 400);
			
//			if ($time->hour >= $timeto->hour) throw new Exception("Invalid time period", 400);
			
//			$status = $this->case_status_models->get_status_by_id($this->raw_data['StatusID']);
//			if ($status['SellerID'] !== $access_token['seller_id']) throw new Exception('Not allow', 400);
			
			$this->case_status_models->updateAppointment($this->raw_data);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully update appointment.';
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_create_input_appointment_status() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
				'AppointmentDate',
				'AppointmentTime',
				'AppointmentPlace',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$viewer = $this->dealer_models->dealer_get($access_token['dealer_id']);
			$is_root = $viewer['RoleID'] === "0";
			
			$case = $this->case_models->dealer_read_case($this->raw_data['CaseID'], $access_token['dealer_id'], $is_root);
			if ($case->StatusOri !== '10') throw new Exception('Invalid state', 400);
			
			$this->raw_data['DealerID'] = $access_token['dealer_id'];
			$this->raw_data['SellerID'] = $case->SellerID;
			$case->StatusOri = $this->raw_data['StatusID'] = 12;
			
			$this->data->status = 0;
			$this->data->message = 'Successfully input appointment.';
			$this->data->data = $this->case_status_models->create($this->raw_data);
			
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_edit_appointment_status() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
				'AppointmentDate',
				'AppointmentTime',
				'AppointmentTimeTo',
				'SellerBankAccount',
				'BankName',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$date = Carbon::createFromFormat('Y-m-d', $this->raw_data['AppointmentDate']);
			if (!$date->isWeekday()) throw new Exception("Must be on weekday", 400);
			
			$time = Carbon::createFromFormat('H:i:s', $this->raw_data['AppointmentTime']);
			if ($time->hour < 9 || 16 < $time->hour) throw new Exception("Must be on work hour", 400);
			
			$timeto = Carbon::createFromFormat('H:i:s', $this->raw_data['AppointmentTimeTo']);
			if ($timeto->hour < 9 || 16 < $timeto->hour) throw new Exception("Must be on work hour", 400);
			
//			if ($time->hour >= $timeto->hour) throw new Exception("Invalid time period", 400);
			
			$viewer = $this->dealer_models->dealer_get($access_token['dealer_id']);
			$is_root = $viewer['RoleID'] === "0";
			
			$case = $this->case_models->dealer_read_case($this->raw_data['CaseID'], $access_token['dealer_id'], $is_root);
			if (empty($case->Status)) throw new Exception("Invalid case", 400);
			
			$index = null;
			foreach ($case->StatusLogs as $i => $status) {
				if ($status->StatusID === '15') $index = $i;
				if ($status->StatusID === '23') throw new Exception("Case is in handover process", 400);
			}
			if ($index === null) throw new Exception("Case does not have appointment", 400);
			
			$this->raw_data['StatusID'] = $case->StatusLogs[$index]->ID;
			$this->case_status_models->updateAppointment($this->raw_data);
			
			
			$this->data->status = 0;
			$this->data->message = 'Successfully edit appointment.';
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	
	public function seller_create_appointment_confirmed_by_car_owner_status() {
		try {
			$access_token = $this->seller_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$case = $this->case_models->seller_read_case($this->raw_data['CaseID'], $access_token['seller_id']);
			if ($case->StatusOri !== '15') throw new Exception('Invalid state', 400);
			
			$this->raw_data['DealerID'] = $case->DealerID;
			$this->raw_data['SellerID'] = $access_token['seller_id'];
			$case->StatusOri = $this->raw_data['StatusID'] = 17;
			
			$this->data->status = 0;
			$this->data->message = 'Successfully confirm appointment.';
			$this->data->data = $this->case_status_models->create($this->raw_data);
			
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function seller_create_appointment_rejected_by_car_owner_status() {
		try {
			$access_token = $this->seller_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$case = $this->case_models->seller_read_case($this->raw_data['CaseID'], $access_token['seller_id']);
			if ($case->StatusOri !== '15') throw new Exception('Invalid state', 400);
			
			$this->raw_data['DealerID'] = $case->DealerID;
			$this->raw_data['SellerID'] = $access_token['seller_id'];
			$case->StatusOri = $this->raw_data['StatusID'] = 18;
			
			$this->data->status = 0;
			$this->data->message = 'Successfully reject appointment.';
			$this->data->data = $this->case_status_models->create($this->raw_data);
			
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_create_appointment_confirmed_by_car_owner_status() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$viewer = $this->dealer_models->dealer_get($access_token['dealer_id']);
			$is_root = $viewer['RoleID'] === "0";
			
			$case = $this->case_models->dealer_read_case($this->raw_data['CaseID'], $access_token['dealer_id'], $is_root);
			if ($case->StatusOri !== '15') throw new Exception('Invalid state', 400);
			
			$this->raw_data['DealerID'] = $access_token['dealer_id'];
			$this->raw_data['SellerID'] = $case->SellerID;
			$case->StatusOri = $this->raw_data['StatusID'] = 17;
			
			$this->data->status = 0;
			$this->data->message = 'Successfully confirm appointment.';
			$this->data->data = $this->case_status_models->create($this->raw_data);
			
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_create_appointment_rejected_by_car_owner_status() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$viewer = $this->dealer_models->dealer_get($access_token['dealer_id']);
			$is_root = $viewer['RoleID'] === "0";
			
			$case = $this->case_models->dealer_read_case($this->raw_data['CaseID'], $access_token['dealer_id'], $is_root);
			if ($case->StatusOri !== '15') throw new Exception('Invalid state', 400);
			
			$this->raw_data['DealerID'] = $access_token['dealer_id'];
			$this->raw_data['SellerID'] = $case->SellerID;
			$case->StatusOri = $this->raw_data['StatusID'] = 18;
			
			$this->data->status = 0;
			$this->data->message = 'Successfully reject appointment.';
			$this->data->data = $this->case_status_models->create($this->raw_data);
			
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function seller_click_link_onemotoring() {
		try {
			$access_token = $this->seller_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$case = $this->case_models->seller_read_case($this->raw_data['CaseID'], $access_token['seller_id']);
			if ($case->StatusOri !== '17') throw new Exception('Invalid state', 400);
			
			$this->raw_data['DealerID'] = $case->DealerID;
			$this->raw_data['SellerID'] = $access_token['seller_id'];
			$case->StatusOri = $this->raw_data['StatusID'] = 19;
			
			$this->data->status = 0;
			$this->data->message = 'Successfully click link.';
			$this->data->data = $this->case_status_models->create($this->raw_data);
			
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function seller_car_title_transferred() {
		try {
			$access_token = $this->seller_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$case = $this->case_models->seller_read_case($this->raw_data['CaseID'], $access_token['seller_id']);
			if ($case->StatusOri !== '19') throw new Exception('Invalid state', 400);
			
			$this->raw_data['DealerID'] = $case->DealerID;
			$this->raw_data['SellerID'] = $access_token['seller_id'];
			$case->StatusOri = $this->raw_data['StatusID'] = 20;
			
			$this->data->status = 0;
			$this->data->message = 'Successfully transferred car title.';
			$this->data->data = $this->case_status_models->create($this->raw_data);
			
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function seller_amount_received() {
		try {
			$access_token = $this->seller_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$case = $this->case_models->seller_read_case($this->raw_data['CaseID'], $access_token['seller_id']);
			if ($case->StatusOri !== '21') throw new Exception('Invalid state', 400);
			
			$this->raw_data['DealerID'] = $case->DealerID;
			$this->raw_data['SellerID'] = $access_token['seller_id'];
			$case->StatusOri = $this->raw_data['StatusID'] = 22;
			
			$this->data->status = 0;
			$this->data->message = 'Successfully receive seller amount.';
			$this->data->data = $this->case_status_models->create($this->raw_data);
			
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_create_hand_over_status() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
				'AppointmentDate',
				'AppointmentTime',
				'AppointmentPlace',
				'AppointmentLat',
				'AppointmentLng',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			// $date = Carbon::createFromFormat('Y-m-d', $this->raw_data['AppointmentDate']);
			// if (!$date->isWeekday()) throw new Exception("Must be on weekday", 400);
			
			// $time = Carbon::createFromFormat('H:i:s', $this->raw_data['AppointmentTime']);
			// if ($time->hour < 9 || 16 < $time->hour) throw new Exception("Must be on work hour", 400);
			
			$viewer = $this->dealer_models->dealer_get($access_token['dealer_id']);
			$is_root = $viewer['RoleID'] === '0';
			
			$case = $this->case_models->dealer_read_case($this->raw_data['CaseID'], $access_token['dealer_id'], $is_root);
			if ($case->StatusOri !== '22') throw new Exception('Invalid state', 400);
			
			$this->raw_data['DealerID'] = $access_token['dealer_id'];
			$this->raw_data['SellerID'] = $case->SellerID;
			$case->StatusOri = $this->raw_data['StatusID'] = 23;
			
			$this->data->status = 0;
			$this->data->message = 'Successfully hand over.';
			$this->data->data = $this->case_status_models->create($this->raw_data);
			
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_accept_hand_over_acknowledgement_status() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			// $date = Carbon::createFromFormat('Y-m-d', $this->raw_data['AppointmentDate']);
			// if (!$date->isWeekday()) throw new Exception("Must be on weekday", 400);
			
			// $time = Carbon::createFromFormat('H:i:s', $this->raw_data['AppointmentTime']);
			// if ($time->hour < 9 || 16 < $time->hour) throw new Exception("Must be on work hour", 400);
			
			$viewer = $this->dealer_models->dealer_get($access_token['dealer_id']);
			$is_root = $viewer['RoleID'] === '0';
			
			$case = $this->case_models->dealer_read_case($this->raw_data['CaseID'], $access_token['dealer_id'], $is_root);
			if ($case->StatusOri !== '23') throw new Exception('Invalid state', 400);
			
			$this->raw_data['DealerID'] = $access_token['dealer_id'];
			$this->raw_data['SellerID'] = $case->SellerID;
			$case->StatusOri = $this->raw_data['StatusID'] = 24;
			
			$this->data->status = 0;
			$this->data->message = 'Successfully accept hand over acknowledgement.';
			$this->data->data = $this->case_status_models->create($this->raw_data);
			
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function seller_accept_hand_over_acknowledgement_status() {
		try {
			$access_token = $this->seller_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$case = $this->case_models->seller_read_case($this->raw_data['CaseID'], $access_token['seller_id']);
			if ($case->StatusOri !== '24') throw new Exception('Invalid state', 400);
			
			$this->raw_data['DealerID'] = $case->DealerID;
			$this->raw_data['SellerID'] = $access_token['seller_id'];
			$case->StatusOri = $this->raw_data['StatusID'] = 25;
			
			$this->data->status = 0;
			$this->data->message = 'Successfully accept hand over acknowledgement.';
			$this->data->data = $this->case_status_models->create($this->raw_data);
			
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	// ----------------------------------------------------------------------------------------------------------------
	// Case status: Sell
	
	public function seller_update_buy_sell_agreement() {
		try {
			$access_token = $this->seller_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
				'Accept',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$case = $this->case_models->seller_read_case($this->raw_data['CaseID'], $access_token['seller_id']);
			if ($case->StatusOri !== '101') throw new Exception('Invalid state', 400);
			$seller = $this->seller_models->seller_get($case->SellerID);
			
			$accept = filter_var($this->raw_data['Accept'], FILTER_VALIDATE_BOOLEAN);
			
			$this->raw_data['DealerID'] = $case->DealerID;
			$this->raw_data['SellerID'] = $seller->ID;
			$case->StatusOri = $this->raw_data['StatusID'] = !empty($accept) ? 102 : 103;
			
			$this->data->status = 0;
			$this->data->message = !empty($accept) ? 'Successfully accept agreement.' : 'Successfully reject agreement.';
			$this->data->data = $this->case_status_models->create($this->raw_data);
			
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	// ----------------------------------------------------------------------------------------------------------------
	// Surveys
	
	public function seller_create_survey() {
		try {
			$access_token = $this->seller_models->check_access_token($this->raw_data['access_token']);
			
			$this->required_field = [
				'CaseID',
				'QualityofService',
				'ProvidingAccurateInformationA',
				'ProvidingAccurateInformationB',
				'ProvidingAccurateInformationC',
				'ProvidingAccurateInformationD',
				'ProvidingAccurateInformationE',
				'Recommendation',
				'TradePalServicesA',
				// 'TradePalServicesB',
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			$case = $this->case_models->seller_read_case($this->raw_data['CaseID'], $access_token['seller_id']);
			if ($case->StatusOri !== '25') throw new Exception('Invalid state', 400);
			$this->raw_data['DealerID'] = $case->DealerID;
			$this->raw_data['SellerID'] = $access_token['seller_id'];
			
			$this->data->status = 0;
			$this->data->message = 'Successfully create a survey.';
			$this->data->data = $this->survey_models->create($this->raw_data);
			
			$case_status = [
				'CaseID'   => $case->ID,
				'DealerID' => $case->DealerID,
				'SellerID' => $access_token['seller_id'],
				'StatusID' => 26,
			];
			$this->case_status_models->create($case_status);
			
			$case->StatusOri = 26;
			$this->_process_noti($case);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	
	// ----------------------------------------------------------------------------------------------------------------
	// Surveys
	
	public function case_status_log() {
		try {
			
			$this->required_field = [
				'CaseID',
				'StatusID'
			];
			$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
			if ($validate_result['check_point'] > 0) throw new Exception($validate_result['message'], 400);
			
			
			$case_status = [
				'CaseID'   => $this->raw_data['CaseID'],
				'StatusID' => $this->raw_data['StatusID'],
			];
			
			
			
			$this->data->status = 0;
			$this->data->message = 'Successfully ';
			$this->data->data = $this->case_status_models->create_log($case_status);
			
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	// ----------------------------------------------------------------------------------------------------------------
	// Noti
	
	
	public function admin_view_noti() {
		try {
			
			
			$page = $this->raw_data['page'];
			$per_page = $this->raw_data['per_page'];
			$unread = $this->raw_data['unread'];
		

			$list = $this->noti_models->list_noti_admin( $unread, $page, $per_page);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully retrieve admin notifications';
			$this->data->data = $list;
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function admin_mark_as_read() {
		try {
	
			
			$this->noti_models->admin_mark_as_read($this->raw_data['noti_id']);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully mark admin notification as read';
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_view_noti() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			$this->dealer_models->dealer_get($access_token['dealer_id']);
			
			$page = $this->raw_data['page'];
			$per_page = $this->raw_data['per_page'];
			$unread = $this->raw_data['unread'];
			$dealer_id = $access_token['dealer_id'];
			
			// $viewer = $this->dealer_models->dealer_get($dealer_id);
			// $is_root = $viewer['RoleID'] === "0";
			
			$list = $this->noti_models->list_noti_dealer($dealer_id, $unread, $page, $per_page);
			foreach ($list['items'] as &$item) {
				$item->Dealer = $this->dealer_models->dealer_get($item->DealerID);
			}
			
			$this->data->status = 0;
			$this->data->message = 'Successfully retrieve dealer notifications';
			$this->data->data = $list;
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function dealer_mark_as_read() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			$this->dealer_models->dealer_get($access_token['dealer_id']);
			$dealer_id = $access_token['dealer_id'];
			
			$this->noti_models->dealer_mark_as_read($this->raw_data['noti_id'], $dealer_id);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully mark dealer notification as read';
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function seller_view_noti() {
		try {
			$access_token = $this->seller_models->check_access_token($this->raw_data['access_token']);
			$this->seller_models->seller_get($access_token['seller_id']);
			
			$page = $this->raw_data['page'];
			$per_page = $this->raw_data['per_page'];
			$unread = $this->raw_data['unread'];
			$seller_id = $access_token['seller_id'];
			
			$list = $this->noti_models->list_noti_seller($seller_id, $unread, $page, $per_page);
			foreach ($list['items'] as &$item) {
				$item->Seller = $this->seller_models->seller_get($item->SellerID);
			}
			
			$this->data->status = 0;
			$this->data->message = 'Successfully retrieve seller notifications';
			$this->data->data = $list;
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function seller_mark_as_read() {
		try {
			$access_token = $this->seller_models->check_access_token($this->raw_data['access_token']);
			$this->seller_models->seller_get($access_token['seller_id']);
			$seller_id = $access_token['seller_id'];
			
			$this->noti_models->seller_mark_as_read($this->raw_data['noti_id'], $seller_id);
			
			$this->data->status = 0;
			$this->data->message = 'Successfully mark seller notification as read';
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	private function _process_noti($case) {
		$case = (array)$case;
		
		$stat = $case['StatusOri'];
		if (empty($s)) $s = $case['Status'];
		
		$noti_conf = $this->case_status_models->get_case_status_noti_conf($stat);
		if (empty($noti_conf['Notify'])) return;
		
		$noti = [
			'CaseID'  => $case['ID'],
			'Subject' => "Case {$case['ID']}: {$noti_conf['NotiSubject']}",
			'Detail'  => $noti_conf['NotiDetail'],
		];
		
		
		if (!empty($noti_conf['NotiAdmin'])) {
			$this->noti_models->create_noti_admin($noti);
		}
		
		if (!empty($noti_conf['NotiCarOwner'])) {
			$seller = $this->seller_models->seller_get($case['SellerID']);
			$noti['SellerID'] = $seller['ID'];
			$this->noti_models->create_noti_seller($noti);
			$this->onesignal_models->send_to_player_id($seller['PlayerID'], $noti['Subject'], $case);
		}

		if (!empty($noti_conf['NotiDealer'])) {
			$root = $this->dealer_models->dealer_get($case['RootID']);
			$noti['DealerID'] = $root['ID'];
			$this->noti_models->create_noti_dealer($noti);
			$this->onesignal_models->send_to_player_id($root['PlayerID'], $noti['Subject'], $case);
		}
		
		
		if (!empty($noti_conf['NotiTradepal'])) {
			$this->case_status_models->send_noti_mail($noti_conf['NotiTradepal'], $noti['Subject'], $noti_conf['NotiDetail']);
		}
		
		if (!empty($noti_conf['NotiBank'])) {
			$this->case_status_models->send_noti_mail($noti_conf['NotiBank'], $noti['Subject'], $noti_conf['NotiDetail']);
		}
		
		if ($stat === 2) {
			if(!empty($case['SellerID'])) {
				$case['Seller'] = $this->seller_models->seller_get($case['SellerID']);
			}
		
			$case['Dealer'] = $this->dealer_models->dealer_get($case['DealerID']);
			$case['DealerRoot'] = $this->dealer_models->dealer_get($case['RootID']);
			
			$receivers = [
				$case['Seller']['Email'],
				$case['Dealer']['Email'],
				$case['DealerRoot']['Email'],
				$noti_conf['NotiTradepal'],
				$noti_conf['NotiBank'],
			];
			
			$message = $noti_conf['NotiDetail'];
			$body = $this->load->view('noti_mail', compact('message'), true);
			
			$case = (object)$case;
			$html1 = $this->load->view('api/pdf/buy-sell-agreement.php', compact('case'), TRUE);
			$html2 = $this->load->view('api/pdf/term-buy-sell-agreement.php', compact('case'), TRUE);
			
			$filePath = dirname($_SERVER["SCRIPT_FILENAME"]) . '/temp/pdf/';
			
			$fileName_1 = 'buy-sell-agreement-' . $case->ID . '.pdf';
			$filePath_1 = $filePath . $fileName_1;
			$this->create_pdf($filePath_1, $html1, 'F');
			
			$fileName_2 = 'term-buy-sell-agreement-' . $case->ID . '.pdf';
			$filePath_2 = $filePath . $fileName_2;
			$this->create_pdf($filePath_2, $html2, 'F');
			
			$files = [];
			$files[0]['name'] = $fileName_1;
			$files[0]['path'] = $filePath_1;
			$files[1]['name'] = $fileName_2;
			$files[1]['path'] = $filePath_2;
			
			$this->models->mailer_file($receivers, $noti['Subject'], $body, $files);
		}
		
		if ($stat === 25) {
			if (!empty($case['SellerID'])) {
				$case['Seller'] = $this->seller_models->seller_get($case['SellerID']);
			}
			$case['Dealer'] = $this->dealer_models->dealer_get($case['DealerID']);
			$case['DealerRoot'] = $this->dealer_models->dealer_get($case['RootID']);
			$case['Survey'] = $this->survey_models->read($case['ID']);
			
			$receivers = [
				$case['Seller']['Email'],
				$case['Dealer']['Email'],
				$case['DealerRoot']['Email'],
				$noti_conf['NotiTradepal'],
				$noti_conf['NotiBank'],
			];
			$message = $noti_conf['NotiDetail'];
			$body = $this->load->view('noti_mail', compact('message'), true);
			$attachments = [
				[
					'name'    => 'handover-acknowledgement.pdf',
					'content' => $this->_gen_handover_acknowledgement_pdf($case),
				],
			];
			
			$this->models->mailer_string_attachment($receivers, $noti['Subject'], $body, $attachments);
		}
	}
	
	public function test() {
		$case = [
			'StatusOri' => '1',
			'SellerID' => '26',
			'RootID' => '7',
			'ID' => '999999'
		];
		$this->_process_noti($case);
	}
	
	
	public function _gen_handover_acknowledgement_pdf($case) {
		$this->load->library('DomPDFCustom');
		
		$case = (object)$case;
		
		$car_title_transfer_status = null;
		$money_transfer_to_car_owner_status = null;
		$handover_status = null;
		
		foreach ($case->StatusLogs as $log) {
			switch ($log->StatusID) {
				case '20':
					$car_title_transfer_status = $log;
					break;
				case '21':
					$money_transfer_to_car_owner_status = $log;
					break;
				case '23':
					$handover_status = $log;
					break;
			}
		}
		
		$path = "/www/wwwroot/tradepal.sg{$case->Dealer['Logo']}";
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$size = getimagesize($path);
		$data = file_get_contents($path);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
		
		$data = [
			'Logo'                        => $base64,
			'LogoWidth'                   => ($size[0] * 75) / $size[1],
			'LogoHeight'                  => 75,
			'Date'                        => Carbon::now()->format('d M Y H:i'),
			'CaseID'                      => $case->ID,
			'DealerName'                  => $case->Dealer['UserName'],
			'DealerID'                    => $case->Dealer['ID'],
			'SellerName'                  => "{$case->Seller['FirstName']} {$case->Seller['LastName']}",
			'SellerID'                    => $case->Seller['ID'],
			'VehicleNo'                   => $case->VehicleNo,
			'RegNo'                       => empty($case->RegNo) ? '-' : $case->RegNo,
			'MakeAndModel'                => "{$case->VehicleMake} {$case->VehicleModel}",
			'OriginalRegnDate'            => Carbon::createFromFormat('Y-m-d H:i:s', $case->OriginalRegnDate)->format('d M Y H:i'),
			'PriceAgreed'                 => $case->PriceAgreed,
			'DepositAmount'               => $case->DepositAmount,
			'OutStandingHirePurchaseLoan' => empty($case->OutStandingHirePurchaseLoan) ? 'No' : 'Yes',
			'Bank'                        => $case->Bank,
			'CarTitleTranOn'              => Carbon::createFromFormat('Y-m-d H:i:s', $car_title_transfer_status->INS)->format('d M Y H:i'),
			'CarOwnerBalancePayment'      => $money_transfer_to_car_owner_status->MoneyTransferredCarOwner,
			'CarOwnerBalancePaymentOn'    => Carbon::createFromFormat('Y-m-d H:i:s', $money_transfer_to_car_owner_status->INS)->format('d M Y H:i'),
			'HandoverDate'                => Carbon::createFromFormat('Y-m-d', $handover_status->AppointmentDate)->format('d M Y'),
			'HandoverTime'                => $handover_status->AppointmentTime,
			'HandoverLocation'            => $handover_status->AppointmentPlace,
		];
		
		$html = $this->load->view('handover_ack', $data, true);
		$this->DomPDFCustom->loadHtml($html);
		$this->DomPDFCustom->setPaper('A4', 'portrait');
		$this->DomPDFCustom->render();
		
		return $this->DomPDFCustom->output();
	}
	
	// ----------------------------------------------------------------------------------------------------------------
	// Misc
	
	public function cron_send_appointment_noti() {
		// $list =
	}
	
	public function dealer_check_vehicle_no() {
		try {
			$access_token = $this->dealer_models->check_access_token($this->raw_data['access_token']);
			$dealer = $this->dealer_models->dealer_get($access_token['dealer_id']);
			
			$this->data->status = 0;
			$this->data->message = 'The given vehicle number is valid';
			$this->data->data = $this->case_models->dealer_check_vehicle_no($dealer['root_id'], $this->raw_data['VehicleNo']);
			$this->renderJson($this->data, $this->data->header);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	// ----------------------------------------------------------------------------------------------------------------
	// PDF
	
	public function test_mail($case_id = 0) {
		try {
			$to = ['keawsongkort@gmail.com'];
			$subject = 'test';
			$detail = 'testddd';
			$body = $this->load->view('noti_mail', compact('detail'), true);
			
			$case = $this->view_case_data($case_id);
			$html1 = $this->load->view('api/pdf/buy-sell-agreement.php', compact('case'), TRUE);
			$html2 = $this->load->view('api/pdf/term-buy-sell-agreement.php', compact('case'), TRUE);
			
			$filePath = dirname($_SERVER["SCRIPT_FILENAME"]) . '/temp/pdf/';
			
			$fileName_1 = 'buy-sell-agreement-' . $case->ID . '.pdf';
			$filePath_1 = $filePath . $fileName_1;
			$this->create_pdf($filePath_1, $html1, 'F');
			
			$fileName_2 = 'term-buy-sell-agreement-' . $case->ID . '.pdf';
			$filePath_2 = $filePath . $fileName_2;
			$this->create_pdf($filePath_2, $html2, 'F');
			
			$files = [];
			$files[0]['name'] = $fileName_1;
			$files[0]['path'] = $filePath_1;
			$files[1]['name'] = $fileName_2;
			$files[1]['path'] = $filePath_2;
			
			$this->models->mailer_file($to, $subject, $body, $files);
			
			echo 'ssssss';
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function pdf_handover_acknowledgement($case_id = 0) {
		try {
			$case = $this->view_case_data($case_id);
			
			$car_title_transfer_status = null;
			$money_transfer_to_car_owner_status = null;
			$handover_status = null;
			
			foreach ($case->StatusLogs as $log) {
				switch ($log->StatusID) {
					case '20':
						$car_title_transfer_status = $log;
						break;
					case '21':
						$money_transfer_to_car_owner_status = $log;
						break;
					case '23':
						$handover_status = $log;
						break;
				}
			}
			
			$case->INS = date("d M Y H:i", strtotime($case->INS));
			$case->OriginalRegnDate = date("d M Y", strtotime($case->OriginalRegnDate));
			$case->CarTitleTranOn = date("d M Y", strtotime($car_title_transfer_status->INS));
			$case->CarOwnerBalancePayment = $money_transfer_to_car_owner_status->MoneyTransferredCarOwner;
			$case->CarOwnerBalancePaymentOn = date("d M Y H:i", strtotime($money_transfer_to_car_owner_status->INS));
			$case->HandoverDate = date("d M Y", strtotime($handover_status->AppointmentDate));
			$case->HandoverTime = $handover_status->AppointmentTime;
			$case->HandoverLocation = $handover_status->AppointmentPlace;
			
			$html = $this->load->view('api/pdf/handover_acknowledgement.php', compact('case'), TRUE);
			$this->create_pdf('handover_acknowledgement-' . $case->ID . '.pdf', $html, 'D');
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	
	public function pdf_buy_sell_agreemen_view($case_id = 0) {
		
		$case = $this->view_case_data($case_id);
		$this->renderJson($case, $this->data->header);
	}
	
	public function pdf_buy_sell_agreement($case_id = 0) {
		try {
			$case = $this->view_case_data($case_id);
			$html = $this->load->view('api/pdf/buy-sell-agreement.php', compact('case'), TRUE);
			$this->create_pdf('buy-sell-agreement-' . $case->ID . '.pdf', $html);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function pdf_term_buy_sell_agreement($case_id = 0) {
		try {
			$case = $this->view_case_data($case_id);
			$html = $this->load->view('api/pdf/term-buy-sell-agreement.php', compact('case'), TRUE);
			$this->create_pdf('term-buy-sell-agreement-' . $case->ID . '.pdf', $html);
		} catch (Exception $e) {
			$this->data->status = $e->getCode();
			$this->data->message = $e->getMessage();
			$this->renderJson($this->data, $this->data->header);
		}
	}
	
	public function view_case_data($case_id = 0) {
		$case = $this->case_models->dealer_read_case_all($case_id);
		if (!empty($case->SellerID)) {
			$case->Seller = $this->seller_models->seller_get($case->SellerID);
		}
		$case->Dealer = $this->dealer_models->dealer_get($case->DealerID);
		$case->DealerRoot = $this->dealer_models->dealer_get($case->RootID);
		$case->INS = date("d M Y H:i", strtotime($case->INS));
		$case->OriginalRegnDate = date("d M Y", strtotime($case->OriginalRegnDate));
		return $case;
	}
	
	public function create_pdf($fileName, $html, $saveType = 'D') {
		$gen = new mPDF('UTF-8', 'A4', 9, 'helvetica');
		$gen->SetDisplayMode('fullpage');
		$gen->shrink_tables_to_fit = 0;
		$gen->WriteHTML($html);
		$gen->Output($fileName, $saveType);
	}
	
	
	public function saveBase64Image($base64_image) {
		$image_parts = explode(";base64,", $base64_image);
		$image_type_aux = explode("image/", $image_parts[0]);
		$image_type = $image_type_aux[1];
		
//		$allow_type = ['gif', 'jpg', 'png', 'jpeg'];
//		if (!in_array($image_type, $allow_type)) throw new Exception("Invalid image type.", 400);
		
		$image_base64 = base64_decode($image_parts[1]);
		$file_name = uniqid() . '.' . $image_type;
		$file = APPPATH . '../uploads/loandoc/' . $file_name;
		file_put_contents($file, $image_base64);
		
		return "{$file_name}";
	}
}
