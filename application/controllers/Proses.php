<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proses extends CI_Controller
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

  public function simpan_user(){
        $nama = $this->data_model->clean($this->input->post('nama'));
        $username = $this->data_model->filter($this->input->post('username'));
        $pass = $this->input->post('pass');
        $idtipe = $this->input->post('idtipe');
        $akses2 = $this->data_model->clean($this->input->post('akses'));
        if($akses2=="Super"){
            $akses = "Super";
        } elseif($akses2=="Admin"){
            $akses = "Admin";
        } elseif($akses2=="User"){
            $akses = "User";
        } else {
            $akses = "User";
        }
        if($nama!="" AND $username!="" AND $pass!="" AND $akses!=""){
          $cek = $this->data_model->get_byid('table_users', ['username'=>$username]);
          if($idtipe == 0){
              if($cek->num_rows()==0){
                  $this->data_model->saved('table_users', [
                    'nama_admin' => $nama,
                    'username' => $username,
                    'password' => sha1($pass),
                    'akses' => $akses
                  ]);
                  $this->session->set_flashdata('sukses', 'User baru telah ditambahkan');
                  redirect(base_url('akses-users'));
              } else {
                  $this->session->set_flashdata('gagal', 'Username telah terdaftar. Gunakan username lain');
                  redirect(base_url('akses-users'));
              }
          } else {
              $cekid = $this->data_model->get_byid('table_users', ['idadm'=>$idtipe])->row_array();
              if($cekid['password'] == $pass){
                  $in_pass = $cekid['password'];
              } else {
                  $in_pass = sha1($pass);
              }
              if($cek->num_rows()==1){
                  $idadm = $cek->row("idadm");
                  if($idadm == $idtipe){
                      $this->data_model->updatedata('idadm',$idtipe, 'table_users', ['nama_admin'=>$nama,'username' => $username, 'password' => $in_pass, 'akses' => $akses]);
                      $this->session->set_flashdata('sukses', 'Update user berhasil.');
                      redirect(base_url('akses-users'));
                  } else {
                      $this->session->set_flashdata('gagal', 'Username sudah di gunakan');
                      redirect(base_url('akses-users'));
                  }
              } else {
                  $this->data_model->updatedata('idadm',$idtipe, 'table_users', ['nama_admin'=>$nama,'username' => $username, 'password' => $in_pass, 'akses' => $akses]);
                  $this->session->set_flashdata('sukses', 'Update user berhasil.');
                  redirect(base_url('akses-users'));
              }
          }
        } else {
            $this->session->set_flashdata('gagal', 'Anda tidak mengisi data dengan benar!!');
            redirect(base_url('akses-users'));
        }
  } //end

  function save_bot(){
        $this->load->library('upload');
        $pesan = $this->data_model->clean($this->input->post('pesanuser'));
        $tipe = $this->data_model->clean($this->input->post('tipebalasan'));
        $jawaban = $this->input->post('idreplay');
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'png|jpg|jpeg|doc|docx|xls|xlsx|pdf';
        $config['max_size'] = 6048; // Batas ukuran file 2 MB
        $config['encrypt_name'] = TRUE; // Supaya nama file terenkripsi
        $config['file_ext_tolower'] = TRUE; // Ekstensi file menjadi huruf kecil

        // Inisiasi konfigurasi upload
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('upload')) {
            // Menampilkan error jika upload gagal
            $error = array('error' => $this->upload->display_errors());
            //$this->load->view('upload_form', $error);
            // echo "<pre>";
            // print_r($error);
            // echo "</pre>";
            // echo "<br> $pesan <br> $tipe <br> $jawaban <br>";
            $dtlist = [
                'pesan' => $pesan,
                'jawaban' => $jawaban,
                'tipe_reply' => $tipe,
                'url_file' => 'null'
            ];
        } else {
            // Jika upload berhasil, tampilkan data file
            $data = array('upload_data' => $this->upload->data());
            //$this->load->view('upload_success', $data);
            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            // echo "<br> $pesan <br> $tipe <br> $jawaban <br>";
            $dt = $data['upload_data']['file_name'];
            $dtlist = [
                'pesan' => $pesan,
                'jawaban' => $jawaban,
                'tipe_reply' => $tipe,
                'url_file' => $dt
            ];
        }
        $this->data_model->saved('table_botwa', $dtlist);
        $this->session->set_flashdata('sukses', 'Berhasil menyimpan data');
        //redirect(base_url('bot'));
  } //end
  function save_produk_image(){
        $this->load->library('upload');
        $codeunik = $this->data_model->clean($this->input->post('codeunik'));
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'png|jpg|jpeg';
        $config['max_size'] = 6048; // Batas ukuran file 2 MB
        $config['encrypt_name'] = TRUE; // Supaya nama file terenkripsi
        $config['file_ext_tolower'] = TRUE; // Ekstensi file menjadi huruf kecil

        // Inisiasi konfigurasi upload
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('upload')) {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('gagal', $error['error']);
            redirect(base_url('product/'.$codeunik));
        } else {
            // Jika upload berhasil, tampilkan data file
            $data = array('upload_data' => $this->upload->data());
            $dt = $data['upload_data']['file_name'];
            $this->data_model->saved('gambar_produk',['codeunik'=>$codeunik,'url_gbr'=>$dt]);
            $this->session->set_flashdata('sukses', "Upload sukses");
            redirect(base_url('product/'.$codeunik));
        }
       
        
  } //end
  

  function save_produk(){
    $this->load->library('upload');
    $codeunik = $this->data_model->clean($this->input->post('codeunik'));
    $katproduk = $this->data_model->clean($this->input->post('katproduk'));
    $namaproduk = $this->data_model->clean($this->input->post('namaproduk'));
    $satuan = $this->data_model->clean($this->input->post('satuan'));
    $ketproduk = $this->data_model->clean($this->input->post('ketproduk'));
    $config['upload_path'] = './uploads/';
    $config['allowed_types'] = 'png|jpg|jpeg';
    $config['max_size'] = 6048; // Batas ukuran file 2 MB
    $config['encrypt_name'] = TRUE; // Supaya nama file terenkripsi
    $config['file_ext_tolower'] = TRUE; // Ekstensi file menjadi huruf kecil

    // Inisiasi konfigurasi upload
    $this->upload->initialize($config);

    if (!$this->upload->do_upload('upload')) {
        $error = array('error' => $this->upload->display_errors());
    } else {
        // Jika upload berhasil, tampilkan data file
        $data = array('upload_data' => $this->upload->data());
        $dt = $data['upload_data']['file_name'];
        $this->data_model->saved('gambar_produk',['codeunik'=>$codeunik,'url_gbr'=>$dt]);
    }
    $dtlist = [
        'codeunik' => $codeunik,
        'id_kat' => $katproduk,
        'nama_produk' => $namaproduk,
        'keterangan_produk' => $ketproduk,
        'satuan' => $satuan
    ];
    $this->data_model->saved('data_produk', $dtlist);
    $this->session->set_flashdata('sukses', 'Berhasil menyimpan data');
    redirect(base_url('product'));
} //end
  function save_kat(){
        $kat = $this->input->post('kat', TRUE);
        $ket = $this->input->post('ket', TRUE);
        $idtipe = $this->input->post('idtipe', TRUE);
        if($ket==""){ $ket="null"; }
        //echo $kat."<br>".htmlspecialchars($ket, ENT_QUOTES, 'UTF-8');
        if($idtipe==0){
            $cek = $this->data_model->get_byid('kategori_produk', ['kategori'=>$kat])->num_rows();
            if($cek==0){
                $this->data_model->saved('kategori_produk', ['kategori'=>$kat, 'keterangan'=>$ket]);
                $this->session->set_flashdata('sukses', 'Berhasil menyimpan data kategori');
                redirect(base_url('product'));
            } else {
                $this->session->set_flashdata('gagal', 'Kategori produk telah terdata');
                redirect(base_url('product'));
            }
        } else {
            $cek = $this->data_model->get_byid('kategori_produk', ['kategori'=>$kat]);
            if($cek->num_rows()==0){
                $this->data_model->updatedata('id_kat',$idtipe,'kategori_produk', ['kategori'=>$kat, 'keterangan'=>$ket]);
                $this->session->set_flashdata('sukses', 'Berhasil menyimpan data kategori');
                redirect(base_url('product'));
            } else {
                if($cek->num_rows()==1){
                    $id_kat = $cek->row('id_kat');
                    if($id_kat==$idtipe){
                        $this->data_model->updatedata('id_kat',$idtipe,'kategori_produk', ['kategori'=>$kat, 'keterangan'=>$ket]);
                        $this->session->set_flashdata('sukses', 'Berhasil menyimpan data kategori');
                        redirect(base_url('product'));
                    } else {
                        $this->session->set_flashdata('gagal', 'Kategori produk telah terdata');
                        redirect(base_url('product'));
                    }
                }
            }
        }
  } //end

  function update_produk(){
        $codeunik = $this->data_model->clean($this->input->post('codeunik'));
        $katproduk = $this->data_model->clean($this->input->post('kat'));
        $namaproduk = $this->data_model->clean($this->input->post('namaproduk'));
        $satuan = $this->data_model->clean($this->input->post('satuan'));
        $ket = $this->input->post('ket', TRUE);
        $this->data_model->updatedata('codeunik',$codeunik,'data_produk', ['id_kat'=>$katproduk, 'nama_produk'=>$namaproduk, 'satuan'=>$satuan, 'keterangan_produk'=>$ket]);
        $this->session->set_flashdata('sukses', 'Berhasil menyimpan data produk');
        redirect(base_url('product/'.$codeunik));
  } //end

  function save_distributor(){
        $nama = $this->data_model->clean($this->input->post('namadistributor'));
        $nowa = $this->data_model->clean($this->input->post('nowa'));
        $alamat = $this->input->post('almt', TRUE);
        $idtipe = $this->input->post('idtipe', TRUE);
        if($idtipe==0){
            if($nama!="" AND $nowa!="" AND $alamat!=""){
                $cek = $this->data_model->get_byid('data_distributor', ['nama_distributor'=>$nama])->num_rows();
                if($cek==0){
                $this->data_model->saved('data_distributor', ['nama_distributor'=>$nama, 'notelp'=>$nowa, 'alamat'=>$alamat]);
                $this->session->set_flashdata('sukses', 'Berhasil menyimpan data distributor');
                redirect(base_url('distributor'));
                } else {
                    $this->session->set_flashdata('gagal', 'Distributor telah terdata');
                    redirect(base_url('distributor'));
                }
            } else {
                $this->session->set_flashdata('gagal', 'Data tidak boleh kosong');
                redirect(base_url('distributor'));
            }
        } else {
            $cek = $this->data_model->get_byid('data_distributor', ['nama_distributor'=>$nama]);
            if($cek->num_rows()==0){
                $this->data_model->updatedata('id_dis',$idtipe,'data_distributor', ['nama_distributor'=>$nama, 'notelp'=>$nowa, 'alamat'=>$alamat]);
                $this->session->set_flashdata('sukses', 'Berhasil menyimpan data distributor');
                redirect(base_url('distributor'));
            } else {
                if($cek->num_rows()==1){
                    $id_distributor = $cek->row('id_dis');
                    if($id_distributor==$idtipe){
                        $this->data_model->updatedata('id_dis',$idtipe,'data_distributor', ['nama_distributor'=>$nama, 'notelp'=>$nowa, 'alamat'=>$alamat]);
                        $this->session->set_flashdata('sukses', 'Berhasil menyimpan data distributor');
                        redirect(base_url('distributor'));
                    } else {
                        $this->session->set_flashdata('gagal', 'Distributor telah terdata');
                        redirect(base_url('distributor'));
                    }
                }
            }
        }
        
  } //end

  function save_reseller(){
        $nama = $this->data_model->clean($this->input->post('namadistributor'));
        $nowa = $this->data_model->clean($this->input->post('nowa'));
        $alamat = $this->input->post('almt', TRUE);
        $idtipe = $this->input->post('idtipe', TRUE);
        if($idtipe==0){
            if($nama!="" AND $nowa!="" AND $alamat!=""){
                $cek = $this->data_model->get_byid('data_reseller', ['nama_reseller'=>$nama])->num_rows();
                if($cek==0){
                $this->data_model->saved('data_reseller', ['nama_reseller'=>$nama, 'notelp'=>$nowa, 'alamat'=>$alamat]);
                $this->session->set_flashdata('sukses', 'Berhasil menyimpan data reseller');
                redirect(base_url('reseller'));
                } else {
                    $this->session->set_flashdata('gagal', 'Reseller telah terdata');
                    redirect(base_url('reseller'));
                }
            } else {
                $this->session->set_flashdata('gagal', 'Data tidak boleh kosong');
                redirect(base_url('reseller'));
            }
        } else {
            $cek = $this->data_model->get_byid('data_reseller', ['nama_reseller'=>$nama]);
            if($cek->num_rows()==0){
                $this->data_model->updatedata('id_res',$idtipe,'data_reseller', ['nama_reseller'=>$nama, 'notelp'=>$nowa, 'alamat'=>$alamat]);
                $this->session->set_flashdata('sukses', 'Berhasil menyimpan data reseller');
                redirect(base_url('reseller'));
            } else {
                if($cek->num_rows()==1){
                    $id_distributor = $cek->row('id_res');
                    if($id_distributor==$idtipe){
                        $this->data_model->updatedata('id_res',$idtipe,'data_reseller', ['nama_reseller'=>$nama, 'notelp'=>$nowa, 'alamat'=>$alamat]);
                        $this->session->set_flashdata('sukses', 'Berhasil menyimpan data reseller');
                        redirect(base_url('reseller'));
                    } else {
                        $this->session->set_flashdata('gagal', 'Reseller telah terdata');
                        redirect(base_url('reseller'));
                    }
                }
            }
        }
        
  } //end

  function save_produsen(){
        $nama = $this->data_model->clean($this->input->post('namadistributor'));
        $nowa = $this->data_model->clean($this->input->post('nowa'));
        $alamat = $this->input->post('almt', TRUE);
        $idtipe = $this->input->post('idtipe', TRUE);
        if($idtipe==0){
            if($nama!="" AND $nowa!="" AND $alamat!=""){
                $cek = $this->data_model->get_byid('data_produsen', ['nama_produsen'=>$nama])->num_rows();
                if($cek==0){
                $this->data_model->saved('data_produsen', ['nama_produsen'=>$nama, 'notelp'=>$nowa, 'alamat'=>$alamat]);
                $this->session->set_flashdata('sukses', 'Berhasil menyimpan data produsen');
                redirect(base_url('produksi'));
                } else {
                    $this->session->set_flashdata('gagal', 'Produsen telah terdata');
                    redirect(base_url('produksi'));
                }
            } else {
                $this->session->set_flashdata('gagal', 'Data tidak boleh kosong');
                redirect(base_url('produksi'));
            }
        } else {
            $cek = $this->data_model->get_byid('data_produsen', ['nama_produsen'=>$nama]);
            if($cek->num_rows()==0){
                $this->data_model->updatedata('id_produsen',$idtipe,'data_produsen', ['nama_produsen'=>$nama, 'notelp'=>$nowa, 'alamat'=>$alamat]);
                $this->session->set_flashdata('sukses', 'Berhasil menyimpan data produsen');
                redirect(base_url('produksi'));
            } else {
                if($cek->num_rows()==1){
                    $id_distributor = $cek->row('id_produsen');
                    if($id_distributor==$idtipe){
                        $this->data_model->updatedata('id_produsen',$idtipe,'data_produsen', ['nama_produsen'=>$nama, 'notelp'=>$nowa, 'alamat'=>$alamat]);
                        $this->session->set_flashdata('sukses', 'Berhasil menyimpan data produsen');
                        redirect(base_url('produksi'));
                    } else {
                        $this->session->set_flashdata('gagal', 'Produsen telah terdata');
                        redirect(base_url('produksi'));
                    }
                }
            }
        }
        
  } //end

  function stok_in(){
        $codeinput = $this->data_model->clean($this->input->post('codeinput'));
        $id_barang = $this->data_model->clean($this->input->post('namaproduk'));
        $tgl = $this->input->post('tglmasuk', TRUE);
        $jumlah_masuk = $this->input->post('jumlah', TRUE);
        $ukuran = $this->input->post('ukuran', TRUE);
        $dari = $this->input->post('dari', TRUE);
        $ketproduk = $this->input->post('ketproduk', TRUE);
        $_satuan = $this->input->post('inputsatuan', TRUE);
        $_harga_beli = $this->input->post('hargabeli', TRUE);
        $hargabeli = str_replace('.', '', $_harga_beli);
        $_harga_jual = $this->input->post('hargajual', TRUE);
        $hargajual = str_replace('.', '', $_harga_jual);
        $yginput = $this->session->userdata('nama');

        if($tgl!="" AND $codeinput!="" AND $id_barang!="" AND $ukuran!="" AND $jumlah_masuk!="" AND $dari!=""){
            $jumlahArray = array_map('trim', explode(',', $jumlah_masuk));
            $ukuranArray = array_map('trim', explode(',', $ukuran));
            // Memeriksa kesesuaian jumlah
            if (count($jumlahArray) !== count($ukuranArray)) {
                $this->session->set_flashdata('gagal', 'Jumlah dan ukuran harus memiliki jumlah yang sama!');
                redirect(base_url('data-stok'));
            } else {
                $valid = true;

                // Memeriksa input yang valid
                for ($i = 0; $i < count($jumlahArray); $i++) {
                    if (!is_numeric($jumlahArray[$i]) || (int)$jumlahArray[$i] <= 0) {
                        //echo "<p style='color: red;'>Jumlah tidak valid pada data ke-" . ($i + 1) . "</p>";
                        $this->session->set_flashdata('gagal', 'Jumlah tidak valid pada data ke-' . ($i + 1) .'');
                        redirect(base_url('data-stok'));
                        $valid = false;
                    }
                    if (empty($ukuranArray[$i])) {
                        //echo "<p style='color: red;'>Ukuran tidak boleh kosong pada data ke-" . ($i + 1) . "</p>";
                        $this->session->set_flashdata('gagal', 'Ukuran tidak boleh kosong pada data ke-' . ($i + 1) .'');
                        redirect(base_url('data-stok'));
                        $valid = false;
                    }
                }

                if ($valid) {
                    //mulai proses simpan
                    for ($i = 0; $i < count($jumlahArray); $i++) {
                        $dtlist = [
                            'tgl_masuk' => $tgl,
                            'tms_tmp' => date('Y-m-d H:i:s'),
                            'id_barang' => $id_barang,
                            'jml_masuk' => $jumlahArray[$i],
                            'satuan' => $_satuan,
                            'ukuran' => $ukuranArray[$i],
                            'dari' => $dari,
                            'yg_input' => $yginput,
                            'kode_input' => $codeinput,
                            'harga_beli' => $hargabeli,
                            'harga_jual' => $hargajual,
                        ];
                        $this->data_model->saved('stok_in', $dtlist);
                        $cek = $this->data_model->get_byid('data_stok', ['id_barang'=>$id_barang,'ukuran'=>$ukuranArray[$i],'lokasi_dis'=>'0','harga_beli'=>$hargabeli,'harga_jual'=>$hargajual]);
                        if($cek->num_rows()==0){
                            $this->data_model->saved('data_stok', ['id_barang' => $id_barang, 'jumlah_barang'=>$jumlahArray[$i], 'ukuran' => $ukuranArray[$i], 'lokasi_dis'=>'0', 'harga_beli'=>$hargabeli, 'harga_jual'=>$hargajual]);
                            //gudang idnya adalah nol
                        } else {
                            if($cek->num_rows()==1){
                                $id_stok = $cek->row('idstok');
                                $jml = $cek->row('jumlah_barang');
                                $jml_now = $jml + $jumlahArray[$i];
                                $this->data_model->updatedata('idstok',$id_stok,'data_stok',['jumlah_barang'=>$jml_now]);
                            }
                        }
                    }
                    $this->session->set_flashdata('sukses', 'Berhasil menyimpan data');
                    redirect(base_url('data-stok'));
                }
            }
        } else {
            $this->session->set_flashdata('gagal', 'Anda tidak mengisi data dengan benar!!');
            redirect(base_url('data-stok'));
        }
  } //end
  function inputkain(){
      $namakain = $this->input->post('namakain');
      $satuan = $this->input->post('satuan');
      if($namakain!="" AND $satuan!=""){
        $this->data_model->saved('data_kain',['nama_kain'=>$namakain,'satuan'=>$satuan]);
        $this->session->set_flashdata('sukses', 'Berhasil menyimpan data kain');
        redirect(base_url('data-kain'));
      } else {
        $this->session->set_flashdata('gagal', 'Anda tidak mengisi data dengan benar!!');
        redirect(base_url('data-kain'));
      }
  } //end
  function savekain_masuk(){
        $this->load->library('upload');
        $codeinput = $this->data_model->acakKode(19);
        //$saldo = $this->data_model->getSaldo();
        $nosj = $this->input->post('nosj');
        $tglmasuk = $this->input->post('tglmasuk');
        $tglinput = date('Y-m-d H:i:s');
        $idkain = $this->input->post('namakain');
        $ket = $this->input->post('ket');
        //$jml = preg_replace('/\./', '', $this->input->post('jumlah'));
        //$roll = preg_replace('/\./', '', $this->input->post('roll'));
        $jml = preg_replace('/[^0-9]/', '', $this->input->post('jumlah'));
        $roll = preg_replace('/[^0-9]/', '', $this->input->post('roll'));
        $dari = $this->input->post('dari');
        // $hargabeli = preg_replace('/\./', '', $this->input->post('hargabeli'));
        // $hargakain = preg_replace('/\./', '', $this->input->post('hargakain'));
        $hargabeli = preg_replace('/[^0-9]/', '', $this->input->post('hargabeli'));
        $hargakain = preg_replace('/[^0-9]/', '', $this->input->post('hargakain'));

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
            'surat_jalan' => $nosj,
            'tgl_masuk' => $tglmasuk,
            'tgl_input' => $tglinput,
            'id_kain' => $idkain,
            'total_panjang' => $jml,
            'jumlah_roll' => $roll,
            'supplier' => strtoupper($dari),
            'harga_beli' => $hargabeli,
            'harga_permeter' => $hargakain,
            'gambar_foto' => $uploadan,
            'ket' => $ket,
            'yg_input' => $this->session->userdata('nama'),
            'codeinput' => $codeinput
        ];
        $cek = $this->data_model->get_byid('data_kain_masuk', ['surat_jalan'=>$nosj])->num_rows();
        if($cek==0){
            $this->data_model->saved('data_kain_masuk', $dtlist);
            $this->data_model->saved('tagihan',[
                'nama_supplier' => strtolower($dari),
                'jenis_tagihan' => 'PEMBELIAN KAIN',
                'nominal_tagihan' => $hargabeli,
                'tgl_awal_tagihan' => $tglmasuk,
                'status' => 'Belum Lunas',
                'codeinput' => $codeinput
            ]);
            $this->session->set_flashdata('sukses', 'Berhasil menyimpan data kain masuk');
            redirect(base_url('data-kain/id/'.$codeinput));
        } else {
            $this->session->set_flashdata('gagal', 'Surat jalan sudah di input!!');
            redirect(base_url('data-kain'));
        }
  } //end

  function delkain_masuk(){
        $code = $this->input->post('idkain');
        $dt = $this->data_model->get_byid('data_kain_masuk', ['codeinput'=>$code])->row_array();
        $jml = $this->data_model->get_byid('data_kain_masuk', ['codeinput'=>$code])->num_rows();
        if($jml == 1){
            $gambar = $dt['gambar_foto'];
            $this->db->query("DELETE FROM tagihan WHERE codeinput='$code'");
            $this->db->query("DELETE FROM stok_kain_masuk_history WHERE codeinput='$code'");
            $this->db->query("DELETE FROM stok_kain WHERE codeinput='$code'");
            $this->db->query("DELETE FROM data_kain_masuk WHERE codeinput='$code'");
            if($gambar!="null"){ unlink('./uploads/'.$gambar); }
            $this->session->set_flashdata('sukses', 'Berhasil menghapus data kain masuk');
            redirect(base_url('data-kain/masuk'));
        }
        $this->session->set_flashdata('sukses', 'Berhasil menghapus data kain masuk');
        redirect(base_url('data-kain/masuk'));
        
  } //end

  function kirim_kain(){
        $waktu_input = date('Y-m-d H:i:s');
        $codeinput_real = $this->data_model->acakKode(19);
        $tgl = $this->input->post('tglkirim');
        $namakain = $this->input->post('namakain');
        $x = explode('-', $tgl);
        $tahun = $x[0];
        $bulan = $x[1];
        $bulan_romawi = ['01' => 'I','02' => 'II','03' => 'III','04' => 'IV','05' => 'V','06' => 'VI','07' => 'VII','08' => 'VIII','09' => 'IX','10' => 'X','11' => 'XI','12' => 'XII'];
        $cek_sj = $this->db->query("SELECT * FROM data_kain_keluar WHERE YEAR(tgl_kirim)='$tahun' AND MONTH(tgl_kirim)='$bulan'");
        if($cek_sj->num_rows()==0){
            $codeinput = "SJ/001/".$bulan_romawi[$bulan]."/".$tahun;
        } else {
            $cek_sj = $this->db->query("SELECT * FROM data_kain_keluar WHERE YEAR(tgl_kirim)='$tahun' AND MONTH(tgl_kirim)='$bulan' ORDER BY id_kainout DESC LIMIT 1")->row("nosj");
            $xx = explode('/', $cek_sj);
            if(count($xx) == 4){
                $no = intval($xx[1]) + 1;
                $no2 = sprintf('%03s', $no);
                $codeinput = "SJ/".$no2."/".$bulan_romawi[$bulan]."/".$tahun;
            } else {
                $codeinput = $codeinput_real;
            }
        }
        $id_produsen = $this->input->post('produsen');
        $nilai = preg_replace('/[^0-9]/', '', $this->input->post('nilai'));
        if($tgl!="" && $id_produsen!="" && $nilai!=""){
            $dtlist = [
                'tgl_kirim' =>$tgl,
                'tgl_input' => $waktu_input,
                'id_produsen' => $id_produsen,
                'id_kain' => $namakain,
                'panjang_kirim' => 0,
                'jumlah_roll' => 0,
                'harga_barang_real' => 0,
                'harga_bayar' => $nilai,
                'yg_input' => $this->session->userdata('nama'),
                'codeinput' => $codeinput_real,
                'nosj' => $codeinput
            ];
            $this->data_model->saved('data_kain_keluar', $dtlist);
            $this->session->set_flashdata('sukses', 'Berhasil menyimpan data kain kirim');
            redirect(base_url('data-kain/kirim/id/'.$codeinput_real));
        } else {
            $this->session->set_flashdata('gagal', 'Anda tidak mengisi data dengan benar!!');
            redirect(base_url('data-kain'));
        }
        
  } //end
  function saldoawal(){
        $tgl = $this->input->post('tgl');
        $nilai = preg_replace('/\D/', '', $this->input->post('nilai'));
        $waktu = date('H:i:s');
        $newdatetime = $tgl." ".$waktu;
        $this->data_model->saved('flowcash', [
            'alur' => 'in',
            'jumlah' => $nilai,
            'tgl_waktu' => $newdatetime,
            'ket' => 'SALDO AWAL',
            'codeinput' => 'SLDAWL'
        ]);
        redirect(base_url('cash-flow'));
    } //end
    function save_per_item(){
        $codeinput = $this->input->post('codeinput');
        $codekain = $this->input->post('codekain');
        $namakain = $this->input->post('namakain');
        $jmlroll = $this->input->post('jmlroll');
        $idkain = $this->input->post('ididkain');
        $totalpanjang = $this->input->post('totalpanjang');
        $harga_satuan = $this->input->post('harga_satuan');
        if($codeinput != '' AND $codekain != '' AND $namakain != '' AND $jmlroll != '' AND $totalpanjang != ''){
            $this->data_model->saved('stok_kain_masuk_history', [
                'id_kain' => $idkain,
                'total_panjang' => $totalpanjang,
                'jumlah_roll' => $jmlroll,
                'harga_satuan' => $harga_satuan,
                'kode_kain' => $codekain,
                'nama_kain' => $namakain,
                'codeinput' => $codeinput,
            ]);
            for($i=0; $i <$jmlroll ; $i++){
                $this->data_model->saved('stok_kain', [
                    'id_kain' => $idkain,
                    'total_panjang' => $totalpanjang,
                    'jumlah_roll' => '1',
                    'harga_satuan' => $harga_satuan,
                    'kode_kain' => $codekain,
                    'nama_kain' => $namakain,
                    'codeinput' => $codeinput,
                ]);
            }
            
            redirect(base_url('data-kain/id/'.$codeinput));
        } else {
            $this->session->set_flashdata('gagal', 'Anda harus mengisi data penerimaan kain dengan benar!!');
            redirect(base_url('data-kain/id/'.$codeinput));
        }
    } //end

    function save_foto_sj(){
        $this->load->library('upload');
        $codeinput = $this->input->post('codeinput');
        $tglinput = date('Y-m-d H:i:s');

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
            $this->session->set_flashdata('gagal', 'Gagal menyimpan gambar');
            redirect(base_url('data-kain/id/'.$codeinput));
        } else {
            // Jika upload berhasil, tampilkan data file
            $data = array('upload_data' => $this->upload->data());
            $uploadan = $data['upload_data']['file_name'];
            $cek = $this->data_model->get_byid('data_kain_masuk', ['codeinput' => $codeinput])->row("gambar_foto");
            if($cek == "null"){
                $this->data_model->updatedata('codeinput', $codeinput, 'data_kain_masuk', ['gambar_foto' => $uploadan]);
            } else {
                $this->data_model->saved('data_kain_masuk_sj', ['codeinput' => $codeinput,'gambar_foto' => $uploadan]);
            }
            $this->session->set_flashdata('sukses', 'Berhasil menyimpan gambar');
            redirect(base_url('data-kain/id/'.$codeinput));
        }
        
        
    } //end

    function saveupdatekain(){
        $codeinput = $this->input->post('codeinputupdate');
        $surat_jalan = $this->input->post('surat_jalan');
        $tgl = $this->input->post('tgl');
        $roll = preg_replace('/[^0-9]/', '', $this->input->post('roll'));
        $total_panjang = preg_replace('/[^0-9]/', '', $this->input->post('total_panjang'));
        $harga_beli = preg_replace('/[^0-9]/', '', $this->input->post('harga_beli'));
        $harga_satuan = preg_replace('/[^0-9]/', '', $this->input->post('harga_satuanup'));
        if($harga_satuan == "0"){
            $harga_satuan = $harga_beli / $total_panjang;
            $harga_satuan = round($harga_satuan);
        }
        $supplier = $this->input->post('supplier');
        $ket = $this->input->post('ket');
        if($codeinput != '' AND $surat_jalan != '' AND $tgl != '' AND $roll != '' AND $total_panjang != '' AND $harga_beli != '' AND $harga_satuan != '' AND $supplier != ''){
            $this->data_model->updatedata('codeinput', $codeinput, 'data_kain_masuk', [
                'surat_jalan' => $surat_jalan,
                'tgl_masuk' => $tgl,
                'total_panjang' => $total_panjang,
                'jumlah_roll' => $roll,
                'supplier' => $supplier,
                'harga_beli' => $harga_beli,
                'harga_permeter' => $harga_satuan,
                'ket' => $ket
            ]);
            $this->data_model->updatedata('codeinput', $codeinput, 'stok_kain', ['harga_satuan'=>$harga_satuan]);
            $this->data_model->updatedata('codeinput', $codeinput, 'tagihan', ['nominal_tagihan'=>$harga_beli]);
            $this->session->set_flashdata('sukses', 'Berhasil menyimpan data');
            redirect(base_url('data-kain/id/'.$codeinput));
        }
    }//end

    function savepembayaran(){
        $kodesha = $this->input->post('kodesha');
        $kodebayar = $this->data_model->kodeBayar(10);
        //$codeinput = $this->input->post('kodedasar');
        $nama_sup =strtolower($this->input->post('nama_sup'));
        $all_tagihan = $this->data_model->get_byid('tagihan',['nama_supplier'=>$nama_sup,'status'=>'Belum Lunas'])->result();
        $tgl = $this->input->post('tglmasuk');
        $nominal = preg_replace('/[^0-9]/', '', $this->input->post('nominal'));
        $ket = $this->input->post('ket');
        $prosesbayar = $this->input->post('prosesbayar');
        $ket = $this->input->post('ket');

        $this->load->library('upload');

        $tglinput = date('Y-m-d H:i:s');

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
            $data = array('upload_data' => $this->upload->data());
            $uploadan = $data['upload_data']['file_name'];
        }
        if($tgl != '' AND $nominal != '' AND $prosesbayar != ''){
            $this->data_model->saved('tagihan_bayar',[
                'codeinput' => "tes",
                'tgl_bayar' => $tgl,
                'tgl_input' => $tglinput,
                'nominal_bayar' => $nominal,
                'proses_pembayaran' => $prosesbayar,
                'bukti_bayar' => $uploadan,
                'ket' => $ket,
                'yg_input' => $this->session->userdata('nama'),
                'codebayar' => $kodebayar,
                'nm' => $nama_sup
            ]);
            $sisa_uang = $nominal;
            $nominal_bayar = $nominal;
            foreach($all_tagihan as $val){
                $id_tagihan = $val->id_tagihan;
                $nominal_tagihan = $val->nominal_tagihan;
                $total_bayar = $this->db->query("SELECT SUM(nominal) AS jml FROM tagihan_bayar2 WHERE id_tagihan='$id_tagihan'")->row("jml");
                $kekurangan_bayar = $nominal_tagihan - $total_bayar;
                if($sisa_uang>0){
                    if($sisa_uang >= $kekurangan_bayar){
                        $this->data_model->saved('tagihan_bayar2',['codebayar'=>$kodebayar,'id_tagihan'=>$id_tagihan,'nominal'=>$kekurangan_bayar]);
                        $this->data_model->updatedata('id_tagihan', $id_tagihan, 'tagihan', ['status'=>'Lunas']);
                        $sisa_uang = $sisa_uang - $kekurangan_bayar;
                    } else {
                        $this->data_model->saved('tagihan_bayar2',['codebayar'=>$kodebayar,'id_tagihan'=>$id_tagihan,'nominal'=>$sisa_uang]);
                        $sisa_uang = $sisa_uang - $kekurangan_bayar;
                    }
                } else { 
                    break; 
                }
            }
            if($sisa_uang > 0){
                $this->data_model->saved('tagihan_kelebihan', [
                    'nama_supplier' => $nama_sup,
                    'nominal_lebih' => $sisa_uang,
                    'codebayar' => $kodebayar
                ]);
            }
            $this->data_model->saved('flowcash', [
                'alur' => 'out',
                'jumlah' => $nominal,
                'tgl_waktu' => $tglinput,
                'ket' => 'PEMBAYARAN KAIN',
                'codeinput' => $kodebayar
            ]);
            // $total_bayar = $this->db->query("SELECT SUM(nominal_bayar) AS jml FROM tagihan_bayar WHERE codeinput='$codeinput'")->row("jml");
            // $total_bayar2 = $this->db->query("SELECT * FROM tagihan WHERE codeinput='$codeinput'")->row("nominal_tagihan");
            // if($total_bayar >= $total_bayar2){
            //     $this->data_model->updatedata('codeinput', $codeinput, 'tagihan', [
            //         'status' => 'LUNAS'
            //     ]);
            // }
            $this->session->set_flashdata('sukses', 'Menyimpan data pembayaran');
            redirect(base_url('tagihan/id/'.$kodesha));
        } else {
            $this->session->set_flashdata('gagal', 'Anda harus mengisi data pembayaran dengan benar!!');
            redirect(base_url('tagihan/id/'.$kodesha));
        }
    } //end
    function savepembayaranhutang(){
        $idhutang = $this->input->post('idhutang');
        $idid = $this->input->post('idid');
        $metode = $this->input->post('metode');
        $tglmasuk = $this->input->post('tglmasuk');
        $nominal = preg_replace('/[^0-9]/', '', $this->input->post('nominal'));
        $ket = $this->input->post('ket');
        $prosesbayar = $this->input->post('prosesbayar');

        $this->load->library('upload');

        $tglinput = date('Y-m-d H:i:s');

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
            $data = array('upload_data' => $this->upload->data());
            $uploadan = $data['upload_data']['file_name'];
        }
        if($ket == ""){
            $ket = "null";
        }
        if($idhutang != '' AND $metode != '' AND $tglmasuk != '' AND $nominal != ''){
            $this->data_model->saved('hutang_produsen_bayar',[
                'kode_htgp' => $idhutang,
                'metode_bayar' => $metode,
                'tanggal_bayar' => $tglmasuk,
                'tanggal_input' => $tglinput,
                'yg_input' => $this->session->userdata('nama'),
                'nominal_bayar' => $nominal,
                'bukti_bayar' => $uploadan,
                'proses_bayar' => $prosesbayar,
                'keterangan' => $ket
            ]);
            if($metode != "Exchange"){
                $this->data_model->saved('flowcash', [
                   'alur' => 'in',
                   'jumlah' => $nominal,
                   'tgl_waktu' => $tglinput,
                   'ket' => 'PEMBAYARAN HUTANG',
                   'codeinput' => $idhutang
                ]);
            }
            $this->session->set_flashdata('sukses', 'Menyimpan data pembayaran');
            redirect(base_url('piutang/id/'.$idid));
        } else {
            $this->session->set_flashdata('gagal', 'Anda harus mengisi data pembayaran dengan benar!!');
            redirect(base_url('piutang/id/'.$idid));
        }
    } //end

    function updatepengiriman(){
        $newsj = $this->input->post('newsj');
        $oldsj = $this->input->post('oldsj');
        //$newjmlbayar = $this->input->post('newjmlbayar');
        //$oldjmlbayar = $this->input->post('oldjmlbayar');
        $newjmlbayar = preg_replace('/[^0-9]/', '', $this->input->post('newjmlbayar'));
        $oldjmlbayar = preg_replace('/[^0-9]/', '', $this->input->post('oldjmlbayar'));
        $codeinput = $this->input->post('codeinput');
        $modal = $this->data_model->get_byid('data_kain_keluar',['codeinput'=>$codeinput])->row("harga_barang_real");

        if($newsj == $oldsj){
            $this->data_model->updatedata('codeinput', $codeinput, 'data_kain_keluar', [
                'harga_bayar' => $newjmlbayar
            ]);
            $this->data_model->updatedata('code_kiriman', $codeinput, 'hutang_produsen', ['harga_barang'=>$modal,'jumlah_hutang'=>$newjmlbayar]);
            $this->session->set_flashdata('sukses', 'Data berhasil di update');
            redirect(base_url('data-kain/kirim/id/'.$codeinput));
        } else {
            $cek = $this->data_model->get_byid('data_kain_keluar', ['nosj'=>$newsj])->num_rows();
            if($cek == 0){
                $this->data_model->updatedata('codeinput', $codeinput, 'data_kain_keluar', [
                    'harga_bayar' => $newjmlbayar,
                    'nosj'=>$newsj
                ]);
                $this->data_model->updatedata('code_kiriman', $codeinput, 'hutang_produsen', ['harga_barang'=>$modal,'jumlah_hutang'=>$newjmlbayar]);
                $this->session->set_flashdata('sukses', 'Data berhasil di update');
                redirect(base_url('data-kain/kirim/id/'.$codeinput));
            } else {
                $this->session->set_flashdata('gagal', 'Data gagal di update');
                redirect(base_url('data-kain/kirim/id/'.$codeinput));
            }
        }
    } //end

    function addPiutang(){
        $codeinput = $this->input->post('codekiriman');
        $cek = $this->data_model->get_byid('data_kain_keluar', ['codeinput'=>$codeinput]);
        if($cek->num_rows() == 1){
            $kode_htg = $this->data_model->kodeBayar(6);
            $id_produsen = $cek->row("id_produsen");
            $harga_barang = $cek->row("harga_barang_real");
            $jumlah_hutang = $cek->row("harga_bayar");
            $ceklagi = $this->data_model->get_byid('hutang_produsen', ['id_produsen'=>$id_produsen, 'code_kiriman'=>$codeinput])->num_rows();
            if($ceklagi == 0){
                $this->data_model->saved('hutang_produsen',[
                    'id_produsen' => $id_produsen,
                    'code_kiriman' => $codeinput,
                    'harga_barang' => $harga_barang,
                    'jumlah_hutang' => $jumlah_hutang,
                    'kode_htgp' => $kode_htg
                ]);
            }
            $this->session->set_flashdata('sukses', 'Berhasil menyimpan piutang');
            redirect(base_url('data-kain/kirim/id/'.$codeinput));
        } else {
            $this->session->set_flashdata('gagal', 'ID tidak ditemukan');
            redirect(base_url('data-kain/kirim/id/'.$codeinput));
        }
    } //end

    function aksesprodusen(){
        $idtipe = $this->input->post('idtipe');
        $idprodusen2 = $this->input->post('idprodusen2');
        $namadistributor = $this->input->post('namadistributor');
        $usernames = $this->input->post('usernames');
        $pass = $this->input->post('pass');
        if($idtipe!="" AND $namadistributor!="" AND $usernames!="" AND $pass!=""){
            $this->data_model->updatedata('id_produsen',$idprodusen2,'data_produsen',['user_login'=>$usernames,'user_pass'=>$pass,'user_token'=>sha1($pass)]);
            $this->session->set_flashdata('sukses', 'Berhasil menyimpan data login');
            redirect(base_url('produksi'));
        } else {
            $this->session->set_flashdata('gagal', 'Mohon isi form dengan benar!!');
            redirect(base_url('produksi'));
        }
        
    } //end

    function addnotes2(){
        $id = $this->input->post('idnts');
        $code = $this->data_model->get_byid('data_kain_keluar_notes', ['id_nts'=>$id])->row("codeinput");
        $notes = $this->input->post('notes');
        $this->data_model->updatedata('id_nts',$id,'data_kain_keluar_notes',[
            'nb' => $notes
        ]);
        redirect(base_url('data-kain/kirim/id/'.$code));
    } //end
    function addnotes3(){
        $id = $this->input->post('idnts');
        $code = $this->data_model->get_byid('data_kain_keluar_notes', ['id_nts'=>$id])->row("codeinput");
        $terpenuhi = $this->input->post('terpenuhi');
        $this->data_model->updatedata('id_nts',$id,'data_kain_keluar_notes',[
            'terpenuhi' => $terpenuhi
        ]);
        redirect(base_url('data-kain/kirim/id/'.$code));
    } //end
    function saveprodukmasuk(){
        $codeinput = $this->data_model->acakKode(19);
        $sj = $this->input->post('sj', TRUE);
        $tglmasuk = $this->input->post('tglmasuk', TRUE);
        $idprodusen = $this->input->post('idprodusen', TRUE);
        $tagihan = $this->input->post('tagihan', TRUE);
        $diterimadi = $this->input->post('diterimadi', TRUE);
        $tglinput = date('Y-m-d H:i:s');
        $totalharga = preg_replace('/[^0-9]/', '', $this->input->post('totalharga'));
        //echo "$codeinput <br> $sj <br> $tglmasuk <br> $idprodusen <br> $totalharga <br> $tagihan";
        
        $this->load->library('upload');

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
            $data = array('upload_data' => $this->upload->data());
            $uploadan = $data['upload_data']['file_name'];
        }
        
        if($sj != '' AND $tglmasuk != '' AND $idprodusen != '' AND $totalharga != '' AND $diterimadi != ''){
            $nama_produsen2 = $this->data_model->get_byid('data_produsen',['id_produsen'=>$idprodusen])->row('nama_produsen');
            $nama_produsen = strtolower($nama_produsen2);
            $this->data_model->saved('data_produk_stok_masuk',[
                'suratjalan' => $sj,
                'tgl_masuk' => $tglmasuk,
                'tgl_input' => $tglinput,
                'yg_input' => $this->session->userdata('nama'),
                'id_produsen' => $idprodusen,
                'total_nilai_barang' => $totalharga,
                'masuk_tagihan' => $tagihan=='yes'?'yes':'no',
                'gambar' => $uploadan,
                'codeinput' => $codeinput,
                'lokasi' => $diterimadi=='Gudang' ?'Gudang':'Toko'
            ]);
            if($tagihan=="yes"){
                $this->data_model->saved('tagihan', [
                    'nama_supplier' => $nama_produsen,
                    'jenis_tagihan' => 'PEMBAYARAN PRODUK',
                    'nominal_tagihan' => $totalharga,
                    'tgl_awal_tagihan' => $tglmasuk,
                    'status' => 'Belum Lunas',
                    'codeinput' => $codeinput
                ]);
            }
            redirect(base_url('data-stok/masuk/'.$codeinput));
        } else {
            $this->session->set_flashdata('gagal', 'Anda harus mengisi data pembayaran dengan benar!!');
            redirect(base_url('data-stok'));
        }
    } //end

    function updatekodeproduk(){
        $id = $this->input->post('idid');
        $produk = $this->input->post('produkmodel');
        $nilai = $this->input->post('nilai');
        if($id != '' AND $produk != '' AND $nilai != ''){
            $ukuran = $this->data_model->get_byid('data_produk_detil', ['id_produkdetil'=>$id])->row('ukuran');
            $new = $nilai."-".$ukuran;
            $this->data_model->updatedata('id_produkdetil', $id, 'data_produk_detil', [
                'kode_bar' => $new,
                'kode_bar1' => $nilai
            ]);
            $this->session->set_flashdata('sukses', 'Berhasil update kode produk');
            redirect(base_url('product/data-stok'));
        } else {
            $this->session->set_flashdata('gagal', 'Anda harus mengisi data dengan benar!!');
            redirect(base_url('product/data-stok'));
        }
    } //emnd

}



?>
