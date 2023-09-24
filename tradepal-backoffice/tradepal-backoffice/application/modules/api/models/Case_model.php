<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Case_model extends Api_model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function dealer_create_case($data = array()) {
		$insert = [
			'DealerID'                       => $data['DealerID'],
			'SellerID'                       => $data['SellerID'],
			'RootID'                         => $data['RootID'],
			'BranchID'                       => $data['BranchID'],
			'NRIC'                           => $data['NRIC'],
			'VehicleNo'                      => $data['VehicleNo'],
			'ChassisNo'                      => $data['ChassisNo'],
			'EngineNo'                       => $data['EngineNo'],
			'OriginalRegnDate'               => $data['OriginalRegnDate'],
			'YearOfManufacture'              => $data['YearOfManufacture'],
			'PriceAgreed'                    => $data['PriceAgreed'],
			'Remark'                         => $data['Remark'],
			'DepositAmount'                  => $data['DepositAmount'],
			'Video'                          => $data['Video'],
			'Photo1'                         => $this->saveBase64Image($data['Photo1']),
			'Photo2'                         => $this->saveBase64Image($data['Photo2']),
			'Photo3'                         => $this->saveBase64Image($data['Photo3']),
			'Photo4'                         => $this->saveBase64Image($data['Photo4']),
			'Photo5'                         => $this->saveBase64Image($data['Photo5']),
			'Photo6'                         => $this->saveBase64Image($data['Photo6']),
			'DocHandoverAcknowledgement'      => $this->saveBase64($data['DocHandoverAcknowledgement']),
			'VehicleMake'                    => $data['VehicleMake'],
			'VehicleModel'                   => $data['VehicleModel'],
			'PrimaryColour'                  => $data['PrimaryColour'],
			'OutStandingHirePurchaseLoan'    => $data['OutStandingHirePurchaseLoan'],
			'Bank'                           => $data['Bank'],
			'BalancePayableToSellerByTrader' => $data['BalancePayableToSellerByTrader'],
			'OutstandingHirePurchaseBalance' => $data['OutstandingHirePurchaseBalance'],
			'TentativeDeliveryDate'          => $data['TentativeDeliveryDate'],
			'RegNo'                          => $data['RegNo'],
			'Type'                           => $data['Type'],
			'IsthisaPIUsedCar'               => $data['IsthisaPIUsedCar'],
			'FirstRegistrationDate'          => $data['FirstRegistrationDate'],
			'NoOfTransfers'                  => $data['NoOfTransfers'],
			'ChangeRegNo'                  => $data['ChangeRegNo'],
			'Status'                         => "1",
			'INS'                            => $this->get_now(),
			'MOD'                            => $this->get_now(),
		];
		
		
		
		
		$this->db->insert('case', $insert);
		
		return $this->db->insert_id();
	}
	
	public function dealer_create_sell_case($data = array()) {
		$insert = [
			'DealerID'                    => $data['DealerID'],
			'SellerID'                    => $data['SellerID'],
			'RootID'                      => $data['RootID'],
			'BranchID'                    => $data['BranchID'],
			'NRIC'                        => $data['NRIC'],
			'VehicleNo'                   => $data['VehicleNo'],
			'ChassisNo'                   => $data['ChassisNo'],
			'EngineNo'                    => $data['EngineNo'],
			'OriginalRegnDate'            => $data['OriginalRegnDate'],
			'YearOfManufacture'           => $data['YearOfManufacture'],
			'PriceAgreed'                 => $data['PriceAgreed'],
			'Remark'                      => $data['Remark'],
			'DepositAmount'               => $data['DepositAmount'],
			'VehicleMake'                 => $data['VehicleMake'],
			'VehicleModel'                => $data['VehicleModel'],
			'PrimaryColour'               => $data['PrimaryColour'],
			'RegNo'                       => $data['RegNo'],
			'Type'                        => $data['Type'],
			'SellBalancePayableToDealer'  => $data['SellBalancePayableToDealer'],
			'SellTentativeHandOverDate'   => $data['SellTentativeHandOverDate'],
			'SellBankFinanceCompany'      => $data['SellBankFinanceCompany'],
			'SellHowMuchHirePurchaseLoan' => $data['SellHowMuchHirePurchaseLoan'],
			'SellHirePurchaseLoan'        => $data['SellHirePurchaseLoan'],
			'NoOfTransfers'               => $data['NoOfTransfers'],
			'ChangeRegNo'               	=> $data['ChangeRegNo'],
			'SellerName'               	=> $data['SellerName'],
			'SellerEmail'               	=> $data['SellerEmail'],
			'SellerMobile'               	=> $data['SellerMobile'],
			'ModeOfPayment'               	=> $data['ModeOfPayment'] ,
		
	
//			'Status'                      => "101",
			'INS'                         => $this->get_now(),
			'MOD'                         => $this->get_now(),
		];
		
	
		
		$this->db->insert('case', $insert);
		return $this->db->insert_id();
	}
	
	public function dealer_view_cases($page, $per_page, $dealer_id, $is_root, $filters, $sort_column = 'MOD', $sort_by = 'desc') {
		$offset = ($page - 1) * $per_page;
		
		$this->db->from('case');
		
		if (empty($is_root)) {
			$this->db->where('DealerID', $dealer_id);
		} else {
			$this->db->where('RootID', $dealer_id);
		}
		
		foreach ($filters as $key => $filter) {
			if ($key === 'SellerID') {
				$this->db->where_in($key, $filter);
				continue;
			}
			
			if ($key === 'Month' ) {
				if (!empty($filter)) {
					$this->db->where('MONTH(`MOD`)', $filter);
					$this->db->where('YEAR(`MOD`)', date('Y'));
				}
				continue;
			}
			
			$this->db->like($key, $filter, 'both');
		}
		
		$this->db->where('Deleted', 0);
		
		$total = $this->db->count_all_results();
		
		$this->db->from('case');
		
		if (empty($is_root)) {
			$this->db->where('DealerID', $dealer_id);
		} else {
			$this->db->where('RootID', $dealer_id);
		}
		
		foreach ($filters as $key => $filter) {
			if ($key === 'SellerID') {
				$this->db->where_in($key, $filter);
				continue;
			}
			
			if ($key === 'Month' ) {
				if (!empty($filter)) {
					$this->db->where('MONTH(`MOD`)', $filter);
					$this->db->where('YEAR(`MOD`)', date('Y'));
				}
				continue;
			}
			
			$this->db->like($key, $filter, 'both');
		}
		
		$this->db->where('Deleted', 0);
		
		if ($sort_column == 'Status') {
			$cases = $this->db->order_by("ABS(`$sort_column`)", $sort_by)->limit($per_page, $offset)->get()->result();
		} else {
			$cases = $this->db->order_by($sort_column, $sort_by)->limit($per_page, $offset)->get()->result();
		}
		
	
		
		
		foreach ($cases as &$case) {
			$case->StatusOri = $case->Status;
			$case->Status = $this->load_case_status_text($case->Status, 'dealer');
		}
		
		return [
			'total' => $total,
			'items' => $cases,
		];
	}
	
	public function seller_view_cases($page, $per_page, $seller_id, $filters, $sort_column = 'MOD', $sort_by = 'desc') {
		$offset = ($page - 1) * $per_page;
		
		$this->db->from('case');
		$this->db->where('SellerID', $seller_id)->where('Deleted', 0);
		
		foreach ($filters as $key => $filter) {
			if ($key === 'Month' ) {
				if (!empty($filter)) {
					$this->db->where('MONTH(`MOD`)', $filter);
					$this->db->where('YEAR(`MOD`)', date('Y'));
				}
				continue;
			}
			
			$this->db->like($key, $filter, 'both');
		}
		
		$total = $this->db->count_all_results();
		
		$this->db->from('case');
		$this->db->where('SellerID', $seller_id)->where('Deleted', 0);
		
		foreach ($filters as $key => $filter) {
			
			if ($key === 'Month' ) {
				if (!empty($filter)) {
					$this->db->where('MONTH(`MOD`)', $filter);
					$this->db->where('YEAR(`MOD`)', date('Y'));
				}
				continue;
			}
			
			$this->db->like($key, $filter, 'both');
		}
		
		if ($sort_column == 'Status') {
			$cases = $this->db->order_by("ABS(`$sort_column`)", $sort_by)->limit($per_page, $offset)->get()->result();
		} else {
			$cases = $this->db->order_by($sort_column, $sort_by)->limit($per_page, $offset)->get()->result();
		}
		
		
		foreach ($cases as &$case) {
			$case->StatusOri = $case->Status;
			$case->StatusName = $this->load_case_status_text($case->Status, 'seller');
		}
		
		return [
			'total' => $total,
			'items' => $cases,
		];
	}
	
	public function car_brand_get($car_brand_id) {
		$select_field = $this->get_allfield('car_band');
		$result = $this->db->select($select_field)->from('car_band')->where('id', $car_brand_id)->get();
		$row = $result->row_array();
		
		if (empty($row)) throw new Exception("Car brand ID not found.", 404);
		
		return $row;
	}
	
	public function get_car_brands() {
		return $this->db->get('car_band')->result();
	}
	
	
	public function save_doc_handover_acknowledgement($data = array()) {
		$arraySet = [
			'DocHandoverAcknowledgement' => $data['DocHandoverAcknowledgement'],
			'MOD' => $this->get_now(),
		];
		
		
		$this->db->where('id', $data['CaseID'])->where('Deleted', 0);
		return $this->db->update('case', $arraySet);
	}
	public function dealer_edit_case($data = array()) {
		$arraySet = [
			'SellerID'                       => $data['SellerID'],
			'NRIC'                           => $data['NRIC'],
			'VehicleNo'                      => $data['VehicleNo'],
			'ChassisNo'                      => $data['ChassisNo'],
			'EngineNo'                       => $data['EngineNo'],
			'OriginalRegnDate'               => $data['OriginalRegnDate'],
			'YearOfManufacture'              => $data['YearOfManufacture'],
			'PriceAgreed'                    => $data['PriceAgreed'],
			'Remark'                         => $data['Remark'],
			'DepositAmount'                  => $data['DepositAmount'],
			'Video'                          => $data['Video'],
			'VehicleMake'                    => $data['VehicleMake'],
			'VehicleModel'                   => $data['VehicleModel'],
			'PrimaryColour'                  => $data['PrimaryColour'],
			'OutStandingHirePurchaseLoan'    => $data['OutStandingHirePurchaseLoan'],
			'Bank'                           => $data['Bank'],
			'BalancePayableToSellerByTrader' => $data['BalancePayableToSellerByTrader'],
			'OutstandingHirePurchaseBalance' => $data['OutstandingHirePurchaseBalance'],
			'TentativeDeliveryDate'          => $data['TentativeDeliveryDate'],
			'RegNo'                          => $data['RegNo'],
			'Type'                           => $data['Type'],
			'IsthisaPIUsedCar'               => $data['IsthisaPIUsedCar'],
			'FirstRegistrationDate'          => $data['FirstRegistrationDate'],
			'NoOfTransfers'                  => $data['NoOfTransfers'],
			'ChangeRegNo'                  => $data['ChangeRegNo'],
		
			'Status'                         => "1",
			'MOD'                            => $this->get_now(),
		];
		
		
		
		if (!empty($data['Photo1']) && strlen(($data['Photo1']) > 255)) {
			$arraySet['Photo1'] = $this->saveBase64Image($data['Photo1']);
		}
		
		if (!empty($data['Photo2']) && strlen(($data['Photo2']) > 255)) {
			$arraySet['Photo2'] = $this->saveBase64Image($data['Photo2']);
		}
		
		if (!empty($data['Photo3']) && strlen(($data['Photo3']) > 255)) {
			$arraySet['Photo3'] = $this->saveBase64Image($data['Photo3']);
		}
		
		if (!empty($data['Photo4']) && strlen(($data['Photo4']) > 255)) {
			$arraySet['Photo4'] = $this->saveBase64Image($data['Photo4']);
		}
		
		if (!empty($data['Photo5']) && strlen(($data['Photo5']) > 255)) {
			$arraySet['Photo5'] = $this->saveBase64Image($data['Photo5']);
		}
		
		if (!empty($data['Photo6']) && strlen(($data['Photo6']) > 255)) {
			$arraySet['Photo6'] = $this->saveBase64Image($data['Photo6']);
		}
		
		if (!empty($data['DocHandoverAcknowledgement']) && strlen(($data['DocHandoverAcknowledgement']) > 255)) {
			$arraySet['DocHandoverAcknowledgement'] = $this->saveBase64($data['DocHandoverAcknowledgement']);
		}
		
		$this->db->where('id', $data['CaseID'])->where('Deleted', 0);
		return $this->db->update('case', $arraySet);
	}
	
	public function dealer_edit_sell_case($data = array()) {
		$arraySet = [
			'SellerID'                    => $data['SellerID'],
			'NRIC'                        => $data['NRIC'],
			'VehicleNo'                   => $data['VehicleNo'],
			'ChassisNo'                   => $data['ChassisNo'],
			'ChangeRegNo'                   => $data['ChangeRegNo'],
			'EngineNo'                    => $data['EngineNo'],
			'OriginalRegnDate'            => $data['OriginalRegnDate'],
			'YearOfManufacture'           => $data['YearOfManufacture'],
			'PriceAgreed'                 => $data['PriceAgreed'],
			'Remark'                      => $data['Remark'],
			'DepositAmount'               => $data['DepositAmount'],
			'VehicleMake'                 => $data['VehicleMake'],
			'VehicleModel'                => $data['VehicleModel'],
			'PrimaryColour'               => $data['PrimaryColour'],
			'RegNo'                       => $data['RegNo'],
			'SellBalancePayableToDealer'  => $data['SellBalancePayableToDealer'],
			'SellTentativeHandOverDate'   => $data['SellTentativeHandOverDate'],
			'SellBankFinanceCompany'      => $data['SellBankFinanceCompany'],
			'SellHowMuchHirePurchaseLoan' => $data['SellHowMuchHirePurchaseLoan'],
			'SellHirePurchaseLoan'        => $data['SellHirePurchaseLoan'],
			'NoOfTransfers'               => $data['NoOfTransfers'],
			'SellerName'               	=> $data['SellerName'],
			'SellerEmail'               	=> $data['SellerEmail'],
			'SellerMobile'               	=> $data['SellerMobile'],
			'ModeOfPayment'               	=> $data['ModeOfPayment'],
			'MOD'                         => $this->get_now(),
		];
return $data;
		
		$this->db->where('id', $data['CaseID'])->where('Deleted', 0);
		return $this->db->update('case', $arraySet);
	}
	
	public function find_case_by_id($case_id) {
		$select_field = $this->get_allfield('case');
		$result = $this->db->select($select_field)->from('case')->where('id', $case_id)->where('Deleted', 0)->get();
		$row = $result->row_array();
		
		if (empty($row)) throw new Exception("Case not found", 404);
		
		return $row;
	}
	
	public function dealer_delete_case($case_id) {
		$arraySet = [
			'Deleted' => 1,
			'MOD'     => $this->get_now(),
		];
		
		$this->db->where('id', $case_id);
		return $this->db->update('case', $arraySet);
	}
	
	public function dealer_read_case($case_id, $dealer_id, $is_root) {
		$where = ['id' => $case_id, 'Deleted' => 0];
		if (empty($is_root)) {
			$where['DealerID'] = $dealer_id;
		} else {
			$where['RootID'] = $dealer_id;
		}
		
		$case = $this->db->get_where('case', $where)->row();
		if (empty($case)) throw new Exception('Case not found.', 404);
		
		$case->StatusLogs = $this->load_case_status($case->ID);
		$case->StatusOri = $case->Status;
		$case->Status = $this->load_case_status_text($case->Status, 'dealer');
		
		foreach ($case->StatusLogs as &$log) {
			$log->StatusText = $this->load_case_status_text($log->StatusID, 'dealer');
		}
		
		return $case;
	}
	
	public function dealer_read_case_all($case_id = '') {
		$where = ['ID' => $case_id, 'Deleted' => 0];
		$case = $this->db->get_where('case', $where)->row();
		if (empty($case)) throw new Exception('Case not found.', 404);
		
		$case->StatusLogs = $this->load_case_status($case->ID);
		$case->StatusOri = $case->Status;
		$case->Status = $this->load_case_status_text($case->Status, 'dealer');
		
		foreach ($case->StatusLogs as &$log) {
			$log->StatusText = $this->load_case_status_text($log->StatusID, 'dealer');
		}
		
		return $case;
	}
	
	public function seller_read_case($case_id, $seller_id) {
		$where = ['id' => $case_id, 'Deleted' => 0, 'SellerID' => $seller_id];
		$case = $this->db->get_where('case', $where)->row();
		if (empty($case)) throw new Exception('Case not found.', 404);
		
		$case->StatusLogs = $this->load_case_status($case->ID);
		$case->StatusOri = $case->Status;
		$case->Status = $this->load_case_status_text($case->Status, 'seller');
		
		foreach ($case->StatusLogs as &$log) {
			$log->StatusText = $this->load_case_status_text($log->StatusID, 'seller');
		}
		
		return $case;
	}
	
	public function load_case_status($case_id) {
		$where = ['CaseID' => $case_id];
		return $this->db->get_where('status_log', $where)->result();
	}
	
	public function load_case_status_text($status_id, $type) {
		$where = ['ID' => $status_id];
		$status = $this->db->get_where('case_status', $where)->row();
		
		switch ($type) {
			case 'dealer':
				return $status->NameDealer;
			case 'seller':
				return $status->NameSeller;
			default:
				return $status->NameTradepal;
		}
	}
	
	public function dealer_edit_reg_no($case_id, $reg_no) {
		$arraySet = [
			'RegNo' => $reg_no,
			'MOD'   => $this->get_now(),
		];
		
		$this->db->where('id', $case_id)->where('Deleted', 0);
		return $this->db->update('case', $arraySet);
	}
	
	public function dealer_check_vehicle_no($root_id, $vehicle_no) {
		$where = [
			'RootID'    => $root_id,
			'VehicleNo' => $vehicle_no,
			'Deleted'   => 0,
		];
		$case = (array)$this->db->order_by('INS', 'desc')->get_where('case', $where, 1, 0)->row();
		if (empty($case)) {
			$where = [
				'RootID'    => $root_id,
				'RegNo' => $vehicle_no,
				'Deleted'   => 0,
			];
			$case = (array)$this->db->order_by('INS', 'desc')->get_where('case', $where, 1, 0)->row();
		}
		if (empty($case)) throw new Exception('Vehicle number not found.', 404);
		
		if ($case['Type'] === 'BUY' && $case['Status'] < '26') throw new Exception('Vehicle has not been bought.');
		//		if ($case['Type'] === 'SELL' && $case['Status'] !== '103') throw new Exception('Vehicle is already offered to another buyer.');
		
		return [
			'VehicleNo'         => $case['VehicleNo'],
			'OriginalRegnDate'  => $case['OriginalRegnDate'],
			'YearOfManufacture' => $case['YearOfManufacture'],
			'VehicleMake'       => $case['VehicleMake'],
			'VehicleModel'      => $case['VehicleModel'],
			'PrimaryColour'     => $case['PrimaryColour'],
			'ChassisNo'         => $case['ChassisNo'],
			'EngineNo'          => $case['EngineNo'],
			'RegNo'          => $case['RegNo'],
			'ChangeRegNo'          => $case['ChangeRegNo'],
		];
		
	}
}
