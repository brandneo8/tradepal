<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_itemlist($field = '', $order = 'desc') {
        $this->db->select('admin_users.*,admin_group.group_name');
        $this->db->from('admin_users');
        $this->db->join('admin_group', 'admin_users.group_id = admin_group.group_id', 'left');
        $this->db->order_by($field, $order);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_itemtinfo($id = '') {
        if (!empty($id)) {
            $this->db->select('*');
            $this->db->from('admin_users');
            $this->db->where('user_id', $id);
            $this->db->limit(1);
            $query = $this->db->get();
            return $query->row_array();
        } else {
            return null;
        }
    }

    public function get_datatable($table = '', $order = '',$sort = 'asc') {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($order, $sort);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_datatablew($table = '', $where = '', $order = '',$sort = 'asc') {
        $this->db->select('*');
        $this->db->from($table);
        ($where) ? $this->db->where($where) : '';
        $this->db->order_by($order, $sort);
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

    public function get_usertable_byid($table = '', $key = '', $id = '', $order = '', $sort = 'asc') {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($key, $id);
        $this->db->order_by($order, $sort);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function delete($id = '') {
        if ($id != ''):
            $this->db->delete('admin_users', array('user_id' => $id));
            return true;
        else:
            return false;
        endif;
    }

    public function unblock($id = '') {
        if ($id != ''):
            $this->db->where('user_id', $id);
            $this->db->update('admin_users', array('block' => 0, 'fail_attemp' => 0));

            # delete all log
            // $userInfo = $this->get_itemtinfo($id);
            // $this->db->delete('login_attempts', array('login' => $userInfo['user_name']));
            return true;
        else:
            return false;
        endif;
    }

}
