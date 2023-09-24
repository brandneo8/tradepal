<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sch_access {

    public function initialize() {
        # Get Current CI Instance
        $CI = & get_instance();
        $CI->load->library('session');
        # Use $CI instead of $this
        # Check for session details here, here's an example
        $is_logged_in = $CI->session->userdata('scu_logged');
        $allowIncome = $CI->config->item('bof_accept_permission');

        # Get current controller to avoid infinite loop
        $controller = $CI->router->class;
        
        # Check if user session exists and you are not already on the login page
        if ((!$is_logged_in) && ($controller != "login") && (in_array($controller, $allowIncome) == false)) {
            redirect(base_url('login'), 'location');
        } else {
            # nothings
        }
    }

    public function checkPermission() {
        # Check Permission Access
        $CI = & get_instance();
        $CI->load->library('session');
        $CI->load->model('menu_model');

        # Set Var
        $getMenu = $CI->menu_model->gen();
        $getController = $CI->router->class;
        $getPermission = $CI->session->userdata('scu_pms_fk');
        $allowIncome = $CI->config->item('bof_accept_permission');
        if (!isset($getMenu[$getController])):
            $getMenu[$getController] = array('permission' => array('none'));
        endif;

        # if no permission
        if ((is_array($getMenu[$getController]['permission']) && in_array($getPermission, $getMenu[$getController]['permission'])) || in_array($getPermission, explode(',', $getMenu[$getController]['permission'][0])) || in_array($getController, $allowIncome)):
            return true;
        else:
            redirect(base_url('errors/permission'), 'location');
        endif;
    }

}