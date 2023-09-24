<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

    var $model_name = 'Users_model';
    var $page_title = "Users";
    var $page_view = "users";
    var $output_data = array();
    var $can_permission;

    public function __construct() {
        parent:: __construct();
        $this->load->library('user_agent');
        $this->load->model($this->model_name, 'models');
        $this->load->model('main_model', 'mainm');
        $this->load->model('resp_model', 'resp');

        # Check Access
        $this->mainm->check_can_permission($this->router->class, 'access');
    }

    public function loadContent() {
        /* set sort field */
        $sort_field = ($_REQUEST['sort']['field'] ? $_REQUEST['sort']['field'] : 'user_id');
        $sort_type = ($_REQUEST['sort']['sort'] ? $_REQUEST['sort']['sort'] : 'desc');
        /* json data for datatables */
        $data = $this->models->get_itemlist($sort_field,$sort_type);
        echo $this->mains->loadAjaxData($data);
    }

    public function index() {
        $data = array();
        # Genarating CSS/JS
        $css = $this->mainm->gencss();
        $js = $this->mainm->genjs();
        $js['fetchData'] = js('fetch/users.js');
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
        $this->mainm->check_can_permission($this->router->class, 'edit');
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
            $this->load->view($this->page_view . '/edit', $data);
            $this->load->view('inc-footer', $data);
        endif;
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
        $full_name = $this->input->post('full_name');
        $user_name = $this->input->post('user_name');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $password_confirmation = $this->input->post('password_confirmation');
        $group_id = $this->input->post('group_id');

        $mode = $this->input->post('mode');
        $edit_id = $this->input->post('edit_id');

        # Default method
        $resp['text'] = $this->resp->show('default', 0);

        # Add mode
        if ($mode == 'add'):
            $this->mainm->check_can_permission($this->router->class, 'add');
            if (
                    $full_name == "" ||
                    $user_name == "" ||
                    $email == "" ||
                    $password == ""
            ):
                $resp['code'] = 1;
                $resp['text'] = $this->resp->show('default', 2);
            elseif ($this->mains->sumdataRepeat('admin_users', array('user_name' => $user_name))):
                $resp['code'] = 1;
                $resp['text'] = $this->resp->show('default', 4);
            elseif ($password != $password_confirmation):
                $resp['code'] = 1;
                $resp['text'] = $this->resp->show('password', 1);
            else:
                # Make array db
                $insDB = array(
                    'full_name' => $full_name,
                    'user_name' => $user_name,
                    'password' => md5($password),
                    'email' => $email,
                    'group_id' => $group_id,
                    'active' => 1
                );

                $this->db->insert('admin_users', $insDB);
                $insert_id = $this->db->insert_id();

                $resp['code'] = 0;
                $resp['text'] = $this->resp->show('default', 3);
            endif;
        endif;

        # Add mode
        if ($mode == 'edit'):
            $this->mainm->check_can_permission($this->router->class, 'edit');
            if (
                    $full_name == "" ||
                    $email == ""
            ):
                $resp['code'] = 1;
                $resp['text'] = $this->resp->show('default', 2);
            else:
                # Make array db
                $insDB = array(
                    'full_name' => $full_name,
                    'email' => $email,
                    'group_id' => $group_id,
                    'active' => 1
                );

                if($password) {
                    if($password != $password_confirmation) {
                        $resp['code'] = 1;
                        $resp['text'] = $this->resp->show('password', 1);
                        $error++;
                    } else {
                        $error = 0;
                        $insDB['password'] = md5($password);
                    }
                }

                $this->db->where('user_id', $edit_id);
                $this->db->update('admin_users', $insDB);

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

    public function ajax_get_user_by_id(){
        # Get Post data
        $user_id = $this->input->post('user_id');
        $user = $this->models->get_itemtinfo($user_id);

        $resp = $user;
        echo json_encode($resp);
    }

}
