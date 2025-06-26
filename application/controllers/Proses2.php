<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proses2 extends CI_Controller
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
    function sendtoresellerupdate(){
        $nama_reseller = $this->input->post('namaReseller', TRUE);
        $idreseller = $this->data_model->get_byid('data_reseller', ['nama_reseller'=>$nama_reseller])->row("id_res");
        $tgl = $this->input->post('tglKirim', TRUE);
        $tgl_formated = $this->data_model->formatTanggalDb($tgl);
        $sendcode = $this->input->post('sendCode', TRUE);
        $tujuan = $this->input->post('tujuanKirim', TRUE);
        $status = $this->input->post('statusBayar', TRUE);
        $angkaHanya = $this->input->post('angkaBayar', TRUE);
        $angka = preg_replace('/\D/', '', $angkaHanya);
        $ket = $this->input->post('kete', TRUE);
        $ses_nama = $this->session->userdata('username');
        $detime = date('Y-m-d H:i:s');
        $x = $this->db->query("SELECT id_outstok,no_sj,send_code FROM stok_produk_keluar WHERE send_code='$sendcode' ORDER BY id_outstok DESC LIMIT 1")->row("no_sj");
        if($nama_reseller!="" && $tgl!="" && $sendcode!="" && $tujuan!="" && $status!="" && $angka!=""){
            $dtlist = [
                'tgl_out' => $tgl_formated,
                'status_lunas' => $status,
                'ket' => $ket
            ];
            $this->data_model->updatedata('send_code', $sendcode, 'stok_produk_keluar', $dtlist);
            if($status!="Lunas"){
                $this->db->query("DELETE FROM flowcash WHERE codeinput='$sendcode'");
                $cekhtg = $this->data_model->get_byid('hutang_reseller',['send_code'=>$sendcode]);
                if($cekhtg->num_rows() == 0){ 
                    $this->data_model->saved('hutang_reseller',['id_res'=>$idreseller,'tgl'=>$tgl_formated,'nominal_hutang'=>$angka,'send_code'=>$sendcode]); 
                } else {
                    $this->data_model->updatedata('send_code', $sendcode, 'hutang_reseller', ['nominal_hutang'=>$angka]);
                }
            } else {
                $this->db->query("DELETE FROM hutang_reseller WHERE send_code='$sendcode'");
                $cekflowcash = $this->data_model->get_byid('flowcash',['codeinput'=>$sendcode]);
                if($cekflowcash->num_rows() == 0){
                    $tx = "Pembayaran Reseller ".$nama_reseller." ".$x."";
                    $this->data_model->saved('flowcash',['alur'=>'in','jumlah'=>$angka,'tgl_waktu'=>date('Y-m-d H:i:s'),'ket'=>$tx,'codeinput'=>$sendcode]);
                } else {
                    $this->data_model->updatedata('codeinput',$sendcode,'flowcash',['jumlah'=>$angka]); 
                }
            }
            echo json_encode(array("statusCode"=>200, "psn"=>"Data Kiriman Berhasil Diupdate!!"));
        } else {
            echo json_encode(array("statusCode"=>503, "psn"=>"Data Tidak Diupdate"));
        }
    }
    function sendtoreseller(){
        $idreseller = $this->input->post('namaReseller', TRUE);
        $tgl = $this->input->post('tglKirim', TRUE);
        $tgl_formated = $this->data_model->formatTanggalDb($tgl);
        $sendcode = $this->input->post('sendCode', TRUE);
        $x = $this->db->query("SELECT id_outstok,no_sj,tujuan FROM stok_produk_keluar WHERE tujuan='Reseller' ORDER BY id_outstok DESC LIMIT 1");
        if($x->num_rows()==1){
            $no_sj = $x->row('no_sj');
            $xx = explode('ES',$no_sj);
            $num = $xx[1];
            $num2 = intval($num) + 1;
            $num3 = sprintf('%03s', $num2);
            $sj_res = "RES".$num3;
        } else {
            $sj_res = "RES001";
        }
        $tujuan = $this->input->post('tujuanKirim', TRUE);
        $status = $this->input->post('statusBayar', TRUE);
        $angkaHanya = $this->input->post('angkaBayar', TRUE);
        $angka = preg_replace('/\D/', '', $angkaHanya);
        $ket = $this->input->post('kete', TRUE);
        $ses_nama = $this->session->userdata('username');
        $detime = date('Y-m-d H:i:s');
        if($idreseller!="" && $tgl!="" && $sendcode!="" && $tujuan!="" && $status!="" && $angka!=""){
            $cek_reseller = $this->data_model->get_byid('data_reseller', ['id_res'=>$idreseller]);
            if($cek_reseller->num_rows()==1){
                $nama_reseller = strtoupper($cek_reseller->row('nama_reseller'));
                $cek_sendCode = $this->data_model->get_byid('stok_produk_keluar', ['send_code'=>$sendcode]);
                if($cek_sendCode->num_rows()==0){
                    $dtlist = [
                        'user_name' => $ses_nama,
                        'no_sj' => $sj_res,
                        'nama_tujuan' => $nama_reseller,
                        'tgl_out' => $tgl_formated,
                        'tgl_input' => $detime,
                        'tujuan' => $tujuan,
                        'send_code' => $sendcode,
                        'status_lunas' => $status,
                        'nilai_tagihan' => $angka,
                        'status_kirim' => 'kirim',
                        'ket' => $ket
                    ];
                    $this->data_model->saved('stok_produk_keluar', $dtlist);
                    if($status!="Lunas"){
                        $cekhtg = $this->data_model->get_byid('hutang_reseller',['send_code'=>$sendcode]);
                        if($cekhtg->num_rows() == 0){ $this->data_model->saved('hutang_reseller',['id_res'=>$idreseller,'tgl'=>$tgl_formated,'nominal_hutang'=>$angka,'send_code'=>$sendcode]); }
                    } else {
                        $tx = "Pembayaran Reseller ".$nama_reseller." ".$sj_res."";
                        $this->data_model->saved('flowcash',['alur'=>'in','jumlah'=>$angka,'tgl_waktu'=>date('Y-m-d H:i:s'),'ket'=>$tx,'codeinput'=>$sendcode]);
                    }
                    echo json_encode(array("statusCode"=>200, "psn"=>"Data Kiriman Berhasil Disimpan!!"));
                    
                } else {
                    $dtlist = [
                        'user_name' => $ses_nama,
                        'nama_tujuan' => $nama_reseller,
                        'tgl_out' => $tgl_formated,
                        'tujuan' => $tujuan,
                        'status_lunas' => $status,
                        'nilai_tagihan' => $angka,
                        'ket' => $ket
                    ];
                    $this->data_model->updatedata('send_code', $sendcode, 'stok_produk_keluar', $dtlist);
                    if($status!="Lunas"){
                        $this->db->query("DELETE FROM flowcash WHERE codeinput='$sendcode'");
                        $cekhtg = $this->data_model->get_byid('hutang_reseller',['send_code'=>$sendcode]);
                        if($cekhtg->num_rows() == 0){ 
                            $this->data_model->saved('hutang_reseller',['id_res'=>$idreseller,'tgl'=>$tgl_formated,'nominal_hutang'=>$angka,'send_code'=>$sendcode]); 
                        } else {
                            $this->data_model->updatedata('send_code', $sendcode, 'hutang_reseller', ['nominal_hutang'=>$angka]);
                        }
                    } else {
                        $this->db->query("DELETE FROM hutang_reseller WHERE send_code='$sendcode'");
                        $cekflowcash = $this->data_model->get_byid('flowcash',['codeinput'=>$sendcode]);
                        if($cekflowcash->num_rows() == 0){
                            $tx = "Pembayaran Reseller ".$nama_reseller." ".$sj_res."";
                            $this->data_model->saved('flowcash',['alur'=>'in','jumlah'=>$angka,'tgl_waktu'=>date('Y-m-d H:i:s'),'ket'=>$tx,'codeinput'=>$sendcode]);
                        } else {
                            $this->data_model->updatedata('codeinput',$sendcode,'flowcash',['jumlah'=>$angka]); 
                        }
                    }
                    echo json_encode(array("statusCode"=>200, "psn"=>"Data Kiriman Berhasil Diupdate!!"));
                }
            } else {
                echo json_encode(array("statusCode"=>503, "psn"=>"Nama Reseller Tidak Ditemukan!!"));
            }
        } else {
            echo json_encode(array("statusCode"=>503, "psn"=>"Anda tidak mengisi semua data dengan benar!!!"));
        }
    } //end function send reseller

    function cekkodeProduk(){
        $id = $this->input->post('id', TRUE);
        $cek = $this->data_model->get_byid('data_produk_detil', ['kode_bar'=>$id])->num_rows();
        if($cek == 0){
            echo json_encode(array("statusCode"=>503, "psn"=>"Kode tidak ditemukan!!"));
        } else {
            $cek = $this->db->query("SELECT * FROM data_produk_detil WHERE kode_bar = '$id' LIMIT 1")->row_array();
            $ukr = $this->data_model->get_byid('data_produk_detil', ['kode_bar'=>$id]);
            $ar_ukr = array();
            foreach($ukr->result_array() as $row){
                if(!in_array($row['ukuran'], $ar_ukr)){
                    $ar_ukr[] = $row['ukuran'];
                }
            }
            $produk = $cek['nama_produk'];
            $model = $cek['warna_model'];
            echo json_encode(array("statusCode"=>200, "produk"=>$produk, "model"=>$model,"ukr"=>$ar_ukr));
        }
    } //end function cekkodeProduk
    function cekkodeProduk2(){
        $id = $this->input->post('id', TRUE);
        $cek = $this->db->query("SELECT * FROM data_produk_detil WHERE nama_produk = '$id'")->num_rows();
        if($cek == 0){
            echo json_encode(array("statusCode"=>503, "psn"=>"Produk tidak ditemukan!!"));
        } else {
            $cek = $this->db->query("SELECT * FROM data_produk_detil WHERE nama_produk = ? GROUP BY warna_model", [$id]);
            $model = $cek->result();
            echo json_encode(array("statusCode"=>200, "produk"=>$id, "model"=>$model));
        }
    }
    function cekmodel2(){
        $kodebar = $this->input->post('kodebar', TRUE);
        $cek = $this->db->query("SELECT * FROM data_produk_detil WHERE kode_bar = ?", [$kodebar])->num_rows();
        if($cek == 0){
            echo json_encode(array("statusCode"=>503, "psn"=>"Model tidak ditemukan!!"));
        } else {
            $cek = $this->db->query("SELECT * FROM data_produk_detil WHERE kode_bar = ?", [$kodebar]);
            $model = $cek->result();
            echo json_encode(array("statusCode"=>200, "model2"=>$model));
        }
    }

    function cekmodelAndStok(){
        $kodebar   = $this->input->post('kodebar', TRUE);
        $ukr       = $this->input->post('ukr', TRUE);
        $nmProduk  = $this->input->post('nmProduk', TRUE);
        $kodebar1  = $this->input->post('kodebar1', TRUE);
        $asalKirim = $this->input->post('asalKirim', TRUE);
        if($asalKirim == "toko"){
            $cekStok = $this->data_model->get_byid('data_produk_stok', ['kode_bar1'=>$ukr])->num_rows();
            if($cekStok > 0){
                $vartxt = "Stok di toko : <strong>".$cekStok."</strong> Pcs";
                echo json_encode(array("statusCode"=>200, "psn"=>$vartxt));
            } else {
                echo json_encode(array("statusCode"=>500, "psn"=>"Stok Tidak ditemukan di Toko"));
            }
        } else {
            if($asalKirim=="gudang"){
                $cekStok = $this->data_model->get_byid('data_produk_stok_onagen', ['kode_bar1'=>$ukr,'id_dis'=>11])->num_rows();
                if($cekStok > 0){
                    $vartxt = "Stok di gudang : <strong>".$cekStok."</strong> Pcs";
                    echo json_encode(array("statusCode"=>200, "psn"=>$vartxt));
                } else {
                    echo json_encode(array("statusCode"=>500, "psn"=>"Stok Tidak ditemukan di Gudang"));
                }
            } else {
                //jika tidak dikrim dari toko/gudang
                echo json_encode(array("statusCode"=>500, "psn"=>"Error : 233"));
            }
        }
    }
    function carijumlahstok(){
        $id = $this->input->post('id', TRUE);
        $jumlah = $this->data_model->get_byid('data_produk_stok', ['kode_bar1'=>$id])->num_rows();
        echo json_encode(array("statusCode"=>200, "jumlah"=>$jumlah));
    }//end function carijumlahstok

    function tambahkanproduk(){
        $kodebar = $this->input->post('kodebar', TRUE);
        $ukuran = $this->input->post('ukuran', TRUE);
        $jumlahkirim = $this->input->post('jumlahkirim', TRUE);
        $sendCode = $this->input->post('sendCode', TRUE);
        if($kodebar!="" && $ukuran!="" && $jumlahkirim!="" && $sendCode!=""){
            $cekSendCode = $this->data_model->get_byid('stok_produk_keluar', ['send_code'=>$sendCode]);
            if($cekSendCode->num_rows() == 1){
                $kode_bar1 = $kodebar."-".$ukuran;
                $cekStok = $this->data_model->get_byid('data_produk_stok', ['kode_bar1'=>$kode_bar1]);
                if($cekStok->num_rows() > 0){
                    if(intval($cekStok->num_rows()) >= intval($jumlahkirim)){
                        $datakirim = $this->db->query("SELECT * FROM data_produk_stok WHERE kode_bar1 = '$kode_bar1' ORDER BY id_bar LIMIT $jumlahkirim")->result();
                        foreach($datakirim as $val){
                            $id_bar = $val->id_bar;
                            $id_produk = $val->id_produk;
                            $kode_bar1 = $val->kode_bar1;
                            $harga_produk = $val->harga_produk;
                            $harga_jual = $val->harga_jual;
                            $code_sha = $val->code_sha;
                            $this->data_model->saved('stok_produk_keluar_barang',['send_code'=>$sendCode,'id_bar'=>$id_bar,'id_produk'=>$id_produk,'kode_bar1'=>$kode_bar1,'harga_produk'=>$harga_produk,'harga_jual'=>$harga_jual,'code_sha'=>$code_sha]);
                            $this->db->query("DELETE FROM data_produk_stok WHERE id_bar = '$id_bar'");
                        }
                        $nilai_tagihan = $this->db->query("SELECT SUM(harga_jual) AS nilai_tagihan FROM stok_produk_keluar_barang WHERE send_code = '$sendCode'")->row("nilai_tagihan");
                        $this->db->query("UPDATE stok_produk_keluar SET nilai_tagihan = '$nilai_tagihan' WHERE send_code = '$sendCode'");
                        echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil Menambahkan Produk"));
                    } else {
                        echo json_encode(array("statusCode"=>503, "psn"=>"Anda mengirim melebihi jumlah stok yang tersedia."));
                    }
                } else {
                    echo json_encode(array("statusCode"=>503, "psn"=>"Stok Telah Habis!!!"));
                }
            } else {
                echo json_encode(array("statusCode"=>503, "psn"=>"Kode pengiriman tidak ditemukan!!!"));
            }
        } else {
            echo json_encode(array("statusCode"=>503, "psn"=>"Anda tidak mengisi semua data dengan benar!!!"));
        }
    } //end function tambahkanproduk
    function loadtablekirim2(){
        $id = $this->input->post('id', TRUE);
        $ft = $this->data_model->get_byid('stok_produk_keluar', ['send_code'=>$id])->row_array();
        $lunas_tidak = $ft['status_lunas'];
        $sj = $ft['no_sj'];
        $tujuan = $ft['tujuan'];
        $nm = $ft['nama_tujuan'];
        $tgl_out = $ft['tgl_out'];
        $xt = "Pembayaran ".$tujuan.". Nomor Surat Jalan ($sj)";
        $nilai_tagihan = $this->db->query("SELECT SUM(harga_jual) AS nilai_tagihan FROM stok_produk_keluar_barang WHERE send_code = '$id'")->row("nilai_tagihan");
        $this->db->query("UPDATE stok_produk_keluar SET nilai_tagihan = '$nilai_tagihan' WHERE send_code = '$id'");
        $this->db->query("DELETE FROM flowcash WHERE codeinput = '$id'");
        if($tujuan=="Reseller"){
            $this->db->query("DELETE FROM hutang_reseller WHERE send_code = '$id'");
            $cekid = $this->data_model->get_byid('data_reseller', ['UPPER(nama_reseller)'=>$nm])->row("id_res");
        } else {
            $this->db->query("DELETE FROM hutang_agen WHERE send_code = '$id'");
            $cekid = $this->data_model->get_byid('data_distributor', ['UPPER(nama_distributor)'=>$nm])->row("id_dis");
        }
        if($lunas_tidak == "Lunas"){
            if($nilai_tagihan > 0){ 
                $this->data_model->saved('flowcash', 
                    ['alur'=>'in','jumlah'=>$nilai_tagihan,'tgl_waktu'=>date('Y-m-d H:i:s'),'ket'=>$xt,'codeinput'=>$id,]
                );
            }
        } else {
            if($tujuan=="Reseller"){
                $this->data_model->saved('hutang_reseller', ['id_res'=>$cekid,'tgl'=>$tgl_out,'nominal_hutang'=>$nilai_tagihan,'send_code'=>$id]);
            } else {
                $this->data_model->saved('hutang_agen', ['id_dis'=>$cekid,'tgl'=>$tgl_out,'nominal_hutang'=>$nilai_tagihan,'send_code'=>$id]);
            }
        }
        $nilai_tagihan = number_format($nilai_tagihan,0,',','.');
        echo json_encode(array("statusCode"=>200, "psn"=>$nilai_tagihan));
    }
    function loadtablekirim(){
        $id = $this->input->post('id', TRUE);
        $tes = $this->input->post('tes', TRUE);
        $cek = $this->data_model->get_byid('stok_produk_keluar_barang', ['send_code'=>$id]);
        if($cek->num_rows() > 0){
            $kode_bar1 = $this->db->query("SELECT * FROM stok_produk_keluar_barang WHERE send_code = '$id' GROUP BY kode_bar1")->result();
            if($tes=="oke"){} else {
            ?>
            <br>
            <span>Data Pengiriman Produk : </span>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Produk</th>
                        <th>Jumlah Kirim</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                        <th>Hapus</th>
                    </tr>
                </thead><tbody>
            <?php }
            $no=1;
            foreach($kode_bar1 as $val){
                $idid = $val->kode_bar1."".$id;
                $jmlkirim = $this->db->query("SELECT * FROM stok_produk_keluar_barang WHERE send_code = '$id' AND kode_bar1 = '$val->kode_bar1'")->num_rows();
                $harga = $this->db->query("SELECT SUM(harga_jual) AS jml FROM stok_produk_keluar_barang WHERE send_code = '$id' AND kode_bar1 = '$val->kode_bar1'")->row("jml");
                $harga1an = $this->db->query("SELECT * FROM stok_produk_keluar_barang WHERE send_code = '$id' AND kode_bar1 = '$val->kode_bar1' LIMIT 1")->row("harga_jual");
                $produks = $this->db->query("SELECT nama_produk,warna_model,kode_bar1 FROM data_produk_detil WHERE kode_bar1 = '$val->kode_bar1'")->row_array();
                ?><tr id="s<?=$idid;?>"><?php
                echo "<td>".$no++."</td>";
                echo "<td>".$val->kode_bar1."</td>";
                echo "<td>".$produks['nama_produk'].", ".$produks['warna_model']."</td>";
                echo "<td>".$jmlkirim."</td>";
                echo "<td>Rp.".number_format($harga1an, 0, ",", ".")."</td>";
                echo "<td>Rp.".number_format($harga, 0, ",", ".")."</td>";
                ?><td><a href="javascript:void(0)" onclick="hapust('<?=$val->kode_bar1;?>','<?=$id;?>')"><i class='fa fa-trash text-danger'></i></a></td><?php
                //echo "<td><a href='javascript:void(0)'><i class='fa fa-trash text-danger'></i></a></td>";
                echo "</tr>";
            }
            if($tes=="oke"){} else {
            echo "</tbody></table>"; }
        } else {
            echo "";
        }
    } //end function loadtablekirim
    function delproduksend(){
        $sendCode = $this->input->post('sendcode', TRUE);
        $cus = $this->input->post('cus', TRUE);
        $kode_bar1 = $this->input->post('kode_bar1', TRUE);
        $dt = $this->data_model->get_byid('stok_produk_keluar', ['send_code'=>$sendCode])->row_array();
        $ke = $dt['tujuan'];
        $allbrg = $this->data_model->get_byid('stok_produk_keluar_barang', ['send_code'=>$sendCode,'kode_bar1'=>$kode_bar1])->result();
        foreach($allbrg as $val){
            $id_bar = $val->id_bar;
            $id_produk = $val->id_produk;
            $kode_bar1 = $val->kode_bar1;
            $harga_produk = $val->harga_produk;
            $harga_jual = $val->harga_jual;
            $code_sha = $val->code_sha;
            $this->data_model->saved('data_produk_stok', [
                
                'id_produk' => $id_produk,
                'kode_bar1' => $kode_bar1,
                'harga_produk' => $harga_produk,
                'harga_jual' => $harga_jual,
                'code_sha' => $code_sha
            ]);
        }
        $this->db->query("DELETE FROM stok_produk_keluar_barang WHERE send_code = '$sendCode' AND kode_bar1 = '$kode_bar1'");
        if($cus=="yes"){
            $allHarga = $this->db->query("SELECT SUM(harga_jual) AS nilai_tagihan FROM stok_produk_keluar_barang WHERE send_code = '$sendCode'")->row("nilai_tagihan");
            $this->data_model->updatedata('codeinput', $sendCode, 'flowcash', ['jumlah' => $allHarga]);
        }
        if($ke == "Agen"){
            $this->db->query("DELETE FROM data_produk_stok_onagen WHERE kode_bar1 = '$kode_bar1' AND code_send='$sendCode'");
        }
        echo "success";
    } //end
    function sendtoagen2(){
        $namaAgen = $this->input->post('namaAgen', TRUE);
        $namaAgen = strtoupper($namaAgen);
        $tgl = $this->input->post('tglKirim', TRUE);
        $tgl_formated = $this->data_model->formatTanggalDb($tgl);
        $sendCode = $this->input->post('sendCode', TRUE);
        $tujuanKirim = $this->input->post('tujuanKirim', TRUE);
        $statusBayar = $this->input->post('statusBayar', TRUE);
        $angkaBayar = $this->input->post('angkaBayar', TRUE);
        $kete = $this->input->post('kete', TRUE);
        $kodebarang = $this->input->post('kodebarang', TRUE);
        $kirimProduk = $this->input->post('kirimProduk', TRUE);
        $cekDistributor = $this->data_model->get_byid('data_distributor', ['nama_distributor'=>$namaAgen1]);
        $idAgen = $cekDistributor->row("id_dis");
        $disnama = $cekDistributor->row("nama_distributor");
        $disnama = strtoupper($disnama);
        $this->data_model->updatedata('send_code',$sendcode,'stok_produk_keluar', ['nama_tujuan' => $disnama, 'tgl_out' => $tgl_formated, 'status_lunas' => $statusBayar, 'ket' => $ket]);
        echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil menyimpan data!!"));
    }

    function sendtocustomer(){
        $customer = $this->input->post('namaCustomer', TRUE);
        $customer = strtoupper($customer);
        $tgl = $this->input->post('tglKirim', TRUE);
        $tgl_formated = $this->data_model->formatTanggalDb($tgl);
        $sendcode = $this->input->post('sendCode', TRUE);
        $x = $this->db->query("SELECT id_outstok,no_sj,tujuan FROM stok_produk_keluar WHERE tujuan='Customer' ORDER BY id_outstok DESC LIMIT 1");
        if($x->num_rows()==1){
            $no_sj = $x->row('no_sj');
            $xx = explode('L',$no_sj);
            $num = $xx[1];
            $num2 = intval($num) + 1;
            $num3 = sprintf('%04s', $num2);
            $sj_res = "SL".$num3;
        } else {
            $sj_res = "SL0001";
        }
        $tujuan = "Customer";
        $status = "Lunas";
        $angkaHanya = $this->input->post('angkaBayar', TRUE);
        $cariProduk = $this->input->post('cariProduk', TRUE);
        $jumlahProdukKirim = $this->input->post('jumlahProdukKirim', TRUE);
        $jumlahkirim = preg_replace('/\D/', '', $jumlahProdukKirim);
        $angka = preg_replace('/\D/', '', $angkaHanya);
        $ket = $this->input->post('kete', TRUE);
        $ses_nama = $this->session->userdata('username');
        $detime = date('Y-m-d H:i:s');
        if($customer!="" && $tgl!="" && $sendcode!="" && $cariProduk!="" && $jumlahProdukKirim!=""){
            $cekCariProduk = $this->data_model->get_byid('data_produk_stok', ['kode_bar1'=>$cariProduk])->num_rows();
            if($cekCariProduk > 0){
                if($jumlahkirim > 0 AND $jumlahkirim <= $cekCariProduk){
                    $cekSendCode = $this->data_model->get_byid('stok_produk_keluar', ['send_code'=>$sendcode]);
                    if($cekSendCode->num_rows() == 0){
                        $dtlist = ['user_name' => $ses_nama,'no_sj' => $sj_res,'nama_tujuan' => $customer,'tgl_out' => $tgl_formated,'tgl_input' => $detime,'tujuan' => $tujuan,'send_code' => $sendcode,'status_lunas' => $status,'nilai_tagihan' => $angka,'status_kirim' => 'kirim','ket' => $ket
                        ];
                        $this->data_model->saved('stok_produk_keluar', $dtlist);
                    } else {
                        $this->data_model->updatedata('send_code',$sendcode,'stok_produk_keluar', ['nama_tujuan' => $customer, 'tgl_out' => $tgl_formated, 'ket' => $ket]);
                    }
                    //kirim barang ke customer
                    $allproduk = $this->db->query("SELECT * FROM data_produk_stok WHERE kode_bar1='$cariProduk' ORDER BY id_bar LIMIT $jumlahkirim");
                    foreach ($allproduk->result() as $val) {
                        $id_bar = $val->id_bar;
                        $id_produk = $val->id_produk;
                        $kode_bar1 = $val->kode_bar1;
                        $harga_produk = $val->harga_produk;
                        $harga_jual = $val->harga_jual;
                        $code_sha = $val->code_sha;
                        $this->data_model->saved('stok_produk_keluar_barang',[
                            'send_code' => $sendcode,
                            'id_bar' => $id_bar,
                            'id_produk' => $id_produk,
                            'kode_bar1' => $kode_bar1,
                            'harga_produk' => $harga_produk,
                            'harga_jual' => $harga_jual,
                            'code_sha' => $code_sha
                        ]);
                    }
                    foreach($allproduk->result() as $value){
                        $id_bar = $value->id_bar;
                        $this->db->query("DELETE FROM data_produk_stok WHERE id_bar = '$id_bar'");
                    }
                    $allHarga = $this->db->query("SELECT SUM(harga_jual) AS nilai_tagihan FROM stok_produk_keluar_barang WHERE send_code = '$sendcode'")->row("nilai_tagihan");
                    $this->data_model->updatedata('send_code', $sendcode, 'stok_produk_keluar', ['nilai_tagihan' => $allHarga]);
                    
                    $allHarga2 = number_format($allHarga, 0, ',', '.');
                    $cekCashFlow = $this->data_model->get_byid('flowcash', ['codeinput'=>$sendcode]);
                    if($cekCashFlow->num_rows() == 0){
                        $tx = "Penjualan ".$sj_res."";
                        $this->data_model->saved('flowcash', ['alur'=>'in','jumlah'=>$allHarga,'tgl_waktu'=>$detime,'ket'=>$tx,'codeinput'=>$sendcode]);
                    } else {
                        $this->data_model->updatedata('codeinput', $sendcode, 'flowcash', ['jumlah'=>$allHarga]);
                    }
                    echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil menyimpan data!!", "nilai_tagihan"=>$allHarga2));
                } else {
                    $tx = "Minimal pengiriman adalah 1 dan maksimal adalah ".$cekCariProduk."!!";
                    echo json_encode(array("statusCode"=>503, "psn"=>$tx));
                }
            } else {
                $tx = "Produk ".$cariProduk." tidak ada di gudang/habis!!";
                echo json_encode(array("statusCode"=>503, "psn"=>$tx));
            }
        } else {
            echo json_encode(array("statusCode"=>503, "psn"=>"Anda tidak mengisi semua data dengan benar!!!"));
        }
    } //end-sendtocustomer

    function cekjmlstok(){
        $id = $this->input->post('id', TRUE);
        $produk = $this->db->query("SELECT * FROM data_produk_detil WHERE kode_bar1 = '$id' LIMIT 1")->row_array();
        $cek = $this->data_model->get_byid('data_produk_stok', ['kode_bar1'=>$id])->num_rows();
        if($cek > 0){
            echo json_encode(array("statusCode"=>200, "cek"=>$cek, "nm"=>$produk['nama_produk'], "mdl"=>$produk['warna_model'], "ukr"=>$produk['ukuran']));
        } else {
            echo json_encode(array("statusCode"=>404, "cek"=>$cek));
        }
        
    } //end cekjmlstok
    function sendtoagen(){
        $namaAgen1 = $this->input->post('namaAgen', TRUE);
        $namaAgen = strtoupper($namaAgen1);
        $tujuanKirim = $this->input->post('tujuanKirim', TRUE);
        $kodebarang = $this->input->post('kodebarang', TRUE);
        $kirimProduk = $this->input->post('kirimProduk', TRUE);
        $jumlahkirim = preg_replace('/\D/', '', $kirimProduk);

        //$idAgen = $this->input->post('idAgen', TRUE);
        $tgl = $this->input->post('tglKirim', TRUE);
        $tgl_formated = $this->data_model->formatTanggalDb($tgl);
        $sendcode = $this->input->post('sendCode', TRUE);
        $x = $this->db->query("SELECT id_outstok,no_sj,tujuan FROM stok_produk_keluar WHERE tujuan='Agen' ORDER BY id_outstok DESC LIMIT 1");
        if($x->num_rows()==1){
            $no_sj = $x->row('no_sj');
            $xx = explode('IS',$no_sj);
            $num = $xx[1];
            $num2 = intval($num) + 1;
            $num3 = sprintf('%04s', $num2);
            $sj_res = "DIS".$num3;
        } else {
            $sj_res = "DIS0001";
        }
        $tujuan = "Agen";
        $statusBayar = $this->input->post('statusBayar', TRUE);
        if($statusBayar=="Lunas"){$statusBayar="Lunas";}else{$statusBayar="Belum Lunas";};
        $angkaHanya = $this->input->post('angkaBayar', TRUE);
        $angkaBayar = preg_replace('/\D/', '', $angkaHanya);

        $ket = $this->input->post('kete', TRUE);
        $ses_nama = $this->session->userdata('username');
        $detime = date('Y-m-d H:i:s');
        if($namaAgen!="" AND $tgl!="" && $sendcode!="" && $kodebarang!="" && $jumlahkirim!=""){
            $cekDistributor = $this->data_model->get_byid('data_distributor', ['nama_distributor'=>$namaAgen1]);
            if($cekDistributor->num_rows() == 1){
                $idAgen = $cekDistributor->row("id_dis");
                $disnama = $cekDistributor->row("nama_distributor");
                $disnama = strtoupper($disnama);
                $cekCariProduk = $this->data_model->get_byid('data_produk_stok', ['kode_bar1'=>$kodebarang])->num_rows();
                if($cekCariProduk > 0){
                    if($jumlahkirim > 0 AND $jumlahkirim <= $cekCariProduk){
                        $cekSendCode = $this->data_model->get_byid('stok_produk_keluar', ['send_code'=>$sendcode]);
                        if($cekSendCode->num_rows() == 0){
                            $dtlist = ['user_name' => $ses_nama,'no_sj' => $sj_res,'nama_tujuan' => $disnama,'tgl_out' => $tgl_formated,'tgl_input' => $detime,'tujuan' => $tujuan,'send_code' => $sendcode,'status_lunas' => $statusBayar,'nilai_tagihan' => 0,'status_kirim' => 'kirim','ket' => $ket
                            ];
                            $this->data_model->saved('stok_produk_keluar', $dtlist);
                        } else {
                            $this->data_model->updatedata('send_code',$sendcode,'stok_produk_keluar', ['nama_tujuan' => $disnama, 'tgl_out' => $tgl_formated, 'status_lunas' => $statusBayar, 'ket' => $ket]);
                        }
                        // produk
                        $allproduk = $this->db->query("SELECT * FROM data_produk_stok WHERE kode_bar1='$kodebarang' ORDER BY id_bar LIMIT $jumlahkirim");
                        foreach ($allproduk->result() as $val) {
                            $id_bar = $val->id_bar;
                            $id_produk = $val->id_produk;
                            $kode_bar1 = $val->kode_bar1;
                            $harga_produk = $val->harga_produk;
                            $harga_jual = $val->harga_jual;
                            $code_sha = $val->code_sha;
                            $this->data_model->saved('data_produk_stok_onagen',[
                                
                                'id_produk' => $id_produk,
                                'kode_bar1' => $kode_bar1,
                                'harga_produk' => $harga_produk,
                                'harga_jual' => $harga_jual,
                                'code_sha' => $code_sha,
                                'id_dis' => $idAgen,
                                'code_send' => $sendcode
                            ]);
                            $this->data_model->saved('stok_produk_keluar_barang',[
                                'send_code' => $sendcode,
                                'id_bar' => $id_bar,
                                'id_produk' => $id_produk,
                                'kode_bar1' => $kode_bar1,
                                'harga_produk' => $harga_produk,
                                'harga_jual' => $harga_jual,
                                'code_sha' => $code_sha
                            ]);
                        }
                        foreach($allproduk->result() as $value){
                            $id_bar = $value->id_bar;
                            $this->db->query("DELETE FROM data_produk_stok WHERE id_bar = '$id_bar'");
                        }
                        //end produk
                        echo json_encode(array("statusCode"=>200, "psn"=>"oke"));
                    } else {
                        $tx = "Min pengiriman 1 dan maks ".$cekCariProduk."";
                        echo json_encode(array("statusCode"=>503, "psn"=>$tx));
                    }
                } else {
                    echo json_encode(array("statusCode"=>503, "psn"=>"Stok di gudang tidak tersedia!!"));
                }
            } else {
                echo json_encode(array("statusCode"=>503, "psn"=>"Distributor/Agen tidak ditemukan!!"));
            }
        } else {
            echo json_encode(array("statusCode"=>503, "psn"=>"Anda tidak mengisi semua data dengan benar!!"));
        }
        
    } //end

    function hapusKirimanRes(){
        $id = $this->input->post('id', TRUE);
        $cek = $this->data_model->get_byid('stok_produk_keluar_barang',['send_code'=>$id])->num_rows();
        if($cek > 0){
            echo json_encode(array("statusCode"=>503, "psn"=>"Anda harus menghapus semua barang yang di kirim terlebih dahulu!!!"));
        } else {
            $this->data_model->delete('stok_produk_keluar_barang', 'send_code' ,$id);
            $this->data_model->delete('stok_produk_keluar', 'send_code' ,$id);
            $this->data_model->delete('hutang_reseller', 'send_code' ,$id);
            echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil Menghapus Kiriman"));
        }
    } //end
    function lihatnominalsj(){
        $id = $this->input->post('id', TRUE);
        $cek = $this->data_model->get_byid('stok_produk_keluar', ['no_sj'=>$id])->row("nilai_tagihan");
        $nominal = number_format($cek,0,',','.');
        echo $nominal;
    }
    function savebayarresel(){
        $this->load->library('upload');
        $nmReseller = $this->input->post('nmReseller');
        $idReseller = $this->input->post('idReseller');
        //$sjBayar = $this->input->post('sjBayar');
        $tglinput = date('Y-m-d H:i:s');
        $tglBayar = $this->input->post('tglBayar');
        $jnsBayar = $this->input->post('jnsBayar');
        $jmlBayar = preg_replace('/[^0-9]/', '', $this->input->post('jmlBayar'));

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'png|jpg|jpeg';
        $config['max_size'] = 6048; // Batas ukuran file 2 MB
        $config['encrypt_name'] = TRUE; // Supaya nama file terenkripsi
        $config['file_ext_tolower'] = TRUE; // Ekstensi file menjadi huruf kecil
        // Inisiasi konfigurasi upload
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('upload')) {
            $error = array('error' => $this->upload->display_errors());
            $uploadan = "null";
        } else {
            // Jika upload berhasil, tampilkan data file
            $data = array('upload_data' => $this->upload->data());
            $uploadan = $data['upload_data']['file_name'];
        }
        $dtlist = [
            'id_res' => $idReseller,
            'tglbyr' => $tglBayar,
            'tglinput' => $tglinput,
            'nominal' => $jmlBayar,
            'buktibyr' => $uploadan,
            'ketbyr' => $jnsBayar,
            'sj'=> '0'
        ];
        $cek = $this->data_model->get_byid('hutang_reseller_bayar', $dtlist)->num_rows();
        if($cek==0){
            $this->data_model->saved('hutang_reseller_bayar', $dtlist);
            $idse = $this->data_model->get_byid('hutang_reseller_bayar', $dtlist)->row("id_byrres");
            $this->data_model->saved('flowcash', ['alur'=>'in','jumlah'=>$jmlBayar,'tgl_waktu'=>$tglinput,'ket'=>'Pembayaran Reseller','codeinput'=>$idse]);
            //$this->data_model->updatedata('no_sj',$sjBayar,'stok_produk_keluar', ['status_lunas'=>'Lunas']);
            $this->session->set_flashdata('sukses', 'Berhasil menyimpan data pembayaran atas nama '.$nmReseller.'');
            redirect(base_url('reseller'));
        } else {
            $this->session->set_flashdata('gagal', 'Gagal menyimpan pembayaran!!');
            redirect(base_url('reseller'));
        }
    } //end
    function lihatbayar(){
        $id = $this->input->post('id', TRUE);
        $name = $this->input->post('name', TRUE);
        $cek = $this->data_model->get_byid('hutang_reseller_bayar',['id_res'=>$id])->num_rows();
        if($cek > 0){
            ?>
            <table class="table table-bordered stripe hover nowrap">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal Bayar</th>
                        <th>Pembayaran</th>
                        <th>Nominal</th>
                        <th>Bukti</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
            <?php
                $cek = $this->db->query("SELECT * FROM hutang_reseller_bayar WHERE id_res = '$id' ORDER BY tglbyr DESC");
                $no=1;
                foreach($cek->result() as $val){
                    $printTgl = date('d M Y', strtotime($val->tglbyr));
                    $idbyrres = $val->id_byrres;
                    $x = "Pembayaran Reseller ".$name."";
            ?>
                    <tr>
                        <td><?=$no++;?></td>
                        <td><?=$printTgl;?></td>
                        <td><?=$val->ketbyr;?></td>
                        <td><?=number_format($val->nominal,0,',','.');?></td>
                        <td>
                            <?php if($val->buktibyr == "null"){ } else {
                                echo '<i class="icon-copy bi bi-images" style="color:blue;"></i>';
                            } ?>
                        </td>
                        <td>
                            <a href="javascript:void(0)" onclick="del('Pembayaran Reseller','<?=$idbyrres;?>','<?=$x;?>')" style="color:red;" title="Hapus pembayaran"><i class="icon-copy bi bi-trash"></i></a>
                        </td>
                    </tr>
            <?php
                }
            ?>
                </tbody>
            </table>
            <?php
        } else {
            echo "Tidak ada riwayat pembayaran ".$name."";
        }     
    } //end
    function lihatbayarSJ(){
        $id = $this->input->post('id', TRUE);
        $name = $this->input->post('name', TRUE);
        $cek = $this->db->query("SELECT * FROM stok_produk_keluar WHERE nama_tujuan='$name' AND status_lunas!='Lunas'");
        if($cek->num_rows() > 0){
            $sj = array();
            foreach($cek->result() as $val){
                $sj[] = $val->no_sj;
            }
            echo json_encode(array("statusCode"=>200, "psn"=>"yes", "sj"=>$sj));
        } else {
            echo json_encode(array("statusCode"=>200, "psn"=>"nosj", "sj"=>"no"));
        }
    } //end 
    function cekHarga(){
        $kode_bar1 = $this->input->post('id', TRUE);
        $harga_produk = $this->db->query("SELECT harga_produk,harga_jual FROM data_produk_stok WHERE kode_bar1 = '$kode_bar1' ORDER BY id_bar DESC LIMIT 1")->row('harga_produk');
        $harga_jual = $this->db->query("SELECT harga_produk,harga_jual FROM data_produk_stok WHERE kode_bar1 = '$kode_bar1' ORDER BY id_bar DESC LIMIT 1")->row('harga_jual');
	    $_hrg1 = number_format($harga_produk, 0, ',', '.');
	    $_hrg2 = number_format($harga_jual, 0, ',', '.');
        echo json_encode(array("statusCode"=>200, "psn"=>"yes", "harga_produk"=>$_hrg1, "harga_jual"=>$_hrg2));
    } //en
    function updateharga(){
        $kode_bar1 = $this->input->post('kode_bar1', TRUE);
        $harga_produksi2 = $this->input->post('harga_produksi', TRUE);
        $harga_jual2 = $this->input->post('harga_jual', TRUE);
        $codereal = $this->input->post('codereal', TRUE);
        $harga_produksi = preg_replace('/[^0-9]/', '', $harga_produksi2);
        $harga_jual = preg_replace('/[^0-9]/', '', $harga_jual2);
        $this->data_model->updatedata('kode_bar1', $kode_bar1, 'data_produk_stok', ['harga_produk'=>$harga_produksi,'harga_jual'=>$harga_jual]);
        $this->data_model->updatedata('kode_bar1', $kode_bar1, 'data_produk_detil', ['harga_produk'=>$harga_produksi,'harga_jual'=>$harga_jual]);
        redirect(base_url("product/".$codereal."/id/0"));
    }
    function cekModel(){
        $id = $this->input->post('kode', TRUE);
        $id = strtoupper($id);
        $cek = $this->data_model->get_byid('data_produk_detil',['kode_bar'=>$id]);
        if($cek->num_rows() == 0){
            echo json_encode(array("statusCode"=>500, "psn"=>"no"));
        } else {
            $cek = $this->db->query("SELECT * FROM data_produk_detil WHERE kode_bar='$id' LIMIT 1");
            $warna = $cek->row("warna_model");
            echo json_encode(array("statusCode"=>200, "warna"=>$warna));
        }
    } //end
    function tambahStok(){
        $id_produk = $this->input->post('id_produk', TRUE);
        $nama_produk = $this->data_model->get_byid('data_produk',['id_produk'=>$id_produk])->row("nama_produk");
        $ts = $this->db->query("SELECT * FROM data_produk_detil WHERE id_produk='$id_produk' LIMIT 1");
        $harga1 = $ts->row("harga_produk");
        $harga2 = $ts->row("harga_jual");
        if(intval($harga1) > 0){ } else { $harga1 = 0; }
        if(intval($harga2) > 0){ } else { $harga2 = 0; }
        $codeunik = $this->input->post('codeunik', TRUE);
        $kode_bar = $this->input->post('kode_bar', TRUE);
        $modelwarna = $this->input->post('modelwarna', TRUE);
        $ukuran = $this->input->post('ukuran', TRUE);
        $jumlah = $this->input->post('jumlah', TRUE);
        $j = intval($jumlah);
        if($codeunik!="" AND $kode_bar!="" AND $modelwarna!="" AND $ukuran!="" AND $jumlah!=""){
            if(intval($jumlah) > 0){
                $cek_kode = $this->data_model->get_byid('data_produk_detil',['kode_bar'=>$kode_bar,'warna_model'=>$modelwarna,'ukuran'=>$ukuran]);
                if($cek_kode->num_rows() == 0){
                    $this->data_model->saved('data_produk_detil',[
                        'nama_produk' => $nama_produk,
                        'warna_model' => $modelwarna,
                        'ukuran' => $ukuran,
                        'kode_bar' => $kode_bar,
                        'kode_bar1' => $kode_bar.'-'.$ukuran,
                        'id_produk' => $id_produk,
                        'harga_produk' => $harga1,
                        'harga_jual' => $harga2
                    ]);
                } else {
                    $cek = $this->db->query("SELECT * FROM data_produk_detil WHERE kode_bar='$kode_bar' LIMIT 1");
                    $warna = $cek->row("warna_model");
                }
                for ($i=0; $i < $j ; $i++) { 
                    $this->data_model->saved('data_produk_stok',[
                        'id_produk' => $id_produk,
                        'kode_bar1' => $kode_bar.'-'.$ukuran,
                        'harga_produk' => $harga1,
                        'harga_jual'=> $harga2,
                        'code_sha' => date('Y-m-d H:i:s')
                    ]);
                }
                $this->session->set_flashdata('sukses', 'Berhasil menambahkan produk '.$kode_bar.'-'.$ukuran.' sebanyak '.$j.' pcs');
                redirect(base_url('product/'.$codeunik.'/id/0'));
            } else {
                $this->session->set_flashdata('gagal', 'Gagal menyimpan. Jumlah minimal 1.!!');
                redirect(base_url('product/'.$codeunik.'/id/0'));
            }
        } else {
            $this->session->set_flashdata('gagal', 'Gagal menyimpan. Isi data dengan benar23.!!');
            redirect(base_url('product/'.$codeunik.'/id/0'));
        }
    }
}
?>