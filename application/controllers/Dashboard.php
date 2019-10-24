<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model("dashboard_model","dashboard");
		$this->load->helper('fileexist');
	}

	public function index(){
        $this->template->js(array(
			base_url('assets/js/lib/plugins/flot/jquery.flot'),
			base_url('assets/js/lib/plugins/flot/jquery.flot.pie'),
			base_url('assets/js/lib/plugins/sparkline/jquery.sparkline.min'),
		));
        $this->template->backend('dashboard/main');
    }
}