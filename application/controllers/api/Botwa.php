<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Botwa extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('data_model');
        //header("Access-Control-Allow-Origin: https://data.rdgjt.com");
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        // $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        // $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        // $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function index_get()
    {
        $id = $this->get('id');
        if( $id === NULL ){
            $data = $this->data_model->getAllMessage();
        } else {
            $data = $this->data_model->getAllMessage($id);
        }
        $pesan = $data->result_array();
        $jumlahData = $data->num_rows();
        if($pesan){
            $this->response([
                'status' => true,
                'jumlahData' => $jumlahData,
                'data' => $pesan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'jumlahData' => $jumlahData,
                'message' => 'Erorr'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
        
        //var_dump($dataPotongan);
    }

    

}
