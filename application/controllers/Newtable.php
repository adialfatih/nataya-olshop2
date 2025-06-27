<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newtable extends CI_Controller
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
   
  function index(){ }

function hargabarang(){
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
            'autocomplet' => 'true',
            'dist' => $this->data_model->get_record('data_produsen')
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('newpage/table_harga', $data);
        $this->load->view('part/main_jsnew');
    } else {
        $this->load->view('blok_view');
    }
    
} //end
function showmodel(){
    $id   = $this->input->post('id', TRUE);
    $cek  = $this->db->query("SELECT nama_produk,warna_model,kode_bar FROM data_produk_detil WHERE nama_produk='$id' GROUP BY warna_model")->result();
    echo json_encode($cek);
} //en
function tampilkanproduk(){
    $produk   = $this->input->post('produk', TRUE);
    $model    = $this->input->post('model', TRUE);
    if($produk!="" AND $model!=""){
        if($model == "all"){
        $cek  = $this->db->query("SELECT * FROM data_produk_detil WHERE nama_produk='$produk'")->result();
        } else {
        $cek  = $this->db->query("SELECT * FROM data_produk_detil WHERE nama_produk='$produk' AND kode_bar='$model'")->result(); }
        $no=1;
        foreach($cek as $val){
            $id2 = $val->kode_bar1;
            $idproduk = $val->id_produk;
            $cekid = $this->db->query("SELECT kode_bar1 FROM amaster_harga WHERE kode_bar1='$id2'")->num_rows();
            if($cekid == 0){
                $this->data_model->saved('amaster_harga',[
                    'id_produk' => $idproduk,
                    'kode_bar'  => $val->kode_bar,
                    'kode_bar1' => $id2,
                    'harga_hpp' => $val->harga_produk,
                    'harga_jual'=> $val->harga_jual
                ]);
                $harga_jual = $val->harga_jual;
                $harga_produk = $val->harga_produk;
            } else {
                $xx = $this->db->query("SELECT kode_bar1,harga_hpp,harga_jual FROM amaster_harga WHERE kode_bar1='$id2'")->row_array();
                $harga_jual = $xx['harga_jual'];
                $harga_produk = $xx['harga_hpp'];
            }
            echo '<tr>
                    <td>'.$no.'</td>
                    <td>'.$val->nama_produk.'</td>
                    <td>'.$val->warna_model.'</td>
                    <td>'.$val->ukuran.'</td>
                    <td>
                        <span class="harga-produk" 
                            data-id="'.$id2.'" 
                            data-tipe="produk" 
                            data-harga="'.$harga_produk.'">
                            Rp. '.number_format($harga_produk).'
                        </span>
                    </td>
                    <td>
                        <span class="harga-jual" 
                            data-id="'.$id2.'" 
                            data-tipe="jual" 
                            data-harga="'.$harga_jual.'">
                            Rp. '.number_format($harga_jual).'
                        </span>
                    </td>
                </tr>';
            $no++;
        }
        ?>
        <tr>
            <td colspan="6"><strong>Note :</strong><br>- Jika ada produk/model yang belum tampil di sini, pastikan anda menambahkan produk tersebut terlebih dahulu.<br>- Klik harga untuk mengupdate</td>
        </tr>
        <?php
    } else {
        echo '<tr>
                <td colspan="6">
                    Tidak ada produk yang bisa ditampilkan
                </td>
            </tr>';
    }
} //end

public function update_harga(){
    $id = $this->input->post('id');
    $tipe = $this->input->post('tipe'); // produk atau jual
    $harga = (int) $this->input->post('harga');

    if ($tipe == 'produk') {
        $this->db->where('kode_bar1', $id)->update('amaster_harga', ['harga_hpp' => $harga]);
    } else if ($tipe == 'jual') {
        $this->db->where('kode_bar1', $id)->update('amaster_harga', ['harga_jual' => $harga]);
    }

    echo json_encode(['status' => 'ok']);
}

}
?>