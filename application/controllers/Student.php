<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Student extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("student_model", "student");
        $this->load->model("subject_model", "subject");
        $this->load->model("setting_model", "setting");
        $this->load->model("administrator_model", "administrator");
    }

    public function index($id = "")
    {
        $poslogin   = $this->encryption->decrypt($this->input->cookie('sysp'));
        $idlogin    = $this->encryption->decrypt($this->input->cookie('sysli'));

        if (!empty($this->encryption->decrypt($this->input->cookie('syslev')))) {
            if ($idlogin == "") {
                show_404();
            } elseif ($poslogin == 'อาจารย์ผู้สอน' && $idlogin != "" || $poslogin == 'ผู้ดูแลระบบ'  && $idlogin != "" || $poslogin == 'หัวหน้าสาขา' && $idlogin != "" ) {
            
                $condition = array();
                $condition['fide'] = "use_id";
                $condition['where'] = array('use_id' => $idlogin);
                $checkteacher= $this->administrator->listData($condition);
                if (count($checkteacher) == 0) {
                    show_404();
                } else {

                
                    $this->template->backend('student/main');

                }
            }else{
                show_404();
            }

        }

    }

    public function register()
    {
        $data = array();

        $condition = array();
        $condition['fide'] = "*";
        $condition['where'] = array('set_status' => 2);
        $listset = $this->setting->listData($condition);
        // echo count($listset);
        // die;
        if (count($listset) != 1) {
            $this->load->view('page/noreg');
        } else {
            $condition = array();
            $condition['fide'] = "*";
            $condition['orderby'] = "tb_settings.set_status DESC, tb_subject.sub_id DESC ";
            $data['listdata'] = $this->subject->listjoinData($condition);

            $condition = array();
            $condition['fide'] = "sub_id, sub_name";
            $condition['where'] = array('set_id' =>  $listset[0]['set_id']);
            $condition['orderby'] = "sub_id DESC ";
            $data['subject'] = $this->subject->listData($condition);

            $data['formcrf'] = $this->tokens->token('formcrf');
            $this->load->view('page/register', $data);
        }
    }

    public function create()
    {
        if ($this->input->post('std_title') == 'อื่นๆ' && $this->input->post('std_title_input') == '') {
            $result = array(
                'error' => true,
                'msg' => 'กรุณาระบุคำนำหน้า',
            );
            echo json_encode($result);
            die;
        }
        if ($this->tokens->verify('formcrf')) {
            $data = array(
                'sub_id'            => $this->input->post('sub_id'),
                'std_img'           => $this->input->post('std_number') . '.png',
                'std_number'        => $this->input->post('std_number'),
                'std_title'         => $this->input->post('std_title'),
                'std_fname'         => $this->input->post('std_fname'),
                'std_lname'         => $this->input->post('std_lname'),
                'std_email'         => $this->input->post('std_email'),
                'std_pass'          => md5($this->input->post('std_pass')),
                'std_tel'           => $this->input->post('std_tel'),
                'std_checkmail'     => 0,
                'std_status'     => 0,
                'std_create_name'   => $this->encryption->decrypt($this->input->cookie('sysn')),
                'std_create_date'   => date('Y-m-d H:i:s'),
                'std_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
                'std_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $id = $this->student->insertData($data);

            if ($this->input->post('std_img') != '') {
                define('UPLOAD_DIR', './uploads/student/');
                $img = $this->input->post('std_img');
                $img = str_replace('data:image/jpeg;base64,', '', $img);
                $img = str_replace('data:image/jpg;base64,', '', $img);
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace('data:image/gif;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                $file = UPLOAD_DIR  . $this->input->post('std_number') . '.png';
                file_put_contents($file, $data);
            }

            $this->sentmailreg($id);
        }
    }

    // mail verify email
    public function message_verify($data)
    {

        $burl = site_url('student/verifyemail/' . $data['std_id']);
        $html = file_get_contents("assets/template_email/verify-email.html");
        $html = str_replace('[DATA-LINK]', $burl, $html);
        $html = str_replace('[DATA-TITLE]', $data['std_title'], $html);
        $html = str_replace('[DATA-FNAME]', $data['std_fname'], $html);
        $html = str_replace('[DATA-LNAME]', $data['std_lname'], $html);
        $html = str_replace('[DATA-EMAIL]', $data['std_email'], $html);
        return $html;
    }

    public function sentmailreg($id = "")
    {
        if (!empty($id)) {
            $condition = array();
            $condition['fide'] = "*";
            $condition['where'] = array('std_id' => $id);
            $listdata = $this->student->listData($condition);
        } else {
            show_404();
        }
        if (count($listdata) != 0) {
            $data = array(
                'std_id'    => $listdata[0]['std_id'],
                'std_title' => $listdata[0]['std_title'],
                'std_fname' => $listdata[0]['std_fname'],
                'std_lname' => $listdata[0]['std_lname'],
                'std_email' => $listdata[0]['std_email'],

            );

            require_once APPPATH . 'third_party/class.phpmailer.php';
            require_once APPPATH . 'third_party/class.smtp.php';
            $mail = new PHPMailer;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->CharSet = "utf-8";
            $mail->IsSMTP();
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->Host = "smtp.hostinger.in.th";
            $mail->Port = 587;
            $mail->Username = "appoint@preedarat-cv.com";
            $mail->Password = "9a&c?Ww5";
            $mail->setFrom('appoint@preedarat-cv.com', 'Appoint-IT');
            $mail->AddAddress($data['std_email']);
            $mail->Subject = "มีข้อความติดต่อจาก : Appoint-IT";
            $message = $this->message_verify($data);
            $mail->MsgHTML($message);
            $mail->send();
            $result = array(
                'error' => false,
                'msg' => 'ลงทะเบียนสำเร็จ',
                'url' => site_url('student/succeedreg')
            );
            echo json_encode($result);
        } else {
            show_404();
        }
    }

    // mail Repassword
    public function message_repass($datamail)
    {

        $html = file_get_contents("assets/template_email/repassword.html");
        $html = str_replace('[DATA-NAME]', $datamail['fullname'], $html);
        $html = str_replace('[DATA-PASS]', $datamail['pass'], $html);
        return $html;
    }

    public function repassword()
    {
        $seed = str_split('abcdefghijklmnopqrstuvwxyz'
            . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
            . '0123456789');
        shuffle($seed);
        $rand = '';
        foreach (array_rand($seed, 8) as $k) $rand .= $seed[$k];
        $newpass = $rand;

        if ($this->input->post('s_email') != '') {

            $condition = array();
            $condition['fide'] = "std_id,std_title,std_fname,std_lname";
            $condition['where'] = array('std_email' => $this->input->post('s_email'));
            $liststd = $this->student->listData($condition);

            // นักเรียน
            if (count($liststd) == 1) {
                $data = array(
                    'std_id'    => $liststd[0]['std_id'],
                    'std_pass'  => md5($newpass),
                );
                $this->student->updateData($data);

                // data for email 
                $datamail = array(
                    'fullname'  => $liststd[0]['std_title'] . $liststd[0]['std_fname'] . ' ' . $liststd[0]['std_lname'],
                    'email' => $this->input->post('s_email'),
                    'pass'  => $newpass,
                );
                // อาจารย์
            } else {
                $condition = array();
                $condition['fide'] = "use_id, use_name";
                $condition['where'] = array('use_email' => $this->input->post('s_email'));
                $listuse = $this->administrator->listData($condition);

                $data = array(
                    'use_id'    => $listuse[0]['use_id'],
                    'use_pass'  => md5($newpass),
                );
                $this->administrator->updateData($data);

                // data for email 
                $datamail = array(
                    'fullname'  => $listuse[0]['use_name'],
                    'email'     => $this->input->post('s_email'),
                    'pass'      => $newpass,
                );
            }

            require_once APPPATH . 'third_party/class.phpmailer.php';
            require_once APPPATH . 'third_party/class.smtp.php';
            $mail = new PHPMailer;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->CharSet = "utf-8";
            $mail->IsSMTP();
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->Host = "smtp.hostinger.in.th";
            $mail->Port = 587;
            $mail->Username = "appoint@preedarat-cv.com";
            $mail->Password = "9a&c?Ww5";
            $mail->setFrom('appoint@preedarat-cv.com', 'Appoint-IT');
            $mail->AddAddress($datamail['email']);
            $mail->Subject = "มีข้อความติดต่อจาก : Appoint-IT";
            $message = $this->message_repass($datamail);
            $mail->MsgHTML($message);
            // $mail->send();
            if (!$mail->send()) {
                echo $mail->ErrorInfo;
            } else {
                echo '<script>document.location.href = "' . site_url("student/succeedrepass") . '";</script>';
                die;
            }
        } else {
            show_404();
        }
    }

    public function checkemail()
    {
        // check email count 0 = true or than 0 = false
        $std_email = $this->input->post('std_email');
        if (!empty($std_email)) {
            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_email' => $std_email);
            $listemail = $this->student->listData($condition);
            if (count($listemail) == 0) {
                echo "true";
            } else {
                echo "false";
            }
        }
    }

    public function checknumber()
    {
        // check number count 0 = true or than 0 = false
        $std_number = $this->input->post('std_number');
        if (!empty($std_number)) {
            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_number' => $std_number);
            $listnumber = $this->student->listData($condition);
            if (count($listnumber) == 0) {
                echo "true";
            } else {
                echo "false";
            }
        }
    }

    public function getemail()
    {
        $std_email = $this->input->post('s_email');
        if (!empty($std_email)) {
            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_email' => $std_email);
            $listemail = $this->student->listData($condition);
            if (count($listemail) == 1) {
                echo "true";
            } else {
                $condition = array();
                $condition['fide'] = "*";
                $condition['where'] = array('position_id !=' => 4, 'position_id !=' => 1, 'use_email' => $std_email);
                $listuse = $this->administrator->listData($condition);
                if (count($listuse) == 1) {
                    echo "true";
                } else {
                    echo "false";
                }
            }
        }
    }
    public function verifyemail($id = "")
    {
        if (!empty($id)) {
            $condition = array();
            $condition['fide'] = "*";
            $condition['where'] = array('std_id' => $id, 'std_checkmail' => 0);
            $listdata = $this->student->listData($condition);
            if (count($listdata) == 1) {
                $data = array(
                    'std_id'        => $listdata[0]['std_id'],
                    'std_checkmail' => 1,
                );
                $this->student->updateData($data);
                $this->load->view('page/verify');
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }

    public function succeedreg()
    {
        $this->load->view('page/succeed-reg');
    }

    public function succeedrepass()
    {
        $this->load->view('page/succeed-repass');
    }

    public function testmail()
    {
        require_once APPPATH . 'third_party/class.phpmailer.php';
        require_once APPPATH . 'third_party/class.smtp.php';
        $mail = new PHPMailer;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->CharSet = "utf-8";
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;

        // $mail->Host = "27.254.131.201";
        // $mail->Port = 25;
        // $mail->Username = "system@owlsiam.com";
        // $mail->Password = "Ew%9NjEG";
        // $mail->SetFrom("system@owlsiam.com", "owlsiam.com");

        $mail->Host = "smtp.hostinger.in.th";
        $mail->Port = 587;
        $mail->Username = "appoint@preedarat-cv.com";
        $mail->Password = "fAC2Kb>4";
        $mail->setFrom('appoint@preedarat-cv.com', 'Appoint-IT');

        $mail->AddAddress('preedarat.jut@gmail.com');
        $mail->Subject = "มีข้อความติดต่อจาก : Appoint-IT";
        $mail->MsgHTML('test');
        if (!$mail->send()) {
            echo $mail->ErrorInfo;
        } else {
            echo 'send';
        }
    }
}
