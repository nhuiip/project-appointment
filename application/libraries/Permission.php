<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Permission {

  function __construct($config = array()){
		$this->CI =& get_instance();
	}	

  public function admin($cookie_name = "syslev", $url = ""){
    if(!empty($_COOKIE[$cookie_name])){
      $level = $this->CI->encryption->decrypt($_COOKIE[$cookie_name]);
  		if($level != "l1ci"){
  			header("Location:".site_url($url));
  			die;
  		}
    }else{
      header("Location:".site_url($url));
      die;
    }
	}

	public function member(){
		$level = $_COOKIE['cloud_L'];
		$cuid = $_COOKIE['cloud_C'];
		if($level != 1 and $level != 2 and $level != 3){
			header("Location:".site_url());
			die;
		}else if($cuid == ""){
			header("Location:".site_url('customers/index'));
			die;
		}
	}

}
?>
