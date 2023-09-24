<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_permission_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_itemlist($field = '', $order = 'desc') {
        $this->db->select('admin_permission.*, admin_group.group_name');
        $this->db->from('admin_permission');
        $this->db->join('admin_group', 'admin_permission.group_id = admin_group.group_id', 'left');
        $this->db->order_by($field, $order);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_itemtinfo($id = '') {
        if (!empty($id)) {
            $this->db->select('*');
            $this->db->from('admin_permission');
            $this->db->where('permission_id', $id);
            $this->db->limit(1);
            $query = $this->db->get();
            return $query->row_array();
        } else {
            return null;
        }
    }

    public function get_groupinfo($id = '') {
        if (!empty($id)) {
            $this->db->select('*');
            $this->db->from('admin_group');
            $this->db->where('group_id', $id);
            $this->db->limit(1);
            $query = $this->db->get();
            return $query->row_array();
        } else {
            return null;
        }
    }

    public function get_existgroup() {
        $this->db->select('group_id');
        $this->db->from('admin_permission');
        $query = $this->db->get();
        $result = $query->result_array();
        foreach($result as $row) {
            $arrayValue[] = $row['group_id'];
        }
        return array_values($arrayValue);
    }

    public function delete($id = '') {
        if ($id != ''):
            $this->db->delete('admin_permission', array('permission_id' => $id));
            return true;
        else:
            return false;
        endif;
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

    public function get_system() {
        $this->db->select('*');
        $this->db->from('admin_system');
        $this->db->where('sm_active', 1);
        $this->db->order_by('sm_seq');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_system_master() {
        $this->db->select('*');
        $this->db->from('admin_system');
        $this->db->where('sm_parent_id', 0);
        $this->db->where('sm_active', 1);
        $this->db->order_by('sm_seq');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_system_salve($parent_id = '') {
        $this->db->select('*');
        $this->db->from('admin_system');
        $this->db->where('sm_parent_id', $parent_id);
        $this->db->where('sm_active', 1);
        $this->db->order_by('sm_seq');
        $query = $this->db->get();
        return $query->result_array();
    }

}
