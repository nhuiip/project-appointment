<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model("page_model","page");
		$this->load->helper('fileexist');
	}

	public function register(){
        $data['formReg'] = $this->tokens->token('formReg');
        // $this->template->backend('page/register');
        $this->load->view('page/register', $data);
    }
}