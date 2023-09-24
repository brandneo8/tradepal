<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cases extends MY_Controller {

    var $model_name = 'Cases_model';
    var $page_title = "Cases";
    var $page_view = "cases";
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
        $this->load->model('Api/Survey_model', 'survey_models');
       
    
        foreach ($this->raw_data as $key => $row) {
            $this->{$key} = $row;
        }

        # Check Access
        $this->mainm->check_can_permission($this->router->class, 'access');
    }

    public function loadContent() {
        /* set sort field */
        $sort_field = ($_REQUEST['sort']['field'] ? $_REQUEST['sort']['field'] : 'c.ID');
        $sort_type = ($_REQUEST['sort']['sort'] ? $_REQUEST['sort']['sort'] : 'desc');
        /* json data for datatables */
        
       
        $data = $this->models->get_itemlist($sort_field,$sort_type, $_REQUEST['query']);
        echo $this->mains->loadAjaxFilterData($data);
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

    public function dealer_read_case($case_id = '') {
        try {
            if($case_id) {
                $case = $this->case_models->dealer_read_case_all($case_id);
                $case->Seller = $this->seller_models->seller_get($case->SellerID);
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
            } else {
                $this->data->status = 1;
                $this->data->message = 'No case id found';
            }
        } catch (Exception $e) {
            $this->data->status = $e->getCode();
            $this->data->message = $e->getMessage();
        }

        $this->renderJson($this->data, $this->data->header);
    }

    public function insert_input_doc()
    {
        try {
            # SET Required field
            $this->required_field = array('CaseID','TradpalID');

            # Validate
            $validate_result = $this->mains->re_validate($this->required_field, $_POST);

            if($_POST['LoanDocument1']) {
                $validate_result_files['check_point'] = 0;
            } else {
                $validate_result_files = $this->mains->re_validate_files(['LoanDocument1'], $_FILES);
            }
            $error = 0;
            $errorMsg = '';

            # Checkpont and process
            if ($validate_result['check_point'] > 0):
                $this->data->message = $validate_result['message'];
            elseif ($validate_result_files['check_point'] > 0):
                $this->data->message = $validate_result_files['message'];
            else:
                # Check repeat
                for($i = 1; $i<=5;$i++) {
                    if($_FILES['LoanDocument' . $i]['tmp_name']) {
                        # Update new Account
                        $upload_data = $this->uploads('LoanDocument' . $i, '/uploads/loandoc', 5120000, '', '', false,
                            '*');
                        $upload_code = $upload_data['upload_code'];
    
                        if($upload_code == 0) {
                            # set upload data
                            $upload_data = $upload_data['upload_data'];
                            $_POST['LoanDocument' . $i] = $upload_data['file_name'];
                        } else {
                            $error++;
                            $errorMsg = strip_tags($upload_data['upload_data']);
                        }
                    }

                    # handle key
                    if($_POST['LoanDocument' . $i] == "" && $_POST['LoanDocument' . $i] == 'undefined') {
                        $_POST['LoanDocument' . $i] = null;
                        unset($_POST['LoanDocument' . $i]);
                    }
                }
                
                if($error > 0) {
                    $this->data->status = 1;
                    $this->data->message = $errorMsg;
                    $this->data->reason = $errorMsg;
                } else {

                    $saveData = $this->models->log($_POST);
                    
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
	
	
	public function insert_doc_agreement()
	{
		try {
			# SET Required field
			$this->required_field = array('CaseID','TradpalID');
			
			# Validate
			$validate_result = $this->mains->re_validate($this->required_field, $_POST);
			
			if($_POST['DocAgreement1']) {
				$validate_result_files['check_point'] = 0;
			} else {
				$validate_result_files = $this->mains->re_validate_files(['DocAgreement1'], $_FILES);
			}
			$error = 0;
			$errorMsg = '';
			
			# Checkpont and process
			if ($validate_result['check_point'] > 0):
				$this->data->message = $validate_result['message'];
			elseif ($validate_result_files['check_point'] > 0):
				$this->data->message = $validate_result_files['message'];
			else:
				# Check repeat
				for($i = 1; $i<=5;$i++) {
					if($_FILES['DocAgreement' . $i]['tmp_name']) {
						# Update new Account
						$upload_data = $this->uploads('DocAgreement' . $i, '/uploads/loandoc', 5120000, '', '', false,
							'*');
						$upload_code = $upload_data['upload_code'];
						
						if($upload_code == 0) {
							# set upload data
							$upload_data = $upload_data['upload_data'];
							$_POST['DocAgreement' . $i] = $upload_data['file_name'];
						} else {
							$error++;
							$errorMsg = strip_tags($upload_data['upload_data']);
						}
					}
					
					# handle key
					if($_POST['DocAgreement' . $i] == "" && $_POST['DocAgreement' . $i] == 'undefined') {
						$_POST['DocAgreement' . $i] = null;
						unset($_POST['DocAgreement' . $i]);
					}
				}
				
				if($error > 0) {
					$this->data->status = 1;
					$this->data->message = $errorMsg;
					$this->data->reason = $errorMsg;
				} else {
					
					$saveData = $this->models->log($_POST);
					
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
  
  public function amount_due() {
    
    $this->checkPermissionJson(1, $this->raw_data);
    # SET Required field
    $this->required_field = array('CaseID','TradpalID','StatusID', 'AmountDue');
    
    # Validate
    $validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
    
    # Checkpont and process
    if ($validate_result['check_point'] > 0):
      $this->data->message = $validate_result['message'];
    else:
      
      $get_case = $this->mains->sumdataRepeat('case', ['ID' => $this->CaseID]);
      
      if (!$get_case) {
        $this->data->status = 1;
        $this->data->message = 'The Case ID ' . $this->CaseID . ' not found.';
      } else {
        try {
          $saveData = $this->models->log($this->raw_data);
          
          if($saveData) {
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
    
    public function money_transferred() {
        
        $this->checkPermissionJson(1, $this->raw_data);
        # SET Required field
        $this->required_field = array('CaseID','TradpalID','StatusID', 'MoneyTransferredCarOwner');
        
        # Validate
        $validate_result = $this->mains->re_validate($this->required_field, $this->raw_data);
        
        # Checkpont and process
        if ($validate_result['check_point'] > 0):
            $this->data->message = $validate_result['message'];
        else:
            
            $get_case = $this->mains->sumdataRepeat('case', ['ID' => $this->CaseID]);
            
            if (!$get_case) {
                $this->data->status = 1;
                $this->data->message = 'The Case ID ' . $this->CaseID . ' not found.';
            } else {
                try {
                    $saveData = $this->models->log($this->raw_data);
                    
                    if($saveData) {
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

    public function update_casebl() {
        try {
            # SET Required field
            $this->required_field = array('CaseID','Balance');

            # Validate
            $validate_result = $this->mains->re_validate($this->required_field, $_POST);

            $error = 0;
            $errorMsg = '';

            # Checkpont and process
            if ($validate_result['check_point'] > 0):
                $this->data->message = $validate_result['message'];
            else:
                if($error > 0) {
                    $this->data->status = 1;
                    $this->data->message = 'save_fail';
                    $this->data->reason = $errorMsg;
                } else {

                    $get_caseinfo = $this->api_models->get_info('case', ['ID' => $_POST['CaseID']]);

                    if($get_caseinfo) {
                        $this->db->where('ID', $_POST['CaseID']);
                        $this->db->update('case', [
                        	'Bank' => $_POST['Bank'],
                        	'BalancePayableToSellerByTrader' => $_POST['Balance'],
                        	'OutstandingHirePurchaseBalance' => $_POST['Outstanding'],
                        	'FullSettlementofOutstandingCarLoan' => $_POST['FullSettlementofOutstandingCarLoan'],
                        	'OtherFees' => $_POST['OtherFees'],
												]);
    
                        $this->data->status = 0;
                        $this->data->message = 'Successfully save balance';
                        $this->data->data = $_POST;
                    } else {
                        $this->data->status = 1;
                        $this->data->message = 'Case not found';
                        $this->data->data = $_POST;
                    }
                }
            endif;

        } catch (Exception $e) {
            $this->data->status = $e->getCode();
            $this->data->message = $e->getMessage();
        }
        $this->renderJson($this->data, $this->data->header);
    }

    public function delete($id = 0) {
        $this->mainm->check_can_permission($this->router->class, 'delete');
        # Start delete
        $this->models->delete($id);
        redirect(base_url($this->router->class));
    }

    public function unblock($id = 0) {
        $this->mainm->check_can_permission($this->router->class, 'edit');
        # Start delete
        $this->models->unblock($id);
        redirect(base_url($this->router->class));
    }

    public function submit() {
        # Get Post data
        $CaseID = $this->input->post('CaseID');
        $DealerID = $this->input->post('DealerID');
        $SellerID = $this->input->post('SellerID');
        $TradpalID = $this->input->post('TradpalID');
        $StatusID = $this->input->post('StatusID');
        $HPDepositType = $this->input->post('HPDepositType');
        $HPChequeNo = $this->input->post('HPChequeNo');
        $HPAmount = $this->input->post('HPAmount');
        $HPBalanceDue = $this->input->post('HPBalanceDue');
        $HPDeliveredOn = $this->input->post('HPDeliveredOn');
        $BankAmount = $this->input->post('BankAmount');
        $AppointmentDate = $this->input->post('AppointmentDate');
        $AppointmentTime = $this->input->post('AppointmentTime');
        $AppointmentPlace = $this->input->post('AppointmentPlace');

        $mode = $this->input->post('mode');
        $edit_id = $this->input->post('edit_id');

        # Default method
        $resp['text'] = $this->resp->show('default', 0);

        # Add mode
        if ($mode == 'add'):
            $this->mainm->check_can_permission($this->router->class, 'add');
            if (
                    $CaseID == "" ||
                    $DealerID == "" ||
                    $SellerID == "" ||
                    $StatusID == ""
            ):
                $resp['code'] = 1;
                $resp['text'] = $this->resp->show('default', 2);
            else:

                $insert = [
                    'CaseID' => $CaseID,
                    'DealerID' => $DealerID,
                    'SellerID' => $SellerID,
                    'TradpalID' => $TradpalID,
                    'StatusID' => $StatusID,
                    'HPDepositType' => $HPDepositType,
                    'HPChequeNo' => $HPChequeNo,
                    'HPAmount' => $HPAmount,
                    'HPBalanceDue' => $HPBalanceDue,
                    'HPDeliveredOn' => $HPDeliveredOn,
                    'BankAmount' => $BankAmount,
                    'AppointmentDate' => $AppointmentDate,
                    'AppointmentTime' => $AppointmentTime,
                    'AppointmentPlace' => $AppointmentPlace,
                    'INS' => $this->get_now(),
                    'MOD' => $this->get_now(),
                ];
        
                # Check repeat
                for($i = 1; $i<=5;$i++) {
                    if($_FILES['LoanDocument' . $i]['tmp_name']) {
                        # Update new Account
                        $upload_data = $this->uploads('LoanDocument' . $i, '/uploads/loandoc', 5120000, '', '', false, 'pdf|jpg|png|gif');
                        $upload_code = $upload_data['upload_code'];
    
                        if($upload_code == 0) {
                            # set upload data
                            $upload_data = $upload_data['upload_data'];
                            $insert['LoanDocument' . $i] = $upload_data['file_name'];
                        } else {
                            $insert['LoanDocument' . $i] = null;
                        }
                    }
                }

                $this->db->insert('status_log', $insert);
                $id = $this->db->insert_id();
                
                $arraySet = [
                    'Status' => $data['StatusID'],
                    'MOD' => $this->get_now(),
                ];
        
                $this->db->where('id', $data['CaseID']);
                $this->db->update('case', $arraySet);

                $resp['code'] = 0;
                $resp['text'] = $this->resp->show('default', 3);
            endif;
        endif;

        # Add mode
        if ($mode == 'edit'):
            $this->mainm->check_can_permission($this->router->class, 'edit');
            if (
                $CaseID == "" ||
                $DealerID == "" ||
                $SellerID == "" ||
                $StatusID == ""
            ):
                $resp['code'] = 1;
                $resp['text'] = $this->resp->show('default', 2);
            else:
                # Make array db
                if($error) {
                    $resp['code'] = 1;
                    $resp['text'] = $this->resp->show('default', 2);
                } else {
                    $resp['code'] = 0;
                    $resp['text'] = $this->resp->show('default', 1);
                }

            endif;

        endif;

        echo json_encode($resp);
    }

}
