<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Booking_model');
        $this->load->model('Alat_model');
        $this->load->model('Mahasiswa_model');
        
        // Cek apakah user sudah login - tambahkan debug
        if (!$this->session->userdata('logged_in')) {
            // Debug info
            echo "Session tidak ditemukan. Redirect ke login...";
            redirect('auth/login');
            exit;
        }
    }

    public function index() {
        
        // Hanya mahasiswa yang bisa mengakses
        if ($this->session->userdata('role') != 'mahasiswa') {
            redirect('dashboard/admin'); // Redirect ke admin dashboard jika bukan mahasiswa
        }
    
        $data['title'] = 'Dashboard Mahasiswa';
        $id_mahasiswa = $this->session->userdata('id_mahasiswa');
        $data['bookings'] = $this->Booking_model->get_by_mahasiswa($id_mahasiswa);
    
        $this->load->view('layout/header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('layout/footer');
    }
    
    public function admin() {
        // Debug session jika perlu
        // echo "<pre>Session: "; print_r($this->session->userdata()); echo "</pre>";
        
        // Hanya admin yang bisa mengakses
        if ($this->session->userdata('role') != 'admin') {
            redirect('dashboard'); // Redirect ke mahasiswa dashboard jika bukan admin
        }
    
        $data['title'] = 'Dashboard Admin';
        $data['pending_bookings'] = $this->Booking_model->get_pending_bookings();
        $data['alat_count'] = count($this->Alat_model->get_all());
        $data['mahasiswa_count'] = count($this->Mahasiswa_model->get_all());
    
        $this->load->view('layout/header', $data);
        $this->load->view('dashboard/admin', $data);
        $this->load->view('layout/footer');
    }
}