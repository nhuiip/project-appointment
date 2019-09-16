<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getlanguage {

	function __construct(){
		$this->CI =& get_instance();
		log_message('debug', 'Getlanguage Class Initialized');
	}

	public function language(){

		if($this->CI->input->get("lg") == "english" or $this->CI->input->get("lg") == "thailand"){
			$cookie_i = array(
	                'name'   => 'lg',
	                'value'  => $this->CI->input->get("lg"),
	                'expire' => '86500',
	                'path'   => '/'
	            );
			$this->CI->input->set_cookie($cookie_i);
			$this->CI->lang->load('font_page_lang', $this->CI->input->get("lg"));
			$lg = $this->CI->input->get("lg");
			return $lg;
		}else{
			if($this->CI->input->cookie("lg") == ""){

				// Settings page
				$this->CI->db->select("set_language");
				$this->CI->db->where(array('set_id' => 1));
				$query = $this->CI->db->get('tb_settings');
				$listsetting = $query->result_array();
				if(count($listsetting) != 0){
					foreach ($listsetting as $key => $value) {
						$set_language = $value['set_language'];
					}
				}

				$cookie_i = array(
		                'name'   => 'lg',
		                'value'  => $set_language,
		                'expire' => '86500',
		                'path'   => '/'
		            );
				$this->CI->input->set_cookie($cookie_i);
				$this->CI->lang->load('font_page_lang', $set_language);

				$lg = $set_language;
			}else{
				$this->CI->lang->load('font_page_lang', $this->CI->input->cookie("lg"));
				$lg = $this->CI->input->cookie("lg");
			}
			return $lg;
		}

	}

	public function set(){
		// Settings page
		$this->CI->db->select("set_language");
		$this->CI->db->where(array('set_id' => 1));
		$query = $this->CI->db->get('tb_settings');
		$listsetting = $query->result_array();
		if(count($listsetting) != 0){
			foreach ($listsetting as $key => $value) {
				$set_language = $value['set_language'];
			}
		}
		return $set_language;
	}

	public function get(){
		return array('thailand','english');
	}

}
