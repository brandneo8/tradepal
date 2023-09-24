<?php defined('BASEPATH') OR exit('No direct script access allowed');

// reference the Dompdf namespace
use Dompdf\Dompdf;

class DomPDFCustom
{
    public function __construct(){
        
        // include autoloader
        require_once dirname(__FILE__).'/dompdf/autoload.inc.php';
        
        // instantiate and use the dompdf class
        $pdf = new Dompdf();
        
        $CI =& get_instance();
        $CI->DomPDFCustom = $pdf;
        
    }
}