<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' ); 

class BaseController extends CI_Controller {
	
	function isUserLoggedIn() {
	    $isUserLoggedIn  =   $this->session->userdata ('isUserLoggedIn');
	    if(!isset($isUserLoggedIn) || $isUserLoggedIn != TRUE){
			redirect('login');
		} 
	}
	
	
}