<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class SGAddress_model extends Api_model
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_address_by_postal_code($postal_code)
    {
        $select_field = $this->get_allfield('sg_addresses', []);
        $result = $this->db->select($select_field)
            ->from('sg_addresses')
            ->where('PostalCode', $postal_code)
            ->get();
        $row = $result->row_array();

        if (empty($row)) throw new Exception("Address not found", 404);
        return $row;
    }
}
