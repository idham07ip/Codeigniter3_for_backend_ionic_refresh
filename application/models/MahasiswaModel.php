<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MahasiswaModel extends CI_Model{
    
    public function get(){
        return $this->db->get('tbl_mahasiswa')->result();
    }
}