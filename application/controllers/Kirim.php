<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kirim extends CI_Controller
{
    function __construct()
    {
      parent::__construct();
      $this->load->model('data_model');
      date_default_timezone_set("Asia/Jakarta");
      if($this->session->userdata('login_form') != "akses-as1563sd1679dsad8789asff53afhafaf670fa"){
        redirect(base_url('login'));
      }
    }
   
  function index(){
       echo 'Invalid token';
  } //end

  
}
?>