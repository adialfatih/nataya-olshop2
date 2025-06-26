<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mutasi extends CI_Controller
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
    function create_mutasi(){
        $uri1    = $this->uri->segment(2);
        $uri2    = $this->uri->segment(3);
        $uri     = $this->uri->segment(4);
        if($uri == ""){
            $codeProses = $this->data_model->acakKode(13);
            $dataProses = "null";
            $setup  = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
            $data   = array(
                'title' => 'Buat Mutasi Stok',
                'sess_nama' => $this->session->userdata('nama'),
                'sess_id' => $this->session->userdata('id'),
                'sess_username' => $this->session->userdata('username'),
                'sess_password' => $this->session->userdata('password'),
                'sess_akses' => $this->session->userdata('akses'),
                'setup' => $setup,
                'produk' => $this->data_model->getProduk(),
                'autocomplet' => 'mutasi',
                'codeProses' => $codeProses,
                'dataProses' => $dataProses
            );
            $this->load->view('part/main_head', $data);
            $this->load->view('part/left_sidebar', $data);
            $this->load->view('datapage/create_mutasi', $data);
            $this->load->view('part/main_jsmutasi', $data);
        } else {
            if($uri1 == "toko" && $uri2 == "gudang"){
                $cekUri = $this->data_model->get_byid('newtb_mutasi',['jenis_mutasi'=>'KirimGudang','codemutasi'=>$uri]);
                if($cekUri->num_rows() == 1){
                    $codeProses = $uri;
                    $dataProses = $cekUri->row_array();
                    $setup  = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
                    $data   = array(
                        'title' => 'Buat Mutasi Stok',
                        'sess_nama' => $this->session->userdata('nama'),
                        'sess_id' => $this->session->userdata('id'),
                        'sess_username' => $this->session->userdata('username'),
                        'sess_password' => $this->session->userdata('password'),
                        'sess_akses' => $this->session->userdata('akses'),
                        'setup' => $setup,
                        'produk' => $this->data_model->getProduk(),
                        'autocomplet' => 'mutasi',
                        'codeProses' => $codeProses,
                        'dataProses' => $dataProses
                    );
                    $this->load->view('part/main_head', $data);
                    $this->load->view('part/left_sidebar', $data);
                    $this->load->view('datapage/create_mutasi', $data);
                    $this->load->view('part/main_jsmutasi', $data);
                } 
                
            } else {
                if($uri1 == "gudang" && $uri2 == "toko"){
                    $cekUri = $this->data_model->get_byid('newtb_mutasi',['jenis_mutasi'=>'KirimToko','codemutasi'=>$uri]);
                    if($cekUri->num_rows() == 1){
                        $codeProses = $uri;
                        $dataProses = $cekUri->row_array();
                        $setup  = $this->data_model->get_byid('table_settings', ['id_setup'=>1])->row_array();
                        $data   = array(
                            'title' => 'Buat Mutasi Stok',
                            'sess_nama' => $this->session->userdata('nama'),
                            'sess_id' => $this->session->userdata('id'),
                            'sess_username' => $this->session->userdata('username'),
                            'sess_password' => $this->session->userdata('password'),
                            'sess_akses' => $this->session->userdata('akses'),
                            'setup' => $setup,
                            'produk' => $this->data_model->getProduk(),
                            'autocomplet' => 'mutasi',
                            'codeProses' => $codeProses,
                            'dataProses' => $dataProses
                        );
                        $this->load->view('part/main_head', $data);
                        $this->load->view('part/left_sidebar', $data);
                        $this->load->view('datapage/create_mutasi', $data);
                        $this->load->view('part/main_jsmutasi', $data);
                    } 
                } else {
                    $cekUri = 0;
                }
            }
            //$cekUri = $this->data_model->get_byid('newtb_mutasi',['codemutasi'=>$uri]);
            
        }
    } //end


    function simpanMutasi(){
        //"codeProses" : codeProses, "tgl" : tgl, "ctt" : ctt,  "asalKirim" : asalKirim, "nmProduk" : nmProduk, "model" : model, "ukr" : ukr, "jumlah" : jumlah
        $codeProses 	= $this->input->post('codeProses', TRUE);
        $tgl 		 	= $this->input->post('tgl', TRUE);
        $ctt 		 	= $this->input->post('ctt', TRUE);
        $asalKirim	 	= $this->input->post('asalKirim', TRUE);
        $nmProduk	 	= $this->input->post('nmProduk', TRUE);
        $model 		 	= $this->input->post('model', TRUE);
        $ukr 		 	= $this->input->post('ukr', TRUE);
        //$jumlah 		= $this->input->post('jumlah', TRUE);
        $jumlah         = (int) preg_replace('/[^0-9]/', '', $this->input->post('jumlah', TRUE));
        $cekKodeProses  = $this->data_model->get_byid('newtb_mutasi', ['codemutasi'=>$codeProses]);
        $txt1 = "";
        if($asalKirim == "toko"){ $jenis_mutasi="KirimGudang"; } else { $jenis_mutasi="KirimToko"; }
        if($cekKodeProses->num_rows() == 0){
            $this->data_model->saved('newtb_mutasi',[
                'jenis_mutasi'  => $jenis_mutasi,
                'tgl_mutasi'    => $tgl,
                'yginput'       => $this->session->userdata('username'),
                'tgl_input'     => date('Y-m-d H:i:s'),
                'codemutasi'    => $codeProses,
                'ket'           => $ctt,
            ]);
            $txt1 = "Menyimpan Mutasi ";
        } elseif($cekKodeProses->num_rows() == 1) {
            $this->data_model->updatedata('codemutasi', $codeProses, 'newtb_mutasi', [
                'tgl_mutasi'    => $tgl,
                'yginput'       => $this->session->userdata('username'),
                'ket'           => $ctt,
            ]);
            $txt1 = "Update Data Mutasi ";
        }
        if($asalKirim == "toko"){
            $jumlahTersedia = $this->db->query("SELECT kode_bar1 FROM data_produk_stok WHERE kode_bar1 = '$ukr'")->num_rows();
            if($jumlah > 0 AND $jumlah <= $jumlahTersedia){
                $dataKirim = $this->db->query("SELECT * FROM data_produk_stok WHERE kode_bar1 = '$ukr' ORDER BY id_bar LIMIT $jumlah")->result();
                $code_send = $this->data_model->acakKode(13);
                foreach($dataKirim as $val){
                    $id_bar         = $val->id_bar;
                    $id_produk      = $val->id_produk;
                    $kode_bar1      = $val->kode_bar1;
                    $harga_produk   = $val->harga_produk;
                    $harga_jual     = $val->harga_jual;
                    $code_sha       = $val->code_sha;
                    $loc            = $val->loc;
                    $arrayData  = [
                        'id_produk'     => $id_produk,
                        'kode_bar1'     => $kode_bar1,
                        'harga_produk'  => $harga_produk,
                        'harga_jual'    => $harga_jual,
                        'code_sha'      => $code_sha,
                        'id_dis'        => 11,
                        'code_send'     => $code_send
                    ];
                    $this->data_model->saved('data_produk_stok_onagen', $arrayData);
                    $this->db->query("DELETE FROM data_produk_stok WHERE id_bar = '$id_bar'");
                }
                $this->data_model->saved('newtb_mutasi_data', [
                    'codemutasi'    => $codeProses,
                    'tipemutasi'    => $jenis_mutasi,
                    'datas'         => json_encode($arrayData),
                    'jmldatas'      => $jumlah,
                    'kodebar1'      => $kode_bar1,
                    'code_send'     => $code_send
                ]);
                echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil mengirim stok ke gudang", "psn2"=>$txt1));
            } else {
                echo json_encode(array("statusCode"=>300, "psn"=>"Jumlah stok tidak cukup"));
            }
        } else  {
            $jumlahTersedia = $this->db->query("SELECT kode_bar1 FROM data_produk_stok_onagen WHERE kode_bar1 = '$ukr' AND id_dis=11")->num_rows();
            if($jumlah > 0 AND $jumlah <= $jumlahTersedia){
                $dataKirim = $this->db->query("SELECT * FROM data_produk_stok_onagen WHERE kode_bar1 = '$ukr' AND id_dis=11 ORDER BY id_bar LIMIT $jumlah")->result();
                $code_send = $this->data_model->acakKode(13);
                foreach($dataKirim as $val){
                    $id_bar         = $val->id_bar;
                    $id_produk      = $val->id_produk;
                    $kode_bar1      = $val->kode_bar1;
                    $harga_produk   = $val->harga_produk;
                    $harga_jual     = $val->harga_jual;
                    $code_sha       = $val->code_sha;
                    $id_dis         = $val->id_dis;
                    $code_send      = $val->code_send;
                    $arrayData  = [
                        'id_produk'     => $id_produk,
                        'kode_bar1'     => $kode_bar1,
                        'harga_produk'  => $harga_produk,
                        'harga_jual'    => $harga_jual,
                        'code_sha'      => $code_sha,
                        'loc'           => 'Toko'
                    ];
                    $this->data_model->saved('data_produk_stok', $arrayData);
                    $this->db->query("DELETE FROM data_produk_stok_onagen WHERE id_bar = '$id_bar'");
                }
                $this->data_model->saved('newtb_mutasi_data', [
                    'codemutasi'    => $codeProses,
                    'tipemutasi'    => $jenis_mutasi,
                    'datas'         => json_encode($arrayData),
                    'jmldatas'      => $jumlah,
                    'kodebar1'      => $kode_bar1,
                    'code_send'     => $code_send
                ]);
                echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil mengirim stok ke toko", "psn2"=>$txt1));
            } else {
                echo json_encode(array("statusCode"=>300, "psn"=>"Jumlah stok tidak cukup"));
            }
        }
        
    }

    function loadBarangMutasi(){
        $codeProses = $this->input->post('codeProses');
        $data = $this->db->query("SELECT * FROM newtb_mutasi_data WHERE codemutasi = '$codeProses'");
        $no=1;
        if($data->num_rows() > 0){
        foreach($data->result() as $val){
            $thisID = $val->id_ntbmt;
            $kodebar = $val->kodebar1;
            $bar = $this->data_model->get_byid('data_produk_detil',['kode_bar1'=>$kodebar])->row_array();
            $jmldatas = number_format($val->jmldatas);
            
            ?>
            <tr>
                <td><?=$no;?></td>
                <td><?=$bar['nama_produk'];?></td>
                <td><?=$bar['warna_model'];?></td>
                <td><?=$bar['ukuran'];?></td>
                <td><?=$jmldatas;?></td>
                <td><a href="javascript:;" onclick="hapusBarangMutasi('<?=$thisID;?>')" style="color:red;">Hapus</a></td>
            </tr>
            <?php $no++;
        }
        } else {
            ?>
            <tr>
                <td colspan="5">Belum ada data...</td>
            </tr>
            <?php
        }
    }
    function loadBarangMutasi2(){
        $codeProses = $this->input->post('codeProses');
        $data = $this->db->query("SELECT * FROM newtb_mutasi_data WHERE codemutasi = '$codeProses'");
        $no=1;
        ?>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <td>No</td>
                <td>Produk</td>
                <td>Model</td>
                <td>Ukuran</td>
                <td>Jumlah</td>
            </tr></thead><tbody>
        <?php
        if($data->num_rows() > 0){
            foreach($data->result() as $val){
                $thisID = $val->id_ntbmt;
                $kodebar = $val->kodebar1;
                $bar = $this->data_model->get_byid('data_produk_detil',['kode_bar1'=>$kodebar])->row_array();
                $jmldatas = number_format($val->jmldatas);
                
                ?>
                <tr>
                    <td><?=$no;?></td>
                    <td><?=$bar['nama_produk'];?></td>
                    <td><?=$bar['warna_model'];?></td>
                    <td><?=$bar['ukuran'];?></td>
                    <td><?=$jmldatas;?></td>
                </tr>
                <?php $no++;
            }
        } else {
            ?>
            <tr>
                <td colspan="4">Belum ada data...</td>
            </tr>
            <?php
        }
        echo "</tbody></table>";
    }
    function kembalikanMutasi(){
        $id = $this->input->post('id');
        $cekData = $this->data_model->get_byid('newtb_mutasi_data',['id_ntbmt'=>$id]);
        if($cekData->num_rows() == 1){
            $dt = $cekData->row_array();
            $kode_bar1  = $dt['kodebar1'];
            $jumlah     = $dt['jmldatas'];
            $tipe       = $dt['tipemutasi'];
            if($tipe == "KirimGudang"){
                $dataKirim = $this->db->query("SELECT * FROM data_produk_stok_onagen WHERE kode_bar1 = '$kode_bar1' AND id_dis=11 ORDER BY id_bar LIMIT $jumlah")->result();
                $code_send = $this->data_model->acakKode(13);
                foreach($dataKirim as $val){
                    $id_bar         = $val->id_bar;
                    $id_produk      = $val->id_produk;
                    $kode_bar1      = $val->kode_bar1;
                    $harga_produk   = $val->harga_produk;
                    $harga_jual     = $val->harga_jual;
                    $code_sha       = $val->code_sha;
                    $id_dis         = $val->id_dis;
                    $code_send      = $val->code_send;
                    $arrayData  = [
                        'id_produk'     => $id_produk,
                        'kode_bar1'     => $kode_bar1,
                        'harga_produk'  => $harga_produk,
                        'harga_jual'    => $harga_jual,
                        'code_sha'      => $code_sha,
                        'loc'           => 'Toko'
                    ];
                    $this->data_model->saved('data_produk_stok', $arrayData);
                    $this->db->query("DELETE FROM data_produk_stok_onagen WHERE id_bar = '$id_bar'");
                }
            } else {
                $dataKirim = $this->db->query("SELECT * FROM data_produk_stok WHERE kode_bar1 = '$kode_bar1' ORDER BY id_bar LIMIT $jumlah")->result();
                $code_send = $this->data_model->acakKode(13);
                foreach($dataKirim as $val){
                    $id_bar         = $val->id_bar;
                    $id_produk      = $val->id_produk;
                    $kode_bar1      = $val->kode_bar1;
                    $harga_produk   = $val->harga_produk;
                    $harga_jual     = $val->harga_jual;
                    $code_sha       = $val->code_sha;
                    $loc            = $val->loc;
                    $arrayData  = [
                        'id_produk'     => $id_produk,
                        'kode_bar1'     => $kode_bar1,
                        'harga_produk'  => $harga_produk,
                        'harga_jual'    => $harga_jual,
                        'code_sha'      => $code_sha,
                        'id_dis'        => 11,
                        'code_send'     => $code_send
                    ];
                    $this->data_model->saved('data_produk_stok_onagen', $arrayData);
                    $this->db->query("DELETE FROM data_produk_stok WHERE id_bar = '$id_bar'");
                }
            }
            
        }
        if($cekData->num_rows() == 1){ $this->db->query("DELETE FROM newtb_mutasi_data WHERE id_ntbmt = '$id'"); }
        echo "Success";
    }
}
?>