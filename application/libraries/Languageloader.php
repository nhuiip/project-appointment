<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Languageloader
{
    function __construct() {
        $ci =& get_instance();
        $ci->load->helper('language');
        $ci->load->library('session');

        $site_lang = $ci->session->userdata('site_lang');
        if ($site_lang) {
            $ci->lang->load('message',$ci->session->userdata('site_lang'));
        } else {
            $ci->lang->load('message','english');
        }
    }
}
?>