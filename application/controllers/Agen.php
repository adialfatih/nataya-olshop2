<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agen extends CI_Controller
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
      echo "";
  } //end

    function hutang_agen(){
        $shaid = $this->uri->segment(2);
        $cekAgen = $this->data_model->get_byid('data_distributor', ['sha1(id_dis)'=>$shaid]);
        if($cekAgen->num_rows() == 1){
            $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
            $akses = $this->session->userdata('akses');
            $namaagen = $cekAgen->row('nama_distributor');
            $data_hutang = $this->data_model->get_byid('stok_produk_keluar', ['nama_tujuan'=>$namaagen, 'tujuan'=>'Agen']);
            if($akses=="Super"){
                $data = array(
                    'title' => 'Data Hutang Agen - Nota Belum Dibayar',
                    'sess_nama' => $this->session->userdata('nama'),
                    'sess_id' => $this->session->userdata('id'),
                    'sess_username' => $this->session->userdata('username'),
                    'sess_password' => $this->session->userdata('password'),
                    'sess_akses' => $this->session->userdata('akses'),
                    'setup' => $setup,
                    'agen' => $cekAgen->row_array(),
                    'data_hutang' => $data_hutang
                );
                $this->load->view('part/main_head', $data);
                $this->load->view('part/left_sidebar', $data);
                $this->load->view('datapage/hutang_agen_view', $data);
                $this->load->view('part/main_js_dis', $data);
            } else {
                $this->load->view('blok_view');
            }
        } else {
            redirect(base_url('distributor'));
        }
    } //end-cash-flow

}