<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Carowner extends MY_Controller {
	
	var $model_name = 'Carowner_model';
	var $page_title = "Car Owner";
	var $page_view = "carowner";
	var $output_data = array();
	var $can_permission;
	
	public function __construct() {
		parent:: __construct();
		$this->load->library('user_agent');
		$this->load->model($this->model_name, 'models');
		$this->load->model('main_model', 'mainm');
		$this->load->model('resp_model', 'resp');
		/* Api case */
		$this->load->model('Api/Api_model', 'api_models');
		$this->load->model('Api/Dealer_model', 'dealer_models');
		$this->load->model('Api/Seller_model', 'seller_models');
		$this->load->model('Api/Case_model', 'case_models');
		
		foreach ($this->raw_data as $key => $row) {
			$this->{$key} = $row;
		}
		
		# Check Access
		$this->mainm->check_can_permission($this->router->class, 'access');
	}
	
	public function loadContent() {
		/* set sort field */
		$sort_field = ($_REQUEST['sort']['field'] ? $_REQUEST['sort']['field'] : 'ID');
		$sort_type = ($_REQUEST['sort']['sort'] ? $_REQUEST['sort']['sort'] : 'desc');
		/* json data for datatables */
		$data = $this->models->get_itemlist($sort_field, $sort_type);
		
		echo $this->mains->loadAjaxData($data);
	}
	
	public function dealerDetail($cid = 0) {
		/* set sort field */
		$sort_field = ($_REQUEST['sort']['field'] ? $_REQUEST['sort']['field'] : 'ID');
		$sort_type = ($_REQUEST['sort']['sort'] ? $_REQUEST['sort']['sort'] : 'desc');
		/* json data for datatables */
		$data = $this->models->get_dealer_detail($sort_field, $cid, $sort_type);
		echo $this->mains->loadAjaxData($data);
	}
	
	
	public function index() {
		$data = array();
		# Genarating CSS/JS
		$css = $this->mainm->gencss();
		$js = $this->mainm->genjs();
		# Merge Information
		$data['css'] = join(" ", $css);
		$data['js'] = join(" ", $js);
		# Set Page Navi
		$data['page_url'] = $this->router->class;
		$data['page_now'] = $this->router->method;
		$data['page_text'] = $this->page_title;
		
		# Get Information Form (models)
		# Load view
		$this->load->view('inc-header', $data);
		$this->load->view($this->page_view . '/index', $data);
		$this->load->view('inc-footer', $data);
	}
	
	public function add() {
		$this->mainm->check_can_permission($this->router->class, 'add');
		$data = array();
		# Genarating CSS/JS
		$css = $this->mainm->gencss();
		$js = $this->mainm->genjs();
		# Merge Information
		$data['css'] = join(" ", $css);
		$data['js'] = join(" ", $js);
		# Set Page Navi
		$data['page_url'] = $this->router->class;
		$data['page_now'] = $this->router->method;
		$data['page_text'] = $this->page_title;
		$data['act_mode'] = 'add';
		
		# get data
		# Get Information Form (models)
		# Load view
		$this->load->view('inc-header', $data);
		$this->load->view($this->page_view . '/add', $data);
		$this->load->view('inc-footer', $data);
	}
	
	
	public function edit($id = 0) {
		
		$data = array();
		# Genarating CSS/JS
		$css = $this->mainm->gencss();
		$js = $this->mainm->genjs();
		# Merge Information
		$data['css'] = join(" ", $css);
		$data['js'] = join(" ", $js);
		# Set Page Navi
		$data['page_url'] = $this->router->class;
		$data['page_now'] = $this->router->method;
		$data['page_text'] = $this->page_title;
		$data['act_mode'] = 'add';
		$data['edit_id'] = $id;
		
		# get data
		# Get Information Form (models)
		# Load view
		$this->load->view('inc-header', $data);
		$this->load->view($this->page_view . '/edit', $data);
		$this->load->view('inc-footer', $data);
	}
	
	public function view($id = 0) {
		$this->mainm->check_can_permission($this->router->class, 'view');
		if (empty($id)):
			redirect($this->router->class);
		else:
			$data = array();
			# Genarating CSS/JS
			$css = $this->mainm->gencss();
			$js = $this->mainm->genjs();
			# Merge Information
			$data['css'] = join(" ", $css);
			$data['js'] = join(" ", $js);
			# Set Page Navi
			$data['page_url'] = $this->router->class;
			$data['page_now'] = $this->router->method;
			$data['page_text'] = $this->page_title;
			$data['act_mode'] = 'edit';
			$data['edit_id'] = $id;
			
			# get data
			$data['info_data'] = $this->models->get_itemtinfo($id);
			# Load view
			$this->load->view('inc-header', $data);
			$this->load->view($this->page_view . '/view', $data);
			$this->load->view('inc-footer', $data);
		endif;
	}
	
	public function delete($id = 0) {
		
		# Start delete
		$this->models->delete($id);
		redirect(base_url($this->router->class));
	}
	
	public function advance_quantum() {
		
		
		# SET Required field
		$this->required_field = array('ID', 'AdvanceQuantum');
		
		# Validate
		$validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
		
		# Checkpont and process
		if ($validate_result['check_point'] > 0):
			$this->data->message = $validate_result['message'];
		else:
			
			$get_dealer = $this->mains->sumdataRepeat('dealer', ['ID' => $this->ID]);
			
			if (!$get_dealer) {
				$this->data->status = 1;
				$this->data->message = 'The Dealer ID ' . $this->ID . ' not found.';
			} else {
				try {
					$saveData = $this->models->save_advancequantum($this->ID, $this->raw_data);
					
					if ($saveData) {
						$this->data->status = 0;
						$this->data->message = 'Successfully save ';
					} else {
						$this->data->status = 1;
						$this->data->message = 'Failed to save';
					}
				} catch (Exception $e) {
					$this->data->status = $e->getCode();
					$this->data->message = $e->getMessage();
				}
			}
		
		endif;
		$this->renderJson($this->data, $this->data->header);
	}
	
	public function export() {
		// create file name
		$pathName = dirname($_SERVER["SCRIPT_FILENAME"]) . '/uploads/export/';
		$fileName = 'carowner-' . time() . '.xlsx';
		
		// load excel library
		$this->load->library('Excel');
		/* set sort field */
		$sort_field = ($_REQUEST['sort']['field'] ? $_REQUEST['sort']['field'] : 'ID');
		$sort_type = ($_REQUEST['sort']['sort'] ? $_REQUEST['sort']['sort'] : 'asc');
		/* json data for datatables */
		$dataList = $this->models->get_itemlist($sort_field, $sort_type, $_POST);
		
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		
		// set Header
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'No');
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'Name');
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, 'Type');
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, 'Email');
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, 'Status');
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, 'ID Type');
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, 'Owner ID');
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, 'Telephone No.');
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 1, 'Fax No.');
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 1, 'Contact Name');
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, 1, 'Contact Mobile');
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, 1, 'Postal Code');
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, 1, 'Blk/Hse No');
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, 1, 'Street');
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, 1, 'Unit');
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, 1, 'Building Name');
		
		
		// set Row
		$no = 1;
		$rowCount = 2;
		
		/* autosize */
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		foreach (range('C', 'K') as $columnID) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		
		/* loop data */
		foreach ($dataList as $element) {
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowCount, $element['ID']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowCount, $element['Name']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $rowCount, $element['SellerTypeID'] == 1 ? 'INDIVIDUAL' : 'COMPANY');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $rowCount, $element['Email']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $rowCount, $element['Status']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $rowCount, $element['IDType']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $rowCount, $element['IDNo']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $rowCount, $element['TelephoneNo']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $rowCount, $element['FaxNo']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $rowCount, $element['ContactName']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $rowCount, $element['ContactMobile']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $rowCount, $element['PostalCode']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $rowCount, $element['BlkHseNo']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $rowCount, $element['Street']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $rowCount, $element['Unit']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $rowCount, $element['BuildingName']);
			
			$rowCount++;
			$no++;
		}
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter->save($pathName . $fileName);
		
		// download file
		// Redirect output to a client’s web browser (Xlsx)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $fileName);
		header('Cache-Control: max-age=0');
		
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: cache, must-revalidate');
		header('Pragma: public');
		readfile($pathName . $fileName);
		unlink($pathName . $fileName);
	}
	
	
}
