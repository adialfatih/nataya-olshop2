<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('data_model');
        date_default_timezone_set("Asia/Jakarta");
    }

    function index(){
            $this->session->sess_destroy();
            $this->load->view('users/login_users');
    } //end
    function dashboard(){
        if($this->session->userdata('login_form') != "user-as1563sd1679dsad8789asff53afhafaf670fa"){
            redirect(base_url('login'));
        } else {
            $data = array(
                'title' => 'Data Mesin Finger Print',
                'sess_nama' => $this->session->userdata('nama'),
                'sess_id' => $this->session->userdata('id'),
                'sess_username' => $this->session->userdata('username'),
                'sess_password' => $this->session->userdata('password'),
                'akses' => $this->session->userdata('akses')
            );
            $this->load->view('part/main_head', $data);
            $this->load->view('part/left_sidebar2', $data);
            $this->load->view('beranda_view', $data);
            $this->load->view('part/main_js_users');
        }
    }//end
    function viewtukarlibur(){
        $userss = $this->session->userdata('akses');
        $namaa= $this->session->userdata('nama');
        if($userss == 'user'){
            $qry = $this->data_model->get_byid('data_tukar_libur',['yg_input'=>$namaa]);
        } else {
            $qry = $this->data_model->sort_record('id_dtl','data_tukar_libur');
        }
        $data = array(
            'title' => 'Tukar Libur Karyawan',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'akses' => $this->session->userdata('akses'),
            'dtrow' => $qry
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar2', $data);
        $this->load->view('users/tukar_libur', $data);
        $this->load->view('part/main_js_users');
    }
    
    function viewgantilibur(){
        $data = array(
            'title' => 'Ganti Libur Mingguan Karyawan',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'akses' => $this->session->userdata('akses')
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar2', $data);
        $this->load->view('users/ganti_libur', $data);
        $this->load->view('part/main_js_users');
    }
    function createakses(){
        $data = array(
            'title' => 'Akses Users',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'akses' => $this->session->userdata('akses'),
            'autocomplet' => 'finger'
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('users/akses_users_view', $data);
        $this->load->view('part/main_js_users');
    }
    function viewtukarlibur_hrd(){
        $data = array(
            'title' => 'Tukar Libur Karyawan',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'akses' => $this->session->userdata('akses'),
            'dtrow' => $this->data_model->sort_record('tgl_libur','data_tukar_libur')
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('users/tukar_libur', $data);
        $this->load->view('part/main_js_users');
    }
    function addtukarlibur(){
        $data = array(
            'title' => 'Input Tukar Libur Karyawan',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'akses' => $this->session->userdata('akses'),
            'autocomplet' => 'finger'
        );
        $this->load->view('part/main_head', $data);
        if($this->session->userdata('akses') == "user"){
        $this->load->view('part/left_sidebar2', $data); } else {
            $this->load->view('part/left_sidebar', $data);
        }
        $this->load->view('users/tukar_libur_add', $data);
        $this->load->view('part/main_js_users');
    }
    
    function addgantilibur(){
        $data = array(
            'title' => 'Ganti Libur Mingguan Karyawan',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'akses' => $this->session->userdata('akses'),
            'autocomplet' => 'finger'
        );
        $this->load->view('part/main_head', $data);
        if($this->session->userdata('akses') == "user"){
        $this->load->view('part/left_sidebar2', $data); } else {
            $this->load->view('part/left_sidebar', $data);
        }
        $this->load->view('users/tukar_libur_add2', $data);
        $this->load->view('part/main_js_users');
    }
    function view_lembur(){
        $akses = $this->session->userdata('akses');
        $data = array(
            'title' => 'Data Lembur Karyawan',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'akses' => $akses,
            'autocomplet' => 'finger'
        );
        $this->load->view('part/main_head', $data);
        if($akses == "user"){
            $this->load->view('part/left_sidebar2', $data);
            $this->load->view('users/data_lembur_view', $data);
        } else {
            $this->load->view('part/left_sidebar', $data);
            $this->load->view('users/data_lembur_view2', $data);
        }
        
        $this->load->view('part/main_js_users');
    }
    function mutasiview(){
        $akses = $this->session->userdata('akses');
        $data = array(
            'title' => 'Data Mutasi Karyawan',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'akses' => $akses,
            'dep' => $this->data_model->showDepartement(),
            'divisi' => $this->data_model->showDivisi(),
            'jab' => $this->data_model->showJabatan(),
            'autocomplet' => 'finger'
        );
        $this->load->view('part/main_head', $data);
        if($akses == "'ADM'"){
            $this->load->view('part/left_sidebar', $data);
        } else {
            $this->load->view('part/left_sidebar2', $data);
        }
        $this->load->view('users/data_mutasi_view', $data);
        $this->load->view('part/main_js_users');
    }
    function addmutasiview(){
        $akses = $this->session->userdata('akses');
        $data = array(
            'title' => 'Data Mutasi Karyawan',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'akses' => $akses,
            'dep' => $this->data_model->showDepartement(),
            'divisi' => $this->data_model->showDivisi(),
            'jab' => $this->data_model->showJabatan(),
            'autocomplet' => 'finger'
        );
        $this->load->view('part/main_head', $data);
        if($akses == "'ADM'"){
            $this->load->view('part/left_sidebar', $data);
        } else {
            $this->load->view('part/left_sidebar2', $data);
        }
        $this->load->view('users/data_mutasi_view_new', $data);
        $this->load->view('part/main_js_users');
    }
    function add_lembur(){
        $akses = $this->session->userdata('akses');
        $uri2 = $this->uri->segment(4);
        $cekuri2 = $this->data_model->get_byid('data_lembur',['urlcode'=>$uri2]);
        if($cekuri2->num_rows() == 1){
            $deps = $cekuri2->row("dep");
            $yg_inputs = strtolower($cekuri2->row("yg_input"));
        } 
        $data = array(
            'title' => 'Buat Surat Perintah Lembur',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_username' => $this->session->userdata('username'),
            'sess_password' => $this->session->userdata('password'),
            'akses' => $this->session->userdata('akses'),
            'autocomplet' => 'finger2',
            'deps' => $deps,
            'yg_inputs' => $yg_inputs
        );
        $this->load->view('part/main_head', $data);
        if($akses == "user"){
            $this->load->view('part/left_sidebar2', $data);
        } else {
            $this->load->view('part/left_sidebar', $data);
        }
        //$this->load->view('part/left_sidebar2', $data);
        $this->load->view('users/lembur_add', $data);
        $this->load->view('part/main_js_users');
    }
    function proseslogin(){
        $this->load->model('login_model');
        $user = $this->login_model->filter($this->input->post('username'));
		$pass = $this->input->post('password');
		
        if($this->login_model->cek_username($user) == true){
            $cek = $this->login_model->cek_login('table_users', ['username' => $user, 'password' => sha1($pass)]);
            if($cek->num_rows() == 1) {
                $dt = $cek->row_array();
                $id = $dt['idusers'];
                $data_session = array(
                    'id' => $id,
                    'nama'  => $dt['nama_users'],
                    'username'=> $dt['username'],
                    'password' => $dt['password'],
                    'akses' => $dt['akses'],
                    'login_form'=> 'user-as1563sd1679dsad8789asff53afhafaf670fa'
                );
                $this->session->set_userdata($data_session);
                redirect(base_url('beranda-users'));
            } else {
                $this->session->set_flashdata('announce', 'Password anda salah');
                redirect(base_url('users'));
            }
        } else {
            $this->session->set_flashdata('announce', 'Username / Email login tidak terdaftar');
            redirect(base_url('users'));
        }
    }
    function Parse_Data($data,$p1,$p2){
        $data=" ".$data;
        $hasil="";
        $awal=strpos($data,$p1);
        if($awal!=""){
            $akhir=strpos(strstr($data,$p1),$p2);
            if($akhir!=""){
                $hasil=substr($data,$awal+strlen($p1),$akhir-strlen($p1));
            }
        }
        return $hasil;	
    }

    public function sinkronisasi(){
        $mesin = $this->data_model->get_record('data_mesin');
        $data1 = $this->data_model->get_record('dt_tampungan');
        $data2 = $this->data_model->get_record('dt_tampungan_finger');
        foreach($data1->result() as $val){
            foreach($mesin->result() as $val){
                $IP = $val->ip_mesin;
                $MC = $val->nama_mesin;
                $Key = $val->comkey;
                $Connect = fsockopen($IP, "80", $errno, $errstr, 1);
                if($Connect){
                    $id=$val->nrp_onfinger;
                    $nama=ucwords($val->nama);
                    $soap_request="<SetUserInfo><ArgComKey Xsi:type=\"xsd:integer\">".$Key."</ArgComKey><Arg><PIN>".$id."</PIN><Name>".$nama."</Name></Arg></SetUserInfo>";
                    $newLine="\r\n";
                    fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
                    fputs($Connect, "Content-Type: text/xml".$newLine);
                    fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
                    fputs($Connect, $soap_request.$newLine);
                    $buffer="";
                    while($Response=fgets($Connect, 1024)){
                        $buffer=$buffer.$Response;
                    }
                } 
                $buffer=$this->Parse_Data($buffer,"<Information>","</Information>");
                
            } //end foreach
        } //end perulangan data 1
        foreach($data2->result() as $val){
            foreach($mesin->result() as $val){
                $IP = $val->ip_mesin;
                $MC = $val->nama_mesin;
                $Key = $val->comkey;
                $Connect = fsockopen($IP, "80", $errno, $errstr, 1);
                if($Connect){
                    $id=$val->PIN;
                    $temp=$val->Template;
                    $fn=$val->FingerID;
                    $soap_request="<SetUserTemplate><ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">".$id."</PIN><FingerID xsi:type=\"xsd:integer\">".$fn."</FingerID><Size>".strlen($temp)."</Size><Valid>1</Valid><Template>".$temp."</Template></Arg></SetUserTemplate>";
                    $newLine="\r\n";
                    fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
                    fputs($Connect, "Content-Type: text/xml".$newLine);
                    fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
                    fputs($Connect, $soap_request.$newLine);
                    $buffer="";
                    while($Response=fgets($Connect, 1024)){
                        $buffer=$buffer.$Response;
                    }
                }
            
                $buffer=$this->Parse_Data($buffer,"<SetUserTemplateResponse>","</SetUserTemplateResponse>");
                $buffer=$this->Parse_Data($buffer,"<Information>","</Information>");
               
                $Connect = fsockopen($IP, "80", $errno, $errstr, 1);
                $soap_request="<RefreshDB><ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey></RefreshDB>";
                $newLine="\r\n";
                fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
                fputs($Connect, "Content-Type: text/xml".$newLine);
                fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
                fputs($Connect, $soap_request.$newLine);
                
            } //end foreach
        } //end perulangan data 2
        echo "Selesai";
    } //end sinkronisasi
    function tes(){
        $IP = "192.168.10.250";
        $Key = "0";
        $Connect = fsockopen($IP, "80", $errno, $errstr, 1);
	    if($Connect){
            $soap_request="<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
            $newLine="\r\n";
            fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
            fputs($Connect, "Content-Type: text/xml".$newLine);
            fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
            fputs($Connect, $soap_request.$newLine);
            $buffer="";
            while($Response=fgets($Connect, 1024)){
                $buffer=$buffer.$Response;
            }
        
            $buffer=$this->Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
            $buffer=explode("\r\n",$buffer);
        
            for($a=0;$a<count($buffer);$a++){
                $data=$this->Parse_Data($buffer[$a],"<Row>","</Row>");
                $PIN=$this->Parse_Data($data,"<PIN>","</PIN>");
                $DateTime=$this->Parse_Data($data,"<DateTime>","</DateTime>");
                $Verified=$this->Parse_Data($data,"<Verified>","</Verified>");
                $Status=$this->Parse_Data($data,"<Status>","</Status>");
                $WorkCode=$this->Parse_Data($data,"<WorkCode>","</WorkCode>");
                echo $PIN." -> ".$DateTime." -> ".$Verified." -> ".$Status." -> ".$WorkCode."<br>";
            }
        }
    }

    function upload(){
        $tesuser = $this->db->query("SELECT * FROM `dt_tampungan_finger` ");
        $no=1;
        foreach($tesuser->result() as $val):
            $id = $val->PIN;
            $fn = $val->FingerID;
            $temp = $val->Template;
            echo $no." -> ".$id." -> ".$fn." -->";
            $IP  = "192.168.10.250";
            $Key = "0";
            $Connect = fsockopen($IP, "80", $errno, $errstr, 1);
            if($Connect){
                $soap_request="<SetUserTemplate><ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">".$id."</PIN><FingerID xsi:type=\"xsd:integer\">".$fn."</FingerID><Size>".strlen($temp)."</Size><Valid>1</Valid><Template>".$temp."</Template></Arg></SetUserTemplate>";
                $newLine="\r\n";
                fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
                fputs($Connect, "Content-Type: text/xml".$newLine);
                fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
                fputs($Connect, $soap_request.$newLine);
                $buffer="";
                while($Response=fgets($Connect, 1024)){
                    $buffer=$buffer.$Response;
                }
            
                $buffer=$this->Parse_Data($buffer,"<SetUserTemplateResponse>","</SetUserTemplateResponse>");
                $buffer=$this->Parse_Data($buffer,"<Information>","</Information>");
                echo "<B>Result:</B><BR>".$buffer;
                
                //Refresh DB
                $Connect = fsockopen($IP, "80", $errno, $errstr, 1);
                $soap_request="<RefreshDB><ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey></RefreshDB>";
                $newLine="\r\n";
                fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
                fputs($Connect, "Content-Type: text/xml".$newLine);
                fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
                fputs($Connect, $soap_request.$newLine);

            }
            echo "<br>";
            $no++;
        endforeach;
    } //end

}