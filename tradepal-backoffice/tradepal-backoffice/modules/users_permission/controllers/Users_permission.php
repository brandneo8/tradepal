<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users_permission extends MY_Controller {

    var $model_name = 'Users_permission_model';
    var $page_title = "User Permission";
    var $page_view = "users_permission";
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
        $sort_field = ($_REQUEST['sort']['field'] ? $_REQUEST['sort']['field'] : 'permission_id');
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
        $js['fetchData'] = js('fetch/users_permission.js');
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

    public function submit() {
        # Get Post data
        $view_per = implode(',', $this->input->post('view_per'));
        $add_per = implode(',', $this->input->post('add_per'));
        $edit_per = implode(',', $this->input->post('edit_per'));
        $del_per = implode(',', $this->input->post('del_per'));
        $group_id = $this->input->post('group_id');

        $mode = $this->input->post('mode');
        $edit_id = $this->input->post('edit_id');

        $arraySet = array(
            'view' => $view_per,
            'add' => $add_per,
            'edit' => $edit_per,
            'delete' => $del_per
        );

        # Default method
        $resp['text'] = $this->resp->show('default', 0);

        # Add mode
        if ($mode == 'add'):
            $this->mainm->check_can_permission($this->router->class, 'add');
            if (
                $group_id == ""
            ):
                $resp['code'] = 1;
                $resp['text'] = $this->resp->show('default', 2);
            elseif ($this->mains->sumdataRepeat('admin_permission', array('group_id' => $group_id))):
                $resp['code'] = 1;
                $resp['text'] = $this->resp->show('default', 4);
            else:
                # Make array db
                $insDB = array(
                    'group_id' => $group_id,
                    'permission_data' => json_encode($arraySet),
                );

                $this->db->insert('admin_permission', $insDB);
                $insert_id = $this->db->insert_id();

                $resp['code'] = 0;
                $resp['text'] = $this->resp->show('default', 3);
            endif;
        endif;

        # Add mode
        if ($mode == 'edit'):
            $this->mainm->check_can_permission($this->router->class, 'edit');
            # Make array db
            $insDB = array(
                'permission_data' => json_encode($arraySet),
            );

            $this->db->where('permission_id', $edit_id);
            $this->db->update('admin_permission', $insDB);

            if($error) {
                $resp['code'] = 1;
                $resp['text'] = $this->resp->show('default', 2);
            } else {
                $resp['code'] = 0;
                $resp['text'] = $this->resp->show('default', 1);
            }

        endif;

        echo json_encode($resp);
    }
}
