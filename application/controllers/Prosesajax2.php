<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prosesajax2 extends CI_Controller
{
  function __construct()
  {
      parent::__construct();
      $this->load->model('data_model');
      date_default_timezone_set("Asia/Jakarta");
  }
   
  function index(){
      echo "Not Index...";
  }

function hapusProdukini(){
    $id = $this->input->post('id');
    $cek = $this->db->query("DELETE FROM data_produk WHERE id_produk='$id'");
    if($cek){
        echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil menghapus"));
    } else {
        echo json_encode(array("statusCode"=>400, "psn"=>"Anda harus menghapus dulu semua stok yang masuk.!!"));
    }
} //end
function hapusModelini(){
    $kodebar = $this->input->post('kodebar');
    $cek = $this->db->query("DELETE FROM data_produk_detil WHERE kode_bar='$kodebar'");
    $cek2 = $this->db->query("DELETE FROM `data_produk_stok` WHERE `kode_bar1` LIKE '$kodebar-%'");
    if($cek){
        echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil menghapus"));
    } else {
        echo json_encode(array("statusCode"=>400, "psn"=>"Anda harus menghapus dulu semua stok yang masuk.!!"));
    }
} //end

}