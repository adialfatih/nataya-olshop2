<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('data_model');
        date_default_timezone_set("Asia/Jakarta");
        if($this->session->userdata('login_form') != "akses-as1563sd1679dsad8789asff53afhafaf670fa"){
            redirect(base_url("login"));
        }
    }
    function index(){
            echo 'Invalid token';
    } //end-
    function rekapSetoran(){
        $dates = $this->input->post('dates', TRUE);
        $nama1 = $this->input->post('nama', TRUE);
        $nama = strtoupper($nama1);
        $cekReseller = $this->data_model->get_byid('data_reseller', ['nama_reseller'=>$nama]);
        if($dates==""){
            $this->session->set_flashdata('gagal', 'Tanggal tidak boleh kosong');
            redirect(base_url('reseller'));
        } else {
            $x = explode(' - ', $dates);
            $x1 = explode('/', $x[0]);
            $x2 = explode('/', $x[1]);
            $tgl1 = $x1[2]."-".$x1[0]."-".$x1[1];
            $tgl2 = $x2[2]."-".$x2[0]."-".$x2[1];
            if($tgl1 == $tgl2){
                $rekapTipe = 1;
                $_tgl = date('d M Y', strtotime($tgl1));
                $textRekap = "Rekap setoran tanggal <strong>".$_tgl."</strong>";
                $queryRekap = "SELECT * FROM hutang_reseller_bayar WHERE tglbyr='$tgl1'";
            } else {
                $rekapTipe = 2;
                $_tgl = date('d M Y', strtotime($tgl1));
                $_tgl2 = date('d M Y', strtotime($tgl2));
                $textRekap = "Rekap setoran tanggal <strong>".$_tgl."</strong> s/d <strong>".$_tgl2."</strong>";
                $queryRekap = "SELECT * FROM hutang_reseller_bayar WHERE tglbyr BETWEEN '$tgl1' AND '$tgl2'";
            }
            if($nama!=""){
                if($cekReseller->num_rows() == 1){
                    $id_res = $cekReseller->row('id_res');
                    $textRekap .= " reseller atas nama <strong>".$nama."</strong>";
                    $queryRekap .= " AND id_res='$id_res'";
                } else {
                    $textRekap .= " semua reseller";
                    $notifs = "Nama reseller tidak ditemukan. Menampilkan data semua reseller";
                }
            } else {
                $textRekap .= " semua reseller";
            }
            //echo $textRekap."<br>".$notifs."<br>".$queryRekap."";
            $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
            $data = array(
                'title' => 'Rekap Pengeluaran Produk',
                'sess_nama' => $this->session->userdata('nama'),
                'sess_id' => $this->session->userdata('id'),
                'sess_username' => $this->session->userdata('username'),
                'sess_password' => $this->session->userdata('password'),
                'sess_akses' => $this->session->userdata('akses'),
                'queryRekap' => $queryRekap,
                'daterange' => 'one',
                'nama' => $nama,
                'tgl1' => $tgl1,
                'tgl2' => $tgl2,
                'textRekap' => $textRekap,
                'setup' => $setup,
                'notifs' => $notifs
            );
            $this->load->view('part/main_head', $data);
            $this->load->view('part/left_sidebar', $data);
            $this->load->view('datapage/data_setoran_rekap', $data);
            $this->load->view('part/main_jsdtable');
        }
    }
    function rekapPengeluaran(){
        $dates = $this->input->post('dates', TRUE);
        $tipejual = $this->input->post('tipejual', TRUE);
        $tipejual  = ucfirst($tipejual);
        $nama = $this->input->post('nama', TRUE);
        $nama = strtoupper($nama);
        if($dates!="" AND $tipejual!=""){
            //echo $dates."<br>";
            $x = explode(' - ', $dates);
            $x1 = explode('/', $x[0]);
            $x2 = explode('/', $x[1]);
            $tgl1 = $x1[2]."-".$x1[0]."-".$x1[1];
            $tgl2 = $x2[2]."-".$x2[0]."-".$x2[1];
            if($tgl1 == $tgl2){
                $rekapTipe = 1;
                $_tgl = date('d M Y', strtotime($tgl1));
                $textRekap = "Rekap penjualan tanggal <strong>".$_tgl."</strong>";
                $queryRekap = "SELECT * FROM v_pengeluaran WHERE tgl_out='$tgl1'";
            } else {
                $rekapTipe = 2;
                $_tgl = date('d M Y', strtotime($tgl1));
                $_tgl2 = date('d M Y', strtotime($tgl2));
                $textRekap = "Rekap penjualan tanggal <strong>".$_tgl."</strong> s/d <strong>".$_tgl2."</strong>";
                $queryRekap = "SELECT * FROM v_pengeluaran WHERE tgl_out BETWEEN '$tgl1' AND '$tgl2'";
            }
            if($tipejual!="All"){
                $queryRekap .= " AND tujuan='$tipejual'";
                $textRekap .= " Penjualan ke <strong>".$tipejual."</strong>";
            }
            if($nama==""){} else { 
                $queryRekap .= " AND nama_tujuan='$nama'";
                $textRekap .= " Atas Nama <strong>".$nama."</strong>"; 
            }
            //echo $queryRekap."<br>".$textRekap;
            $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
            $data = array(
                'title' => 'Rekap Pengeluaran Produk',
                'sess_nama' => $this->session->userdata('nama'),
                'sess_id' => $this->session->userdata('id'),
                'sess_username' => $this->session->userdata('username'),
                'sess_password' => $this->session->userdata('password'),
                'sess_akses' => $this->session->userdata('akses'),
                'queryRekap' => $queryRekap,
                'daterange' => 'one',
                'rekapTipe' => $rekapTipe,
                'tipejual' => $tipejual,
                'nama' => $nama,
                'tgl1' => $tgl1,
                'tgl2' => $tgl2,
                'textRekap' => $textRekap,
                'setup' => $setup
            );
            $this->load->view('part/main_head', $data);
            $this->load->view('part/left_sidebar', $data);
            $this->load->view('datapage/data_keluar_all_rekap', $data);
            $this->load->view('part/main_jsdtable');
        } else {
            echo "Error Rekap Data.. Anda tidak mengisi data dengan benar.!!";
        }
    }
    
    function keluarall(){
        $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
        $data = array(
            'title' => 'Data Pengeluaran Produk',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'setup' => $setup,
            'daterange' => 'one',
            'showTable' => 'produkKeluar',
            'autocomplet' => 'produkKeluar'
        );
        //'inData' => $this->data_model->sort_record('tgl_out','stok_produk_keluar')
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/data_keluar_all', $data);
        $this->load->view('part/main_js4');
    } //end-keluarall-
    
    function masukall(){
        $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
        $data = array(
            'title' => 'Data Penerimaan Produk',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'setup' => $setup,
            'showTable' => 'produkMasuk',
            'autocomplet' => 'produkMasuk',
            'produsen' => $this->db->query("SELECT nama_produsen FROM data_produsen ORDER BY nama_produsen ASC")
        );
        //'inData' => $this->data_model->sort_record('tgl_masuk','data_produk_stok_masuk')
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/data_masuk_all', $data);
        $this->load->view('part/main_js4',$data);
    } //end-masukall
    
    function mutasiall(){
        $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
        $data = array(
            'title' => 'Data Mutasi Stok Produk',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'setup' => $setup,
            'showTable' => 'produkMutasi'
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/data_mutasi_all', $data);
        $this->load->view('part/main_jsdtable');
    } //end-mutasiall
    
    function send_customer(){
        $uri = $this->uri->segment(4);
        $cekuri = $this->data_model->get_byid('stok_produk_keluar', ['send_code'=>$uri]);
        if($cekuri->num_rows() == 1){
            $send_code1 = $cekuri->row_array();
        } else {
            $send_code1 = "null";
        }
        $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
        $data = array(
            'title' => 'Kirim Stok ke Customer',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'setup' => $setup,
            'send_code1' => $send_code1,
            'autocomplet' => 'oke'
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/send_customer', $data);
        $this->load->view('part/main_jsdtable2', $data);
    } //end
    
    function send_reseller(){
        $uri = $this->uri->segment(4);
        $tes = $this->data_model->get_byid('stok_produk_keluar', ['send_code'=>$uri]);
        if($tes->num_rows() == 1){
            $send_code = $tes;
        } else {
            $send_code = "null";
        }
        $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
        $data = array(
            'title' => 'Kirim Stok ke Reseller',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'send_code1' => $send_code,
            'autocomplet' => 'sendReseller',
            'kode_bar' => $this->data_model->showKodeProduk(),
            'reseller' => $this->db->query("SELECT id_res,nama_reseller FROM data_reseller ORDER BY nama_reseller ASC"),
            'setup' => $setup
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/send_reseller', $data);
        $this->load->view('part/main_jsdtable',$data);
    } //end

    function send_to_agen(){
        $uri = $this->uri->segment(4);
        $tes = $this->data_model->get_byid('stok_produk_keluar', ['send_code'=>$uri]);
        if($tes->num_rows() == 1){
            $send_code = $tes;
        } else {
            $send_code = "null";
        }
        $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
        $data = array(
            'title' => 'Kirim Stok ke Agen',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'send_code1' => $send_code,
            'autocomplet' => 'sendReseller',
            'kode_bar' => $this->data_model->showKodeProduk(),
            'reseller' => $this->db->query("SELECT id_dis,nama_distributor FROM data_distributor ORDER BY nama_distributor ASC"),
            'setup' => $setup
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/send_toagen', $data);
        $this->load->view('part/main_jsdtable2',$data);
    } //end send_to_agen

} //end of class