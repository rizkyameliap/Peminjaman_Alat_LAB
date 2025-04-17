<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Mahasiswa_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        // Cek apakah user adalah admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['title'] = 'Data Mahasiswa';
        $data['mahasiswa'] = $this->Mahasiswa_model->get_all();
        
        $this->load->view('layout/header', $data);
        $this->load->view('mahasiswa/index', $data);
        $this->load->view('layout/footer');
    }

    public function add() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nim', 'NIM', 'required|is_unique[mahasiswa.nim]');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('prodi', 'Program Studi', 'required');
        $this->form_validation->set_rules('semester', 'Semester', 'required|numeric');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Tambah Mahasiswa';
            $this->load->view('layout/header', $data);
            $this->load->view('mahasiswa/add', $data);
            $this->load->view('layout/footer');
        } else {
            $data = array(
                'nim' => $this->input->post('nim'),
                'nama' => $this->input->post('nama'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'prodi' => $this->input->post('prodi'),
                'semester' => $this->input->post('semester'),
                'email' => $this->input->post('email'),
                'created_at' => date('Y-m-d H:i:s')
            );

            $this->Mahasiswa_model->insert($data);
            $this->session->set_flashdata('success', 'Data mahasiswa berhasil ditambahkan!');
            redirect('mahasiswa');
        }
    }

    public function edit($id) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('prodi', 'Program Studi', 'required');
        $this->form_validation->set_rules('semester', 'Semester', 'required|numeric');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Edit Mahasiswa';
            $data['mahasiswa'] = $this->Mahasiswa_model->get_by_id($id);
            
            if (!$data['mahasiswa']) {
                $this->session->set_flashdata('error', 'Data mahasiswa tidak ditemukan!');
                redirect('mahasiswa');
            }
            
            $this->load->view('layout/header', $data);
            $this->load->view('mahasiswa/edit', $data);
            $this->load->view('layout/footer');
        } else {
            $data = array(
                'nama' => $this->input->post('nama'),
                'prodi' => $this->input->post('prodi'),
                'semester' => $this->input->post('semester'),
                'email' => $this->input->post('email')
            );
            
            // Update password jika diisi
            if ($this->input->post('password') != '') {
                $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            }

            $this->Mahasiswa_model->update($id, $data);
            $this->session->set_flashdata('success', 'Data mahasiswa berhasil diperbarui!');
            redirect('mahasiswa');
        }
    }

    public function delete($id) {
        $mahasiswa = $this->Mahasiswa_model->get_by_id($id);
        
        if (!$mahasiswa) {
            $this->session->set_flashdata('error', 'Data mahasiswa tidak ditemukan!');
            redirect('mahasiswa');
        }
        
        $this->Mahasiswa_model->delete($id);
        $this->session->set_flashdata('success', 'Data mahasiswa berhasil dihapus!');
        redirect('mahasiswa');
    }
}