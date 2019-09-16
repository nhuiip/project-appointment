<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Encryption64 {
    public function encode64($data){
		$h = base64_encode($data);
		$h2 = base64_encode($h);
		return $h2;
	}
	public function decode64($data){
		$h = base64_decode($data);
		$h2 = base64_decode($h);
		return $h2;
	}
}

?>