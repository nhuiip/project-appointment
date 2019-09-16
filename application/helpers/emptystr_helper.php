<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('empty_str'))
{
	function empty_str($v){
		if(!empty($v)){
			return $v;
		}else{
			return "-";
		}
	}
}
