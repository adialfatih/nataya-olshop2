<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Block extends CI_Controller
{
  function __construct()
  {
      parent::__construct();
      $this->load->model('data_model');
   //    if($this->session->userdata('status') != "login"){
			// redirect(base_url("auth_login"));
	    //}
  }
   
  function index(){
      $this->load->view('blok_view');
  }
   

}
?>