<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');



class M_pdf  {
 
 
	function __construct() {
        
        require_once dirname(__FILE__) . '/mpdf-6.0.0/mpdf.php';
        
        $pdf = new mPDF('UTF-8', 'A4', 9 , 'helvetica');
        
        $CI =& get_instance();
        $CI->mpdf = $pdf;
	}
	
	
}
