<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model("dashboard_model","dashboard");
		$this->load->helper('fileexist');
	}

	public function index(){
        // echo 'login ss';
        // die;
        $this->template->backend('dashboard/main');
    }
}