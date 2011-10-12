<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function firephp($data){
	$CI =& get_instance();
	$CI->load->library('firephp');
	$CI->firephp->fb($data);
}