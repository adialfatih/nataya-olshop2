<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends CI_Controller
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
      $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
      $data = array(
          'title' => 'Selamat Datang ',
          'sess_nama' => $this->session->userdata('nama'),
          'sess_id' => $this->session->userdata('id'),
          'sess_username' => $this->session->userdata('username'),
          'sess_password' => $this->session->userdata('password'),
          'sess_akses' => $this->session->userdata('akses'),
          'setup' => $setup,
          'saldo' => $this->data_model->getSaldo()
      );
      $this->load->view('part/main_head', $data);
      $this->load->view('part/left_sidebar', $data);
      $this->load->view('beranda_view', $data);
      $this->load->view('part/main_js');
  } //end

  function bot_wa(){
        $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
        
        $data = array(
            'title' => 'Managemen BOT Whatsapp Auto Reply',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'setup' => $setup,
            'bot' => $this->data_model->get_record('table_botwa')
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/data_bot', $data);
        $this->load->view('part/main_js');
  }
  function product(){
        $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
        $kat = $this->db->query("SELECT * FROM kategori_produk ORDER BY kategori ASC");
        $produk = $this->db->query("SELECT * FROM data_produk ORDER BY nama_produk ASC");
        $data = array(
            'title' => 'Product List',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'setup' => $setup,
            'kat'   => $kat,
            'produk' => $produk,
            'codeuniq' => $this->data_model->acakKode(19)
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/data_produk', $data);
        $this->load->view('part/main_js');
  } //end
  function product_byid(){
        $code = $this->uri->segment(2);
        $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
        $kat = $this->db->query("SELECT * FROM kategori_produk ORDER BY kategori ASC");
        $produk = $this->db->query("SELECT * FROM data_produk WHERE codeunik = '$code'");
        $id_produk = $produk->row("id_produk");
        $img_produk = $this->db->query("SELECT * FROM gambar_produk WHERE codeunik = '$code'");
        $data = array(
            'title' => 'Product List',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'setup' => $setup,
            'kat'   => $kat,
            'codereal'   => $code,
            'img_produk'   => $img_produk,
            'id_produk'   => $id_produk,
            'produk' => $produk->row_array(),
            'codeuniq' => $this->data_model->acakKode(19)
        );
        $this->load->view('part/main_head2', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/data_produk_detail', $data);
        $this->load->view('part/main_js2');
  } //end
  function product_update(){
        $code = $this->uri->segment(3);
        $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
        $kat = $this->db->query("SELECT * FROM kategori_produk ORDER BY kategori ASC");
        $produk = $this->db->query("SELECT * FROM data_produk WHERE codeunik = '$code'");
        $img_produk = $this->db->query("SELECT * FROM gambar_produk WHERE codeunik = '$code'");
        $data = array(
            'title' => 'Product List',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'setup' => $setup,
            'kat'   => $kat,
            'codereal'   => $code,
            'img_produk'   => $img_produk,
            'produk' => $produk->row_array(),
            'codeuniq' => $this->data_model->acakKode(19)
        );
        $this->load->view('part/main_head2', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/data_produk_update', $data);
        $this->load->view('part/main_js2');
  } //end
  
   
  function akses_user(){ 
    $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
    $akses = $this->session->userdata('akses');
    if($akses=="Super"){
        $user = $this->data_model->get_record('table_users');
    } else {
        $user = $this->data_model->get_byid('table_users', ['akses!='=>'Super']);
    }
    $data = array(
        'title' => 'Management User Akses',
        'sess_nama' => $this->session->userdata('nama'),
        'sess_id' => $this->session->userdata('id'),
        'sess_username' => $this->session->userdata('username'),
        'sess_password' => $this->session->userdata('password'),
        'sess_akses' => $this->session->userdata('akses'),
        'setup' => $setup,
        'users' => $user
    );
    $this->load->view('part/main_head', $data);
    $this->load->view('part/left_sidebar', $data);
    $this->load->view('datapage/akses_user', $data);
    $this->load->view('part/main_js');
} //end

function distributor(){
    $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
    $akses = $this->session->userdata('akses');
    if($akses=="Super"){
        $data = array(
            'title' => 'Management Distributor',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'setup' => $setup,
            'dist' => $this->data_model->get_record('data_distributor')
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/distributor_view', $data);
        $this->load->view('part/main_js');
    } else {
        $this->load->view('blok_view');
    }
    
} //end-cash-flow

function reseller(){
    $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
    $akses = $this->session->userdata('akses');
    if($akses=="Super"){
        $data = array(
            'title' => 'Management Reseller',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'setup' => $setup,
            'daterange' => 'one',
            'dist' => $this->data_model->get_record('data_reseller')
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/reseller_view', $data);
        $this->load->view('part/main_js');
    } else {
        $this->load->view('blok_view');
    }
    
} //end-cash-flow
function reseller2(){
    $uri = $this->uri->segment(4);
    $id_res = intval($uri) - 98761;
    $cek_res = $this->data_model->get_byid('data_reseller', ['id_res'=>$id_res]);
    if($cek_res->num_rows() == 1){
        $dtres = $cek_res->row_array();
        $nilai_bayar = $this->db->query("SELECT SUM(nominal) AS byr FROM hutang_reseller_bayar WHERE id_res='$id_res'")->row("byr");
    } else {
        $this->session->set_flashdata('gagal', 'Gagal mengambil data reseller');
        redirect(base_url('reseller'));
    }
    $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
    $akses = $this->session->userdata('akses');
    if($akses=="Super"){
        $data = array(
            'title' => 'Nota Reseller',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'setup' => $setup,
            'dtres' => $dtres,
            'nilai_bayar' => $nilai_bayar
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/reseller_view2', $data);
        $this->load->view('part/main_js');
    } else {
        $this->load->view('blok_view');
    }
    
} //end-cash-flow

function produksi(){
    $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
    $akses = $this->session->userdata('akses');
    if($akses=="Super"){
        $data = array(
            'title' => 'Management Produksi',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'setup' => $setup,
            'dist' => $this->data_model->get_record('data_produsen')
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/produksi_view', $data);
        $this->load->view('part/main_js');
    } else {
        $this->load->view('blok_view');
    }
    
} //end

function cashflow(){
    $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
    $akses = $this->session->userdata('akses');
    if($akses=="Super"){
        $data = array(
            'title' => 'Cash Flow',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'setup' => $setup,
            'cash' => $this->data_model->sort_record('tgl_waktu', 'flowcash')
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/cash_flow_view', $data);
        $this->load->view('part/main_js3');
    } else {
        $this->load->view('blok_view');
    }
} //end

function data_stok(){
    $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
    $akses = $this->session->userdata('akses');
    $produk = $this->db->query("SELECT codeunik,nama_produk FROM data_produk ORDER BY nama_produk");
    $produsen = $this->db->query("SELECT * FROM data_produsen ORDER BY nama_produsen");
    $uri = strtolower($this->uri->segment(2));
    if($uri=="gudang"){
        $showStokTipe = "Gudang";
    } else {
        $showStokTipe = "Toko";
    }
        $data = array(
            'title' => 'Management Data Stok '.$showStokTipe,
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'setup' => $setup,
            'produk' => $produk,
            'produsen' => $produsen,
            'showStok' => 'true',
            'autocomplet' => 'stokgudang',
            'showStokTipe' => $showStokTipe,
            'codeinput' => $this->data_model->acakKode(19)
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/stok_view', $data);
        $this->load->view('part/main_js2');
} //end

function data_kain(){
    $id = $this->uri->segment(2);
    $kode = $this->uri->segment(3);
    if($id == "id"){
        $show = "addnew";
    } else {
        if($id == "update"){ 
            $show = "update";
        } else {
            $show = "stok";
        }
    }
    $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
    $akses = $this->session->userdata('akses');
    $kode = $this->uri->segment(3);
    $drow2 = $this->data_model->get_byid('data_kain_masuk', ['codeinput'=>$kode])->row("id_kain");
    $kain = $this->db->query("SELECT * FROM data_kain ORDER BY nama_kain");
        $data = array(
            'title' => 'Management Data Kain',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'setup' => $setup,
            'produk' => $kain,
            'showStok' => 'kain',
            'drow2' => $drow2,
            'autocomplet' => 'addkain',
            'saldo' => $this->data_model->getSaldo()
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        if($show == "stok"){
            $this->load->view('datapage/stok_kain', $data);
        } elseif($show=="update"){
            $this->load->view('datapage/stok_kain_update', $data);
        } else {
            $this->load->view('datapage/stok_kain_add', $data);
        }
        $this->load->view('part/main_js');
} //end

    function riwayat_kain(){
        $uri = $this->uri->segment(2);
        if($uri == "masuk"){ 
            $input = "Kain Masuk";
            $record = $this->data_model->sort_record('tgl_masuk', 'data_kain_masuk');
        } elseif($uri == "pengiriman"){ 
            $input = "Kain Keluar"; 
            $record = $this->data_model->sort_record('tgl_kirim', 'data_kain_keluar');
        } else {
            $input = "null";
            $record = "null";
        }
        if($input == "null"){ redirect(base_url('data-kain')); }
        $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
        
        $data = array(
            'title' => 'Management Data Kain',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'setup' => $setup,
            'input' => $input,
            'record' => $record
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/stok_kain_riwayat', $data);
        $this->load->view('part/main_jsdtable');
    } //end

    function kirim_kain(){
        $uri = $this->uri->segment(4);
        $cek = $this->data_model->get_byid('data_kain_keluar', ['codeinput'=>$uri]);
        if($cek->num_rows() == 1){
            $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
            $data = array(
                'title' => 'Detail Pengiriman Kain Ke Konveksi',
                'sess_nama' => $this->session->userdata('nama'),
                'sess_id' => $this->session->userdata('id'),
                'sess_username' => $this->session->userdata('username'),
                'sess_password' => $this->session->userdata('password'),
                'sess_akses' => $this->session->userdata('akses'),
                'setup' => $setup,
                'autocomplet' => 'sendkain',
                'drow2' => $cek->row("id_kain"),
                'dts' => $cek->row_array()
            );
            $this->load->view('part/main_head', $data);
            $this->load->view('part/left_sidebar', $data);
            $this->load->view('datapage/pengiriman_kain', $data);
            $this->load->view('part/main_js');
        } else {
            $this->session->set_flashdata('gagal', 'ID Tidak ditemukan');
            redirect(base_url('data-kain/pengiriman'));
            //echo $uri;
        }
        
    } //end
    
}
?>