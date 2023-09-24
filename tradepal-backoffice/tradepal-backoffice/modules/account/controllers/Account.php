<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends MY_Controller {

    var $page_title = "Change Password";
    var $model_name = 'account_model';
    var $output_data = array();

    public function __construct() {
        parent:: __construct();
        $this->load->library('user_agent');
        $this->load->model($this->model_name, 'account');
        $this->load->model('main_model', 'mainm');
        $this->load->model('resp_model', 'resp');
        $this->load->model('login/Login_model', 'login');
    }

    public function index() {
        $this->password();
    }

    public function password() {
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

        # get data
        # Get Information Form (models)
        # Load view
        $this->load->view('inc-header', $data);
        $this->load->view('password', $data);
        $this->load->view('inc-footer', $data);
    }

    public function submit() {
        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');
        $new_password2 = $this->input->post('new_password2');
        $mode = $this->input->post('mode');
    
        # Default method
        $resp['text'] = $this->resp->show('default', 0);

        # Add mode
        if ($mode == 'add'):

        endif;

        # Add mode
        if ($mode == 'edit'):
            if ($old_password == "" && $new_password == "" && $new_password2 == ""):
                $resp['code'] = 1;
                $resp['text'] = $this->resp->show('password', 3, 0);
            elseif ($new_password != $new_password2):
                $resp['code'] = 1;
                $resp['text'] = $this->resp->show('password', 1, 0);
            elseif ($this->login->checkpass($old_password)):
                # Make array db
                $passDB = array(
                    'password' => md5($new_password)
                );
                $this->db->where('user_id', $this->session->userdata('scu_id'));
                $this->db->update('admin_users', $passDB);

                $resp['code'] = 0;
                $resp['text'] = $this->resp->show('password', 1, 0);
            else:
                $resp['code'] = 1;
                $resp['text'] = $this->resp->show('password', 0, 0);
            endif;
        endif;

        echo json_encode($resp);
    }
}