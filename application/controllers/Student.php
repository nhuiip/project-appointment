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
        $this->load->model("project_model", "project");
        $this->load->model("meet_model", "meet");
        $this->load->model("projectfile_model", "projectfile");
        $this->load->model("administrator_model", "administrator");
    }

    // อาจารย์ && ผู้ดูแล
    public function index($id = "")
    {
        $poslogin   = $this->encryption->decrypt($this->input->cookie('sysp'));
        $idlogin    = $this->encryption->decrypt($this->input->cookie('sysli'));

        if (!empty($this->encryption->decrypt($this->input->cookie('syslev')))) {
            if ($idlogin == "") {
                show_404();
            } elseif ($poslogin == 'อาจารย์ผู้สอน' && $idlogin != "" || $poslogin == 'ผู้ดูแลระบบ'  && $idlogin != "" || $poslogin == 'หัวหน้าสาขา' && $idlogin != "") {

                $condition = array();
                $condition['fide'] = "use_id";
                $condition['where'] = array('use_id' => $idlogin);
                $checkteacher = $this->administrator->listData($condition);
                if (count($checkteacher) == 0) {
                    show_404();
                } else {

                    $condition = array();
                    $condition['fide'] = "*";
                    $condition['orderby'] = "std_number DESC";
                    $data['listdata'] = $this->student->listData($condition);

                    $data['formcrfmail'] = $this->tokens->token('formcrfmail');
                    $data['formcrfstudent'] = $this->tokens->token('formcrfstudent');
                    $data['formcrfpassword'] = $this->tokens->token('formcrfpassword');
                    $this->template->backend('student/main', $data);
                }
            } else {
                show_404();
            }
        }
    }

    public function register()
    {
        $data = array();
        $data['formcrf'] = $this->tokens->token('formcrf');
        $this->load->view('page/register', $data);
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
            if ($this->input->post('std_img') != '') {
                $data = array(
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
            } else {
                $data = array(
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
            }
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
            $mail->Host = "27.254.131.201";
            $mail->Port = 25;
            $mail->Username = "sys@preedarat-cv.com";
            $mail->Password = "br%9CPF7";
            $mail->setFrom('sys@preedarat-cv.com', 'Appoint-IT');
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
            $mail->Host = "27.254.131.201";
            $mail->Port = 25;
            $mail->Username = "sys@preedarat-cv.com";
            $mail->Password = "br%9CPF7";
            $mail->setFrom('sys@preedarat-cv.com', 'Appoint-IT');
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

    public function changemailstd()
    {
        $poslogin   = $this->encryption->decrypt($this->input->cookie('sysp'));
        $idlogin    = $this->encryption->decrypt($this->input->cookie('sysli'));

        if (!empty($this->encryption->decrypt($this->input->cookie('syslev')))) {

            if ($poslogin == 'อาจารย์ผู้สอน' && $idlogin != "" || $poslogin == 'ผู้ดูแลระบบ'  && $idlogin != "" || $poslogin == 'หัวหน้าสาขา' && $idlogin != "") {

                if ($this->tokens->verify('formcrfmail')) {
                    $data = array(
                        'std_id'                => $this->input->post('Idmail'),
                        'std_email'             => $this->input->post('std_email'),
                        'std_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'std_lastedit_date'     => date('Y-m-d H:i:s'),
                    );

                    $this->student->updateStd($data);

                    if (!empty($this->input->post('Idmail'))) {
                        $result = array(
                            'error' => false,
                            'msg' => 'เปลี่ยนที่อยู่อีเมล์แล้วเรียบร้อยแล้ว',
                            'url' => site_url('student/index')
                        );
                        echo json_encode($result);
                    } else {
                        $result = array(
                            'error' => false,
                            'msg' => 'เปลี่ยนที่อยู่อีเมล์แล้วเรียบร้อยแล้ว',
                            'url' => site_url('student/index')
                        );
                        echo json_encode($result);
                    }
                    die;
                } else {
                    $result = array(
                        'error' => true,
                        'title' => "ล้มเหลว",
                        'msg' => "เปลี่ยนที่อยู่อีเมล์ไม่สำเร็จ"
                    );
                    echo json_encode($result);
                }
            } else {
                show_404();
            }
        }
    }

    public function changepasswordstd()
    {
        if ($this->tokens->verify('formcrfpassword')) {
            $data = array(
                'std_id'        => $this->input->post('Id2'),
                'std_pass'      => md5($this->input->post('std_password'))
            );
            $this->student->updateStd($data);

            $result = array(
                'error' => false,
                'msg' => 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว',
                'url' => site_url('student/index')
            );
            echo json_encode($result);
        } else {
            $result = array(
                'error' => true,
                'title' => "ล้มเหลว",
                'msg' => "อัพเดตข้อมูลไม่สำเร็จ"
            );
            echo json_encode($result);
        }
    }

    public function updatestd()
    {
        $poslogin   = $this->encryption->decrypt($this->input->cookie('sysp'));
        $idlogin    = $this->encryption->decrypt($this->input->cookie('sysli'));

        if (!empty($this->encryption->decrypt($this->input->cookie('syslev')))) {

            if ($poslogin == 'อาจารย์ผู้สอน' && $idlogin != "" || $poslogin == 'ผู้ดูแลระบบ'  && $idlogin != "" || $poslogin == 'หัวหน้าสาขา' && $idlogin != "") {

                if ($this->tokens->verify('formcrfstudent')) {
                    $data = array(
                        'std_id'                => $this->input->post('Idstd_up'),
                        'std_fname'             => $this->input->post('text_name'),
                        'std_lname'             => $this->input->post('text_lastname'),
                        'std_tel'               => $this->input->post('text_tel'),
                        'std_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'std_lastedit_date'     => date('Y-m-d H:i:s'),
                    );

                    $this->student->updateStd($data);

                    if (!empty($this->input->post('Idstd_up'))) {
                        $result = array(
                            'error' => false,
                            'msg' => 'แก้ไขข้อมูลสำเร็จ',
                            'url' => site_url('student/index/')
                        );
                        echo json_encode($result);
                    } else {
                        $result = array(
                            'error' => true,
                            'title' => "ล้มเหลว",
                            'msg' => 'อัพเดตข้อมูลไม่สำเร็จ',
                        );
                        echo json_encode($result);
                    }
                    die;
                } else {
                    $result = array(
                        'error' => true,
                        'title' => "ล้มเหลว",
                        'msg' => "อัพเดตข้อมูลไม่สำเร็จ"
                    );
                    echo json_encode($result);
                }
            }
        }
    }

    // นักศึกษาใช้งาน
    public function stdupdate()
    {
        if ($this->input->post('std_img') != '') {
            $data = array(
                'std_id'                => $this->input->post('Id'),
                'std_img'               => $this->input->post('std_number') . '.png',
                'std_fname'             => $this->input->post('text_name'),
                'std_lname'             => $this->input->post('text_lastname'),
                'std_tel'               => $this->input->post('text_tel'),
                'std_lastedit_name'     => $this->input->post('text_name') . ' ' . $this->input->post('text_lastname'),
                'std_lastedit_date'     => date('Y-m-d H:i:s'),
            );
        } else {
            $data = array(
                'std_id'                => $this->input->post('Id'),
                'std_fname'             => $this->input->post('text_name'),
                'std_lname'             => $this->input->post('text_lastname'),
                'std_tel'               => $this->input->post('text_tel'),
                'std_lastedit_name'     => $this->input->post('text_name') . ' ' . $this->input->post('text_lastname'),
                'std_lastedit_date'     => date('Y-m-d H:i:s'),
            );
        }

        $this->student->updateStd($data);

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

        $f = $this->encryption->encrypt($this->input->post('text_name') . ' ' . $this->input->post('text_lastname'));
        $loginimg = $this->encryption->encrypt($this->input->post('std_number') . '.png');
        $cookie_fullname = array(
            'name'   => 'sysn',
            'value'  => $f,
            'expire' => '86500',
            'path'   => '/'
        );
        $this->input->set_cookie($cookie_fullname);
        $cookie_img = array(
            'name'   => 'sysimg',
            'value'  => $loginimg,
            'expire' => '86500',
            'path'   => '/'
        );
        $this->input->set_cookie($cookie_img);

        $result = array(
            'error' => false,
            'msg' => 'แก้ไขข้อมูลสำเร็จ',
            'url' => 'reload',

        );
        echo json_encode($result);
    }
    public function stdchangemail()
    {
        $Id  =  $this->input->post('Idmail');
        if ($Id == "") {
            $this->load->view('errors/html/error_403');
        } else if ($this->encryption->decrypt($this->input->cookie('sysp')) == 'นักศึกษา') {


            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $Id);
            $checkstudent = $this->student->listData($condition);
            if (count($checkstudent) == 0) {
                $this->load->view('errors/html/error_403');
            } else {

                $data = array(
                    'std_id'                => $this->input->post('Idmail'),
                    'std_email'             => $this->input->post('std_email'),
                    'std_checkmail'         => 0,
                    'std_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                    'std_lastedit_date'     => date('Y-m-d H:i:s'),
                );

                $this->student->updateStd($data);

                // ส่งเมลยืนยันอีเมลใหม่อีครั้ง //
                $this->sentmailchange($this->input->post('Idmail'));
            }
        }
    }
    public function sentmailchange($id = "")
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
            $mail->Port = 25;
            $mail->Username = "sys@preedarat-cv.com";
            $mail->Password = "br%9CPF7";
            $mail->setFrom('sys@preedarat-cv.com', 'Appoint-IT');
            $mail->AddAddress($data['std_email']);
            $mail->Subject = "มีข้อความติดต่อจาก : Appoint-IT";
            $message = $this->message_verify($data);
            $mail->MsgHTML($message);
            // $mail->send();
            if (!$mail->send()) {
                $result = array(
                    'error' => true,
                    'msg' => $mail->ErrorInfo,
                );
                echo json_encode($result);
                die;
            } else {
                $result = array(
                    'error' => false,
                    'msg' => 'เปลี่ยนที่อยู่อีเมล์สำเร็จ',
                    'url' =>  site_url('administrator/logout')
                );
                echo json_encode($result);
                die;
            }
        } else {
            show_404();
        }
    }
    public function stdchangepassword()
    {
        $data = array(
            'std_id'         => $this->input->post('Id2'),
            'std_pass'       => md5($this->input->post('std_password'))
        );

        $Id = $this->student->updateStd($data);

        if (!empty($Id)) {
            $result = array(
                'error' => false,
                'msg' => 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว',
                'url' => 'reload'
            );
            echo json_encode($result);
        } else {
            $result = array(
                'error' => true,
                'title' => "ล้มเหลว",
                'msg' => 'อัพเดตข้อมูลไม่สำเร็จ',
            );
            echo json_encode($result);
        }
        die;
    }
    public function stdproject($id = '')
    {
        // echo 'stdproject';
        // die;
        //ไม่ login ให้ show 404
        if(empty($id)){
            show_404();
        }
        if (empty($this->encryption->decrypt($this->input->cookie('syslev')))) {
            show_404();
        }
        $data = array();
        $poslogin   = $this->encryption->decrypt($this->input->cookie('sysp'));
        $idlogin    = $this->encryption->decrypt($this->input->cookie('sysli'));

        if (!empty($id) && $poslogin == 'นักศึกษา' && $idlogin == $id) {
            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $id);
            $data['liststudent'] = $this->student->listjoinData($condition);
            if (count($data['liststudent']) != 1) {
                //ไม่พบ id, พบข้อมูลมากกว่า 1 แถว ให้ show 404
                show_404();
            } else {
                //ค้นหาโปรเจคที่นักศึกษาสร้างไว้
                $condition = array();
                $condition['fide'] = "
                tb_project.project_id, project_name, project_status,
                project_create_name, project_create_date, project_lastedit_name, project_lastedit_date,
                tb_user.use_name, tb_user.use_id";
                $condition['where'] = array('tb_projectperson.std_id' => $id, 'tb_project.project_status !=' => 0);
                $data['searchProject'] = $this->project->listjoinData($condition);
                if (count($data['searchProject']) != 0) {
                    $project_id = $data['searchProject'][0]['project_id'];

                    $condition = array();
                    $condition['fide'] = "std_title, std_fname, std_lname";
                    $condition['where'] = array('tb_projectperson.project_id' => $project_id);
                    $data['listprojectperson'] = $this->project->listperson($condition);

                    $condition = array();
                    $condition['fide'] = "file_id, file_name";
                    $condition['where'] = array('tb_projectfile.project_id' => $project_id);
                    $condition['orderby'] = "tb_projectfile.file_name ASC";
                    $data['listfile'] = $this->projectfile->listjoinData($condition);

                    $condition = array();
                    $condition['fide'] = "sub_code, sub_name, set_year, set_term, meet_id, tb_project.use_id";
                    $condition['where'] = array('tb_meet.project_id' => $project_id, 'tb_meet.meet_status !=' => 0, 'tb_settings.set_status' => 2);
                    $data['listmeetnow'] = $this->meet->listjoinData($condition);

                    $condition = array();
                    $condition['fide'] = "sub_code, sub_name, set_year, set_term, meet_id, tb_project.use_id";
                    $condition['where'] = array('tb_meet.project_id' => $project_id, 'tb_meet.meet_status !=' => 0, 'tb_settings.set_status' => 0);
                    $data['listmeethis'] = $this->meet->listjoinData($condition);
                }

                $condition = array();
                $condition['fide'] = "*";
                $condition['where'] = array('tb_projectperson.std_id' => $id, 'tb_project.project_status' => 0);
                $data['lastProject'] = $this->project->listjoinData($condition);
                //แสดงอาจารญ์ทั้งหมด
                $condition = array();
                $condition['fide'] = "*";
                // $condition['where_in'] = array('position_id !=' => 1, 'position_id !=' => 5);
                $condition['where_in']['filde'] = 'position_id';
                $condition['where_in']['value'] = ['2', '3'];
                $data['listuser'] = $this->administrator->listData($condition);

                $condition = array();
                $condition['fide'] = "*";
                $condition['where'] = array('std_status' => 0, 'std_checkmail' => 1);
                $data['liststd'] = $this->student->listData($condition);

                $condition = array();
                $condition['fide'] = "*";
                $data['listformat'] = $this->projectfile->listformat($condition);

                //แสดง id ที่ login เอาไป select subject
                $data['Idstd'] =   $this->encryption->decrypt($this->input->cookie('sysli'));
                $data['formcrf'] = $this->tokens->token('formcrf');
                $data['formcrfaddproject'] = $this->tokens->token('formcrfaddproject');
                $data['formcrfupproject'] = $this->tokens->token('formcrfupproject');
                $data['formcrffileproject'] = $this->tokens->token('formcrffileproject');
                $this->template->backend('student/project', $data);
            }
        } elseif ($poslogin != 'นักศึกษา' && $idlogin != $id) {
            //ไม่ใช่นักศึกษา, ไม่ใช่เจ้าของ user ให้ show 403
            $this->load->view('errors/html/error_403');
        }
    }
    public function stdprojectadd()
    {
        if ($this->tokens->verify('formcrfaddproject')) {
            $data = array(
                'project_name'          => $this->input->post('project_name'),
                'use_id'                => $this->input->post('use_id'),
                'project_status'        => 1,
                'project_create_name'   => $this->encryption->decrypt($this->input->cookie('sysn')),
                'project_create_date'   => date('Y-m-d H:i:s'),
                'project_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
                'project_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $id = $this->project->insertData($data);
            foreach ($this->input->post('std_id') as $key => $value) {
                $data = array(
                    'project_id'            => $id,
                    'std_id'                => $value,
                );
                $this->project->insertPerson($data);
            }
            if (!file_exists('./uploads/fileproject/Project_' . $id)) {
                mkdir('./uploads/fileproject/Project_' . $id, 0777, true);
            }
            $result = array(
                'error' => false,
                'msg' => 'เพิ่มข้อมูลสำเร็จ',
                'url' => site_url('student/stdproject/' . $this->encryption->decrypt($this->input->cookie('sysli')))
            );
            echo json_encode($result);
        }
    }
    public function stdprojectupdate()
    {
        if ($this->tokens->verify('formcrfupproject')) {
            $data = array(
                'project_id'        => $this->input->post('project_id'),
                'project_name'      => $this->input->post('project_name'),
                'use_id'            => $this->input->post('use_id'),
                'project_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
                'project_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $this->project->updateData($data);
            $result = array(
                'error' => false,
                'msg' => 'แก้ไขข้อมูลสำเร็จ',
                'url' => site_url('student/stdproject/' . $this->encryption->decrypt($this->input->cookie('sysli')))
            );
            echo json_encode($result);
        }
    }
    public function stdprojectdel($id)
    {
        $data = array(
            'project_id'        => $id,
            'project_status'    => 0,
            'project_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
            'project_lastedit_date' => date('Y-m-d H:i:s'),
        );
        $this->project->updateData($data);
        header("location:" . site_url('student/stdproject/' . $this->encryption->decrypt($this->input->cookie('sysli'))));
    }
    public function stdprojectaddfile()
    {
        $condition = array();
        $condition['fide'] = "*";
        $condition['where'] = array(
            'project_id' => $this->input->post('project_id'),
            'file_name' => $this->input->post('proformat_name') . '.pdf'
        );
        $listdata = $this->projectfile->listData($condition);

        if (count($listdata) == 0) {
            if ($this->tokens->verify('formcrffileproject')) {
                $data = array(
                    'project_id'            => $this->input->post('project_id'),
                    'file_name'             => $this->input->post('proformat_name') . '.pdf',
                    'file_create_name'      => $this->encryption->decrypt($this->input->cookie('sysn')),
                    'file_create_date'      => date('Y-m-d H:i:s'),
                    'file_lastedit_name'    => $this->encryption->decrypt($this->input->cookie('sysn')),
                    'file_lastedit_date'    => date('Y-m-d H:i:s'),
                );
                $this->projectfile->insertData($data);
                $this->upfileimages('file_name', $this->input->post('proformat_name'), $this->input->post('project_id'));

                $result = array(
                    'error' => false,
                    'msg' => 'เพิ่มเอกสารสำเร็จ',
                    'url' => site_url('student/stdproject/' . $this->encryption->decrypt($this->input->cookie('sysli')))
                );
                echo json_encode($result);
            }
        } else {
            $result = array(
                'error' => true,
                'msg' => 'มีเอกสารรายการนี้อยู่ก่อนแล้ว',
            );
            echo json_encode($result);
        }
    }
    public function stdprojectupfile()
    {
        $file_name = $this->input->post('file_name_up');
        $proformat_name = str_replace(".pdf", "", $file_name);
        $project_id = $this->input->post('project_id');
        // del old file
        @unlink('./uploads/fileproject/Project_' . $project_id . '/' . $file_name);
        //upnewfile
        $this->upfileimages('file_name', $proformat_name, $project_id);

        $result = array(
            'error' => false,
            'msg' => 'แก้ไขเอกสารสำเร็จ',
            'url' => site_url('student/stdproject/' . $this->encryption->decrypt($this->input->cookie('sysli')))
        );
        echo json_encode($result);
    }
    public function stdprojectdelfile($id)
    {
        $condition = array();
        $condition['fide'] = "project_id, file_name";
        $condition['where'] = array('file_id' => $id,);
        $listdata = $this->projectfile->listData($condition);

        $project_id = $listdata[0]['project_id'];
        $file_name = $listdata[0]['file_name'];

        $data = array(
            'file_id'        => $id,
        );
        $this->projectfile->deleteData($data);

        //del file
        @unlink('./uploads/fileproject/Project_' . $project_id . '/' . $file_name);
        header("location:" . site_url('student/stdproject/' . $this->encryption->decrypt($this->input->cookie('sysli'))));
    }
    private function upfileimages($Fild_Name, $proformat_name, $project_id)
    {
        if (!empty($_FILES[$Fild_Name])) {
            $new_name = $proformat_name;
            $config['upload_path'] = './uploads/fileproject/Project_' . $project_id;
            $config['allowed_types'] = 'pdf';
            $config['file_name'] = $new_name;
            $config['max_size']    = 0;
            $this->load->library('upload', $config, 'upbanner');
            $this->upbanner->initialize($config);
            if (!$this->upbanner->do_upload($Fild_Name)) {
                $result = array(
                    'error' => true,
                    'title' => "Error",
                    'msg' => $this->upbanner->display_errors()
                );
                echo json_encode($result);
                die;
            } else {
                $img = $this->upbanner->data();
                return $img['file_name'];
            }
        }
    }

    // public function testq($id = 1)
    // {

    //     // if (!file_exists('./uploads/fileproject/Project_' . $id)) {
    //     //     mkdir('./uploads/fileproject/Project_' . $id, 0777, true);
    //     // }

    //     // $condition = array();
    //     // $condition['fide'] = "*";
    //     // $condition['where'] = array('tb_projectperson.std_id' => $id);
    //     // $listdata = $this->project->listjoinData($condition);

    //     // echo '<pre>';
    //     // print_r($listdata);
    //     // echo '</pre>';
    // }

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

        $mail->Host = "mail.preedarat-cv.com";
        $mail->Port = 25;
        $mail->Username = "sys@preedarat-cv.com";
        $mail->Password = "br%9CPF7";
        $mail->setFrom('sys@preedarat-cv.com', 'Appoint-IT');

        $mail->AddAddress('preedarat.jut@gmail.com');
        $mail->Subject = "มีข้อความติดต่อจาก : Appoint-IT";
        $mail->MsgHTML('test');

        if (!$mail->send()) {
            echo $mail->ErrorInfo;
        } else {
            echo 'send';
        }
    }

    public function showdetailproject($project_id = '')
    { }
}
