<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//require_once(APPPATH . '/vendor/mike42/escpos-php/autoload.php');
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\CapabilityProfiles\DefaultCapabilityProfile;
use Mike42\Escpos\RTLBuffer;
class Escpos {

    public function __construct() {
        # Autoload
        require_once(APPPATH . '/vendor/mike42/escpos-php/autoload.php');
    }

}
