<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Exportexcel extends CI_Controller {
public function __construct(){
    parent::__construct();
    $this->load->model('data_model');
    date_default_timezone_set("Asia/Jakarta");
}
public function index(){
    $this->load->view('spreadsheet');
}
    function rekap(){
        $dep = $this->uri->segment(3);
        $tgl1 = $this->uri->segment(4);
        $tgl2 = $this->uri->segment(5);
        $blns = [ '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agu', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des', ];
        if($tgl1 == $tgl2){
            $xx = explode('-',$tgl1);
            $printTgl = $xx[2]." ".$blns[$xx[1]]." ".$xx[0];
            $filename = 'Data Rekap Absensi Tanggal '.$printTgl.''; 
        } else {
            $xx = explode('-',$tgl1);
            $printTgl = $xx[2]." ".$blns[$xx[1]]." ".$xx[0];
            $xx2 = explode('-',$tgl2);
            $printTgl2 = $xx2[2]." ".$blns[$xx2[1]]." ".$xx2[0];
            $filename = 'Data Rekap Absensi Tanggal '.$printTgl.' s/d '.$printTgl2.''; 
        }
        $events = array();
        $table_event = $this->data_model->get_record('table_events');
        foreach($table_event->result() as $val2){
            $start_event = $val2->start_event;
            $end_event = $val2->end_event;
            if($start_event == $end_event){
                $events[] = $start_event;
            } else {
                $startDate = new DateTime($start_event);
                $endDate = new DateTime($end_event);
                $endDate->modify('+1 day');
                $interval = new DateInterval('P1D');
                $dateRange = new DatePeriod($startDate, $interval, $endDate);
                foreach ($dateRange as $date) {
                    $events[]= $date->format("Y-m-d");
                }
            }
        }
        $liburnasional = 0;
                $startDate = new DateTime($tgl1);
                $endDate = new DateTime($tgl2);
                $endDate->modify('+1 day');
                $interval = new DateInterval('P1D');
                $dateRange = new DatePeriod($startDate, $interval, $endDate);
                foreach ($dateRange as $date) {
                    foreach ($events as $harievents) {
                        if($date->format('Y-m-d') == $harievents){
                            $liburnasional += 1;
                        }
                    }
                }
        //$st = $this->uri->segment(4);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->mergeCells('B2:Q2');
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        $style_row2 = [
            'font' => [
                'bold' => true, // Set font jadi bold
                'color' => ['rgb' => 'FF0000'] // Set warna font menjadi merah
            ],
            'alignment' => [
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        $style_row3 = [
            'font' => [
                'bold' => true, // Set font jadi bold
                'color' => ['rgb' => '1D8207'] // Set warna font menjadi hijau
            ],
            'alignment' => [
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        $sheet->setCellValue('B2', $filename); // Set kolom A1 
        //$sheet->setCellValue('C2', "".$nama_cus.""); // Set kolom A1 
        $sheet->setCellValue('B4', "NO"); // Set kolom A1 
        $sheet->setCellValue('C4', "NRP"); // Set kolom A1 
        $sheet->setCellValue('D4', "NAMA KARYAWAN"); // Set kolom A1 
        $sheet->setCellValue('E4', "DEPARTEMENT"); // Set kolom A1 
        $sheet->setCellValue('F4', "DIVISI"); // Set kolom A1 
        $sheet->setCellValue('G4', "JABATAN"); // Set kolom A1 
        $sheet->setCellValue('H4', "HARI LIBUR"); // Set kolom A1 
        $sheet->setCellValue('I4', "HARI KERJA SEBULAN"); // Set kolom A1 
        $sheet->setCellValue('J4', "TOTAL ABSENSI"); // Set kolom A1 
        $sheet->setCellValue('K4', "TERLAMBAT / PLG CEPAT(Menit)"); // Set kolom A1 
        $sheet->setCellValue('L4', "HARI KERJA AKTIF"); // Set kolom A1 
        $sheet->setCellValue('M4', "KJK (Jam)"); // Set kolom A1 
        $sheet->setCellValue('N4', "LEMBUR HARIAN (Jam)"); // Set kolom A1 
        $sheet->setCellValue('O4', "LEMBUR HARI KERJA (Jam)"); // Set kolom A1 
        $sheet->setCellValue('P4', "LEMBUR HARI LIBUR (Jam)"); // Set kolom A1 
        $sheet->setCellValue('Q4', "Catatan"); // Set kolom A1 
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        //$sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);
        $sheet->getColumnDimension('Q')->setAutoSize(true);
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $sheet->getStyle('B2:Q2')->applyFromArray($style_col);
        //$sheet->getStyle('C2')->applyFromArray($style_col);
        $sheet->getStyle('B4')->applyFromArray($style_col);
        $sheet->getStyle('C4')->applyFromArray($style_col);
        $sheet->getStyle('D4')->applyFromArray($style_col);
        $sheet->getStyle('E4')->applyFromArray($style_col);
        $sheet->getStyle('F4')->applyFromArray($style_col);
        $sheet->getStyle('G4')->applyFromArray($style_col);
        $sheet->getStyle('H4')->applyFromArray($style_col);
        $sheet->getStyle('I4')->applyFromArray($style_col);
        $sheet->getStyle('J4')->applyFromArray($style_col);
        $sheet->getStyle('K4')->applyFromArray($style_col);
        //$sheet->getStyle('K4')->applyFromArray($style_col);
        $sheet->getStyle('L4')->applyFromArray($style_col);
        $sheet->getStyle('M4')->applyFromArray($style_col);
        $sheet->getStyle('N4')->applyFromArray($style_col);
        $sheet->getStyle('O4')->applyFromArray($style_col);
        $sheet->getStyle('P4')->applyFromArray($style_col);
        $sheet->getStyle('Q4')->applyFromArray($style_col);

        $note = array();
        $libur = $this->hitungHariDalamPeriode($tgl1,$tgl2);
        $kar = $this->data_model->get_byid('data_karyawan', ['departement'=>$dep, 'status_io'=>'1']);
        
        if($kar->num_rows() > 0){
            $no=1; $numrow=5;
            foreach($kar->result() as $val){
                $nrp = $val->nrp;
                $jam_kerja = $val->jam_kerja;
                $kjk = $val->kjk;
                $tmt = $val->tmt;
                $cek_libur = $this->data_model->get_byid('data_libur',['nrp'=>$nrp])->row("hari_libur");
                $hari_libur2 = strtolower($cek_libur);
                $hari_libur = ucwords($hari_libur2);
                $jumlah_cuti = $this->db->query("SELECT * FROM cuti_karyawan WHERE nrp = '$nrp' AND tanggal_cuti BETWEEN '$tgl1' AND '$tgl2' AND acc_hrd='acc'")->num_rows();
                $nama = strtolower($val->nama);
                $dep = strtolower($val->departement);
                $div = strtolower($val->divisi);
                $jab = strtolower($val->jabatan);

                if($nama!="Undefined"){
                    if($cek_libur == ""){
                        $note[]= ucwords($nama)." tidak memiliki hari libur.";
                        $notess= ucwords($nama)." tidak memiliki hari libur.";
                    } else {
                        $notess = "-";
                    }
                $pengurangan_hari_aktif = $this->db->query("SELECT * FROM data_tukar_libur WHERE nrp='$nrp' AND tgl_libur BETWEEN '$tgl1' AND '$tgl2'")->num_rows();
                $penambahan_hari_aktif = $this->db->query("SELECT * FROM data_tukar_libur WHERE nrp='$nrp' AND tgl_libur_asli BETWEEN '$tgl1' AND '$tgl2'")->num_rows();

                $jumlah_libur_seharusnya = $libur[$hari_libur];
                $range_hari = $libur['Total'];
                $_hari_kerja = $range_hari - $jumlah_libur_seharusnya - $liburnasional;
                if($pengurangan_hari_aktif > 0){
                    $_hari_kerja = $_hari_kerja - $pengurangan_hari_aktif;
                }
                if($penambahan_hari_aktif > 0){
                    $_hari_kerja = $_hari_kerja + $penambahan_hari_aktif;
                }
                $cekasben_all = $this->db->query("SELECT COUNT(id_abs) AS jml FROM real_absensi WHERE nrp='$nrp' AND tgl_masuk BETWEEN '$tgl1' AND '$tgl2' AND tipe_absen='Harian'")->row("jml");
                
                $cekasben_masuk = $this->db->query("SELECT COUNT(id_abs) AS jml FROM real_absensi WHERE nrp='$nrp' AND tgl_masuk BETWEEN '$tgl1' AND '$tgl2' AND verifikasi='1' AND tipe_absen='Harian'")->row("jml");
                $_cekasben_masuk2 = $this->db->query("SELECT nrp,tgl_masuk,verifikasi,tipe_absen FROM real_absensi WHERE nrp='$nrp' AND tgl_masuk BETWEEN '$tgl1' AND '$tgl2' AND verifikasi='1' AND tipe_absen='Harian'");
                $absen = array();
                foreach($_cekasben_masuk2->result() as $hg){
                    $absen[] = $hg->tgl_masuk;
                }

                $terlambat_ttl = $this->db->query("SELECT nrp,tgl,terlambat,keterangan FROM data_terlambat WHERE nrp='$nrp' AND tgl BETWEEN '$tgl1' AND '$tgl2' AND keterangan='Terlambat masuk kerja'");
                $totalDetik = 0; $pengurangan=0;
                foreach($terlambat_ttl->result() as $fg){
                    $_s_tgl = $fg->tgl;
                    $_s_jamtelat = $fg->terlambat;
                    if($jam_kerja == "Shift"){
                        $_s_detik = $this->waktuTerlambatKeDetik($_s_jamtelat);
                        if($_s_detik <= 1800){
                            $pengurangan += $_s_detik;
                        } else {
                            $sisa_detik = $_s_detik - 1800;
                            $totalDetik += $sisa_detik;
                            $pengurangan += 1800;
                        }
                    } else {
                        $totalDetik += $this->waktuTerlambatKeDetik($fg->terlambat);
                    }
                    
                }
                if($totalDetik > 0){
                    $__terlambat = $totalDetik / 60;
                } else {
                    $__terlambat = 0;
                }
                if($jam_kerja == "Shift"){
                    $lembur_harian_nilai2 = intval($cekasben_masuk) * 1800;
                    if($pengurangan > 0){
                        $lembur_harian_nilai =  $lembur_harian_nilai2 - $pengurangan;
                    } else {
                        $lembur_harian_nilai = $lembur_harian_nilai2;
                    }
                    $lembur_harian_menit = $lembur_harian_nilai / 60;
                    $lembur_harian_menit_round = round($lembur_harian_menit);
                    $lembur_harian_jam = $lembur_harian_menit_round / 60;
                    $lembur_harian_jam_round = round($lembur_harian_jam,2); 
                    // $lembur_harian = $this->data_model->convertSecondsToHMS($lembur_harian_nilai);
                    // if($lembur_harian == "00:00:00"){
                    //     $nilai_lembur_harian = "0";
                    // } else {
                    //     $nilai_lembur_harian = "1";
                    // }

                } else {
                    $lembur_harian = "0";
                    $nilai_lembur_harian = "0";
                    $lembur_harian_jam_round = "0";
                }
                //yuk hitung kjk dimulai dari sini
                if($kjk == "yes"){
                    $kjk_nilai = "0";
                    $startDate = new DateTime($tgl1);
                    $endDate = new DateTime($tgl2);
                    $endDate->modify('+1 day');
                    $tigaBulanDariTmt = new DateTime($tmt);
                    $tigaBulanDariTmt->modify('+3 months');
                    
                    //$interval = new DateInterval('P1D');
                    //$dateRange = new DatePeriod($startDate, $interval, $endDate);
                    $interval = new DateInterval('P1W');
                    $dateRange = new DatePeriod($startDate, $interval, $endDate);
                    foreach ($dateRange as $date) {
                        $weekStart = $date->format("Y-m-d");
                        $weekEnd = $date->modify('+6 days')->format("Y-m-d");
                        // Tentukan apakah minggu ini sudah melewati 3 bulan dari TMT
                        if ($weekEnd >= $tigaBulanDariTmt->format("Y-m-d")) {
                            // Hitung jumlah hari absen dalam minggu ini
                            $absenMingguIni = 0;
                            foreach ($absen as $hariAbsen) {
                                if ($hariAbsen >= $weekStart && $hariAbsen <= $weekEnd) {
                                    $absenMingguIni++;
                                }
                            }
                    
                            // Cek apakah absen kurang dari 6 hari dalam minggu ini
                            if ($absenMingguIni >= 6) {
                                //echo "Minggu dari $weekStart sampai $weekEnd mendapat tambahan gaji 2 jam\n";
                                $kjk_nilai+=7200;
                            } else {
                                //echo "Minggu dari $weekStart sampai $weekEnd tidak mendapat tambahan gaji 2 jam karena absen tidak penuh atau kurang dari 6 hari\n";
                            }
                        } else {
                            //echo "Minggu dari $weekStart sampai $weekEnd tidak mendapat tambahan gaji 2 jam\n";
                        }
                    
                        // Kembalikan tanggal ke awal minggu untuk iterasi berikutnya
                        $date->modify('-6 days');
                    }
                } else {
                    $kjk_nilai = "0";
                }
                if($kjk!="0"){
                    if($kjk == "yes"){
                    $_sisa_terlambat = $__terlambat * 60;
                    $kurangi_kjk = $kjk_nilai - $_sisa_terlambat;
                    $kjk_nilai = $kurangi_kjk;
                    $__terlambat = 0;
                    }
                }
                $lembur_hk = $this->db->query("SELECT * FROM data_lembur,data_lembur_kar WHERE data_lembur.urlcode = data_lembur_kar.id_data_lembur AND data_lembur.hari_kerja='y' AND data_lembur_kar.nrp = '$nrp' AND data_lembur_kar.acc_hrd = 'acc' AND data_lembur.tgl_lembur BETWEEN '$tgl1' AND '$tgl2'");
                $lembur_hl = $this->db->query("SELECT * FROM data_lembur,data_lembur_kar WHERE data_lembur.urlcode = data_lembur_kar.id_data_lembur AND data_lembur.hari_kerja='n' AND data_lembur_kar.nrp = '$nrp' AND data_lembur_kar.acc_hrd = 'acc' AND data_lembur.tgl_lembur BETWEEN '$tgl1' AND '$tgl2'");
                $detik_lembur_hk=0; $detik_lembur_hl=0;
                if($lembur_hk->num_rows() >0){
                    foreach($lembur_hk->result() as $gt){
                        $waktu_lembur = $gt->total_jam;
                        $hitung_kedetik = $this->waktuTerlambatKeDetik($waktu_lembur);
                        $detik_lembur_hk+=$hitung_kedetik;
                    }
                }
                if($lembur_hl->num_rows() >0){
                    foreach($lembur_hl->result() as $gt){
                        $waktu_lembur = $gt->total_jam;
                        $hitung_kedetik = $this->waktuTerlambatKeDetik($waktu_lembur);
                        $detik_lembur_hl+=$hitung_kedetik;
                    }
                }
                if($detik_lembur_hk>0){
                    $lembur_hk_menit = $detik_lembur_hk / 60;
                    $lembur_hk_menit_round = round($lembur_hk_menit);
                    $lembur_hk_jam = $lembur_hk_menit_round / 60;
                    $jam_lembur_hk = round($lembur_hk_jam,2);
                    //$jam_lembur_hk = $this->data_model->convertSecondsToHMS($detik_lembur_hk);
                } else {
                    $jam_lembur_hk = 0;
                }
                if($detik_lembur_hl>0){
                    $lembur_hl_menit = $detik_lembur_hl / 60;
                    $lembur_hl_menit_round = round($lembur_hl_menit);
                    $lembur_hl_jam = $lembur_hl_menit_round / 60;
                    $jam_lembur_hl = round($lembur_hl_jam,2);
                    //$jam_lembur_hl = $this->data_model->convertSecondsToHMS($detik_lembur_hl);
                } else {
                    $jam_lembur_hl = 0;
                }
                //if($kjk!="yes" AND )
                $sheet->setCellValue('B'.$numrow.'', $no);
                $sheet->getStyle('B'.$numrow.'')->applyFromArray($style_col);
                $sheet->setCellValue('C'.$numrow.'', $val->nrp);
                $sheet->getStyle('C'.$numrow.'')->applyFromArray($style_row);
                $sheet->setCellValue('D'.$numrow.'', ucwords($nama));
                $sheet->getStyle('D'.$numrow.'')->applyFromArray($style_row);
                $sheet->setCellValue('E'.$numrow.'', ucwords($dep));
                $sheet->getStyle('E'.$numrow.'')->applyFromArray($style_row);
                $sheet->setCellValue('F'.$numrow.'', ucwords($div));
                $sheet->getStyle('F'.$numrow.'')->applyFromArray($style_row);
                $sheet->setCellValue('G'.$numrow.'', ucwords($jab));
                $sheet->getStyle('G'.$numrow.'')->applyFromArray($style_row);
                $sheet->setCellValue('H'.$numrow.'', $hari_libur);
                $sheet->getStyle('H'.$numrow.'')->applyFromArray($style_row);
                if($jumlah_cuti > 0){
                    $cekasben_masuk = $cekasben_masuk + $jumlah_cuti;
                }
                $sheet->setCellValue('I'.$numrow.'', $_hari_kerja);
                $sheet->setCellValue('J'.$numrow.'', $cekasben_masuk);
                if(intval($_hari_kerja) == intval($cekasben_masuk)){
                    $sheet->getStyle('I'.$numrow.'')->applyFromArray($style_row3);
                    $sheet->getStyle('J'.$numrow.'')->applyFromArray($style_row3);
                } else {
                    $sheet->getStyle('I'.$numrow.'')->applyFromArray($style_row);
                    $sheet->getStyle('J'.$numrow.'')->applyFromArray($style_row2);
                }
                
                $nilai_terlambat = intval($__terlambat);
                $rumus_terlambat = $nilai_terlambat / 420;
                
                if($nilai_terlambat > 0){
                    $fix_terlambat = round($rumus_terlambat, 9);
                    $sheet->setCellValue('K'.$numrow.'', $fix_terlambat);
                    $sheet->getStyle('K'.$numrow.'')->applyFromArray($style_row2);
                    $hari_kerja_aktif = $cekasben_masuk - $fix_terlambat;
                } else {
                    $sheet->setCellValue('K'.$numrow.'', '0');
                    $sheet->getStyle('K'.$numrow.'')->applyFromArray($style_row);
                    $hari_kerja_aktif =  $cekasben_masuk;
                }
                $hk_aktif = round($hari_kerja_aktif, 9);
                $sheet->setCellValue('L'.$numrow.'', $hk_aktif);
                $sheet->getStyle('L'.$numrow.'')->applyFromArray($style_row);

                if($kjk_nilai > 0){
                    //$print_kjk = $this->data_model->convertSecondsToHMS($kjk_nilai);
                    //$_newx = explode(':', $print_kjk);
                    //$print_kjk2 = $_newx[0].':'.$_newx[1];
                    $kjk_menit2 = $kjk_nilai / 60;
                    $kjk_menit = round($kjk_menit2);
                    $kjk_jam = $kjk_menit / 60;
                    $kjk_jam2 = round($kjk_jam,2);
                    $sheet->setCellValue('M'.$numrow.'', $kjk_jam2);
                } else {
                    $sheet->setCellValue('M'.$numrow.'', '0');
                }
                $sheet->getStyle('M'.$numrow.'')->applyFromArray($style_row);

                //if($lembur_harian == 0 OR $lembur_harian == "00:00:00"){
                    $sheet->setCellValue('N'.$numrow.'', $lembur_harian_jam_round);
                //} else {
                    //$_newxx = explode(':', $lembur_harian);
                    //$lembur_harian2 = $_newxx[0].':'.$_newxx[1];
                    //$sheet->setCellValue('N'.$numrow.'', $lembur_harian2);
                //}
                
                $sheet->getStyle('N'.$numrow.'')->applyFromArray($style_row);

                $sheet->setCellValue('O'.$numrow.'', $jam_lembur_hk);
                $sheet->getStyle('O'.$numrow.'')->applyFromArray($style_row);

                $sheet->setCellValue('P'.$numrow.'', $jam_lembur_hl);
                $sheet->getStyle('P'.$numrow.'')->applyFromArray($style_row);

                $sheet->setCellValue('Q'.$numrow.'', $notess);
                $sheet->getStyle('Q'.$numrow.'')->applyFromArray($style_row);
                
                $no++;
                $numrow++;
                }
            } //end foreach

            // echo '</table>';
            // if(count($note) > 0){
            // echo "<pre>";
            // print_r($note);
            // echo "</pre>"; }
        } else {
            //echo "Data Karyawan Tidak Ditemukan";
            $sheet->setCellValue('D12', ucwords($nama));
        }
        
        // $sheet->setCellValue('I'.$new_nomber.'', $ttl2);
        // $sheet->getStyle('B'.$new_nomber.'')->applyFromArray($style_col);
        // $sheet->getStyle('C'.$new_nomber.'')->applyFromArray($style_col);
        // $sheet->getStyle('D'.$new_nomber.'')->applyFromArray($style_col);
        // $sheet->getStyle('E'.$new_nomber.'')->applyFromArray($style_col);
        // $sheet->getStyle('F'.$new_nomber.'')->applyFromArray($style_col);
        // $sheet->getStyle('G'.$new_nomber.'')->applyFromArray($style_col);
        // $sheet->getStyle('H'.$new_nomber.'')->applyFromArray($style_col);
        // $sheet->getStyle('I'.$new_nomber.'')->applyFromArray($style_col);
        //$sheet->setCellValue('A2', $kode); // Set kolom A1 
        //$sheet->setCellValue('H2', $st); // Set kolom A1 
        //$sheet->getStyle('A1')->applyFromArray($style_row);
        
        $writer = new Xlsx($spreadsheet);
        

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output'); // download file
        
    } //end
    function hitungHariDalamPeriode($tanggal_awal, $tanggal_akhir) {
        // Konversi string tanggal ke objek DateTime
        $start = new DateTime($tanggal_awal);
        $end = new DateTime($tanggal_akhir);
        $end->modify('+1 day');
        $hari = array(
            'Senin' => 0,
            'Selasa' => 0,
            'Rabu' => 0,
            'Kamis' => 0,
            'Jumat' => 0,
            'Sabtu' => 0,
            'Minggu' => 0
        );
        $interval = new DateInterval('P1D'); // Interval satu hari
        $period = new DatePeriod($start, $interval, $end);
    
        foreach ($period as $date) {
            $dayOfWeek = $date->format('l'); // Mendapatkan nama hari dalam format Inggris
            switch ($dayOfWeek) {
                case 'Monday':
                    $hari['Senin']++;
                    break;
                case 'Tuesday':
                    $hari['Selasa']++;
                    break;
                case 'Wednesday':
                    $hari['Rabu']++;
                    break;
                case 'Thursday':
                    $hari['Kamis']++;
                    break;
                case 'Friday':
                    $hari['Jumat']++;
                    break;
                case 'Saturday':
                    $hari['Sabtu']++;
                    break;
                case 'Sunday':
                    $hari['Minggu']++;
                    break;
            }
        }
        $totalHari = array_sum($hari);
        $hari['Total'] = $totalHari;
        return $hari;
    } //end fun

    function waktuTerlambatKeDetik($waktu) {
        list($jam, $menit) = explode(':', $waktu);
        return ($jam * 3600) + ($menit * 60);
    }
}