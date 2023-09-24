<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Onesignal_model extends Api_model
{

    function __construct()
    {
        parent::__construct();
    }

    public function send_to_player_id($player_id, $message, $data)
    {
        $data = (object)$data;
        $content = array("en" => $message);
        
        $fields = array(
            'app_id' => "125bb255-4ec8-4c5d-b56a-b548a472c9b9",
            'include_player_ids' => [$player_id],
            'data' => [
                "case_id" => $data->ID,
            ],
            'contents' => $content
        );

        $fields = json_encode($fields);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
