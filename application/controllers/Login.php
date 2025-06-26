<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model(array('login_model'));
		date_default_timezone_set("Asia/Jakarta");
	}

	public function index(){
		$this->session->sess_destroy();
		$this->load->view('login_form');
	}
	public function aksi_login(){
		$user = $this->login_model->filter($this->input->post('username'));
		$pass = $this->input->post('password');
		$pass_sha1 = sha1($pass);

				if($this->login_model->cek_username($user) == true){
					$cek = $this->login_model->cek_login('table_users', ['username' => $user, 'password' => sha1($pass)]);
					if($cek->num_rows() == 1) {
						$dt = $cek->row_array();
						$id = $dt['idadm'];
							$data_session = array(
								'id' => $id,
								'nama'  => $dt['nama_admin'],
								'username'=> $dt['username'],
								'password' => $dt['password'],
								'akses' => $dt['akses'],
								'login_form'=> 'akses-as1563sd1679dsad8789asff53afhafaf670fa'
							);
							$this->session->set_userdata($data_session);
							redirect(base_url('dashboard'));
							
					} else {
						$this->session->set_flashdata('announce', 'Password anda salah');
						redirect(base_url('login'));
					}
				} else {
					$this->session->set_flashdata('announce', 'Username / Email login tidak terdaftar');
					redirect(base_url('login'));
				}
	}


	
	
	public function logout(){
		$this->session->sess_destroy();
	}

	

}