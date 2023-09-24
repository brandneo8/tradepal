<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {

    var $page_title = "แดชบอร์ด";
    var $model_name = 'main_model';
    var $output_data = array();

    public function __construct() {
        parent:: __construct();
        $this->load->model($this->model_name, 'mainm');
        $this->mainm->check_can_permission($this->router->class, 'access');
    }

    public function index() {
        redirect('/cases');
        return;
      
      
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
        
        # get data
        # Get Information Form (models)
        # Load view
        $this->load->view('inc-header', $data);
        $this->load->view('main', $data);
        $this->load->view('inc-footer', $data);
    }

    public function genseourl() {
        $vals = $this->input->post('vals');
        $retsn = $this->mainm->genUrl($vals);
        echo json_encode(array('data' => $retsn));
    }

    public function setactive() {
        $sa_url = $this->input->post('sa_url');
        $sa_id_field = $this->input->post('sa_id_field');
        $sa_id = $this->input->post('sa_id');
        $sa_table = $this->input->post('sa_table');
        $sa_field_active = $this->input->post('sa_field_active');
        $sa_value = $this->input->post('sa_value');

        $this->mainm->setActive($sa_table, $sa_field_active, $sa_id_field, $sa_id, $sa_value);
        echo json_encode(array('code' => 0));
    }

    public function setapprove() {
        $sa_url = $this->input->post('sa_url');
        $sa_id_field = $this->input->post('sa_id_field');
        $sa_id = $this->input->post('sa_id');
        $sa_table = $this->input->post('sa_table');
        $sa_field_active = $this->input->post('sa_field_active');
        $sa_value = $this->input->post('sa_value');

        $this->mainm->setActive($sa_table, $sa_field_active, $sa_id_field, $sa_id, $sa_value);
        echo json_encode(array('code' => 0));
    }

    public function setseq() {
        $getDirect = $this->input->post('getDirect');
        $getTable = $this->input->post('getTable');
        $getField = $this->input->post('getField');
        $getFieldID = $this->input->post('getFieldID');
        $getID = $this->input->post('getID');
        $getOption = @json_decode($this->input->post('getOption'), true);
        $return = $this->mainm->setSeq($getTable, $getField, $getDirect, $getFieldID, $getID, $getOption);
        if ($return):
            echo json_encode(array('code' => 0));
        else:
            echo json_encode(array('code' => 1));
        endif;
    }

    public function ajaxdel() {
        $getTable = $this->input->post('table');
        $getField = $this->input->post('field');
        $getID = $this->input->post('id');

        $return = $this->mainm->ajaxdelete($getTable, $getField, $getID);
        if ($return):
            echo json_encode(array('code' => 0));
        else:
            echo json_encode(array('code' => 1));
        endif;
    }

    public function setupdatefield() {
        $table = $this->input->post('table');
        $field = explode(',',$this->input->post('field'));
        $idfield = $this->input->post('idfield');
        $id = $this->input->post('id');
        $value = $this->input->post('value');
        $return = $this->mainm->update_by_field($table, $field, $idfield, $id, $value);

        if ($return):
            echo json_encode(array('code' => 0));
        else:
            echo json_encode(array('code' => 1));
        endif;
    }

    public function language_changer($lang) {
        $this->session->set_userdata('lang', $lang);
        if ($this->agent->is_referral()) {
            redirect($this->agent->referrer());
        } else {
            redirect('/index.php');
        }
    }

    public function check_repeater() {

        $tables = $this->input->post('tables');
        $data = $this->input->post('data');

        $this->db->select('*');
        $this->db->from($tables);
        foreach ($data as $key => $row):
            $this->db->where("`{$row[0]}` {$row[1]} '{$row[2]}'");
        endforeach;
        $query = $this->db->get();
        $total_rows = $query->num_rows();
        if ($total_rows > 0) {
            echo json_encode(array('code' => 1, 'html' => 'This value is already used by another users.'));
        } else {
            echo json_encode(array('code' => 0, 'html' => 'You can use this value.'));
        }
    }

    public function test_esspace() {
        $this->load->model('Esspace_model', 'esp');
        $this->esp->get_empoyee();
        // echo number_format($this->esp->get_sumsaraly(), 2, '.','');
        // $this->esp->get_periodpay();
    }

    public function upload_tum() {
        $files = $_FILES;
        $folder = '../uploads/editors/';
        if($files['fileToUpload']['name']) {
            # create folder if not exits
            if(FALSE !== $this->mains->folder_exist($folder))
            {
                mkdir($folder, 0777);
            }
            $upload_data = $this->uploads('fileToUpload', $folder, 102400, '', '', false);
            if($upload_data['upload_code'] == 1) {
                $resp['success'] = false;
                $resp['url'] = $upload_data['upload_data'];
            } else {
                $resp['success'] = true;
                $resp['url'] = base_url($folder . $upload_data['upload_data']['file_name']);
            }
        } else {
            $resp['success'] = false;
            $resp['url'] = '';
        }
        echo json_encode($resp);
    }
    
}
