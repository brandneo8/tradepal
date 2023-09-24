<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Other_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function create_branch($data = [])
    {
        if($data) {
            $this->db->insert('branch', [
                'DealerID' => $data['DealerID'],
                'BranchName' => $data['BranchName'],
                'BranchAddress' => $data['BranchAddress'],
                'INS' => $this->get_now(),
                'MOD' => $this->get_now()
            ]);
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function save_branch($data = [], $id = '')
    {
        if($data && $id) {
            $this->db->where('ID', $id);
            $this->db->update('branch', [
                'BranchName' => $data['BranchName'],
                'BranchAddress' => $data['BranchAddress'],
                'MOD' => $this->get_now()
            ]);
            return true;
        } else {
            return false;
        }
    }

    public function delele_branch($id = '') {
        $this->db->where('ID', $id);
        $this->db->update('branch', ['Delete' => 1]);
    }
    
    
 

}