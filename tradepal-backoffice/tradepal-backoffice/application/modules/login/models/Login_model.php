<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_model extends MY_Model {

    private $_lang = NULL;
    private $api_point;

    public function __construct() {
        parent::__construct();
    }

    public function auth($user = '', $pass = '') {
        if ($user != "" && $pass != ""):
            # first check user
            $query_check = $this->db->select('*')
                    ->from('admin_users')
                    ->where('user_name', $user)
                    ->limit(1)
                    ->get();
            if ($query_check->num_rows() <= 0):
                # return false
                return array('code' => 1);
            else:

                # first check block user
                $query_block = $this->db->select('*')
                ->from('admin_users')
                ->where('user_name', $user)
                ->where('block', 1)
                ->limit(1)
                ->get();
                if ($query_block->num_rows() > 0):
                    # return True
                    return array('code' => 4);
                else:

                    $query = $this->db->select('*')
                    ->from('admin_users')
                    ->where('user_name', $user)
                    ->where('password', md5($pass))
                    ->where('active', 1)
                    ->limit(1)
                    ->get();
                    if ($query->num_rows() > 0):
                        # Get Row
                        $info = $query->row();

                        # update last login
                        $this->uplastlogin($user);

                        # check lock user
                        if($info->block == 1) {
                            # return True
                            return array('code' => 4);
                        } else {
                            # Set Session
                            $schData = array(
                                'scu_id' => $info->user_id,
                                'scu_username' => $info->user_name,
                                'scu_firstname' => $info->full_name,
                                'scu_email' => $info->email,
                                'scu_group_id' => $info->group_id,
                                'scu_logged' => TRUE
                            );
                            $this->session->set_userdata($schData);
                            $this->checkLoginAttemp([
                                'ip_address' => $this->input->ip_address(),
                                'login' => $user,
                                'time' => time(),
                                'login_status' => 'true'
                            ]);
                            # return True
                            return array('code' => 0);
                        }
                    else:
                        # insert attemp
                        $this->checkLoginAttemp([
                            'ip_address' => $this->input->ip_address(),
                            'login' => $user,
                            'time' => time(),
                            'login_status' => 'false'
                        ]);
                        # return false
                        return array('code' => 1);
                    endif;

                endif;

            endif;
        else:
            # return require Information
            return array('code' => 2);
        endif;
    }

    public function checkpass($password = '') {
        $query = $this->db->select('user_name,password')
                ->from('admin_users')
                ->where('user_name', $this->session->userdata('scu_username'))
                ->where('password', md5($password))
                ->limit(1)
                ->get();
        if ($query->num_rows() > 0):
            return true;
        else:
            return false;
        endif;
    }

    public function insert_attemp($attemps = array()) {
        if(is_array($attemps) && $attemps) {
            $this->db->trans_start();
            $this->db->insert('login_attempts', $attemps);
            $this->db->trans_complete();

            /* update attemp */
            $this->db->trans_start();
            $this->db->set('fail_attemp', 'fail_attemp+1', FALSE);
            $this->db->where('user_name', $attemps['login']);
            $this->db->update('admin_users');
            $this->db->trans_complete();
            return true;
        } else {
            return false;
        }
    }

    public function block_attemp($attemps = array()) {
        if(is_array($attemps) && $attemps) {
            $this->db->where('user_name', $attemps['login']);
            $this->db->update('admin_users', ['block' => 1]);
            return true;
        } else {
            return false;
        }
    }

    public function uplastlogin($login = '') {
        if($login) {
            $this->db->where('user_name', $login);
            $this->db->update('admin_users', ['last_login' => time()]);
            return true;
        } else {
            return false;
        }
    }

    public function logout() {
        # logout
        $this->session->unset_userdata($schData);
        $this->session->sess_destroy();
        $schData = $this->session->all_userdata();
        $schData['scu_pms_fk'] = null;
        $schData['scu_logged'] = FALSE;
    }

    public function checkLoginAttemp($data = '') {
        $this->db->select('fail_attemp');
        $this->db->from('admin_users');
        $this->db->where('user_name', $data['login']);
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            $point = 0;
            $login_limit = 4;
            $attemp = $query->row_array();

            if($attemp['fail_attemp'] >= $login_limit) {
                $this->insert_attemp($data);
                if($data['login'] != 'admin') {
                    $this->block_attemp($data);
                }
                return false;
            } else {
                $this->insert_attemp($data);
                return true;
            }
        } else {
            $this->insert_attemp($data);
            return true;
        }
    }


}
