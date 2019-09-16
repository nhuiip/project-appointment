<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captcha extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index(){
        //$rand = rand();
        $rand = mt_rand(100000, 999999);
		$this->load->helper('captcha');
		$src = $this->input->post('src');
		if( file_exists($src) ){
			unlink($src);
		}
		$vals = array(
                    'word'          => $rand,
					'font_path'     => './assets/canvas/captcha/times_new_yorker.ttf',
					'font_size'     => 20,
					'word_length'   => 6,
			        'img_path'      => './assets/canvas/captcha/',
			        'img_url'       => base_url('assets/canvas/captcha/')
						);
		$cap = create_captcha($vals);
		$data = array(
			'filename' => $cap['filename'],
			'word' => $cap['word']
		);
		echo json_encode($data);
		die;
	}


}
