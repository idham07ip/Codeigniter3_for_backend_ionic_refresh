<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X- Request-With');
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Api extends RestController {

    function __construct(){
        // Construct the parent class
        parent::__construct();
        $this->load->model('MahasiswaModel', 'mhs');
    }

    public function index_get(){
        $this->response(
            [
                'status' => 200,
                'data'   => 'default method'
            ],
        RestController::HTTP_OK );
    }

    public function mahasiswa_get(){
        $listmhs = $this->mhs->get();

        $this->response(
            [
                'status' => 200,
                'data'   => $listmhs
            ],
        RestController::HTTP_OK );
    }

    public function insertmahasiswa_get(){
        $data = [
            'npm' => urldecode($this->uri->segment(3)),
            'nama' => urldecode($this->uri->segment(4)),
            'gender' => urldecode($this->uri->segment(5)),
            'jurusan' => urldecode($this->uri->segment(6)),
        ];
        
        $insert = $this->db->insert('tbl_mahasiswa', $data);

        if ($insert) {
            $this->response(['status' => 'success'], 200);
        } else {
            $this->response(['status' => 'fail', 502]);            
        }

    }

    public function mhsById_get(){
        $id = urldecode($this->uri->segment(3));
       
        $this->db->where('id', $id);
        $mhs = $this->db->get('tbl_mahasiswa')->result();
        
        if ($mhs) {
            $this->response(['data' => $mhs], 200);
        } else {
            $this->response(['data' => 'data not found'], 404);
        }
    }

    public function updatemhs_get(){

        $id = urldecode($this->uri->segment(3));
        $data = [
            'npm' =>  urldecode($this->uri->segment(4)),
            'nama' => urldecode($this->uri->segment(5)),
            'gender' => urldecode($this->uri->segment(6)),
            'jurusan' => urldecode($this->uri->segment(7)),
        ];

        $this->db->where('id', $id);
        $update = $this->db->update('tbl_mahasiswa', $data);

        if ($update) {
            $this->response(['status' => 'success'], 200);
        } else {
            $this->response(['status' => 'fail'], 504);
        }
        
    }
    
    function hapusmhs_get() {
        $id=urldecode($this->uri->segment(3));
        $this->db->where('id', $id);
        $delete = $this->db->delete('tbl_mahasiswa');
        if ($delete) {
            $this->response(array('status' => 'success'), RestController::HTTP_OK );
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}