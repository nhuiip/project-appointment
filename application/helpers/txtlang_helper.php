<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('txtlang'))
{
	function txtlang($txtTH,$txtEN){
		$CI =& get_instance();
		$lg = $CI->input->cookie("lg");
		if($lg != ""){
			if(!empty($txtEN) && !empty($txtEN)){
				if($lg == "english"){
					return $txtEN;
				}else{
					return $txtTH;
				}
			}else{
				return $txtTH;
			}
		}else{
			return $txtTH;
		}
	}

}
