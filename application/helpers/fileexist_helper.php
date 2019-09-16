<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('empty_img'))
{
	function empty_img($path, $v){
		if(!empty($v)){
			if(file_exists($path.$v) ){
				$file = base_url($path.$v);
			}else{
				$file = base_url('assets/canvas/images/noimg-800.png');
			}
		}else{
			$file = base_url('assets/canvas/images/noimg-800.png');
		}
		return $file;
	}

}
