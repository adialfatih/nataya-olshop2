<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Data extends CI_Controller
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
    } //end
    function tagihan(){
        $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
        //$tgh = $this->data_model->sort_record('tgl_awal_tagihan','tagihan');
        $tgh2 = $this->db->query("SELECT DISTINCT nama_supplier FROM tagihan ORDER BY nama_supplier ASC");
        $data = array(
            'title' => 'Data Tagihan Pembayaran',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'setup' => $setup,
            'tgh' => $tgh2
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/tagihan_view', $data);
        $this->load->view('part/main_jsdtable');
    } //end
    function piutang(){
        $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
        //$tgh = $this->data_model->sort_record('id_htgp','hutang_produsen');
        $data = array(
            'title' => 'Data Piutang Konveksi/Produsen',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'setup' => $setup
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/piutang_view', $data);
        $this->load->view('part/main_jsdtable');
    } //end
    function piutangid(){
        $id = $this->uri->segment(3);
        $prod = $this->data_model->get_byid('data_produsen', ['sha1(id_produsen)'=>$id])->row_array();
        $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
        //$tgh = $this->data_model->sort_record('id_htgp','hutang_produsen');
        $data = array(
            'title' => 'Data Piutang Konveksi/Produsen',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'setup' => $setup,
            'prod' => $prod
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/piutang_viewid', $data);
        $this->load->view('part/main_jsdtable');
    } //end
    function tagihanid(){
        $id = $this->uri->segment(3);
        //echo $id;
        $nm = $this->data_model->safe_base64_decode($id);
        //echo "<br>".$nm;
        $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
        $tgh = $this->data_model->get_byid('tagihan', ['nama_supplier'=>$nm]);
        $data = array(
            'title' => 'Data Tagihan Pembayaran',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'setup' => $setup,
            'tgh' => $tgh,
            'nmnm' => $nm
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/tagihan_viewid', $data);
        $this->load->view('part/main_js');
    } //end
    function tagihanid2(){
        $id = $this->uri->segment(3);
        $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
        $tgh = $this->data_model->get_byid('tagihan', ['sha1(id_tagihan)'=>$id]);
        $data = array(
            'title' => 'Data Tagihan Pembayaran',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'setup' => $setup,
            'tgh' => $tgh
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/tagihan_viewid', $data);
        $this->load->view('part/main_js');
    } //end

    function redirect(){
        $uri = $this->uri->segment(2);
        $uri2 = $this->uri->segment(3);
        $txt = urldecode($uri2);
        if($txt == "PEMBAYARAN KAIN"){
            $codeinput = $this->data_model->get_byid('tagihan_bayar', ['codebayar'=>$uri])->row("codeinput");
            //echo $codeinput;
            $idtagihan = $this->data_model->get_byid('tagihan', ['codeinput'=>$codeinput])->row("id_tagihan");
            $nm = $this->data_model->get_byid('tagihan', ['codeinput'=>$codeinput])->row("nama_supplier");
            $shaid = sha1($idtagihan);
            //echo $shaid;
            redirect(base_url("tagihan/id/$nm"));
        } else {
            redirect(base_url("cash-flow"));
        }
    }
    function product_stok(){
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
        $this->load->view('datapage/data_produk_stok', $data);
        $this->load->view('part/main_jsdtable');
    }//end
    function product_stok2(){
        $id_kat = $this->uri->segment(3);
        $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
        $kat = $this->db->query("SELECT * FROM kategori_produk ORDER BY kategori ASC");
        $nama_kat = $this->db->query("SELECT * FROM kategori_produk WHERE id_kat='$id_kat'")->row("kategori");
        $produk = $this->db->query("SELECT * FROM data_produk WHERE id_kat='$id_kat' ORDER BY nama_produk ASC");
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
            'nama_kat' => strtolower($nama_kat),
            'codeuniq' => $this->data_model->acakKode(19)
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/data_produk_stok2', $data);
        $this->load->view('part/main_jsdtable');
    }//end

    function stokmasuk(){
        $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
        $akses = $this->session->userdata('akses');
        $uri = $this->uri->segment(3);
        $inData = $this->db->query("SELECT * FROM data_produk_stok_masuk WHERE codeinput='$uri'")->row_array();
        $inDatan = $this->db->query("SELECT * FROM data_produk_stok_masuk WHERE codeinput='$uri'")->num_rows();
        if($inDatan==0){
            redirect(base_url('produk/data-stok-in'));
        }
        $id_produsen = $inData['id_produsen'];
        $produsen = $this->db->query("SELECT * FROM data_produsen WHERE id_produsen='$id_produsen'")->row_array();
            $data = array(
                'title' => 'Management Data Stok',
                'sess_nama' => $this->session->userdata('nama'),
                'sess_id' => $this->session->userdata('id'),
                'sess_username' => $this->session->userdata('username'),
                'sess_password' => $this->session->userdata('password'),
                'sess_akses' => $this->session->userdata('akses'),
                'setup' => $setup,
                'indata' => $inData,
                'produsen' => $produsen,
                'autocomplet' => 'stokprodukmasuk',
                'uri' => $uri
            );
            $this->load->view('part/main_head', $data);
            $this->load->view('part/left_sidebar', $data);
            $this->load->view('datapage/stok_produk_masuk', $data);
            $this->load->view('part/main_js2');
    } //end
    function data_stok_in(){
        $setup = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
        $data = array(
            'title' => 'Management Data Stok',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'sess_akses' => $this->session->userdata('akses'),
            'setup' => $setup,
            'indata' => $this->data_model->sort_record('tgl_masuk','data_produk_stok_masuk'),
            'produsen' => 2,
            'autocomplet' => 'stokprodukmasuk',
            'uri' => $uri
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('datapage/stok_masuk_in', $data);
        $this->load->view('part/main_jsdtable');
    }

}
?>