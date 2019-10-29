<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("dashboard_model", "dashboard");
		$this->load->model("administrator_model", "administrator");
		$this->load->model("project_model", "project");
		$this->load->model("meet_model", "meet");
		$this->load->helper('fileexist');
	}

	public function index()
	{
		$data = array();

		$condition = array();
		$condition['fide'] = "meet_date, meet_time, project_name, tb_meet.meet_id";
		$condition['where'] = array(
			'tb_settings.set_status' => 2,
			'meet_status' => 1,
			'tb_meetdetail.use_id' => $this->encryption->decrypt($this->input->cookie('sysli')),
			'tb_meetdetail.dmeet_status' => 1
		);
		$condition['orderby'] = "meet_date ASC, meet_time ASC ";
		$data['listmeet'] = $this->meet->listjoinData2($condition);

		$condition = array();
		$condition['fide'] = "use_id, use_name";
		$condition['where_in']['filde'] = 'position_id';
		$condition['where_in']['value'] = ['2', '3'];
		$condition['orderby'] = "position_id ASC, use_id ASC ";
		$data['listuser'] = $this->administrator->listData($condition);

		$this->template->js(array(
			base_url('assets/js/lib/plugins/flot/jquery.flot'),
			base_url('assets/js/lib/plugins/flot/jquery.flot.resize'),
			base_url('assets/js/lib/plugins/flot/jquery.flot.pie'),
			base_url('assets/js/lib/plugins/chartJs/Chart.min'),
			base_url('assets/js/lib/plugins/chartJs/Chart.HorizontalBar'),
		));
		$this->template->backend('dashboard/main', $data);
	}
	public function typeproject()
	{

		$condition = array();
		$condition['fide'] = "project_id";
		$condition['where'] = array('project_status !=' => 0);
		$listproject = $this->project->listData($condition);
		$one = array();
		$group = array();
		foreach ($listproject as $key => $value) {
			$condition = array();
			$condition['fide'] = "tb_projectperson.project_id";
			$condition['where'] = array('tb_projectperson.project_id ' => $value['project_id']);
			$listpreson = $this->project->listperson($condition);

			if (count($listpreson) == 1) {
				array_push($one, 1);
			} else {
				array_push($group, 1);
			}
		}
		$total = count($one) + count($group);
		$countone = (count($one) / $total) * 100;
		$countgroup = (count($group) / $total) * 100;
		$onetext = 'เดี่ยว ( '.$countone.'% )';
		$grouptext = 'กลุ่ม ( '.$countgroup.'% )';

		$data = array();
		$data[0] = array('label' => $grouptext, 'data' => $countgroup, 'color' => '#27ae60');
		$data[1] = array('label' => $onetext, 'data' => $countone, 'color' => '#16a085');

		echo json_encode($data);
	}

	public function statusproject()
	{
		$condition = array();
		$condition['fide'] = "project_id";
		$condition['where'] = array('project_status' => 1);
		$zero = $this->project->listData($condition);

		$condition = array();
		$condition['fide'] = "project_id";
		$condition['where'] = array('project_status' => 2);
		$one = $this->project->listData($condition);

		$condition = array();
		$condition['fide'] = "project_id";
		$condition['where'] = array('project_status' => 3);
		$two = $this->project->listData($condition);

		$condition = array();
		$condition['fide'] = "project_id";
		$condition['where'] = array('project_status' => 4);
		$tree = $this->project->listData($condition);

		$condition = array();
		$condition['fide'] = "project_id";
		$condition['where'] = array('project_status' => 5);
		$four = $this->project->listData($condition);

		$condition = array();
		$condition['fide'] = "project_id";
		$condition['where'] = array('project_status' => 0);
		$five = $this->project->listData($condition);

		$data = array();
		$data[0] = array(1, count($zero));
		$data[1] = array(2, count($one));
		$data[2] = array(3, count($two));
		$data[3] = array(4, count($tree));
		$data[4] = array(5, count($four));
		$data[5] = array(6, count($five));

		echo json_encode($data);
	}
}
