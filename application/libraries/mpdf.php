<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH."third_party/mpdf/mpdf.php"; 

class MY_mpdf extends mPDF { 
    public function __construct() 
	{ 
        parent::__construct(); 
    } 
}

/* End of file mpdf.php */
/* Location: ./application/libraries/mpdf.php */