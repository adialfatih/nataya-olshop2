<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reseller2 extends CI_Controller
{
  function __construct()
  {
      parent::__construct();
      $this->load->model('data_model');
      date_default_timezone_set("Asia/Jakarta");
      
  }
   
  function index(){ 
    $this->load->view('view_reseller_html');
  } //end
  function datas(){ 
    $this->load->view('view_reseller_html');
  } //end
  function cekRes2(){
        $ty = $this->data_model->get_record('stok_produk_keluar_barang');
        foreach($ty->result() as $val){
            $kode_bar1 = $val->kode_bar1;
            $id_spkb = $val->id_spkb;
            $h1 = $val->harga_jual;
            $_hpp = $this->db->query("SELECT * FROM data_produk_detil WHERE kode_bar1='$kode_bar1' LIMIT 1")->row("harga_produk");
            $_hjual = $this->db->query("SELECT * FROM data_produk_detil WHERE kode_bar1='$kode_bar1' LIMIT 1")->row("harga_jual");
            $this->data_model->updatedata('id_spkb',$id_spkb,'stok_produk_keluar_barang',['harga_produk'=>$_hpp,'harga_jual'=>$_hjual]);
            if($h1 == $_hjual){
                $ss = "";
            } else {
                $ss = "error";
            }
            echo $kode_bar1." - ".$h1." - ".$_hjual." $ss<br>";
        }
  }

  function loadData(){
    $uri = $this->uri->segment(3);
    $id_res = intval($uri) - 98761;
    $cek_res = $this->data_model->get_byid('data_reseller', ['sha1(id_res)'=>$uri]);
    if($cek_res->num_rows() == 1){
        $id_res2 = $cek_res->row('id_res');
        $nama_res = $cek_res->row('nama_reseller');
        $res = $cek_res->row('nama_reseller');
        $nilai_bayar = $this->db->query("SELECT SUM(nominal) AS jml FROM hutang_reseller_bayar WHERE id_res='$id_res2'")->row("jml");
        //$nilai_bayar = 20000000;
        $sisa_bayar = $nilai_bayar;
        $outstanding = 0;
        $data = array();
        $ary = $this->db->query("SELECT * FROM stok_produk_keluar WHERE nama_tujuan='$res' AND tujuan='Reseller' ORDER BY tgl_out");
        if($ary->num_rows() > 0){
            $no=1;
            foreach($ary->result() as $val){
                $id_outstok = $val->id_outstok;
                $view = $val->shide;
                $tgl = date('d M Y', strtotime($val->tgl_out));
                $nilai_tagihan = floatval($val->nilai_tagihan);
                if($sisa_bayar > 0){
                    if($sisa_bayar >= $nilai_tagihan){
                        $this->data_model->updatedata('id_outstok',$id_outstok,'stok_produk_keluar',['status_lunas'=>'Lunas']);
                        $_jmlBayar = number_format($nilai_tagihan,0,",",".");
                        $_jmlSisa = 0;
                        $outstanding = $outstanding + $_jmlSisa;
                        $_lunas = "<span class='badge badge-success'>Lunas</span>";
                        $_lunas2 = "Lunas";
                        $sisa_bayar = $sisa_bayar - $nilai_tagihan;
                    } else {
                        $this->data_model->updatedata('id_outstok',$id_outstok,'stok_produk_keluar',['status_lunas'=>'Belum Lunas']);
                        $_jmlBayar = number_format($sisa_bayar,0,",",".");
                        $_jmlSisa2 = $nilai_tagihan - $sisa_bayar;
                        $outstanding = $outstanding + $_jmlSisa2;
                        $_jmlSisa = number_format($_jmlSisa2,0,",",".");
                        $_lunas = "<span class='badge badge-danger'>Belum Lunas</span>";
                        $_lunas2 = "Belum Lunas";
                        $sisa_bayar = 0;
                    }
                } else {
                    $_jmlBayar = 0;
                    $_jmlSisa2 = $nilai_tagihan - $_jmlBayar;
                    $outstanding = $outstanding + $_jmlSisa2;
                    $_jmlSisa = number_format($_jmlSisa2,0,",",".");
                    $_lunas = "<span class='badge badge-danger'>Belum Lunas</span>";
                    $_lunas2 = "Belum Lunas";
                }
                // if($no!=1){ echo ","; }
                // echo "{ no: '".$no++."', nama: '".$val->nama_tujuan."', no_sj: '".$val->no_sj."', tgl: '".$tgl."', nilai_tagihan: '".number_format($val->nilai_tagihan,0,",",".")."', jml_bayar: '".$_jmlBayar."', jml_sisa: '".$_jmlSisa."', lunas: '".$_lunas2."' }";
                // echo "<br>";
                if($view=="view"){
                $data[] = [
                    "no" => $no++,
                    "nama" => $val->nama_tujuan,
                    "no_sj" => $val->no_sj,
                    "tgl" => $tgl,
                    "nilai_tagihan" => number_format($val->nilai_tagihan,0,",","."),
                    "jml_bayar" => $_jmlBayar,
                    "jml_sisa" => $_jmlSisa,
                    "lunas" => $_lunas2
                ];
                }
            }
            echo json_encode($data);
        } else {
            echo json_encode(array("statusCode"=>400, "psn"=>"232!"));
        }
    } else {
        echo json_encode(array("statusCode"=>400, "psn"=>"234"));
    }
  } //end

  function showAllSJ(){
        $id = $this->input->post('id', TRUE);
        $ceksj = $this->data_model->get_byid('stok_produk_keluar',['no_sj'=>$id]);
        if($ceksj->num_rows() == 1){
            $send_code = $ceksj->row("send_code");
            $qry = $this->data_model->get_byid('stok_produk_keluar_barang',['send_code'=>$send_code]);
            if($qry->num_rows() > 0){
                ?>
                <div style="width:100%;overflow: auto;white-space: nowrap;">
                Kiriman berdasarkan Surat Jalan <?=$id;?>
                <table border="1" style="width:100%;border:1px solid #000;border-collapse:collapse;">
                    <tr>
                        <th style="padding:8px;">No.</th>
                        <th style="padding:8px;">Produk</th>
                        <th style="padding:8px;">Jumlah Kirim</th>
                        <th style="padding:8px;">Harga</th>
                        <th style="padding:8px;">Total Harga</th>
                    </tr>
                    <?php 
                    $kodebar1 = array();
                    foreach($qry->result() as $tr){ 
                        if(in_array($tr->kode_bar1, $kodebar1)){} else { $kodebar1[]=$tr->kode_bar1; }
                    }
                    $no=1;
                    $_totalJumlahKirim = 0;
                    $_totalHarga = 0;
                    foreach($kodebar1 as $val){
                    $kode_bar1 = $val;
                    $sgte = $this->db->query("SELECT * FROM data_produk_detil WHERE kode_bar1='$val' LIMIT 1")->row_array();
                    $nama_produk = $sgte['nama_produk'];
                    $warna_model = $sgte['warna_model'];
                    $ukuran = $sgte['ukuran'];
                    $jml = $this->data_model->get_byid('stok_produk_keluar_barang',['send_code'=>$send_code,'kode_bar1'=>$val])->num_rows();
                    $hrg = $this->db->query("SELECT * FROM stok_produk_keluar_barang WHERE send_code='$send_code' AND kode_bar1='$val' LIMIT 1")->row("harga_jual");
                    $ttl_hrg = intval($jml) * floatval($hrg);
                    $_totalJumlahKirim += intval($jml);
                    $_totalHarga += $ttl_hrg;
                    ?>
                    <tr>
                        <td><?=$no++;?></td>
                        <td><?=$nama_produk.", ".$warna_model." (".$ukuran.")";?></td>
                        <td style="text-align:center;"><?=$jml;?></td>
                        <td style="text-align:center;"><?=number_format($hrg,0,',','.');?></td>
                        <td style="text-align:left;">Rp. <?=number_format($ttl_hrg,0,',','.');?></td>
                    </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td><strong>TOTAL</strong></td>
                        <td style="text-align:center;"><?=number_format($_totalJumlahKirim,0,',','.');?></td>
                        <td style="text-align:center;"></td>
                        <td>Rp. <?=number_format($_totalHarga,0,',','.');?></td>
                    </tr>
                </table>
                </div>
                <?php
                
            } else {
                echo "Tidak terdapat pengiriman pada Surat Jalan <strong>".$id."</strong>.";
            }
        } else {
            echo "Surat Jalan <strong>".$id."</strong> Tidak ditemukan atau sudah di hapus.!!";
        }
        
  }

}