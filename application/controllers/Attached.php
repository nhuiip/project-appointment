<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Attached extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model("attached_model", "attached");
	}

	public function create()
	{
		if ($this->tokens->verify('formcrf')) {
			$data = array(
				'att_name' 			=> $this->input->post('att_name'),
				'att_filename' 		=> $this->upfileimages('att_filename'),
				'sub_id' 		    => $this->input->post('sub_id'),
				'att_create_name' 	=> $this->encryption->decrypt($this->input->cookie('sysn')),
				'att_create_date' 	=> date('Y-m-d H:i:s'),
			);
			$this->attached->insertData($data);
			
			$result = array(
				'error' => false,
				'msg' => 'เพิ่มข้อมูลสำเร็จ',
				'url' => site_url('profile/index/' . $this->input->post('use_id'))
			);
			echo json_encode($result);
		}
	}

	private function upfileimages($fild_Name)
	{
		if (!empty($_FILES[$fild_Name])) {
			$new_name = time();
			$config['upload_path'] = './uploads/attached';
			$config['allowed_types'] = 'pdf|docx|doc|xlsx|xls|pptx|ptt|jpg|jpeg|png|gif';
			$config['file_name'] = $new_name;
			$config['max_size']	= 6500;
			$this->load->library('upload', $config, 'upbanner');
			$this->upbanner->initialize($config);
			if (!$this->upbanner->do_upload($fild_Name)) {
				$result = array(
					'error' => true,
					'title' => "Error",
					'msg' => $this->upbanner->display_errors()
				);
				echo json_encode($result);
				die;
			}
			$img = $this->upbanner->data();
			return $img['file_name'];
		}
	}


	
	public function delete($id)
	{
		$condition = array();
        $condition['fide'] = "att_filename";
        $condition['where'] = array('att_id' => $id);
		$listdata = $this->attached->listData($condition);
	
		@unlink('./uploads/attached/' .$listdata[0]['att_filename']);
		
		$data = array(
			'att_id'            => $id,
		);
		$this->attached->deleteData($data);
        // @unlink('./uploads/fileproject/Project_' . $project_id . '/' . $file_name);		
		
		header("location:" . site_url('profile/index/' . $this->encryption->decrypt($this->input->cookie('sysli'))));
	}

	public function phpinfo()
	{
		echo phpinfo();
	}
}
