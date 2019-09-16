<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tokens {

	function __construct($config = array()){
		$this->CI =& get_instance();
	}
	public function token($tokens_name){
		$token = md5(uniqid(rand(),true));
		$this->CI->session->sess_expiration = '14400';
		$this->CI->session->set_userdata($tokens_name,$token);
		return $token;
	}
	public function verify($tokens_name){
		if($this->CI->input->post($tokens_name) == $this->CI->session->userdata($tokens_name)){
			return true;
		}else{
			return false;
		}
	}
}