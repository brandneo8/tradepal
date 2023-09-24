<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Resp_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    private $_lang = NULL;

    public function show($type = 'default', $id = 0, $lang = '') {
        # Make Array
        $info = array();
        # Unknow Respone (en,th);
        $info['default'][0] = array('Invalid input method', 'การเข้าถึง Class ไม่ถูกต้อง');
        $info['default'][1] = array('Information has been updated', 'ข้อมูลถูกอัพเดทเรียบร้อยแล้ว');
        $info['default'][2] = array('Please fill in the required * fields', 'กรุณากรอกข้อมูลในช่องที่มีเครื่องหมาย * ให้ครบถ้วน');
        $info['default'][3] = array('Information has been added successfull', 'ระบบได้ทำการเพิ่มข้อมูลเรียบร้อยแล้ว');
        $info['default'][4] = array('Some data has already in database', 'ข้อมูลบางส่วนนี้มีอยู่ในฐานข้อมูลอยู่แล้วกรุณาตรวจสอบ');

        # Section
        $info['login'][0] = array('Login successful', 'การเข้าสู่ระบบสำเร็จ');
        $info['login'][1] = array('Username and Password is incorrect', 'ชื่อผู้ใช้และรหัสผ่านไม่ถูกต้อง');
        $info['login'][2] = array('Username and Password required', 'ไม่พบชื่อผู้ใช้งานและรหัสผ่านกรุณาตรวจสอบ');
        $info['login'][3] = array('Your area not allow', 'พื้นที่ของคุณไม่อยู่ในเขตให้บริการโปรแกรม');
        $info['login'][4] = array('Username is locked', 'ผู้ใช้ถูกล็อค กรุณาติดต่อผู้ดูแลระบบ');

        # Password
        $info['password'][0] = array('Current password is incorrect', 'รหัสผ่านปัจจุบันไม่ถูกต้อง');
        $info['password'][1] = array('Password not match', 'รหัสผ่านและยืนยันรหัสผ่านไม่ถูกต้อง');
        $info['password'][2] = array('Pasword has been changed', 'ระบบได้ทำการเปลี่ยนรหัสเรียบร้อยแล้ว.');
        $info['password'][3] = array('Password field required', 'กรุณากรอกให้ครบถ่วน');
        $info['idcard'][0] = array('ID Card is invalid', 'หมายเลขบัตรประชาชนไม่ถูกต้อง');

        # Set language
        if (empty($lang)) {
            ($this->session->userdata('lang') == 'th') ? $langSet = 1 : $langSet = 0;
        } else {
            $langSet = $lang;
        }
        # Make Val
        $resp = $info[$type][$id];

        # Return Information
        return $resp[$langSet];
    }

}

/* End of file home_model.php */
/* Location: ./application/models/home_model.php */