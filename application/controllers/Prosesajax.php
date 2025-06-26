<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prosesajax extends CI_Controller
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

  function tesajax(){
    $kd = $this->input->post('kd');
    $kode = $this->data_model->get_byid('new_tb_pkg_list', ['no_roll'=>$kd]);
    if($kode->num_rows() == 1){
        echo json_encode(array("statusCode"=>200, "psn"=>"oke"));
    } else {
        echo json_encode(array("statusCode"=>404, "psn"=>"failde"));
    }
    
  }//end

  function deletes(){
        $id = $this->input->post('id');
        $tipe = $this->input->post('tipe');
        if($tipe == "User"){
            $this->db->query("DELETE FROM table_users WHERE username='$id'");
            echo "Oke Sip";
        }
        if($tipe == "Pesan Auto Reply"){
            $cek = $this->data_model->get_byid('table_botwa', ['idbot'=>$id])->row("url_file");
            if($cek!="null"){ unlink('./uploads/'.$cek); }
            $this->db->query("DELETE FROM table_botwa WHERE idbot='$id'");
            echo "Oke Sip";
        }
        if($tipe == "Pembayaran Reseller"){
            $cek = $this->data_model->get_byid('hutang_reseller_bayar', ['id_byrres'=>$id])->row("buktibyr");
            $sj = $this->data_model->get_byid('hutang_reseller_bayar', ['id_byrres'=>$id])->row("sj");
            if($cek!="null"){ unlink('./uploads/'.$cek); }
            $this->db->query("DELETE FROM hutang_reseller_bayar WHERE id_byrres='$id'");
            $this->db->query("DELETE FROM flowcash WHERE ket='Pembayaran Reseller' AND codeinput='$id'");
            $this->data_model->updatedata('no_sj',$sj,'stok_produk_keluar',['status_lunas'=>'Belum Lunas']);
            echo "Oke Sip";
        }
        if($tipe == "Produk"){
            $cek = $this->data_model->get_byid('gambar_produk', ['codeunik'=>$id]);
            if($cek->num_rows() > 0){
                foreach($cek->result() as $val){
                    unlink('./uploads/'.$val->url_gbr);
                }
            }
            $this->db->query("DELETE FROM data_produk WHERE codeunik='$id'");
            $this->db->query("DELETE FROM gambar_produk WHERE codeunik='$id'");
            echo "Oke Sip";
        }
        if($tipe == "Kategori"){
            $this->db->query("DELETE FROM kategori_produk WHERE id_kat='$id'");
            echo "Oke Sip";
        }
        if($tipe == "Distributor"){
            $this->db->query("DELETE FROM data_distributor WHERE id_dis='$id'");
            echo "Oke Sip";
        }
        if($tipe == "Reseller"){
            $this->db->query("DELETE FROM data_reseller WHERE id_res='$id'");
            echo "Oke Sip";
        }
        if($tipe == "Kain"){
            $this->db->query("DELETE FROM data_kain WHERE id_kain='$id'");
            echo "Oke Sip";
        }
        if($tipe == "Tagihan"){
            $this->db->query("DELETE FROM tagihan WHERE id_tagihan='$id'");
            echo "Oke Sip";
        }
        if($tipe == "Extras"){
            $this->db->query("DELETE FROM data_kain_keluar_extras WHERE id_extras='$id'");
            echo "Oke Sip";
        }
        if($tipe == "Produsen"){
            $this->db->query("DELETE FROM data_produsen WHERE id_produsen='$id'");
            echo "Oke Sip";
        }
        if($tipe == "Tagihan Piutang"){
            $this->db->query("DELETE FROM hutang_produsen WHERE code_kiriman='$id'");
            echo "Oke Sip";
        }
        if($tipe == "Data Kain"){
            $cek = $this->data_model->get_byid('stok_kain_masuk_history', ['idstokkain'=>$id]);
            if($cek->num_rows() == 1){
                $id_kain = $cek->row('id_kain');
                $pjg_kain = $cek->row('total_panjang');
                $harga = $cek->row('harga_satuan');
                $code = $cek->row('kode_kain');
                $code2 = $cek->row('codeinput');
                $this->db->query("DELETE FROM stok_kain WHERE id_kain='$id_kain' AND total_panjang='$pjg_kain' AND kode_kain='$code' AND codeinput='$code2'");
                $this->db->query("DELETE FROM stok_kain_masuk_history WHERE idstokkain='$id'");
            }
            echo "Oke Sip";
        }
        if($tipe == "Foto Surat Jalan"){
            $cek = $this->data_model->get_byid('data_kain_masuk', ['gambar_foto'=>$id]);
            if($cek->num_rows() == 1){
                $ids = $cek->row('id_kainmasuk'); 
                $this->data_model->updatedata('id_kainmasuk',$ids,'data_kain_masuk',['gambar_foto'=>'null']);
                unlink('./uploads/'.$id);
            }
            $this->db->query("DELETE FROM data_kain_masuk_sj WHERE gambar_foto='$id'");
            unlink('./uploads/'.$id);
            echo "Oke Sip";
        }
        if($tipe == "Pembayaran Tagihan"){
            $nama_supplier = $this->data_model->get_byid('tagihan_bayar',['codebayar'=>$id])->row("nm");
            $this->db->query("DELETE FROM tagihan_bayar WHERE codebayar='$id'");
            $this->db->query("DELETE FROM tagihan_bayar2 WHERE codebayar='$id'");
            $this->db->query("DELETE FROM flowcash WHERE codeinput='$id'");
            $cek = $this->data_model->get_byid('tagihan',['nama_supplier'=>$nama_supplier])->result();
            foreach($cek as $val){
                $id_tagihan = $val->id_tagihan;
                $nominal_tagihan = $val->nominal_tagihan;
                $nominal_bayar = $this->db->query("SELECT SUM(nominal) AS jml FROM tagihan_bayar2 WHERE id_tagihan='$id_tagihan'")->row("jml");
                if($nominal_tagihan == $nominal_bayar){
                    $this->data_model->updatedata('id_tagihan',$id_tagihan,'tagihan',['status'=>'Lunas']);
                } else {
                    $this->data_model->updatedata('id_tagihan',$id_tagihan,'tagihan',['status'=>'Belum Lunas']);
                }
            }
            echo "Oke Sip";
        }
        if($tipe == "kain yang dikirim"){
            $kode = $this->data_model->get_byid('data_kain_keluar_history', ['idstokkain'=>$id])->row_array();
            $id_kain = $kode['id_kain'];
            $codeinput = $kode['codeinput'];
            $pjg = $kode['pjg_perroll'];
            $jml = $kode['jumlah_roll'];
            $kode_kain = $kode['kode_kain'];
            //echo "$id_kain|$codeinput|$pjg|$jml|$kode_kain";
            //$where = ['id_kain'=>$id_kain,'total_panjang'=>$pjg,'kode_kain'=>$kode_kain,'codekirim'=>$codeinput];
            //$qr2 = $this->data_model->get_byid('stok_kain_delete',$where);
            $qr2 = $this->db->query("SELECT * FROM stok_kain_delete WHERE id_kain='$id_kain' AND total_panjang='$pjg' AND kode_kain='$kode_kain' AND codekirim='$codeinput' LIMIT $jml");
            $arid = array();
            foreach($qr2->result() as $val):
                $_idstokkain = $val->idstokkain;
                $_id_kain = $val->id_kain;
                $_total_panjang = $val->total_panjang;
                $_jumlah_roll = $val->jumlah_roll;
                $_harga_satuan = $val->harga_satuan;
                $_kode_kain = $val->kode_kain;
                $_nama_kain = $val->nama_kain;
                $_codeinput = $val->codeinput;
                $arid[] = $_idstokkain;
                $this->data_model->saved('stok_kain',[
                    'id_kain' => $_id_kain,
                    'total_panjang' => $_total_panjang,
                    'jumlah_roll' => $_jumlah_roll,
                    'harga_satuan' => $_harga_satuan,
                    'kode_kain' => $_kode_kain,
                    'nama_kain' => $_nama_kain,
                    'codeinput' => $_codeinput
                ]);
            endforeach;
            for ($i=0; $i <count($arid) ; $i++) { 
                $this->db->query("DELETE FROM stok_kain_delete WHERE idstokkain='$arid[$i]'");
            }
            $this->db->query("DELETE FROM data_kain_keluar_history WHERE idstokkain='$id'");
            $all_panjang = 0;
            $all_roll = $this->db->query("SELECT SUM(jumlah_roll) AS panjang FROM data_kain_keluar_history WHERE codeinput='$codeinput'")->row("panjang");
            $all_harga = $this->db->query("SELECT SUM(harga_barang) AS panjang FROM data_kain_keluar_history WHERE codeinput='$codeinput'")->row("panjang");
            $alldt = $this->db->query("SELECT * FROM data_kain_keluar_history WHERE codeinput='$codeinput'");
                    foreach($alldt->result() as $bo){
                        $_roll = $bo->jumlah_roll;
                        $_pjg = $bo->pjg_perroll;
                        $_panjang = $_roll * $_pjg;
                        $all_panjang += $_panjang;
                    }
            $this->data_model->updatedata('codeinput',$codeinput,'data_kain_keluar',['panjang_kirim'=>$all_panjang, 'jumlah_roll'=>$all_roll, 'harga_barang_real'=>$all_harga]);
            echo "Oke Sip";
        }
  } //end

  function showKategori(){
        $id = $this->input->post('id');
        $kat = $this->input->post('kat');
        if($id!="all"){
            $data_produk = $this->data_model->get_byid('data_produk', ['id_kat'=>$id]);
        } else {
            $data_produk = $this->db->query("SELECT * FROM data_produk ORDER BY nama_produk ASC");
        }
        
        if($data_produk->num_rows() > 0){
            $no=1;
                                        foreach($data_produk->result() as $val){
                                        $idkat = $val->id_kat;
                                        $katnama = $this->data_model->get_byid('kategori_produk', ['id_kat'=>$idkat])->row('kategori');
                                        $codeunik = $val->codeunik;
                                        $cek_gambar = $this->data_model->get_byid('gambar_produk', ['codeunik'=>$codeunik])->num_rows();
                                        if($cek_gambar==0){
                                            $url_gbr = base_url('assets/img-placeholder.svg');
                                            $alt_gbr = 'Image Placeholder';
                                        } else {
                                            $gbr = $this->db->query("SELECT * FROM gambar_produk WHERE codeunik='$codeunik' LIMIT 1")->row("url_gbr");
                                            $url_gbr = base_url('uploads/'.$gbr);
                                            $alt_gbr = $val->nama_produk;
                                        }
                                    ?>
                                    <tr>
                                        <td><?=$no;?></td>
                                        <td>
                                            <img src="<?=$url_gbr;?>" alt="<?=$alt_gbr;?>" style="width:100px;height:100px;">
                                        </td>
                                        <td><?=$katnama;?></td>
                                        <td><?=$val->nama_produk;?></td>
                                        <td style="max-width: 300px;word-wrap: break-word;">
                                            <?php
                                            $keterangan_produk = $val->keterangan_produk;
                                            $kata_array = explode(' ', $keterangan_produk); // Memecah teks menjadi array kata-kata
                                            $kata_terbatas = array_slice($kata_array, 0, 20); // Mengambil 20 kata pertama
                                            $teks_terbatas = implode(' ', $kata_terbatas); 
                                            echo $teks_terbatas.'...';
                                            ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" href="<?=base_url('product/'.$codeunik);?>">
                                                        <i class="dw dw-eye"></i> View
                                                    </a>
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="del('Produk','<?=$codeunik;?>','<?=$val->nama_produk;?>')">
                                                        <i class="dw dw-trash" style="color:#c90e0e;"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                            $no++;
                                        }
        } else {
            echo "<tr><td colspan='6'>Tidak ada produk dengan kategori ".$kat."</td></tr>";
        }
  } //end

  function ambilsatuan(){
    $id = $this->input->post('id');
    if($id==""){
        echo json_encode(array("statusCode"=>500, "psn"=>"Anda belum memilih produk"));
    } else {
        $satuan = $this->data_model->get_byid('data_produk', ['codeunik'=>$id])->row('satuan');
        $cek_stok = $this->db->query("SELECT * FROM stok_in WHERE id_barang='$id' ORDER BY tgl_masuk DESC LIMIT 1");
        if($cek_stok->num_rows() == 1){
            $harga_beli = number_format($cek_stok->row('harga_beli'),0, '', '.');
            $harga_jual = number_format($cek_stok->row('harga_jual'),0, '', '.');
            echo json_encode(array("statusCode"=>200, "satuan"=>$satuan, "harga_beli"=>$harga_beli, "harga_jual"=>$harga_jual));
        } else {
            echo json_encode(array("statusCode"=>200, "satuan"=>$satuan, "harga_beli"=>"0", "harga_jual"=>"0"));
        }
        
    }
  } //end
  ///----------------------Tampilkan data stok
  function tampilkanstok(){
        $id           = $this->input->post('id');
        $tipeShowStok = $this->input->post('tipeShowStok');
        $kat          = $this->input->post('kat');
        $nm           = $this->input->post('nm');
        if($tipeShowStok=="Toko"){ $tipeShowStokID="1"; } else { $tipeShowStokID="2"; }
        if($id!=""){
            if($kat == "null" AND $nm == "null"){
                $produk = $this->db->query("SELECT * FROM data_produk ORDER BY nama_produk ASC");
            } else {
                if($kat!="null" AND $nm == "null"){
                    $produk = $this->db->query("SELECT * FROM data_produk WHERE id_kat='$kat' ORDER BY nama_produk ASC");
                } else {
                    $produk = $this->db->query("SELECT * FROM data_produk WHERE nama_produk LIKE '%$nm%' ORDER BY nama_produk ASC");
                }
            }
            
            if($produk->num_rows() > 0){
                $no=1;
                foreach($produk->result() as $val){
                $id_produk = $val->id_produk;
                $codeunik = $val->codeunik;
                $satuan = $val->satuan;
                $cek_gambar = $this->data_model->get_byid('gambar_produk', ['codeunik'=>$codeunik])->num_rows();
                if($cek_gambar==0){
                    $url_gbr = base_url('assets/img-placeholder.svg');
                    $alt_gbr = 'Image Placeholder';
                } else {
                    $gbr = $this->db->query("SELECT * FROM gambar_produk WHERE codeunik='$codeunik' LIMIT 1")->row("url_gbr");
                    $url_gbr = base_url('uploads/'.$gbr);
                    $alt_gbr = $val->nama_produk;
                }

                if($id=="0"){
                    if($tipeShowStok=="Toko"){
                        $jml_stok = $this->db->query("SELECT COUNT(id_bar) AS jml FROM data_produk_stok WHERE id_produk = '$id_produk'")->row('jml');
                    } else {
                        $jml_stok = $this->db->query("SELECT COUNT(id_bar) AS jml FROM data_produk_stok_onagen WHERE id_produk = '$id_produk' AND id_dis = '11'")->row('jml');
                    }
                } else {
                    $jml_stok = $this->db->query("SELECT COUNT(id_bar) AS jml FROM data_produk_stok_onagen WHERE id_produk = '$id_produk' AND id_dis = '$id'")->row('jml');
                }
                
                if($jml_stok<1){$jml_stok="0";}
                //if($jml_stok>0){ //tampilkan jika jumlah stok lebih dari nol #1
                if($id=="0"){
                    if($tipeShowStok=="Toko"){
                        $ukr = $this->db->query("SELECT * FROM data_produk_stok WHERE id_produk = '$id_produk' GROUP BY kode_bar1");
                    } else {
                        $ukr = $this->db->query("SELECT * FROM data_produk_stok_onagen WHERE id_produk = '$id_produk' AND id_dis = '11' GROUP BY kode_bar1");
                    }
                    
                } else {
                    $ukr = $this->db->query("SELECT * FROM data_produk_stok_onagen WHERE id_produk = '$id_produk' AND id_dis = '$id' GROUP BY kode_bar1");
                }
                $ar=array();
                foreach($ukr->result() as $p){
                    $xx = explode('-',$p->kode_bar1);
                    if(in_array($xx[1], $ar)){} else { $ar[] = $xx[1]; }
                }
                sort($ar);
                if(count($ar)>0){
                    $ukr_im = implode(', ', $ar);
                    $_ada = "yes";
                } else {
                    $_ada = "no";
                    $ukr_im = '<span class="text-danger">Stok Kosong</span>';
                }
                if($id=="0"){
                if($jml_stok==0){} else {
            ?>
            <tr id="trid<?=$id_produk;?>">
                <td><?=$no;?></td>
                <?php if($cek_gambar==0){ echo "<td><code>No Image</code></td>"; } else { ?> 
                <td><img src="<?=$url_gbr;?>" alt="<?=$alt_gbr;?>" style="width:80px;height:80px;"></td><?php } ?>
                <td><?=$val->nama_produk;?></td>
                <td><?=$ukr_im;?></td>
                <td class="<?=$jml_stok=='0' ?'text-danger':'';?>"><?=number_format($jml_stok, 0, '', '.').' '.$satuan;?></td>
                <td>
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item" href="<?=base_url('product/'.$codeunik.'/id');?><?='/'.$id.'/'.$tipeShowStokID;?>"><i class="dw dw-eye"></i> View
                            </a>
                            <?php if($_ada == "no"){?>
                            <a class="dropdown-item" href="javascript:void(0);" style="color:red;" onclick="hapusProduk('<?=$val->nama_produk;?>','<?=$id_produk;?>')">
                                <i class="bi bi-trash"></i> Hapus Produk
                            </a>
                            <?php } ?>
                        </div>
                    </div>
                </td>
            </tr>
            <?php $no++; }
                } else {
                    if(count($ar)>0){
                        if($jml_stok==0){} else {
                        ?>
                        <tr>
                            <td><?=$no;?></td>
                            <?php if($cek_gambar==0){ echo "<td><code>No Image</code></td>"; } else { ?> 
                            <td><img src="<?=$url_gbr;?>" alt="<?=$alt_gbr;?>" style="width:80px;height:80px;"></td><?php } ?>
                            <td><?=$val->nama_produk;?></td>
                            <td><?=$ukr_im;?></td>
                            <td class="<?=$jml_stok=='0' ?'text-danger':'';?>"><?=number_format($jml_stok, 0, '', '.').' '.$satuan;?></td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" href="<?=base_url('product/'.$codeunik.'/id');?><?='/'.$id.'/'.$tipeShowStokID;?>"><i class="dw dw-eye"></i> View
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0);">
                                            <i class="bi bi-send" style="color:blue;"></i> Kirim Produk
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php $no++; }
                    }
                }
                    //} //end #1
                } //end foreach
                
            } else {
            ?>
            <tr>
                <td colspan="6">Tidak ada produk yang bisa ditampilkan</td>
            </tr>
            <?php
            }
            
        } else {
            ?>
            <tr>
                <td colspan="6">
                    <div style="width:100%;display:flex;justify-content:center;align-items:center"><div class="loader"></div></div>
                </td>
                <td colspan="6">Gagal Menampilkan Data</td>
            </tr>
            <?php
        }
  } //end showstok

  function datadis(){
    $id             = $this->input->post('id');
    $tipeShowStok   = $this->input->post('tipeShowStok');
    if($id=="0"){
        if($tipeShowStok == "Gudang"){
            $all_stok = $this->data_model->get_byid('data_produk_stok_onagen',['id_dis'=>11])->num_rows();
            echo  "STOK GUDANG (".number_format($all_stok, 0, ',', '.')." Pcs)";
        } else {
            $all_stok   = $this->db->query("SELECT id_bar FROM data_produk_stok")->num_rows();
            echo  "STOK TOKO (".number_format($all_stok, 0, ',', '.')." Pcs)";
        }
    } else {
        $dis = $this->db->query("SELECT * FROM data_distributor WHERE id_dis='$id'")->row("nama_distributor");
        $all_stok = $this->data_model->get_byid('data_produk_stok_onagen',['id_dis'=>$id])->num_rows();
        echo "STOK DI ".strtoupper($dis)." (".$all_stok.")";
    }
  } //

  function ambilkain(){
    $id = $this->input->post('id');
    $cek= $this->data_model->get_byid('data_kain',['id_kain'=>$id])->row_array();
    $cek2= $this->data_model->get_byid('data_kain',['id_kain'=>$id])->num_rows();
    if($cek2==1){
        $satuan = $cek['satuan'];
        echo json_encode(array("statusCode"=>200, "satuan"=>$satuan));
    } else {
        $satuan = $cek['satuan'];
        echo json_encode(array("statusCode"=>400, "satuan"=>''));
    }
    
  } //end
  function showDataKain(){
        $data_kain = $this->db->query("SELECT * FROM data_kain ORDER BY nama_kain");
        if($data_kain->num_rows() > 0){
            $no=1;
            foreach($data_kain->result() as $val){
            $id = $val->id_kain;
            $stok = $this->db->query("SELECT SUM(total_panjang) AS jml FROM stok_kain WHERE id_kain='$id'")->row("jml");
            $roll = $this->db->query("SELECT SUM(jumlah_roll) AS jml FROM stok_kain WHERE id_kain='$id'")->row("jml");
            if($stok>0){
                if (floor($stok) != $stok) {
                    $pjg = number_format($stok, 2, ',', '.');
                } else {
                    $pjg = number_format($stok, 0, ',', '.');
                }
                $showStok = $pjg. ' '.$val->satuan;
            } else {
                $showStok = '0';
            } 
            if($roll>0){
                $showRoll = number_format($roll, 0, ',', '.');
            } else {
                $showRoll = '0';
            }
                ?>
            <tr>
                <td><?=$no++;?></td>
                <td><a href="javascript:void(0)" onclick="openViewKain('<?=$id;?>')" data-toggle="modal" data-target="#modals-datakain"><?=$val->nama_kain;?></a></td>
                <td><?=$showStok;?></td>
                <td><?=$showRoll;?></td>
                <td>
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item" href="javascript:void(0);" onclick="openViewKain('<?=$id;?>')" data-toggle="modal" data-target="#modals-datakain"><i class="dw dw-eye"></i> View</a>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="openViewKain('<?=$id;?>')" data-toggle="modal" data-target="#modals-datakain"><i class="bi bi-box-arrow-up-right" style="color:red;"></i> Kirim Kain</a>
                        </div>
                    </div>
                </td>
            </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada data kain</td></tr>";
        }
  } //end
  function showDataKainid(){
        $id = $this->input->post('id');
        $dm = $this->data_model->get_byid('data_kain', ['id_kain'=>$id])->row_array();
        $nama_kain = $dm['nama_kain'];
        $satuan = $dm['satuan'];
        $cek = $this->data_model->get_byid('stok_kain', ['id_kain'=>$id]);
        $cek = $this->db->query("SELECT * FROM stok_kain WHERE id_kain='$id' GROUP BY kode_kain");
        if($cek->num_rows() > 0){
            echo '<div class="table-responsive">';
            echo '<table class="table table-bordered stripe hover">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>No</th>';
            echo '<th>Jenis Kain</th>';
            echo '<th>Kode</th>';
            echo '<th>Kain</th>';
            echo '<th>Panjang</th>';
            echo '<th>Jumlah Roll</th>';
            echo '<th>Harga /'.$satuan.'</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            $no=1;
            foreach($cek->result() as $val){
                $kdkain = $val->kode_kain;
                $ceklagi = $this->db->query("SELECT * FROM stok_kain WHERE kode_kain='$kdkain' GROUP BY total_panjang");
                foreach($ceklagi->result() as $val2){
                    $ttlpjg = $val2->total_panjang;
                    $total_roll = $this->db->query("SELECT * FROM stok_kain WHERE kode_kain='$kdkain' AND total_panjang='$ttlpjg' AND kode_kain='$kdkain'")->num_rows();
                    echo '<tr>';
                    echo '<td>'.$no++.'</td>';
                    echo '<td>'.$nama_kain.'</td>';
                    echo '<td>'.$val->kode_kain.'</td>';
                    echo '<td>'.$val->nama_kain.'</td>';
                    echo '<td>'.$ttlpjg.'</td>';
                    echo '<td>'.$total_roll.'</td>';
                    echo '<td>'.number_format($val->harga_satuan,0,',','.').'</td>';
                    echo '</tr>';
                }
                
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        } else {
            echo "Tidak ada data kain"; 
        }

  } //end

  function ambilStokKain(){
        $id = $this->input->post('id');
        $cek = $this->data_model->get_byid('stok_kain', ['id_kain'=>$id])->num_rows();
        if($cek > 0){
            $panjang = $this->db->query("SELECT SUM(jumlah_stok) AS jml FROM stok_kain WHERE id_kain='$id'")->row("jml");
            $roll = $this->db->query("SELECT SUM(jumlah_roll) AS jml FROM stok_kain WHERE id_kain='$id'")->row("jml");
            $nilai = $this->db->query("SELECT id_kain,nilai FROM stok_kain WHERE id_kain='$id' ORDER BY nilai DESC LIMIT 1")->row('nilai');
            echo json_encode(array("statusCode"=>200, "panjang"=>$panjang, "roll"=>$roll, "nilai"=>$nilai));
        } else {
            echo json_encode(array("statusCode"=>200, "panjang"=>"0", "roll"=>"0", "nilai"=>"0"));
         }
  } //end

  function viewKainMasuk(){
        $code = $this->input->post('id');
        $dt = $this->data_model->get_byid('data_kain_masuk', ['codeinput'=>$code]);
        if($dt->num_rows() == 1){
            $row = $dt->row_array();
            $tanggal_masuk = $row['tgl_masuk'];
            $date = new DateTime($tanggal_masuk);
            $formatted_date = $date->format('d M Y');
            $id_kain = $row['id_kain'];
            $codeinput = $row['codeinput'];
            $dt = $this->data_model->get_byid('data_kain', ['id_kain'=>$id_kain])->row_array();
            $nama_kain = $dt['nama_kain'];
            $satuan = $dt['satuan'];
            $pjg = $row['total_panjang'];
            $roll = $row['jumlah_roll'];
            $supplier = $row['supplier'];
            $ket = $row['ket'];
            $yg = $row['yg_input'];
            $bukti = $row['gambar_foto'];
            $detime = explode(' ',$row['tgl_input']);
            $date2 = new DateTime($detime[0]);
            $formatted_date2 = $date2->format('d M Y');
            $harga_beli = number_format($row['harga_beli'], 0, ',', '.');
            $harga_satuan = number_format($row['harga_permeter'], 0, ',', '.');
            if($satuan == "Yard") {
                if (floor($pjg) == $pjg) {
                    $nilai_yard = number_format($pjg, 0, ',', '.');
                } else {
                    $nilai_yard = number_format($pjg, 2, ',', '.');
                }
                $nilai_meter_temp = $pjg * 0.9144;
                if (floor($nilai_meter_temp) == $nilai_meter_temp) {
                    $nilai_meter = number_format($nilai_meter_temp, 0, ',', '.');
                } else {
                    $nilai_meter = number_format($nilai_meter_temp, 2, ',', '.');
                }
            } else {
                if (floor($pjg) == $pjg) {
                    $nilai_meter = number_format($pjg, 0, ',', '.');
                } else {
                    $nilai_meter = number_format($pjg, 2, ',', '.');
                }
                $nilai_yard_temp = $pjg / 0.9144;
                if (floor($nilai_yard_temp) == $nilai_yard_temp) {
                    $nilai_yard = number_format($nilai_yard_temp, 0, ',', '.');
                } else {
                    $nilai_yard = number_format($nilai_yard_temp, 2, ',', '.');
                }
            }
            ?>
            <div style="width:100%;display:flex;flex-wrap:wrap;">
                <div style="width:30%;display:flex;align-items:flex-start;">No Surat Jalan</div>
                <div style="width:70%;display:flex;align-items:flex-start;">: &nbsp;&nbsp;<strong><?=$row['surat_jalan'];?></strong></div>
            </div>
            <div style="width:100%;display:flex;flex-wrap:wrap;margin-top:10px;">
                <div style="width:30%;display:flex;align-items:flex-start;">Tanggal Masuk</div>
                <div style="width:70%;display:flex;align-items:flex-start;">: &nbsp;&nbsp;<strong><?=$formatted_date;?></strong></div>
            </div>
            <div style="width:100%;display:flex;flex-wrap:wrap;margin-top:10px;">
                <div style="width:30%;display:flex;align-items:flex-start;">Supplier</div>
                <div style="width:70%;display:flex;align-items:flex-start;">: &nbsp;&nbsp;<strong><?=$supplier;?></strong></div>
            </div>
            <div style="width:100%;display:flex;flex-wrap:wrap;margin-top:10px;">
                <div style="width:30%;display:flex;align-items:flex-start;">Jenis Kain</div>
                <div style="width:70%;display:flex;align-items:flex-start;">: &nbsp;&nbsp;<strong><?=$nama_kain;?></strong></div>
            </div>
            <div style="width:100%;display:flex;flex-wrap:wrap;margin-top:10px;">
                <div style="width:30%;display:flex;align-items:flex-start;">Total Panjang</div>
                <div style="width:70%;display:flex;align-items:flex-start;">: &nbsp;&nbsp;<strong><?=$nilai_yard;?></strong>&nbsp;Yard /&nbsp; <strong><?=$nilai_meter;?></strong>&nbsp;Meter</div>
            </div>
            <div style="width:100%;display:flex;flex-wrap:wrap;margin-top:10px;">
                <div style="width:30%;display:flex;align-items:flex-start;">Jumlah Roll</div>
                <div style="width:70%;display:flex;align-items:flex-start;">: &nbsp;&nbsp;<strong><?=$roll;?></strong></div>
            </div>
            <div style="width:100%;display:flex;flex-wrap:wrap;margin-top:10px;">
                <div style="width:30%;display:flex;align-items:flex-start;">Total Harga</div>
                <div style="width:70%;display:flex;align-items:flex-start;">: &nbsp;&nbsp;<strong>Rp. <?=$harga_beli;?></strong></div>
            </div>
            <div style="width:100%;display:flex;flex-wrap:wrap;margin-top:10px;">
                <div style="width:30%;display:flex;align-items:flex-start;">Harga /<?=$satuan;?></div>
                <div style="width:70%;display:flex;align-items:flex-start;">: &nbsp;&nbsp;<strong>Rp. <?=$harga_satuan;?></strong></div>
            </div>
            <div style="width:100%;display:flex;flex-wrap:wrap;margin-top:10px;">
                <div style="width:30%;display:flex;align-items:flex-start;">Keterangan</div>
                <div style="width:70%;display:flex;align-items:flex-start;">: &nbsp;&nbsp;<strong><?=$ket;?></strong></div>
            </div>
            <div style="width:100%;display:flex;flex-wrap:wrap;margin-top:10px;">
                <div style="width:30%;display:flex;align-items:flex-start;">Diinput Oleh</div>
                <div style="width:70%;display:flex;align-items:flex-start;">: &nbsp;&nbsp;<strong><?=$yg;?></strong></div>
            </div>
            <div style="width:100%;display:flex;flex-wrap:wrap;margin-top:10px;">
                <div style="width:30%;display:flex;align-items:flex-start;">Tanggal dan Waktu</div>
                <div style="width:70%;display:flex;align-items:flex-start;">: &nbsp;&nbsp;<strong><?=$formatted_date2." ".$detime[1];?></strong></div>
            </div>
            <?php if($bukti=="null"){?>
                <div style="width:100%;display:flex;flex-wrap:wrap;margin-top:10px;">
                    <div style="width:30%;display:flex;align-items:flex-start;">Foto Surat Jalan</div>
                    <div style="width:70%;display:flex;align-items:flex-start;">: &nbsp;&nbsp;Tidak ada foto</div>
                </div>
            <?php } else { ?>
                <div style="width:100%;display:flex;flex-direction:column;margin-top:10px;">
                    <div style="width:100%;display:flex;align-items:flex-start;">Foto Surat Jalan</div>
                    <div style="width:100%;display:flex;align-items:flex-start;margin-top:10px;">
                        <img src="<?=base_url('uploads/'.$bukti);?>" alt="Foto surat jalan <?=$row['surat_jalan'];?>" style="width:100%;height:auto;">
                    </div>
                </div>
            <?php } ?>


            
            <?php
        } else {
            echo "<div style='width:100%;height:300px;display:flex;justify-content:center;align-items:center;color:red;'>";
            echo "Data Tidak ditemukan";
            echo "</div>";
        }
  } //end

  function viewKainKeluar(){
        $code = $this->input->post('id');
        $dt = $this->data_model->get_byid('data_kain_keluar', ['codeinput'=>$code]);
        if($dt->num_rows() == 1){
            $row = $dt->row_array();
            $tgl_kirim2 = $row['tgl_kirim'];
            $date = new DateTime($tgl_kirim2);
            $tgl_kirim = $date->format('d M Y');
            $id_produsen = $row['id_produsen'];
            $id_kain = $row['id_kain'];
            $nama_produsen = $this->data_model->get_byid('data_produsen', ['id_produsen'=>$id_produsen])->row('nama_produsen');
            $nama_kain = $this->data_model->get_byid('data_kain', ['id_kain'=>$id_kain])->row('nama_kain');
            $satuan = $this->data_model->get_byid('data_kain', ['id_kain'=>$id_kain])->row('satuan');
            $pjg = $row['panjang_kain'];
            if($satuan == "Yard") {
                if (floor($pjg) == $pjg) {
                    $nilai_yard = number_format($pjg, 0, ',', '.');
                } else {
                    $nilai_yard = number_format($pjg, 2, ',', '.');
                }
                $nilai_meter_temp = $pjg * 0.9144;
                if (floor($nilai_meter_temp) == $nilai_meter_temp) {
                    $nilai_meter = number_format($nilai_meter_temp, 0, ',', '.');
                } else {
                    $nilai_meter = number_format($nilai_meter_temp, 2, ',', '.');
                }
            } else {
                if (floor($pjg) == $pjg) {
                    $nilai_meter = number_format($pjg, 0, ',', '.');
                } else {
                    $nilai_meter = number_format($pjg, 2, ',', '.');
                }
                $nilai_yard_temp = $pjg / 0.9144;
                if (floor($nilai_yard_temp) == $nilai_yard_temp) {
                    $nilai_yard = number_format($nilai_yard_temp, 0, ',', '.');
                } else {
                    $nilai_yard = number_format($nilai_yard_temp, 2, ',', '.');
                }
            }
            ?>
            <div style="width:100%;display:flex;flex-wrap:wrap;">
                <div style="width:30%;display:flex;align-items:flex-start;">Tanggal Pengiriman</div>
                <div style="width:70%;display:flex;align-items:flex-start;">: &nbsp;&nbsp;<strong><?=$tgl_kirim;?></strong></div>
            </div>
            <div style="width:100%;display:flex;flex-wrap:wrap;margin-top:10px;">
                <div style="width:30%;display:flex;align-items:flex-start;">Produsen</div>
                <div style="width:70%;display:flex;align-items:flex-start;">: &nbsp;&nbsp;<strong><?=$nama_produsen;?></strong></div>
            </div>
            <div style="width:100%;display:flex;flex-wrap:wrap;margin-top:10px;">
                <div style="width:30%;display:flex;align-items:flex-start;">Jenis Kain</div>
                <div style="width:70%;display:flex;align-items:flex-start;">: &nbsp;&nbsp;<strong><?=$nama_kain;?></strong></div>
            </div>
            <div style="width:100%;display:flex;flex-wrap:wrap;margin-top:10px;">
                <div style="width:30%;display:flex;align-items:flex-start;">Total Kirim</div>
                <div style="width:70%;display:flex;align-items:flex-start;">: &nbsp;&nbsp;<strong><?=$nilai_yard;?></strong>&nbsp;Yard /&nbsp; <strong><?=$nilai_meter;?></strong>&nbsp;Meter</div>
            </div>
            <?php
        } else {
            echo "<div style='width:100%;height:300px;display:flex;justify-content:center;align-items:center;color:red;'>";
            echo "Data Tidak ditemukan";
            echo "</div>";
        }
  } //end

  function loadcash(){
    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 100;
    
    // Query untuk mengambil data dengan paginasi
    $sql = "SELECT id_flow, alur, jumlah, tgl_waktu, ket, codeinput FROM flowcash ORDER BY tgl_waktu DESC LIMIT $offset, $limit";
    $result = $this->db->query($sql);
    
    // Format data menjadi array
    $data = [];
    if ($result->num_rows() > 0) {
        foreach($result->result() as $row){
            $x = explode(" ", $row->tgl_waktu);
            $xx = explode('-', $x[0]);
            $x1 = explode(':', $x[1]);
            $printTgl = $xx[2]." ".$this->data_model->printBln2($xx[1])." ".$xx[0];
            $data[] = [
                'id_flow' => $row->id_flow,
                'alur' => $row->alur,
                'jumlah' => number_format($row->jumlah, 0, ',', '.'),//$row->jumlah,
                'tgl' => $printTgl,
                'waktu' => $x1[0].":".$x1[1],
                'ket' => $row->ket,
                'codeinput' => $row->codeinput
            ];
        }
    }
    header('Content-Type: application/json');
    echo json_encode(['data' => $data]);
  } //end
  function inputflowcash(){
        $tgl = $this->input->post('tgl');
        $tipe = $this->input->post('tipe');
        $nominal = $this->input->post('nominal');
        $nilai = preg_replace('/\D/', '', $this->input->post('nominal'));
        $ket = $this->input->post('ket');
        $kode = $this->data_model->acakKode(21);
        if($tgl!="" && $tipe!="" && $nominal!="" && $ket!=""){
            $data = array(
                'alur' => $tipe,
                'jumlah' => $nilai,
                'ket' => $ket,
                'tgl_waktu' => $tgl.' '.date('H:i:s'),
                'codeinput' => $kode
            );
            $this->data_model->saved('flowcash', $data);
            echo "berhasil";
        }
  } //emd

  function shodnamakain(){
        $id = $this->input->post('id');
        $nama = $this->db->query("SELECT * FROM stok_kain WHERE kode_kain='$id'")->row('nama_kain');
        echo $nama;
  } //ned
  function shodnamakain2(){
    $id = $this->input->post('id');
    $x = explode(',', $id);
    $kd = $x[0];
    $pj = $x[1];
    $jumlah_kain = $this->db->query("SELECT * FROM stok_kain WHERE kode_kain='$kd' AND total_panjang='$pj'")->num_rows();
    $nama = $this->db->query("SELECT * FROM stok_kain WHERE kode_kain='$kd' AND total_panjang='$pj' LIMIT 1");
    $nama_kain = $nama->row("nama_kain");
    $ukuran = $nama->row("total_panjang");
    $id_kain = $nama->row("id_kain");
    $satuan = $this->data_model->get_byid('data_kain', ['id_kain'=>$id_kain])->row('satuan');
    echo json_encode(array("statusCode"=>200, "jumlah_kain"=>$jumlah_kain, "nama"=>$nama_kain, "ukuran"=>$ukuran, "satuan"=>$satuan));
} //ned

  function deletesaldo(){
        $id = $this->input->post('id');
        $tipe = $this->input->post('tipe');
        $cek = $this->data_model->get_byid('flowcash', ['codeinput'=>$id]);
        if($cek->num_rows() == 1){
            if($tipe == "PEMBAYARAN KAIN"){
                $this->db->query("DELETE FROM tagihan_bayar WHERE codebayar='$id'");
            }
            $this->db->query("DELETE FROM flowcash WHERE codeinput='$id'");
        }
        echo "berhasil";
  } //end
  
  function sendDataKain(){
        $codeinput = $this->input->post('codeinput');
        $codekain2 = $this->input->post('codekain');
        $x = explode(',', $codekain2);
        $codekain = $x[0];
        $pjg = $x[1];
        $jmlroll_stok = $this->input->post('jmlroll_stok');
        $jmlroll_kirim = $this->input->post('jmlroll_kirim');
        $namakain = $this->input->post('namakain');
        $pjgPerRoll = $this->input->post('pjgPerRoll');
        if($codeinput!="" AND $codekain!="" AND $jmlroll_stok!="" AND $jmlroll_kirim!=""){
            $jmlstok = $this->data_model->get_byid('stok_kain', ['total_panjang'=>$pjg,'kode_kain'=>$codekain])->num_rows();
            if($jmlstok > 0){
                if(intval($jmlroll_kirim) > 0 AND intval($jmlstok) >= intval($jmlroll_kirim)){
                    $dt = $this->db->query("SELECT * FROM stok_kain WHERE total_panjang='$pjg' AND kode_kain='$codekain' ORDER BY idstokkain ASC LIMIT $jmlroll_kirim");
                    $harga_total = 0; $total_panjang=0; $jumlah_roll=0; 
                    $id_kain = ""; $nama_kain = "";
                    foreach($dt->result() as $val){
                        $_idstokkain = $val->idstokkain;
                        $_id_kain = $val->id_kain;
                        $_total_panjang = $val->total_panjang;
                        $_jumlah_roll = $val->jumlah_roll;
                        $_harga_satuan = $val->harga_satuan;
                        $_harga_satuan2 = $_harga_satuan * $_total_panjang;
                        $_kode_kain = $val->kode_kain;
                        $_nama_kain = $val->nama_kain;
                        $_codeinput = $val->codeinput;

                        $total_panjang += $_total_panjang;
                        $harga_total += $_harga_satuan2;
                        $jumlah_roll += $_jumlah_roll;
                        $id_kain = $_id_kain;
                        $nama_kain = $_nama_kain;
                        $this->data_model->saved('stok_kain_delete', ['idstokkain'=>$_idstokkain, 'id_kain'=>$_id_kain, 'total_panjang'=>$_total_panjang, 'jumlah_roll'=>$_jumlah_roll, 'harga_satuan'=>$_harga_satuan, 'kode_kain'=>$_kode_kain, 'nama_kain'=>$_nama_kain, 'codeinput'=>$_codeinput, 'codekirim'=>$codeinput]);
                    } //end foreach
                    $this->data_model->saved('data_kain_keluar_history', ['id_kain'=>$id_kain, 'pjg_perroll'=>$pjg, 'jumlah_roll'=>$jumlah_roll, 'harga_barang'=>$harga_total, 'kode_kain'=>$codekain, 'nama_kain'=>$namakain, 'codeinput'=>$codeinput]);
                    foreach($dt->result() as $val2){
                        $_idstokkain = $val2->idstokkain;
                        $this->db->query("DELETE FROM stok_kain WHERE idstokkain='$_idstokkain'");
                    }
                    // $all_panjang = $this->db->query("SELECT SUM(total_panjang) AS panjang FROM data_kain_keluar_history WHERE codeinput='$codeinput'")->row("panjang");
                    $all_panjang = 0;
                    $all_roll = $this->db->query("SELECT SUM(jumlah_roll) AS panjang FROM data_kain_keluar_history WHERE codeinput='$codeinput'")->row("panjang");
                    $all_harga = $this->db->query("SELECT SUM(harga_barang) AS panjang FROM data_kain_keluar_history WHERE codeinput='$codeinput'")->row("panjang");
                    $alldt = $this->db->query("SELECT * FROM data_kain_keluar_history WHERE codeinput='$codeinput'");
                    foreach($alldt->result() as $bo){
                        $_roll = $bo->jumlah_roll;
                        $_pjg = $bo->pjg_perroll;
                        $_panjang = $_roll * $_pjg;
                        $all_panjang += $_panjang;
                    }
                    $this->data_model->updatedata('codeinput',$codeinput,'data_kain_keluar',['panjang_kirim'=>$all_panjang, 'jumlah_roll'=>$all_roll, 'harga_barang_real'=>$all_harga]);
                    $txt = "Berhasil mengirimkan ".$codekain." sebanyak ".$jmlroll_kirim." roll.!!";
                    echo json_encode(array("statusCode"=>200, "psn"=>$txt));
                } else {
                    $text = "Anda mengirim melebihi jumlah stok di gudang!!";
                    echo json_encode(array("statusCode"=>500, "psn"=>$text));
                }
            } else {
                $text = $codekain." tidak memiliki stok di gudang.!!";
                echo json_encode(array("statusCode"=>500, "psn"=>$text));
            }
        } else {
            echo json_encode(array("statusCode"=>500, "psn"=>"Anda tidak mengisi data dengan benar!!"));
        }
  } //end

  function showSendKainData2(){
        $id = $this->input->post('id');
        $cek = $this->data_model->get_byid('data_kain_keluar_extras', ['codeinput'=>$id]);
        if($cek->num_rows() > 0){
            foreach($cek->result() as $val){
                $id2=$val->id_extras;
                $datax = $val->nama_barang." ".$val->jumlah;
                echo "<tr>";
                echo "<td>".$val->nama_barang."</td>";
                echo "<td>".$val->jumlah."</td>";
                ?><td><a href="javascript:void(0)" onclick="del('Extras', '<?=$id2;?>', '<?=$datax;?>')"><i class="dw dw-trash" style="color:red;"></i></a></td><?php
                echo "</tr>";
            }
        }
  }
  function showSendKainData3(){
        $id = $this->input->post('id');
        $nm_barang = $this->input->post('extr');
        $jml = $this->input->post('pcs');
        if($id!="" AND $nm_barang!="" AND $jml!=""){
            $this->data_model->saved('data_kain_keluar_extras',[
                'codeinput' => $id,
                'nama_barang' => $nm_barang,
                'jumlah' => $jml
            ]); 
        }
  }
  function showSendKainData(){
        $id = $this->input->post('id');
        $cek = $this->data_model->get_byid('data_kain_keluar_history', ['codeinput'=>$id]);
        if($cek->num_rows() > 0){
            $no=1;
            $_allroll = 0; $_allpjg=0; $_allharga = 0;
            foreach($cek->result() as $val){
                $id2 = $val->idstokkain;
                $id_kain = $val->id_kain;
                $satuan = $this->data_model->get_byid('data_kain',['id_kain'=>$id_kain])->row("satuan");
                $r = $val->jumlah_roll;
                $p = $val->pjg_perroll;
                $pjg = $r * $p;
                $_allpjg += $pjg;
                if (floor($pjg) != $pjg) {
                    $pjg = number_format($pjg, 2, ',', '.');
                } else {
                    $pjg = number_format($pjg, 0, ',', '.');
                }
                echo "<tr>";
                echo "<td>$no</td>";
                echo "<td>$val->kode_kain</td>";
                echo "<td>$val->nama_kain</td>";
                echo "<td>$val->pjg_perroll ".$satuan."</td>";
                echo "<td>$val->jumlah_roll</td>";
                $_allroll += $val->jumlah_roll;
                echo "<td>$pjg </td>";
                echo "<td>Rp.".number_format($val->harga_barang, 0, ',', '.')."</td>";
                $_allharga += $val->harga_barang;
                ?><td><a href="javascript:void(0)" onclick="del('kain yang dikirim', '<?=$id2;?>', 'Kiriman')"><i class="dw dw-trash" style="color:red;"></i></a></td><?php
                echo "</tr>";
                $no++;
            }
            if (floor($_allpjg) != $_allpjg) {
                $_allpjg2 = number_format($_allpjg, 2, ',', '.');
            } else {
                $_allpjg2 = number_format($_allpjg, 0, ',', '.');
            }
            echo "<tr>";
            echo "<th colspan='4'>Total</th>";
            echo "<th>".$_allroll."</th>";
            echo "<th>".$_allpjg2." ".$satuan."</th>";
            echo "<th>Rp.".number_format($_allharga, 0, ',', '.')."</th>";
            echo "<th></th>";
            echo "</tr>";
        } else {
            echo "<tr><td colspan='8'>Silahkan tambahkan kain yang di kirim melalui form di bawah</td></tr>";
        }
  } //end 

  function hapusKiriman(){
        $id = $this->input->post('id');
        $cek = $this->data_model->get_byid('data_kain_keluar', ['codeinput'=>$id]);
        $cek2 = $this->data_model->get_byid('hutang_produsen', ['code_kiriman'=>$id])->num_rows();
        if($cek2 == 0){
            if($cek->num_rows() == 1){
                $panjang_kirim = $cek->row("panjang_kirim");
                $jumlah_roll = $cek->row("jumlah_roll");
                if(floatval($panjang_kirim) < 1 AND floatval($jumlah_roll) < 1){
                    $this->db->query("DELETE FROM data_kain_keluar WHERE codeinput = '$id'");
                    $text = "Data berhasil dihapus";
                    echo json_encode(array("statusCode"=>200, "psn"=>$text));
                } else {
                    $text = "Anda harus menghapus semua data kiriman terlebih dahulu!!";
                    echo json_encode(array("statusCode"=>404, "psn"=>$text));
                }
            } else {
                $text = "ID tidak ditemukan!!";
                echo json_encode(array("statusCode"=>404, "psn"=>$text));
            }
        } else {
            $text = "Untuk menghapus kiriman anda perlu menghapus piutang terlebih dahulu";
            echo json_encode(array("statusCode"=>404, "psn"=>$text));
        }
        
  } //end
  function sendnotes(){
        $id = $this->input->post('id');
        $databenar = $this->input->post('databenar');
        $idproduk = $this->input->post('idproduk');
        $model = $this->input->post('model');
        $ukr = $this->input->post('ukr');
        $jumlah = $this->input->post('jumlah');
        if($databenar == "1" AND $idproduk!="" AND $model!="" AND $ukr!="" AND $jumlah!=""){
            $x1 = explode(',', $ukr);
            $x2 = explode(',', $jumlah);
            if(count($x1) == count($x2)){
                $data_benar = 0; $data_salah = 0;
                for($i=0; $i<count($x1); $i++){
                    if($x1[$i]!=""){
                        $data_benar++;
                    } else {
                        $data_salah++;
                    }
                    if($x2[$i]!="" AND intval($x2[$i]) > 0){
                        $data_benar++;
                    } else {
                        $data_salah++;
                    }
                }
                //echo $data_benar."-".$data_salah;
                if($data_salah == 0){
                    for($i=0; $i<count($x1); $i++){
                        $in_model = strtoupper($model);
                        $in_ukuran = strtoupper($x1[$i]);
                        $in_nama_produk = $this->data_model->get_byid('data_produk',['id_produk'=>$idproduk])->row("nama_produk");
                        $this->data_model->saved('data_kain_keluar_notes',[
                            'id_produk'=>$idproduk,
                            'nama_produk'=>$in_nama_produk,
                            'model_warna'=>$in_model,
                            'ukuran'=>$in_ukuran,
                            'jumlah'=>$x2[$i],
                            'codeinput'=>$id
                        ]);
                        $cek = $this->data_model->get_byid('data_produk_detil', ['nama_produk'=>$in_nama_produk,'warna_model'=>$in_model,'ukuran'=>$in_ukuran,'id_produk'=>$idproduk])->num_rows();
                        if($cek == 0){
                            $kodebar = $this->data_model->kodeBayar(5);
                            $cekbar = $this->data_model->get_byid('data_produk_detil',['kode_bar'=>$kodebar])->num_rows();
                            if($cekbar == 0){
                                $this->data_model->saved('data_produk_detil',[
                                    'nama_produk'=>$in_nama_produk,
                                    'warna_model'=>$in_model,
                                    'ukuran'=>$in_ukuran,
                                    'kode_bar' => $kodebar,
                                    'id_produk'=>$idproduk
                                ]);
                            } else {
                                $kodebar2 = $this->data_model->kodeBayar(5);
                                $this->data_model->saved('data_produk_detil',[
                                    'nama_produk'=>$in_nama_produk,
                                    'warna_model'=>$in_model,
                                    'ukuran'=>$in_ukuran,
                                    'kode_bar' => $kodebar2,
                                    'id_produk'=>$idproduk
                                ]);
                            }
                        }
                        //echo $idproduk."-".$model."-".$x1[$i]."-".$x2[$i]."<br>";
                    } //end for
                    $text = "sukses";
                    echo json_encode(array("statusCode"=>200, "psn"=>$text));
                } else {
                    $text = "Data yang anda masukan tidak sesuai";
                    echo json_encode(array("statusCode"=>404, "psn"=>$text));
                }
            } else {
                $text = "Jumlah data tidak sesuai";
                echo json_encode(array("statusCode"=>404, "psn"=>$text));
            }
        } else {
            $text = "Data tidak di isi dengan benar.!!";
            echo json_encode(array("statusCode"=>404, "psn"=>$text));
        }
  } //end
    function cariNotes(){
        $id = $this->input->post('id');
        $cek = $this->data_model->get_byid('data_kain_keluar_notes', ['id_nts'=>$id])->row_array();
        $nb = $cek['nb'];
        echo json_encode(array("statusCode"=>200, "nb"=>$nb));
    }
  function showNotes(){
        $id = $this->input->post('id');
        $cek = $this->data_model->get_byid('data_kain_keluar_notes', ['codeinput'=>$id]);
        if($cek->num_rows() > 0){
            foreach($cek->result() as $val){
                $idnts = $val->id_nts;
                $nb = $val->nb;
                $terpenuhi = $val->terpenuhi;
                echo "<tr>";
                echo "<td>".$val->nama_produk."</td>";
                echo "<td>".$val->model_warna."</td>";
                echo "<td>".$val->ukuran."</td>";
                echo "<td>".$val->jumlah."</td>";
                //echo "<td>".$terpenuhi."</td>";
                ?>
                    <td style="cursor:pointer;" onclick="note2s('<?=$idnts;?>','<?=$terpenuhi;?>')" data-toggle="modal" data-target="#Medium-modal">
                        <?=$terpenuhi;?>
                    </td>
                <?php
                if($nb=="null"){
                    ?>
                    <td style="cursor:pointer;" onclick="notes('<?=$idnts;?>')" data-toggle="modal" data-target="#modalsnotesBN">
                        <i class="icon-copy bi bi-chat-text"></i>
                    </td>
                    <?php
                } else {
                    ?>
                    <td style="cursor:pointer;" onclick="notes('<?=$idnts;?>')" data-toggle="modal" data-target="#modalsnotesBN">
                        <i class="icon-copy bi bi-chat-text" style="color:#389c03;"></i>
                    </td>
                    <?php
                }
                ?><td><a href="javascript:void(0)" onclick="delnotes('<?=$idnts;?>')"><i class="dw dw-trash" style="color:red;"></i></a></td><?php
                echo "</tr>";
            }
        }
  } //end
  function delNotes(){
    $id = $this->input->post('id');
    $this->db->query("DELETE FROM data_kain_keluar_notes WHERE id_nts = '$id'");
    echo "oke";
  } //end

  function showPembayaranPiutang(){
        $id = $this->input->post('id');
        $cek = $this->data_model->get_byid('hutang_produsen_bayar', ['kode_htgp'=>$id]);
        if($cek->num_rows()>0){
            $cek = $this->db->query("SELECT * FROM hutang_produsen_bayar WHERE kode_htgp='$id' ORDER BY tanggal_bayar DESC");
            $no=1;
            ?>
            <div class="table-responsive">
            <table class="table table-bordered table-hover table-full-width">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Metode Bayar</th>
                        <th>Nominal Bayar</th>
                        <th>Proses Pembayaran</th>
                        <th>Bukti Bayar</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
            <?php
            foreach($cek->result() as $val):
            ?>
               <tr>
                   <td><?=$no;?></td>
                   <td>
                        <?=date("d M Y", strtotime($val->tanggal_bayar));?>
                   </td>
                   <td><?=$val->metode_bayar;?></td>
                   <td>Rp. <?=number_format($val->nominal_bayar,0,',','.');?></td>
                   <td><?=$val->proses_bayar;?></td>
                   <td>
                    <?php if($val->bukti_bayar=="null"){ ?>
                    <i class="dw dw-image"></i>
                    <?php } else { ?>
                    <a href="<?=base_url('uploads/'.$val->bukti_bayar);?>" target="_blank"><i class="dw dw-image" style="color:blue;"></i></a>
                    <?php } ?>
                   </td>
                   <td><a href="javascript:void(0)" onclick="delPembayaranPiutang('<?=$val->id_hpb;?>')"><i class="dw dw-trash" style="color:red;"></i></a></td>
               </tr>
               <?php if($val->keterangan == "null" OR $val->keterangan == ""){} else { ?>
               <tr>
                    <td></td>
                    <td colspan="6">
                        Ket : <?=$val->keterangan;?>
                    </td>
               </tr>
            <?php }
                $no++;
            endforeach;
            echo "</tbody></table></div>";
        } else {
            echo "Belum ada data pembayaran piutang ini.";
        }
  } //end

  function delPembayaranPiutang(){
        $id = $this->input->post('id');
        $cek = $this->data_model->get_byid('hutang_produsen_bayar', ['id_hpb'=>$id])->row_array();
        $kode_htgp = $cek['kode_htgp'];
        $metode = $cek['metode_bayar'];
        $nominal_bayar = $cek['nominal_bayar'];
        if($metode == "Bayar"){
            $this->db->query("DELETE FROM flowcash WHERE alur='in' AND jumlah='$nominal_bayar' AND ket='PEMBAYARAN HUTANG' AND codeinput='$kode_htgp'");
            $this->db->query("DELETE FROM hutang_produsen_bayar WHERE id_hpb='$id'");
        } else {
            $this->db->query("DELETE FROM hutang_produsen_bayar WHERE id_hpb='$id'");
        }
        echo "oke";
  }
  function ceksjbrgmask(){
        $val = $this->input->post('val');
        $cek = $this->data_model->get_byid('data_produk_stok_masuk', ['suratjalan'=>$val])->num_rows();
        if($cek==0){
            echo json_encode(array("statusCode"=>200, "nb"=>"true"));
        } else {
            echo json_encode(array("statusCode"=>200, "nb"=>"false"));
        }
  } //end
  function cekmodel(){
        $kode1 = strtoupper($this->input->post('autoComplete'));
        $model = strtoupper($this->input->post('model'));
        $nama = strtoupper($this->input->post('nama'));
        $cek = $this->data_model->get_byid('data_produk_detil',['id_produk'=>$nama, 'warna_model'=>$model]);
        if($cek->num_rows() == 0){
            echo json_encode(array("statusCode"=>200, "nb"=>"true", "kode"=>"null"));
        } else {
            $kode = $cek->row("kode_bar");
            if($kode1 == $kode){
                echo json_encode(array("statusCode"=>200, "nb"=>"true", "kode"=>$kode));
            } else {
                echo json_encode(array("statusCode"=>200, "nb"=>"false", "kode"=>$kode));
            }
            
        }
  }
  function cekkodedetil(){
        $selection = strtoupper($this->input->post('selection'));
        $dt = $this->data_model->get_byid('data_produk_detil',['kode_bar1'=>$selection]);
        if($dt->num_rows() > 0){
            $dtrow = $this->db->query("SELECT * FROM data_produk_detil WHERE kode_bar1='$selection' LIMIT 1")->row_array();
            $id_produk = $dtrow['id_produk'];
            $nm_produk = $dtrow['nama_produk'];
            $warna = $dtrow['warna_model'];
            $ukuran = $dtrow['ukuran'];
            echo json_encode(array("statusCode"=>200, "psn"=>"true", "id_produk"=>$id_produk, "nm_produk"=>$nm_produk, "warna"=>$warna, "ukuran"=>$ukuran));
        } else {
            echo json_encode(array("statusCode"=>400, "psn"=>"Tidak ditemukan", "kode"=>"null"));
        }
        
  } //end
  function sendnotes2(){
    //data: {"kode":kode,"nmproduk":nmproduk,"model":model,"ukr":ukr,"jumlah":jumlah,"codeinput":codeinput,"hpp":hpp,"hargajual":hargajual},
    $codeinput  = $this->input->post('codeinput');
    $lokasi     = $this->data_model->get_byid('data_produk_stok_masuk',['codeinput'=>$codeinput])->row("lokasi");
    $kode       = strtoupper($this->input->post('kode'));
    $idproduk   = $this->input->post('nmproduk');
    $nmproduk   = $this->db->query("SELECT id_produk,nama_produk FROM data_produk WHERE id_produk='$idproduk'")->row("nama_produk");
    $nmproduk   = strtoupper($nmproduk);
    $model      = strtoupper($this->input->post('model'));
    $ukr        = strtoupper($this->input->post('ukr'));
    $jumlah     = preg_replace('/[^0-9]/', '', $this->input->post('jumlah'));
    $jumlah     = intval($jumlah);
    $hpp        = preg_replace('/[^0-9]/', '', $this->input->post('hpp'));
    $hargajual  = preg_replace('/[^0-9]/', '', $this->input->post('hargajual'));
    $code_sha   = $this->data_model->kodeBayar(10);
    $truee      = 1;
    $x          = explode('-',$kode);
    $kode_bar1  = $kode;
    $kode_bar   = $x[0];
    if($kode!="" AND $nmproduk!="" AND $model!="" AND $ukr!="" AND $jumlah!="" AND $hpp!="" AND $hargajual!=""){
        $cekproduk = $this->data_model->get_byid('data_produk_detil',['kode_bar1'=>$kode]);
        if($cekproduk->num_rows() == 0){
            $cekproduk2 = $this->data_model->get_byid('data_produk_detil',['nama_produk'=>$nmproduk,'warna_model'=>$model,'ukuran'=>$ukr]);
            if($cekproduk2->num_rows() == 0){
                $datalist = [
                    'nama_produk'=>strtoupper($nmproduk),
                    'warna_model'=>strtoupper($model),
                    'ukuran'=>strtoupper($ukr),
                    'kode_bar'=>$kode_bar,
                    'kode_bar1'=>strtoupper($kode),
                    'id_produk'=>$idproduk,
                    'harga_produk' => 0,
                    'harga_jual' => 0
                ];
                $this->data_model->saved('data_produk_detil',$datalist);
            }
            if($cekproduk2->num_rows() == 1){
                $kode = $cekproduk2->row("kode_bar1");
            }
            if($lokasi=="Gudang"){
                //Simpan ke Gudang (Agen ID 11) 
                for ($i=0; $i <$jumlah ; $i++) { 
                    $this->data_model->saved('data_produk_stok_onagen',[
                        'id_produk'=>$idproduk,
                        'kode_bar1'=>$kode_bar1,
                        'harga_produk'=>$hpp,
                        'harga_jual'=>$hargajual,
                        'code_sha'=>$code_sha,
                        'id_dis'=>11,
                        'code_send' => $codeinput
                    ]);
                }
            } else {
                //Simpan ke Toko 
                for ($i=0; $i <$jumlah ; $i++) { 
                    $this->data_model->saved('data_produk_stok',[
                        'id_produk'=>$idproduk,
                        'kode_bar1'=>$kode_bar1,
                        'harga_produk'=>$hpp,
                        'harga_jual'=>$hargajual,
                        'code_sha'=>$code_sha
                    ]);
                }
            }
            $datalist = ['kode_produk'=>$kode,'nama_produk'=>$nmproduk,'model'=>$model,'ukuran'=>$ukr,'jumlah'=>$jumlah,'harga_produk'=>$hpp,'harga_jual'=>$hargajual,'codeinput'=>$codeinput,'code_sha'=>$code_sha];
            $this->data_model->saved('data_produk_stok_masuk_notes',$datalist);
            $text = "sukses";
            echo json_encode(array("statusCode"=>200, "psn"=>$text));
        } else {
            if($cekproduk == 1){
                $_nama_produk = $cekproduk->row("nama_produk");
                $_model = $cekproduk->row("warna_model");
                $_ukr = $cekproduk->row("ukuran");
                if($_nama_produk==$nmproduk AND $_model==$model AND $_ukr==$ukr){
                    if($lokasi=="Gudang"){
                        //Simpan ke Gudang (Agen ID 11) 
                        for ($i=0; $i <$jumlah ; $i++) { 
                            $this->data_model->saved('data_produk_stok_onagen',[
                                'id_produk'=>$idproduk,
                                'kode_bar1'=>$kode_bar1,
                                'harga_produk'=>$hpp,
                                'harga_jual'=>$hargajual,
                                'code_sha'=>$code_sha,
                                'id_dis'=>11,
                                'code_send' => $codeinput
                            ]);
                        }
                    } else {
                        //Simpan ke Toko 
                        for ($i=0; $i <$jumlah ; $i++) { 
                            $this->data_model->saved('data_produk_stok',[
                                'id_produk'=>$idproduk,
                                'kode_bar1'=>$kode_bar1,
                                'harga_produk'=>$hpp,
                                'harga_jual'=>$hargajual,
                                'code_sha'=>$code_sha
                            ]);
                        }
                    }
                    $datalist = ['kode_produk'=>$kode,'nama_produk'=>$nmproduk,'model'=>$model,'ukuran'=>$ukr,'jumlah'=>$jumlah,'harga_produk'=>$hpp,'harga_jual'=>$hargajual,'codeinput'=>$codeinput,'code_sha'=>$code_sha];
                    $this->data_model->saved('data_produk_stok_masuk_notes',$datalist);
                    $text = "sukses";
                    echo json_encode(array("statusCode"=>200, "psn"=>$text));
                } else {
                    $text = "Kode ".$kode." adalah produk ".$nmproduk.", ".$model." ukuran ".$ukr; //error terjadi kode sudah di gunakan oleh produk detil yang lain
                    echo json_encode(array("statusCode"=>404, "psn"=>$text));
                }
            } else {
                $text = "Error Token - 2154"; //error terjadi karena doble kode di produk detil
                echo json_encode(array("statusCode"=>404, "psn"=>$text));
            }
        }
        
    } else {
        $text = "Data tidak di isi dengan benar.!!";
        echo json_encode(array("statusCode"=>404, "psn"=>$text));
    }
} //end
function showTable2(){
    $id = $this->input->post('id');
    $cek = $this->data_model->get_byid('data_produk_stok_masuk_notes', ['codeinput'=>$id]);
    if($cek->num_rows()>0){
        $no = 1;
        $semuaTotalHpp=0;
        $semuaTotalPcs=0;
        foreach($cek->result() as $val){
            $_hpp = $val->harga_produk;
            $_jml = $val->jumlah;
            $_totalHpp = $_hpp * $_jml;
            echo "<tr>";
            echo "<td>".$no++."</td>";
            echo "<td>".$val->kode_produk."</td>";
            echo "<td>".$val->nama_produk."</td>";
            echo "<td>".$val->model."</td>";
            echo "<td>".$val->ukuran."</td>";
            echo "<td>".$val->jumlah."</td>";
            echo "<td>Rp.".number_format($val->harga_produk, 0, ",", ".")."</td>"; 
            echo "<td>Rp.".number_format($_totalHpp, 0, ",", ".")."</td>"; 
            echo "<td>Rp.".number_format($val->harga_jual, 0, ",", ".")."</td>"; 
            ?>
            <td>
                <a href="javascript:void(0)">
                    <i class="fa fa-trash text-danger" onclick="hapusIn('<?=$val->idnotesin?>','<?=$id;?>')"></i>
                </a>
            </td>
            <?php
            echo "</tr>";
            $semuaTotalHpp += $_totalHpp;
            $semuaTotalPcs += $_jml;
        }
        echo '<tr class="bg-secondary text-white">';
        echo "<th colspan='5'>Total</th>";
        echo "<th>".number_format($semuaTotalPcs)."</th>";
        echo "<th></th>";
        echo "<th>Rp.".number_format($semuaTotalHpp, 0, ",", ".")."</th>"; 
        echo "<th></th>";
        echo "<th></th>";
        echo "</tr>";
    }
} //end

function hapusTablke(){
    $id         = $this->input->post('id');
    $codeinput  = $this->input->post('codeinput');
    $lokasi     = $this->data_model->get_byid('data_produk_stok_masuk', ['codeinput'=>$codeinput])->row("lokasi");
    $cek        = $this->data_model->get_byid('data_produk_stok_masuk_notes', ['idnotesin'=>$id]);
    if($cek->num_rows()==1){
        $codeinput = $cek->row("codeinput");
        $code_sha = $cek->row("code_sha");
        if($lokasi == "Toko"){
            $this->db->query("DELETE FROM data_produk_stok WHERE code_sha = '$code_sha'");
        } else {
            $this->db->query("DELETE FROM data_produk_stok_onagen WHERE code_sha = '$code_sha'");
        }
        $this->db->query("DELETE FROM data_produk_stok_masuk_notes WHERE idnotesin = '$id'");
        echo json_encode(array("statusCode"=>200, "psn"=>$codeinput));
    } else {
        echo json_encode(array("statusCode"=>400, "psn"=>"tes"));
    }
    
} //end
function delstokin(){
    $cd = $this->input->post('cd');
    $cek = $this->data_model->get_byid('data_produk_stok_masuk_notes', ['codeinput'=>$cd]);
    if($cek->num_rows() == 0){
        $this->db->query("DELETE FROM data_produk_stok_masuk WHERE codeinput = '$cd'");
        echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil menghapus"));
    } else {
        echo json_encode(array("statusCode"=>400, "psn"=>"Anda harus menghapus dulu semua stok yang masuk.!!"));
    }
} //end

}