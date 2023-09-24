<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Menu_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    private $_lang = null;

    public function getPermissionbygroup()
    {
        /* first get user group permission */
        $this->db->trans_start();
        $this->db->select('permission_data');
        $this->db->from('admin_permission');
        $this->db->where('group_id', $this->session->userdata('scu_group_id'));
        $query = $this->db->get();
        $this->db->trans_complete();
        $result = $query->row();

        /* defined permission */
        $defined_permission = json_decode($result->permission_data, true);
        $view = explode(',', $defined_permission['view']);
        $add = explode(',', $defined_permission['add']);
        $edit = explode(',', $defined_permission['edit']);
        $delete = explode(',', $defined_permission['delete']);
        return [
            'view' => $view,
            'add' => $add,
            'edit' => $edit,
            'delete' => $delete,
        ];
    }

    public function gen($permission = '')
    {
        # Generate Menu
        $returnBack = array();
        $dbSystem = $this->get_systems();

        if (@count($dbSystem) > 0):
            foreach ($dbSystem as $key => $row):
                # get submenu
                $get_submenu = $this->get_systems_par($row['sm_id']);
                $permission = $this->getPermissionbygroup();
                $submenu = array();
                if (count($get_submenu) > 0):
                    foreach ($get_submenu as $skey => $srow):
                        if (in_array($srow['sm_id'], $permission['view'])) {
                            $submenu[$srow['sm_controller']] = array(
                                'icon_class' => $srow['sm_icon'],
                                'main_link' => array($srow['sm_name'], $srow['sm_controller']),
                                'subdomain' => array(),
                                'permission' => array('all'),
                            );
                        }
                    endforeach;
                endif;

                if (in_array($row['sm_id'], $permission['view'])) {
                    $returnBack[$row['sm_controller']] = array(
                        'icon_class' => $row['sm_icon'],
                        'main_link' => array($row['sm_name'], $row['sm_controller']),
                        'subdomain' => $submenu,
                        'permission' => array('all'),
                    );
                }
            endforeach;
        endif;

        $returnBack['logout'] = array(
            'icon_class' => 'm-menu__link-icon la la-power-off',
            'main_link' => array('Logout', 'logout'),
            'subdomain' => array(),
            'permission' => array('all'),
        );

        return $returnBack;
    }

    public function gen_full($permission = '')
    {
        # Generate Menu
        $returnBack = array();
        $dbSystem = $this->get_systems_nosub();

        if (@count($dbSystem) > 0):
            foreach ($dbSystem as $key => $row):
                # get submenu
                $get_submenu = $this->get_systems_par($row['sm_id']);
                $permission = $this->getPermissionbygroup();
                $submenu = array();
                if (count($get_submenu) > 0):
                    foreach ($get_submenu as $skey => $srow):
                        if (in_array($srow['sm_id'], $permission['view'])) {
                            $submenu[$srow['sm_controller']] = array(
                                'icon_class' => $srow['sm_icon'],
                                'main_link' => array($srow['sm_name'], $srow['sm_controller']),
                                'subdomain' => array(),
                                'permission' => array('all'),
                            );
                        }
                    endforeach;
                endif;

                if (in_array($row['sm_id'], $permission['view'])) {
                    /* fix head menu replace */
                    if ($row['sm_controller'] == 'javascript:;') {
                        $returnBack['menu_' . md5($row['sm_name'])] = array(
                            'icon_class' => $row['sm_icon'],
                            'main_link' => array($row['sm_name'], $row['sm_controller']),
                            'subdomain' => $submenu,
                            'permission' => array('all'),
                        );
                    } else {
                        $returnBack[$row['sm_controller']] = array(
                            'icon_class' => $row['sm_icon'],
                            'main_link' => array($row['sm_name'], $row['sm_controller']),
                            'subdomain' => $submenu,
                            'permission' => array('all'),
                        );
                    }
                }
            endforeach;
        endif;

        $returnBack['logout'] = array(
            'icon_class' => 'm-menu__link-icon la la-power-off',
            'main_link' => array('Logout', 'logout'),
            'subdomain' => array(),
            'permission' => array('all'),
        );
        return $returnBack;
    }

    public function get_systems()
    {
        $this->db->select('*');
        $this->db->from('admin_system');
        $this->db->where('sm_active = 1');
        $this->db->order_by('sm_seq', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_systems_nosub()
    {
        $this->db->select('*');
        $this->db->from('admin_system');
        $this->db->where('sm_active = 1');
        $this->db->where('sm_parent_id = 0');
        $this->db->order_by('sm_seq', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_systems_par($parent_id = '')
    {
        $this->db->select('*');
        $this->db->from('admin_system');
        $this->db->where('sm_active = 1');
        $this->db->where('sm_parent_id =' . $parent_id);
        $this->db->order_by('sm_seq', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_usertable($table = '', $order = '',$sort = 'asc') {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($order, $sort);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_usertable_notin($table = '', $notin = array(), $key = '') {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where_not_in($key, $notin);
        $this->db->order_by($order, $sort);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_usertable_byid($table = '', $key = '', $id = '', $order = '', $sort = 'asc') {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($key, $id);
        $this->db->order_by($order, $sort);
        $query = $this->db->get();
        return $query->result_array();
    }

}

/* End of file home_model.php */
/* Location: ./application/models/home_model.php */
