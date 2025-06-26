<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tes extends CI_Controller
{
  function __construct()
  {
      parent::__construct();
      $this->load->model('data_model');
      date_default_timezone_set("Asia/Jakarta");
    //   if($this->session->userdata('login_form') != "as123sd123dsad8789asff98afhafaf789fa"){
    //     redirect(base_url('login'));
    //   }
  }
   
  function index(){ } //end
    
}
?>