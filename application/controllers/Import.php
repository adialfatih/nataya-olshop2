<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Import extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('data_model');
        date_default_timezone_set("Asia/Jakarta");
    }
    public function index(){
        echo "Token Erorr";
    }
    
    
    function importexcel(){
        $datetime = date('Y-m-d H:i:s');
        $kodeinput = $this->data_model->kodeBayar(10);
        
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        if(isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
            $arr_file = explode('.', $_FILES['upload_file']['name']);
            $extension = end($arr_file);
            if('csv' == $extension){
              $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
              $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
        
            $data_gagal = array(); $data_berhasil = array();
            for ($i=1; $i <count($sheetData) ; $i++) { 
                $data1 = $sheetData[$i][0];
                $data2 = $sheetData[$i][1];
                $data3 = $sheetData[$i][2];
                $data4 = $sheetData[$i][3];
                $data5 = $sheetData[$i][4];
                $data6 = $sheetData[$i][5];
                $data7 = $sheetData[$i][6];
                $data8 = $sheetData[$i][7];
                $data9 = $sheetData[$i][8];
                $data10 = $sheetData[$i][9];
                $data11 = $sheetData[$i][10];
                $data12 = $sheetData[$i][11];
                $data13 = $sheetData[$i][12];
                $data14 = $sheetData[$i][13];
                $data15 = $sheetData[$i][14];
                $data16 = $sheetData[$i][15];
                $data17 = $sheetData[$i][16];
                $data18 = $sheetData[$i][17];
                $data19 = $sheetData[$i][18];
                
                if($data1 == ""){ $kode = "NULL"; } else { $kode = $data1; }
                if($data2 == ""){ $idproduk = 0; } else { $idproduk = $data2; }
                if($data3 == ""){ $namaproduk = "NULL"; } else { $namaproduk = $data3; }
                if($data4 == ""){ $model = "NULL"; } else { $model = $data4; }
                if($data5 == ""){ $ukuranm = 0; } else { $ukuranm = intval($data5); }
                if($data6 == ""){ $ukuranl = 0; } else { $ukuranl = intval($data6); }
                if($data7 == ""){ $ukuranxl = 0; } else { $ukuranxl = intval($data7); }
                if($data8 == ""){ $ukuranxxl = 0; } else { $ukuranxxl = intval($data8); }
                if($data9 == ""){ $ukuranxxxl = 0; } else { $ukuranxxxl = intval($data9); }
                if($data10 == ""){ $ukuran2 = 0; } else { $ukuran2 = intval($data10); }
                if($data11 == ""){ $ukuran4 = 0; } else { $ukuran4 = intval($data11); }
                if($data12 == ""){ $ukuran6 = 0; } else { $ukuran6 = intval($data12); }
                if($data13 == ""){ $ukuran8 = 0; } else { $ukuran8 = intval($data13); }
                if($data14 == ""){ $ukuran10 = 0; } else { $ukuran10 = intval($data14); }
                if($data15 == ""){ $ukuran12 = 0; } else { $ukuran12 = intval($data15); }
                if($data16 == ""){ $ukuran14 = 0; } else { $ukuran14 = intval($data16); }
                if($data17 == ""){ $hpp = 0; } else { $hpp = intval($data17); }
                if($data18 == ""){ $hargajual = 0; } else { $hargajual = intval($data18); }
                if($data19 == ""){ $kdproduk = 0; } else { $kdproduk = $data19; }
                //echo "$kode - $idproduk - $namaproduk - $model - $ukuranm - $ukuranl - $ukuranxl - $ukuranxxl - $ukuranxxxl - $ukuran2 - $ukuran4 - $ukuran6 - $ukuran8 - $ukuran10 - $ukuran12 - $ukuran14 - $hpp - $hargajual - $kdproduk<br>";
                $tes = $this->db->query("SELECT id_produk,nama_produk FROM data_produk WHERE id_produk='$kdproduk'");
                if($tes->num_rows() == 1){
                    $real_nmproduk = $tes->row("nama_produk");
                    if($ukuranm != 0){
                        $kode_bar = $kode;
                        $kode_bar1 = $kode."-M";
                        $dtlist = [
                            'nama_produk' => $real_nmproduk,
                            'warna_model' => $model,
                            'ukuran' => 'M',
                            'kode_bar' => $kode_bar,
                            'kode_bar1' => $kode_bar1,
                            'id_produk' => $kdproduk,
                            'harga_produk' => $hpp,
                            'harga_jual' => $hargajual
                        ];
                        $cekthis = $this->data_model->get_byid('data_produk_detil',['kode_bar1'=>$kode_bar1]);
                        if($cekthis->num_rows()==0){
                            $cekthis2 = $this->data_model->get_byid('data_produk_detil',['nama_produk'=>$real_nmproduk,'warna_model'=>$model,'ukuran'=>'M']);
                            if($cekthis2->num_rows() == 0){
                                $this->data_model->saved('data_produk_detil',$dtlist); 
                            } else {
                                $kode_bar1 = $cekthis2->row("kode_bar1");
                            }
                        } 
                        for($a=1; $a<=$ukuranm; $a++){
                            $this->data_model->saved('data_produk_stok',['id_produk'=>$kdproduk,'kode_bar1'=>$kode_bar1,'harga_produk'=>$hpp,'harga_jual'=>$hargajual,'code_sha'=>$kodeinput]);
                        }
                    } //ukuran M
                    if($ukuranl != 0){
                        $kode_bar = $kode;
                        $kode_bar1 = $kode."-L";
                        $dtlist = [
                            'nama_produk' => $real_nmproduk,
                            'warna_model' => $model,
                            'ukuran' => 'L',
                            'kode_bar' => $kode_bar,
                            'kode_bar1' => $kode_bar1,
                            'id_produk' => $kdproduk,
                            'harga_produk' => $hpp,
                            'harga_jual' => $hargajual
                        ];
                        $cekthis = $this->data_model->get_byid('data_produk_detil',['kode_bar1'=>$kode_bar1]);
                        if($cekthis->num_rows()==0){
                            $cekthis2 = $this->data_model->get_byid('data_produk_detil',['nama_produk'=>$real_nmproduk,'warna_model'=>$model,'ukuran'=>'L']);
                            if($cekthis2->num_rows() == 0){
                                $this->data_model->saved('data_produk_detil',$dtlist); 
                            } else {
                                $kode_bar1 = $cekthis2->row("kode_bar1");
                            }
                        } 
                        for($a=1; $a<=$ukuranl; $a++){
                            $this->data_model->saved('data_produk_stok',['id_produk'=>$kdproduk,'kode_bar1'=>$kode_bar1,'harga_produk'=>$hpp,'harga_jual'=>$hargajual,'code_sha'=>$kodeinput]);
                        }
                    } //ukuran L
                    if($ukuranxl != 0){
                        $kode_bar = $kode;
                        $kode_bar1 = $kode."-XL";
                        $dtlist = [
                            'nama_produk' => $real_nmproduk,
                            'warna_model' => $model,
                            'ukuran' => 'XL',
                            'kode_bar' => $kode_bar,
                            'kode_bar1' => $kode_bar1,
                            'id_produk' => $kdproduk,
                            'harga_produk' => $hpp,
                            'harga_jual' => $hargajual
                        ];
                        $cekthis = $this->data_model->get_byid('data_produk_detil',['kode_bar1'=>$kode_bar1]);
                        if($cekthis->num_rows()==0){
                            $cekthis2 = $this->data_model->get_byid('data_produk_detil',['nama_produk'=>$real_nmproduk,'warna_model'=>$model,'ukuran'=>'XL']);
                            if($cekthis2->num_rows() == 0){
                                $this->data_model->saved('data_produk_detil',$dtlist); 
                            } else {
                                $kode_bar1 = $cekthis2->row("kode_bar1");
                            }
                        } 
                        for($a=1; $a<=$ukuranxl; $a++){
                            $this->data_model->saved('data_produk_stok',['id_produk'=>$kdproduk,'kode_bar1'=>$kode_bar1,'harga_produk'=>$hpp,'harga_jual'=>$hargajual,'code_sha'=>$kodeinput]);
                        }
                    } //ukuran XL
                    if($ukuranxxl != 0){
                        $kode_bar = $kode;
                        $kode_bar1 = $kode."-XXL";
                        $dtlist = [
                            'nama_produk' => $real_nmproduk,
                            'warna_model' => $model,
                            'ukuran' => 'XXL',
                            'kode_bar' => $kode_bar,
                            'kode_bar1' => $kode_bar1,
                            'id_produk' => $kdproduk,
                            'harga_produk' => $hpp,
                            'harga_jual' => $hargajual
                        ];
                        $cekthis = $this->data_model->get_byid('data_produk_detil',['kode_bar1'=>$kode_bar1]);
                        if($cekthis->num_rows()==0){
                            $cekthis2 = $this->data_model->get_byid('data_produk_detil',['nama_produk'=>$real_nmproduk,'warna_model'=>$model,'ukuran'=>'XXL']);
                            if($cekthis2->num_rows() == 0){
                                $this->data_model->saved('data_produk_detil',$dtlist); 
                            } else {
                                $kode_bar1 = $cekthis2->row("kode_bar1");
                            }
                        } 
                        for($a=1; $a<=$ukuranxxl; $a++){
                            $this->data_model->saved('data_produk_stok',['id_produk'=>$kdproduk,'kode_bar1'=>$kode_bar1,'harga_produk'=>$hpp,'harga_jual'=>$hargajual,'code_sha'=>$kodeinput]);
                        }
                    } //ukuran XXL
                    if($ukuranxxxl != 0){
                        $kode_bar = $kode;
                        $kode_bar1 = $kode."-XXXL";
                        $dtlist = [
                            'nama_produk' => $real_nmproduk,
                            'warna_model' => $model,
                            'ukuran' => 'XXXL',
                            'kode_bar' => $kode_bar,
                            'kode_bar1' => $kode_bar1,
                            'id_produk' => $kdproduk,
                            'harga_produk' => $hpp,
                            'harga_jual' => $hargajual
                        ];
                        $cekthis = $this->data_model->get_byid('data_produk_detil',['kode_bar1'=>$kode_bar1]);
                        if($cekthis->num_rows()==0){
                            $cekthis2 = $this->data_model->get_byid('data_produk_detil',['nama_produk'=>$real_nmproduk,'warna_model'=>$model,'ukuran'=>'XXXL']);
                            if($cekthis2->num_rows() == 0){
                                $this->data_model->saved('data_produk_detil',$dtlist); 
                            } else {
                                $kode_bar1 = $cekthis2->row("kode_bar1");
                            }
                        } 
                        for($a=1; $a<=$ukuranxxxl; $a++){
                            $this->data_model->saved('data_produk_stok',['id_produk'=>$kdproduk,'kode_bar1'=>$kode_bar1,'harga_produk'=>$hpp,'harga_jual'=>$hargajual,'code_sha'=>$kodeinput]);
                        }
                    } //ukuran XXXL
                    if($ukuran2 != 0){
                        $kode_bar = $kode;
                        $kode_bar1 = $kode."-2";
                        $dtlist = [
                            'nama_produk' => $real_nmproduk,
                            'warna_model' => $model,
                            'ukuran' => '2',
                            'kode_bar' => $kode_bar,
                            'kode_bar1' => $kode_bar1,
                            'id_produk' => $kdproduk,
                            'harga_produk' => $hpp,
                            'harga_jual' => $hargajual
                        ];
                        $cekthis = $this->data_model->get_byid('data_produk_detil',['kode_bar1'=>$kode_bar1]);
                        if($cekthis->num_rows()==0){
                            $cekthis2 = $this->data_model->get_byid('data_produk_detil',['nama_produk'=>$real_nmproduk,'warna_model'=>$model,'ukuran'=>'2']);
                            if($cekthis2->num_rows() == 0){
                                $this->data_model->saved('data_produk_detil',$dtlist); 
                            } else {
                                $kode_bar1 = $cekthis2->row("kode_bar1");
                            }
                        } 
                        for($a=1; $a<=$ukuran2; $a++){
                            $this->data_model->saved('data_produk_stok',['id_produk'=>$kdproduk,'kode_bar1'=>$kode_bar1,'harga_produk'=>$hpp,'harga_jual'=>$hargajual,'code_sha'=>$kodeinput]);
                        }
                    } //ukuran 2
                    if($ukuran4 != 0){
                        $kode_bar = $kode;
                        $kode_bar1 = $kode."-4";
                        $dtlist = [
                            'nama_produk' => $real_nmproduk,
                            'warna_model' => $model,
                            'ukuran' => '4',
                            'kode_bar' => $kode_bar,
                            'kode_bar1' => $kode_bar1,
                            'id_produk' => $kdproduk,
                            'harga_produk' => $hpp,
                            'harga_jual' => $hargajual
                        ];
                        $cekthis = $this->data_model->get_byid('data_produk_detil',['kode_bar1'=>$kode_bar1]);
                        if($cekthis->num_rows()==0){
                            $cekthis2 = $this->data_model->get_byid('data_produk_detil',['nama_produk'=>$real_nmproduk,'warna_model'=>$model,'ukuran'=>'4']);
                            if($cekthis2->num_rows() == 0){
                                $this->data_model->saved('data_produk_detil',$dtlist); 
                            } else {
                                $kode_bar1 = $cekthis2->row("kode_bar1");
                            }
                        } 
                        for($a=1; $a<=$ukuran4; $a++){
                            $this->data_model->saved('data_produk_stok',['id_produk'=>$kdproduk,'kode_bar1'=>$kode_bar1,'harga_produk'=>$hpp,'harga_jual'=>$hargajual,'code_sha'=>$kodeinput]);
                        }
                    } //ukuran 4
                    if($ukuran6 != 0){
                        $kode_bar = $kode;
                        $kode_bar1 = $kode."-6";
                        $dtlist = [
                            'nama_produk' => $real_nmproduk,
                            'warna_model' => $model,
                            'ukuran' => '6',
                            'kode_bar' => $kode_bar,
                            'kode_bar1' => $kode_bar1,
                            'id_produk' => $kdproduk,
                            'harga_produk' => $hpp,
                            'harga_jual' => $hargajual
                        ];
                        $cekthis = $this->data_model->get_byid('data_produk_detil',['kode_bar1'=>$kode_bar1]);
                        if($cekthis->num_rows()==0){
                            $cekthis2 = $this->data_model->get_byid('data_produk_detil',['nama_produk'=>$real_nmproduk,'warna_model'=>$model,'ukuran'=>'6']);
                            if($cekthis2->num_rows() == 0){
                                $this->data_model->saved('data_produk_detil',$dtlist); 
                            } else {
                                $kode_bar1 = $cekthis2->row("kode_bar1");
                            }
                        } 
                        for($a=1; $a<=$ukuran6; $a++){
                            $this->data_model->saved('data_produk_stok',['id_produk'=>$kdproduk,'kode_bar1'=>$kode_bar1,'harga_produk'=>$hpp,'harga_jual'=>$hargajual,'code_sha'=>$kodeinput]);
                        }
                    } //ukuran 6
                    if($ukuran8 != 0){
                        $kode_bar = $kode;
                        $kode_bar1 = $kode."-8";
                        $dtlist = [
                            'nama_produk' => $real_nmproduk,
                            'warna_model' => $model,
                            'ukuran' => '8',
                            'kode_bar' => $kode_bar,
                            'kode_bar1' => $kode_bar1,
                            'id_produk' => $kdproduk,
                            'harga_produk' => $hpp,
                            'harga_jual' => $hargajual
                        ];
                        $cekthis = $this->data_model->get_byid('data_produk_detil',['kode_bar1'=>$kode_bar1]);
                        if($cekthis->num_rows()==0){
                            $cekthis2 = $this->data_model->get_byid('data_produk_detil',['nama_produk'=>$real_nmproduk,'warna_model'=>$model,'ukuran'=>'8']);
                            if($cekthis2->num_rows() == 0){
                                $this->data_model->saved('data_produk_detil',$dtlist); 
                            } else {
                                $kode_bar1 = $cekthis2->row("kode_bar1");
                            }
                        }
                        for($a=1; $a<=$ukuran8; $a++){
                            $this->data_model->saved('data_produk_stok',['id_produk'=>$kdproduk,'kode_bar1'=>$kode_bar1,'harga_produk'=>$hpp,'harga_jual'=>$hargajual,'code_sha'=>$kodeinput]);
                        }
                    } //ukuran 8
                    if($ukuran10 != 0){
                        $kode_bar = $kode;
                        $kode_bar1 = $kode."-10";
                        $dtlist = [
                            'nama_produk' => $real_nmproduk,
                            'warna_model' => $model,
                            'ukuran' => '10',
                            'kode_bar' => $kode_bar,
                            'kode_bar1' => $kode_bar1,
                            'id_produk' => $kdproduk,
                            'harga_produk' => $hpp,
                            'harga_jual' => $hargajual
                        ];
                        $cekthis = $this->data_model->get_byid('data_produk_detil',['kode_bar1'=>$kode_bar1]);
                        if($cekthis->num_rows()==0){
                            $cekthis2 = $this->data_model->get_byid('data_produk_detil',['nama_produk'=>$real_nmproduk,'warna_model'=>$model,'ukuran'=>'10']);
                            if($cekthis2->num_rows() == 0){
                                $this->data_model->saved('data_produk_detil',$dtlist); 
                            } else {
                                $kode_bar1 = $cekthis2->row("kode_bar1");
                            }
                        } 
                        for($a=1; $a<=$ukuran10; $a++){
                            $this->data_model->saved('data_produk_stok',['id_produk'=>$kdproduk,'kode_bar1'=>$kode_bar1,'harga_produk'=>$hpp,'harga_jual'=>$hargajual,'code_sha'=>$kodeinput]);
                        }
                    } //ukuran 10
                    if($ukuran12 != 0){
                        $kode_bar = $kode;
                        $kode_bar1 = $kode."-12";
                        $dtlist = [
                            'nama_produk' => $real_nmproduk,
                            'warna_model' => $model,
                            'ukuran' => '12',
                            'kode_bar' => $kode_bar,
                            'kode_bar1' => $kode_bar1,
                            'id_produk' => $kdproduk,
                            'harga_produk' => $hpp,
                            'harga_jual' => $hargajual
                        ];
                        $cekthis = $this->data_model->get_byid('data_produk_detil',['kode_bar1'=>$kode_bar1]);
                        if($cekthis->num_rows()==0){
                            $cekthis2 = $this->data_model->get_byid('data_produk_detil',['nama_produk'=>$real_nmproduk,'warna_model'=>$model,'ukuran'=>'12']);
                            if($cekthis2->num_rows() == 0){
                                $this->data_model->saved('data_produk_detil',$dtlist); 
                            } else {
                                $kode_bar1 = $cekthis2->row("kode_bar1");
                            }
                        } 
                        for($a=1; $a<=$ukuran12; $a++){
                            $this->data_model->saved('data_produk_stok',['id_produk'=>$kdproduk,'kode_bar1'=>$kode_bar1,'harga_produk'=>$hpp,'harga_jual'=>$hargajual,'code_sha'=>$kodeinput]);
                        }
                    } //ukuran 12
                    if($ukuran14 != 0){
                        $kode_bar = $kode;
                        $kode_bar1 = $kode."-14";
                        $dtlist = [
                            'nama_produk' => $real_nmproduk,
                            'warna_model' => $model,
                            'ukuran' => '14',
                            'kode_bar' => $kode_bar,
                            'kode_bar1' => $kode_bar1,
                            'id_produk' => $kdproduk,
                            'harga_produk' => $hpp,
                            'harga_jual' => $hargajual
                        ];
                        $cekthis = $this->data_model->get_byid('data_produk_detil',['kode_bar1'=>$kode_bar1]);
                        if($cekthis->num_rows()==0){
                            $cekthis2 = $this->data_model->get_byid('data_produk_detil',['nama_produk'=>$real_nmproduk,'warna_model'=>$model,'ukuran'=>'14']);
                            if($cekthis2->num_rows() == 0){
                                $this->data_model->saved('data_produk_detil',$dtlist); 
                            } else {
                                $kode_bar1 = $cekthis2->row("kode_bar1");
                            }
                        } 
                        for($a=1; $a<=$ukuran14; $a++){
                            $this->data_model->saved('data_produk_stok',['id_produk'=>$kdproduk,'kode_bar1'=>$kode_bar1,'harga_produk'=>$hpp,'harga_jual'=>$hargajual,'code_sha'=>$kodeinput]);
                        }
                    } //ukuran 14
                    $data_berhasil[] = "Baris ke-".$i." berhasil di simpan di database";
                } else {
                    $data_gagal[] = "Baris ke-".$i." tidak di eksekusi karena produk dengan ID ".$kdproduk." tidak ditemukan.";
                }
            
                
            } //end for
            $this->data_model->saved('log_import_stok',['kode_log'=>$kodeinput,'tanggal_import'=>$datetime,'ygimport'=>$this->session->userdata('username')]);
            echo "Proses : <br>";
            for($g=0; $g<count($data_gagal); $g++){
                echo "<font style='color:red;'>".$data_gagal[$g]."</font><br>";
            }
            for($b=0; $b<count($data_berhasil); $b++){
                echo $data_berhasil[$b]."<br>";
            }
        } 
    }

} //end of class 