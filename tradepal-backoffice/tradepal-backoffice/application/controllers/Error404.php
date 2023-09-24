<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Error404 extends MY_Controller {

    var $page_title = "ไม่พบหน้าดังกล่าว";

    function __construct() {
        parent::__construct();
        $this->load->library('user_agent');
        $this->lang->load('global', $this->session->userdata('lang'));  # load lang
        $this->load->model('main_model', 'mainm');
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

        # get data
        # Get Information Form (models)
        # Load view
        $this->load->view('inc-header', $data);
        $this->load->view('error404', $data);
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */