<?php

use Carbon\Carbon;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Survey_model extends Api_model
{

    function __construct()
    {
        parent::__construct();
    }

    public function create($data = array())
    {
        $insert = [
            'SellerID' => $data['SellerID'],
            'DealerID' => $data['DealerID'],
            'CaseID' => $data['CaseID'],
            'QualityofService' => $data['QualityofService'],
            'ProvidingAccurateInformationA' => $data['ProvidingAccurateInformationA'],
            'ProvidingAccurateInformationB' => $data['ProvidingAccurateInformationB'],
            'ProvidingAccurateInformationC' => $data['ProvidingAccurateInformationC'],
            'ProvidingAccurateInformationD' => $data['ProvidingAccurateInformationD'],
            'ProvidingAccurateInformationE' => $data['ProvidingAccurateInformationE'],
            'Recommendation' => $data['Recommendation'],
            'TradePalServicesA' => $data['TradePalServicesA'],
            'TradePalServicesB' => $data['TradePalServicesB'],
            'INS' => $this->get_now(),
            'MOD' => $this->get_now(),
        ];

        $this->db->insert('car_owner_surveys', $insert);

        return $this->db->insert_id();
    }

    public function read($case_id)
    {
        $where = ['CaseID' => $case_id];
        return $this->db->get_where('car_owner_surveys', $where)->row();
    }
}
