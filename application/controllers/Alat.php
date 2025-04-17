<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Alat_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        // Cek apakah user adalah admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['title'] = 'Data Alat';
        $data['alat'] = $this->Alat_model->get_all();
        
        $this->load->view('layout/header', $data);
        $this->load->view('alat/index', $data);
        $this->load->view('layout/footer');
    }

    public function add() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_alat', 'Nama Alat', 'required');
        $this->form_validation->set_rules('kode_alat', 'Kode Alat', 'required');
        $this->form_validation->set_rules('stok_total', 'Stok Total', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Tambah Alat';
            $this->load->view('layout/header', $data);
            $this->load->view('alat/add', $data);
            $this->load->view('layout/footer');
        } else {
            $data = array(
                'nama_alat' => $this->input->post('nama_alat'),
                'kode_alat' => $this->input->post('kode_alat'),
                'deskripsi' => $this->input->post('deskripsi'),
                'stok_total' => $this->input->post('stok_total'),
                'status' => 'tersedia',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            $this->Alat_model->insert($data);
            $this->session->set_flashdata('success', 'Data alat berhasil ditambahkan!');
            redirect('alat');
        }
    }

    public function edit($id) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_alat', 'Nama Alat', 'required');
        $this->form_validation->set_rules('kode_alat', 'Kode Alat', 'required');
        $this->form_validation->set_rules('stok_total', 'Stok Total', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Edit Alat';
            $data['alat'] = $this->Alat_model->get_by_id($id);
            
            if (!$data['alat']) {
                $this->session->set_flashdata('error', 'Data alat tidak ditemukan!');
                redirect('alat');
            }
            
            $this->load->view('layout/header', $data);
            $this->load->view('alat/edit', $data);
            $this->load->view('layout/footer');
        } else {
            $data = array(
                'nama_alat' => $this->input->post('nama_alat'),
                'kode_alat' => $this->input->post('kode_alat'),
                'deskripsi' => $this->input->post('deskripsi'),
                'stok_total' => $this->input->post('stok_total'),
                'status' => $this->input->post('status'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            $this->Alat_model->update($id, $data);
            $this->session->set_flashdata('success', 'Data alat berhasil diperbarui!');
            redirect('alat');
        }
    }

    public function delete($id) {
        $alat = $this->Alat_model->get_by_id($id);
        
        if (!$alat) {
            $this->session->set_flashdata('error', 'Data alat tidak ditemukan!');
            redirect('alat');
        }
        
        $this->Alat_model->delete($id);
        $this->session->set_flashdata('success', 'Data alat berhasil dihapus!');
        redirect('alat');
    }
}