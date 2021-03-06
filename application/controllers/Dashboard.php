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
		$condition['fide'] = "meet_date, meet_time, tb_project.project_id, project_name, tb_meet.meet_id";
		$condition['where'] = array(
			'tb_settings.set_status' => 2,
			'meet_status' => 1,
			'tb_meetdetail.use_id' => $this->encryption->decrypt($this->input->cookie('sysli')),
			'tb_meetdetail.dmeet_status' => 1
		);
		$condition['orderby'] = "meet_date ASC, meet_time ASC ";
		$data['listmeet'] = $this->meet->listjoinData2($condition);

		$condition = array();
		$condition['fide'] = "tb_meet.meet_id";
		$condition['where'] = array('meet_status' => 1,);
		$data['listmeets'] = $this->meet->listjoinData2($condition);

		$condition = array();
		$condition['fide'] = "use_id, use_name";
		$condition['where_in']['filde'] = 'position_id';
		$condition['where_in']['value'] = ['2', '3'];
		$condition['orderby'] = "use_name ASC ";
		$data['listuser'] = $this->administrator->listData($condition);

		$condition = array();
		$condition['fide'] = "project_id";
		$data['listproject'] = $this->project->listData($condition);

		$this->template->js(array(
			base_url('assets/js/lib/plugins/flot/jquery.flot'),
			base_url('assets/js/lib/plugins/flot/jquery.flot.resize'),
			base_url('assets/js/lib/plugins/flot/jquery.flot.pie'),
			// base_url('assets/js/lib/plugins/chartJs/Chart.min'),
			// base_url('assets/js/lib/plugins/chartJs/Chart.HorizontalBar'),
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
		$onetext = 'เดี่ยว ( ' . $countone . '% )';
		$grouptext = 'กลุ่ม ( ' . $countgroup . '% )';

		$data = array();
		$data[0] = array('label' => $grouptext, 'data' => $countgroup, 'color' => '#27ae60');
		$data[1] = array('label' => $onetext, 'data' => $countone, 'color' => '#16a085');

		echo json_encode($data);
	}

	public function statusproject()
	{
		$condition = array();
		$condition['fide'] = "project_id";
		$condition['where'] = array('project_status' => 0);
		$zero = $this->project->listData($condition);

		$condition = array();
		$condition['fide'] = "project_id";
		$condition['where'] = array('project_status' => 1);
		$one = $this->project->listData($condition);

		$condition = array();
		$condition['fide'] = "project_id";
		$condition['where'] = array('project_status' => 2);
		$two = $this->project->listData($condition);

		$condition = array();
		$condition['fide'] = "project_id";
		$condition['where'] = array('project_status' => 3);
		$tree = $this->project->listData($condition);

		$condition = array();
		$condition['fide'] = "project_id";
		$condition['where'] = array('project_status' => 4);
		$four = $this->project->listData($condition);

		$condition = array();
		$condition['fide'] = "project_id";
		$condition['where'] = array('project_status' => 5);
		$five = $this->project->listData($condition);

		$condition = array();
		$condition['fide'] = "project_id";
		$condition['where'] = array('project_status' => 6);
		$six = $this->project->listData($condition);

		$condition = array();
		$condition['fide'] = "project_id";
		$condition['where'] = array('project_status' => 7);
		$seven = $this->project->listData($condition);

		$condition = array();
		$condition['fide'] = "project_id";
		$condition['where'] = array('project_status' => 8);
		$eight = $this->project->listData($condition);

		$data = array();
		$data[0] = array(
			'label' => 'ยกเลิกโปรเจค ('.count($zero).')',
			'backgroundColor' => '#aaa',
			'data' => [count($zero)],
		);
		$data[1] = array(
			'label' => 'เริ่มต้น ('.count($one).')',			
			'backgroundColor' => '#bbb',
			'data' => [count($one)],
		);
		$data[2] = array(
			'label' => 'สอบหัวข้อปริญญานิพนธ์:ผ่าน ('.count($two).')',			
			'backgroundColor' => '#ccc',
			'data' => [count($two)],
		);
		$data[3] = array(
			'label' => 'สอบหัวข้อปริญญานิพนธ์:ผ่านแบบมีเงื่อนไข ('.count($tree).')',			
			'backgroundColor' => '#ddd',
			'data' => [count($tree)],
		);
		$data[4] = array(
			'label' => 'สอบหัวข้อปริญญานิพนธ์:ตก ('.count($four).')',			
			'backgroundColor' => '#ddd',
			'data' => [count($four)],
		);
		$data[5] = array(
			'label' => 'Conference ('.count($five).')',			
			'backgroundColor' => '#ddd',
			'data' => [count($five)],
		);
		$data[6] = array(
			'label' => 'สอบป้องกันปริญญานิพนธ์:ผ่าน ('.count($six).')',			
			'backgroundColor' => '#eee',
			'data' => [count($six)],
		);
		$data[7] = array(
			'label' => 'สอบป้องกันปริญญานิพนธ์:ผ่านแบบมีเงื่อนไข ('.count($seven).')',			
			'backgroundColor' => '#eee',
			'data' => [count($seven)],
		);
		$data[8] = array(
			'label' => 'สอบป้องกันปริญญานิพนธ์:ตก ('.count($eight).')',			
			'backgroundColor' => '#eee',
			'data' => [count($eight)],
		);

		echo json_encode($data);
	}

	public function countmeet()
	{
		$data = array();

		$condition = array();
		$condition['fide'] = "use_id, use_name, use_color";
		$condition['where_in']['filde'] = 'position_id';
		$condition['where_in']['value'] = ['2', '3'];
		$condition['orderby'] = "use_name ASC ";
		$listuser = $this->administrator->listData($condition);
		if (count($listuser) != 0) {
			foreach ($listuser as $key => $value) {
				$this->db->select("*");
				$this->db->from('tb_meet');
				$this->db->join('tb_meetdetail', 'tb_meetdetail.meet_id = tb_meet.meet_id');
				$this->db->where('tb_meet.meet_status', 1);
				$this->db->where('tb_meetdetail.dmeet_status', 1);
				$this->db->where('tb_meetdetail.use_id', $value['use_id']);
				$query_c = $this->db->get();
				$listcount = $query_c->result_array();

				$data[$key] = array(
					'label' => $value['use_name'].' ('.count($listcount).')',
					'backgroundColor' => $value['use_color'],
					'data' => [count($listcount)],
				);
			}
		}
		echo json_encode($data);
	}
}
