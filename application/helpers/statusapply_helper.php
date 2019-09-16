<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('status_military'))
{
	function status_military($v){
		if($v == 1){
			$status = "ผ่านการเกณฑ์ทหาร";
		}else if($v == 2){
			$status = "ได้รับยกเว้น";
		}else if($v == 3){
			$status = "ยังไม่ได้รับการเกณฑ์";
		}else{
			$status = "-";
		}
		return $status;
	}
}

if ( ! function_exists('status_marry'))
{
	function status_marry($v){
		if($v == 1){
			$status = "โสด";
		}else if($v == 2){
			$status = "สมรส";
		}else if($v == 3){
			$status = "อย่า";
		}else if($v == 4){
			$status = "หม้าย";
		}else if($v == 5){
			$status = "แยกกันอยู่";
		}else{
			$status = "-";
		}
		return $status;
	}
}

if ( ! function_exists('status_disease'))
{
	function status_disease($v){
		if($v == 1){
			$status = "ไม่มี";
		}else if($v == 2){
			$status = "มี";
		}else{
			$status = "-";
		}
		return $status;
	}
}
