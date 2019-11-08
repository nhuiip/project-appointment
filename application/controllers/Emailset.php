<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Emailset extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("emailset_model", "emailset");
    }

    public function index()
    {
        $permission = array("ผู้ดูแลระบบ");
        if (in_array($this->encryption->decrypt($this->input->cookie('sysp')), $permission)) {
            $data = array();
            $condition = array();
            $condition['fide'] = "*";
            $condition['orderby'] = "email_status DESC ";
            $data['listdata'] = $this->emailset->listData($condition);

            $data['formcrf'] = $this->tokens->token('formcrf');
            $this->template->backend('administrator/setmail', $data);
        } else {
            $this->load->view('errors/html/error_403');
        }
    }
    public function checkemail()
    {
        $email_user = $this->input->post('email_user');
        if (!empty($email_user)) {
            $condition = array();
            $condition['fide'] = "email_id";
            $condition['where'] = array('email_user' => $email_user);
            $listemail = $this->emailset->listData($condition);
            if (count($listemail) == 0) {
                echo "true";
            } else {
                echo "false";
            }
        }
    }
    public function create()
    {
        if ($this->tokens->verify('formcrf')) {
            $data = array(
                'email_user'            => $this->input->post('email_user'),
                'email_password'        => $this->input->post('email_password'),
                'email_status'          => 0,
                'email_create_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                'email_create_date'     => date('Y-m-d H:i:s'),
                'email_lastedit_name'   => $this->encryption->decrypt($this->input->cookie('sysn')),
                'email_lastedit_date'   => date('Y-m-d H:i:s'),
            );
            $this->emailset->insertData($data);
            $result = array(
                'error' => false,
                'msg' => 'เพิ่มข้อมูลสำเร็จ',
                'url' => site_url('emailset/index')
            );
            echo json_encode($result);
        }
    }

    public function update()
    {
        if ($this->tokens->verify('formcrf')) {
            $data = array(
                'email_id'              => $this->input->post('email_id'),
                'email_user'            => $this->input->post('email_user'),
                'email_password'        => $this->input->post('email_password'),
                'email_lastedit_name'   => $this->encryption->decrypt($this->input->cookie('sysn')),
                'email_lastedit_date'   => date('Y-m-d H:i:s'),
            );
            $this->emailset->updateData($data);
            $result = array(
                'error' => false,
                'msg' => 'แก้ไขข้อมูลสำเร็จ',
                'url' => site_url('emailset/index')
            );
            echo json_encode($result);
        }
    }

    public function delete($id = '')
    {
        $data = array(
            'email_id'            => $id,
        );
        $this->emailset->deleteData($data);
        header("location:" . site_url('emailset/index'));
    }

    public function setmail($id = '')
    {
        $data = array(
            'email_id'            => $id,
        );
        $this->emailset->setData($data);
        header("location:" . site_url('emailset/index'));
    }

    public function testmail()
    {
        $condition = array();
        $condition['fide'] = "email_user, email_password";
        $condition['where'] = array('email_id' => $this->input->post('email_id'));
        $listemail = $this->emailset->listData($condition);

        if (count($listemail) != 0) {
            require_once APPPATH . 'third_party/class.phpmailer.php';
            require_once APPPATH . 'third_party/class.smtp.php';
            $mail = /*edit*/ new PHPMailer;

            // ## setting SMTP GMAIL
            $mail->IsSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Mailer = "smtp";
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 587;
            $mail->Username = $listemail[0]['email_user'];
            $mail->Password = $listemail[0]['email_password'];
            $mail->setFrom($listemail[0]['email_user'], 'Appoint-IT');

            $mail->AddAddress($this->input->post('email_test'));
            $mail->Subject = "Test Mail : Appoint-IT";
            $mail->MsgHTML('test send mail success');
            if (!$mail->Send()) {
                $result = array(
                    'error' => false,
                    'type' => '!send',
                    'msg' => $mail->ErrorInfo,
                    'url' => site_url('emailset/index')
                );
                echo json_encode($result);
            } else {
                $result = array(
                    'error' => false,
                    'type' => 'send',
                    'msg' => 'ส่งเมลสำเร็จ',
                    'url' => site_url('emailset/index')
                );
                echo json_encode($result);
            }
        } else {
            show_404();
        }
    }
}
