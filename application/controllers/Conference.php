<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Conference extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("conference_model", "conference");
    }

    // conference
    public function insertData()
    {
        $data = array(
            'project_id'        => $this->input->post('project_id'),
            'conftype_id'       => $this->input->post('conftype_id'),
            'conf_year'         => '',
            'conf_title'        => '',
            'conf_subtitle'     => '',
            'conf_number'       => '',
            'conf_datepresent'  => '',
            'conf_nopage'       => '',
            'conf_weight'       => '',
            'conf_data'         => '',
            'conf_place'        => '',
            'conf_publisher'    => '',
        );
        $this->conference->insertData($data);
        $result = array(
            'error' => false,
            'msg' => 'เพิ่มข้อมูลสำเร็จ',
            'url' => site_url('project/detail/' . $this->input->post('project_id'))
        );
        echo json_encode($result);
    }

    public function updateData()
    {
        if ($this->input->post('conf_year') != '') {
            $conf_year = $this->input->post('conf_year');
        } else {
            $conf_year = '';
        }
        if ($this->input->post('conf_title') != '') {
            $conf_title = $this->input->post('conf_title');
        } else {
            $conf_title = '';
        }
        if ($this->input->post('conf_subtitle') != '') {
            $conf_subtitle = $this->input->post('conf_subtitle');
        } else {
            $conf_subtitle = '';
        }
        if ($this->input->post('conf_number') != '') {
            $conf_number = $this->input->post('conf_number');
        } else {
            $conf_number = '';
        }
        if ($this->input->post('conf_datepresent') != '') {
            $conf_datepresent = $this->input->post('conf_datepresent');
        } else {
            $conf_datepresent = '';
        }
        if ($this->input->post('conf_nopage') != '') {
            $conf_nopage = $this->input->post('conf_nopage');
        } else {
            $conf_nopage = '';
        }
        if ($this->input->post('conf_weight') != '') {
            $conf_weight = $this->input->post('conf_weight');
        } else {
            $conf_weight = '';
        }
        if ($this->input->post('conf_data') != '') {
            $conf_data = $this->input->post('conf_data');
        } else {
            $conf_data = '';
        }
        if ($this->input->post('conf_place') != '') {
            $conf_place = $this->input->post('conf_place');
        } else {
            $conf_place = '';
        }
        if ($this->input->post('conf_publisher') != '') {
            $conf_publisher = $this->input->post('conf_publisher');
        } else {
            $conf_publisher = '';
        }

        $data = array(
            'conf_id'           => $this->input->post('conf_id'),
            'conf_year'         => $conf_year,
            'conf_title'        => $conf_title,
            'conf_subtitle'     => $conf_subtitle,
            'conf_number'       => $conf_number,
            'conf_datepresent'  => $conf_datepresent,
            'conf_nopage'       => $conf_nopage,
            'conf_weight'       => $conf_weight,
            'conf_data'         => $conf_data,
            'conf_place'        => $conf_place,
            'conf_publisher'    => $conf_publisher,
        );
        $this->conference->updateData($data);
        $result = array(
            'error' => false,
            'msg' => 'แก้ไขข้อมูลสำเร็จ',
            'url' => site_url('project/detail/' . $this->input->post('project_id'))
        );
        echo json_encode($result);
    }
    public function updateType()
    {
        $data = array(
            'conf_id'           => $this->input->post('conf_id'),
            'conftype_id'       => $this->input->post('conftype_id'),
        );
        $this->conference->updateData($data);
        $result = array(
            'error' => false,
            'msg' => 'แก้ไขข้อมูลสำเร็จ',
            'url' => site_url('project/detail/' . $this->input->post('project_id'))
        );
        echo json_encode($result);
    }

    public function deleteData($project_id)
    {
        $condition = array();
        $condition['fide'] = "conf_id";
        $condition['where'] = array('project_id' => $project_id);
        $listdata = $this->conference->listData($condition);
        
        $data = array(
            'conf_id'            => $listdata[0]['conf_id'],
        );
        $this->conference->deleteData($data);
        header("location:" . site_url('project/detail/'.$project_id));
    }

    // conference person
    public function insertPerson()
    {
        $data = array(
            'conf_id'           => $this->input->post('conf_id'),
            'confpos_name'      => $this->input->post('confpos_name'),
            'confpos_sort'      => $this->input->post('confpos_sort'),
        );
        $this->conference->insertPerson($data);
        $result = array(
            'error' => false,
            'msg' => 'เพิ่มข้อมูลสำเร็จ',
            'url' => site_url('project/detail/' . $this->input->post('project_id'))
        );
        echo json_encode($result);
    }

    public function updatePerson()
    {
        $data = array(
            'confpos_id'        => $this->input->post('confpos_id'),
            'confpos_name'      => $this->input->post('confpos_name'),
            'confpos_sort'      => $this->input->post('confpos_sort'),
        );
        $this->conference->updatePerson($data);
        $result = array(
            'error' => false,
            'msg' => 'แก้ไขข้อมูลสำเร็จ',
            'url' => site_url('project/detail/' . $this->input->post('project_id'))
        );
        echo json_encode($result);
    }

    public function deletePerson($project_id, $id = '')
    {
        $data = array(
            'confpos_id'            => $id,
        );
        $this->conference->deletePerson($data);
        header("location:" . site_url('project/detail/'.$project_id));
    }
}
