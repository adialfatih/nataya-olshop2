<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Showtable extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('data_model');
        date_default_timezone_set("Asia/Jakarta");
        // if($this->session->userdata('login_form') != "akses-as1563sd1679dsad8789asff53afhafaf670fa"){
        //     redirect(base_url("login"));
        // }
    }
    function index(){
            echo 'Invalid token';
    } //end-
    function showprodukmasuk(){
        $tgl = $this->input->post('tgl', TRUE);
        $nama = strtolower($this->input->post('nama', TRUE));
        if($tgl==""){$tgl="null";}
        if($nama==""){$nama="null";} else { 
            $nama1=$this->db->query("SELECT id_produsen,nama_produsen FROM data_produsen WHERE nama_produsen='$nama'");
            if($nama1->num_rows() == 1){
                $nama=$nama1->row('id_produsen');
            } else {
                $nama="null";
            }
        }
        $nowDte = date('Y-m-d');
        if($tgl=="null" AND $nama=="null"){
            $qry = "SELECT * FROM data_produk_stok_masuk ORDER BY idstok_in DESC LIMIT 200";
        } else {
            if($tgl=="null" AND $nama!="null"){
                $qry = "SELECT * FROM data_produk_stok_masuk WHERE tgl_masuk='$nowDte' AND id_produsen='$nama' ORDER BY idstok_in DESC";
            }
            if($tgl!="null" AND $nama=="null"){
                $qry = "SELECT * FROM data_produk_stok_masuk WHERE tgl_masuk='$tgl' ORDER BY idstok_in DESC";
            }
            if($tgl!="null" AND $nama!="null"){
                $qry = "SELECT * FROM data_produk_stok_masuk WHERE tgl_masuk='$tgl' AND id_produsen='$nama' ORDER BY idstok_in DESC";
            }
        }
        $inData = $this->db->query($qry);
        if($inData->num_rows()>0){
            $no=1;
            foreach($inData->result() as $val){ 
                $printTgl = date('d M Y', strtotime($val->tgl_masuk));
                $sendCode = $val->codeinput;
                $jml = $this->db->query("SELECT SUM(jumlah) AS jml FROM data_produk_stok_masuk_notes WHERE codeinput='$sendCode'")->row('jml');
                $idprodusen = $val->id_produsen;
                $nm_produsen = $this->data_model->get_byid('data_produsen', ['id_produsen'=>$idprodusen])->row('nama_produsen');
                ?>
                <tr>
                    <td><?=$no;?></td>
                    <td><?=strtoupper($val->suratjalan);?></td>
                    <td><?=$nm_produsen;?></td>
                    <td data-order="<?= date('Y-m-d', strtotime($val->tgl_masuk)); ?>"><?=$printTgl;?></td>
                    <td><?=number_format($jml,0,',','.');?></td>
                    <td data-order="<?=$val->total_nilai_barang;?>">Rp.<?=number_format($val->total_nilai_barang,0,',','.');?></td>
                    <td><?=strtoupper($val->yg_input);?></td>
                                        
                    <td>
                        <div class="dropdown">
							<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
								<i class="dw dw-more"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
								<a class="dropdown-item" href="<?=base_url('data-stok/masuk/');?><?=$sendCode;?>"><i class="dw dw-eye"></i> Lihat Selengkapnya</a>
								<a class="dropdown-item" href="#"><i class="bi bi-trash" style="color:red;"></i> Hapus Data</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php
                $no++;
            } //enf foreach
        } //end if 
    } //end menampilkan produk masuk
    function showprodukmasuk2(){
        $tgl = $this->input->post('tgl', TRUE);
        $nama = strtolower($this->input->post('nama', TRUE));
        $nama2 = ucwords($this->input->post('nama', TRUE));
        if($tgl==""){$tgl="null";}
        if($nama==""){$nama="null";} else { 
            $nama1=$this->db->query("SELECT id_produsen,nama_produsen FROM data_produsen WHERE nama_produsen='$nama'");
            if($nama1->num_rows() == 1){
                $nama=$nama1->row('id_produsen');
            } else {
                if($nama=="null"){$txt=="";} else {
                $txt = "<font style='color:red;'>".$nama2." tidak ditemukan.!</font>";}
                $nama="null";
            }
        }
        $nowDte = date('Y-m-d');
        if($tgl=="null" AND $nama=="null"){
            //$qry = "SELECT * FROM data_produk_stok_masuk WHERE tgl_masuk='$nowDte' ORDER BY idstok_in DESC";
            $txtnotif = "Menampilkan data masuk <strong>200</strong> record terakhir.";
        } else {
            if($tgl=="null" AND $nama!="null"){
                //$qry = "SELECT * FROM data_produk_stok_masuk WHERE tgl_masuk='$nowDte' AND id_produsen='$nama' ORDER BY idstok_in DESC";
                $txtnotif = "Menampilkan data masuk tanggal <strong>".date('d M Y', strtotime($nowDte))."</strong> dari produsen <strong>".$nama2."</strong> ".$txt;
            }
            if($tgl!="null" AND $nama=="null"){
                //$qry = "SELECT * FROM data_produk_stok_masuk WHERE tgl_masuk='$tgl' ORDER BY idstok_in DESC";
                $txtnotif = "Menampilkan data masuk tanggal <strong>".date('d M Y', strtotime($tgl))."</strong> ".$txt;
            }
            if($tgl!="null" AND $nama!="null"){
                //$qry = "SELECT * FROM data_produk_stok_masuk WHERE tgl_masuk='$tgl' AND id_produsen='$nama' ORDER BY idstok_in DESC";
                $txtnotif = "Menampilkan data masuk tanggal <strong>".date('d M Y', strtotime($tgl))."</strong> dari produsen <strong>".$nama2."</strong> ".$txt;
            }
        }
        echo "".$txtnotif;
    } //end menampilkan produk masuk
    
    function showprodukKeluar(){
        $tgl = $this->input->post('tgl', TRUE);
        $tipe = $this->input->post('tipe', TRUE);
        $nama = $this->input->post('nama', TRUE);
        if($nama==""){$nama="null";}
        if($tgl==""){$tgl="all";}
        $nowDte = date('Y-m-d');
        if($tgl=="null"){
            if($tipe=="null" AND $nama=="null"){
                $qry = "SELECT * FROM stok_produk_keluar ORDER BY id_outstok DESC LIMIT 200";
            } else {
                if($tipe=="null" AND $nama!="null"){
                    $qry = "SELECT * FROM stok_produk_keluar WHERE tgl_out='$nowDte' AND nama_tujuan LIKE '$nama' ORDER BY id_outstok DESC";
                }
                if($tipe!="null" AND $nama=="null"){
                    $qry = "SELECT * FROM stok_produk_keluar WHERE tgl_out='$nowDte' AND tujuan LIKE '$tipe' ORDER BY id_outstok DESC";
                }
                if($tipe!="null" AND $nama!="null"){
                    $qry = "SELECT * FROM stok_produk_keluar WHERE tgl_out='$nowDte' AND tujuan LIKE '$tipe' AND nama_tujuan LIKE '%$nama%' ORDER BY id_outstok DESC";
                }
            }
        } elseif($tgl=="all"){
            if($tipe=="null" AND $nama=="null"){
                $qry = "SELECT * FROM stok_produk_keluar WHERE ORDER BY id_outstok DESC DESC LIMIT 200";
            } else {
                if($tipe=="null" AND $nama!="null"){
                    $qry = "SELECT * FROM stok_produk_keluar WHERE nama_tujuan LIKE '$nama' ORDER BY id_outstok DESC LIMIT 200";
                }
                if($tipe!="null" AND $nama=="null"){
                    $qry = "SELECT * FROM stok_produk_keluar WHERE tujuan LIKE '$tipe' ORDER BY id_outstok DESC LIMIT 200";
                }
                if($tipe!="null" AND $nama!="null"){
                    $qry = "SELECT * FROM stok_produk_keluar WHERE tujuan LIKE '$tipe' AND nama_tujuan LIKE '%$nama%' ORDER BY id_outstok DESC LIMIT 200";
                }
            }
        } else {
            if($tipe=="null" AND $nama=="null"){
                $qry = "SELECT * FROM stok_produk_keluar WHERE tgl_out='$tgl' ORDER BY id_outstok DESC";
            } else {
                if($tipe=="null" AND $nama!="null"){
                    $qry = "SELECT * FROM stok_produk_keluar WHERE tgl_out='$tgl' AND nama_tujuan LIKE '$nama' ORDER BY id_outstok DESC";
                }
                if($tipe!="null" AND $nama=="null"){
                    $qry = "SELECT * FROM stok_produk_keluar WHERE tgl_out='$tgl' AND tujuan LIKE '$tipe' ORDER BY id_outstok DESC";
                }
                if($tipe!="null" AND $nama!="null"){
                    $qry = "SELECT * FROM stok_produk_keluar WHERE tgl_out='$tgl' AND tujuan LIKE '$tipe' AND nama_tujuan LIKE '%$nama%' ORDER BY id_outstok DESC";
                }
            }
        }
        $inData = $this->db->query($qry);
        if($inData->num_rows()>0){
            $no=1;
            foreach($inData->result() as $val){ 
                $printTgl = date('d M Y', strtotime($val->tgl_out));
                $sendCode = $val->send_code;
                $jml = $this->data_model->get_byid('stok_produk_keluar_barang', ['send_code'=>$sendCode])->num_rows();
                //$jml = $val->jumlah_barang;
                if($val->tujuan == "Reseller"){
                    $urltolink = "".base_url()."stok/kirim/reseller/".$sendCode."";
                } elseif($val->tujuan == "Agen"){
                    $urltolink = "".base_url()."stok/kirim/agen/".$sendCode."";
                } else {
                    $urltolink = "".base_url()."stok/kirim/customer/".$sendCode."";
                }
                ?>
                <tr>
                    <td><?=$val->no_sj;?></td>
                    <td><?=$val->tujuan;?></td>
                    <td><?=$val->nama_tujuan;?></td>
                    <td data-order="<?= date('Y-m-d', strtotime($val->tgl_out)); ?>"><?=$printTgl;?></td>
                    <td><?=number_format($jml,0,',','.');?></td>
                    <td data-order="<?=$val->nilai_tagihan;?>">Rp.<?=number_format($val->nilai_tagihan,0,',','.');?></td>
                    <td>
                        <?php if($val->status_lunas == 'Belum Lunas'){?>
                            <span class="badge badge-danger">Belum</span>
                        <?php } elseif($val->status_lunas == 'Lunas'){?>
                            <span class="badge badge-success">Lunas</span>    
                        <?php } ?>
                    </td>
                    <td>
                        <?php
                        if($val->status_kirim == "kirim"){
                            echo '<i class="icon-copy bi bi-check-circle-fill" style="color:#389c03;" title="Terkirim"></i>';
                        } else {
                            echo '<i class="icon-copy bi bi-bootstrap-reboot" style="color:#e30031;" title="Retur"></i>';
                        }
                        ?>
                    </td>
                    <td>
                        <div class="dropdown">
							<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
								<i class="dw dw-more"></i>
							</a>
						    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
								<a class="dropdown-item" href="<?=$urltolink;?>"><i class="dw dw-eye"></i> Lihat Selengkapnya</a>
								<a class="dropdown-item" href="#"><i class="bi bi-bootstrap-reboot"></i> Retur Barang</a>
							</div>
						</div>
                    </td>
                </tr>
                <?php
                $no++;
            } //enf foreach
        } //end if 
    } //end menampilkan produk keluar
    function showprodukKeluar2(){
        $tgl = $this->input->post('tgl', TRUE);
        $tipe = $this->input->post('tipe', TRUE);
        $nama = $this->input->post('nama', TRUE);
        $nowDte = date('Y-m-d');
        if($nama==""){$nama="null";}
        if($tgl==""){$tgl="all";}
        if($tgl=="null"){
            if($tipe=="null" AND $nama=="null"){
                $qry = "SELECT * FROM stok_produk_keluar WHERE tgl_out='$nowDte' ORDER BY id_outstok DESC";
                $txt = "Menampilkan data keluar <strong>200</strong> record terakhir.";
            } else {
                if($tipe=="null" AND $nama!="null"){
                    $qry = "SELECT * FROM stok_produk_keluar WHERE tgl_out='$nowDte' AND nama_tujuan LIKE '$nama' ORDER BY id_outstok DESC";
                    $txt = "Menampilkan data keluar tanggal <strong>".date('d M Y', strtotime(date('Y-m-d')))."</strong> pengiriman ke <strong>".$nama."</strong>";
                }
                if($tipe!="null" AND $nama=="null"){
                    $qry = "SELECT * FROM stok_produk_keluar WHERE tgl_out='$nowDte' AND tujuan LIKE '$tipe' ORDER BY id_outstok DESC";
                    $txt = "Menampilkan data keluar tanggal <strong>".date('d M Y', strtotime(date('Y-m-d')))."</strong> untuk tujuan <strong>".$tipe."</strong>";
                }
                if($tipe!="null" AND $nama!="null"){
                    $qry = "SELECT * FROM stok_produk_keluar WHERE tgl_out='$nowDte' AND tujuan LIKE '$tipe' AND nama_tujuan LIKE '%$nama%' ORDER BY id_outstok DESC";
                    $txt = "Menampilkan data keluar tanggal ".date('d M Y', strtotime(date('Y-m-d')))."</strong> untuk tujuan <strong>".$tipe."</strong> dan pengiriman ke <strong>".$nama."</strong>";
                }
            }
        } elseif($tgl=="all"){
            if($tipe=="null" AND $nama=="null"){
                $qry = "SELECT * FROM stok_produk_keluar WHERE ORDER BY id_outstok DESC DESC LIMIT 200";
                $txt = "Menampilkan data keluar <strong>200</strong> record terakhir.";
            } else {
                if($tipe=="null" AND $nama!="null"){
                    $qry = "SELECT * FROM stok_produk_keluar WHERE nama_tujuan LIKE '$nama' ORDER BY id_outstok DESC LIMIT 200";
                    $txt = "Menampilkan data keluar <strong>200</strong> record terakhir penerima ke <strong>".$nama."</strong>";
                }
                if($tipe!="null" AND $nama=="null"){
                    $qry = "SELECT * FROM stok_produk_keluar WHERE tujuan LIKE '$tipe' ORDER BY id_outstok DESC LIMIT 200";
                    $txt = "Menampilkan data keluar <strong>200</strong> record terakhir tujuan <strong>".$tipe."</strong>";
                }
                if($tipe!="null" AND $nama!="null"){
                    $qry = "SELECT * FROM stok_produk_keluar WHERE tujuan LIKE '$tipe' AND nama_tujuan LIKE '%$nama%' ORDER BY id_outstok DESC LIMIT 200";
                    $txt = "Menampilkan data keluar <strong>200</strong> record terakhir tujuan <strong>".$tipe."</strong> dan penerima <strong>".$nama."</strong>";
                }
            }
        } else {
            if($tipe=="null" AND $nama=="null"){
                $qry = "SELECT * FROM stok_produk_keluar WHERE tgl_out='$tgl' ORDER BY id_outstok DESC";
                $txt = "Menampilkan data keluar tanggal <strong>".date('d M Y', strtotime($tgl))."</strong>";
            } else {
                if($tipe=="null" AND $nama!="null"){
                    $qry = "SELECT * FROM stok_produk_keluar WHERE tgl_out='$tgl' AND nama_tujuan LIKE '$nama' ORDER BY id_outstok DESC";
                    $txt = "Menampilkan data keluar tanggal <strong>".date('d M Y', strtotime($tgl))."</strong> pengiriman ke <strong>".$nama."</strong>";
                }
                if($tipe!="null" AND $nama=="null"){
                    $qry = "SELECT * FROM stok_produk_keluar WHERE tgl_out='$tgl' AND tujuan LIKE '$tipe' ORDER BY id_outstok DESC";
                    $txt = "Menampilkan data keluar tanggal <strong>".date('d M Y', strtotime($tgl))."</strong> untuk tujuan <strong>".$tipe."</strong>";
                }
                if($tipe!="null" AND $nama!="null"){
                    $qry = "SELECT * FROM stok_produk_keluar WHERE tgl_out='$tgl' AND tujuan LIKE '$tipe' AND nama_tujuan LIKE '%$nama%' ORDER BY id_outstok DESC";
                    $txt = "Menampilkan data keluar tanggal <strong>".date('d M Y', strtotime($tgl))."</strong> untuk tujuan <strong>".$tipe."</strong> dan pengiriman ke <strong>".$nama."</strong>";
                }
            }
        }
        echo $txt;
    } //end menampilkan produk keluar

    function showprodukMutasi(){
        $showTable = $this->db->query("SELECT * FROM newtb_mutasi ORDER BY id_mutasi DESC ");
        if($showTable->num_rows()>0){
            $no=1;
            foreach($showTable->result() as $val){
                $jns = $val->jenis_mutasi;
                $printTgl = date('d M Y', strtotime($val->tgl_mutasi));
                $sortTgl  = date('Y-m-d', strtotime($val->tgl_mutasi));
                if($jns == "KirimGudang"){
                    $jenisMutasi = '<i style="color:red;" class="icon-copy bi bi-arrow-right-circle-fill"></i> &nbsp;Kirim Gudang';
                    $urlToLink = base_url()."mutasi/toko/gudang/".$val->codemutasi."";
                } else {
                    $jenisMutasi = '<i style="color:green;" class="icon-copy bi bi-arrow-left-circle-fill"></i> &nbsp;Terima Dari Gudang';
                    $urlToLink = base_url()."mutasi/gudang/toko/".$val->codemutasi."";
                }
                $cd = $val->codemutasi;
                $jmlKirim = $this->db->query("SELECT SUM(jmldatas) AS jml FROM newtb_mutasi_data WHERE codemutasi='$cd'")->row("jml");
                ?>
                <tr>
                    <td><?=$no;?></td>
                    <td data-order="<?=$sortTgl;?>"><?=$printTgl;?></td>
                    <td><?=$jenisMutasi;?></td>
                    <td><a href="javascript:;" onclick="showDetail('<?=$cd;?>','<?=$jns;?>')" style="color:blue;"><?=number_format($jmlKirim,0,',','.');?> Pcs</a></td>
                    <td><?=$val->ket;?></td>
                    <td><a href="<?=$urlToLink;?>"><button class="btn btn-sm btn-success">Detail</button></a></td>
                </tr>
                <?php
                $no++;
            }
        }
    } //end mutasi show table

} //end of class