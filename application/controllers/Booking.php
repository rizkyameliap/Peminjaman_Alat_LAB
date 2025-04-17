<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Booking_model');
        $this->load->model('Alat_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        // Cek apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index() {
        // Halaman daftar booking
        if ($this->session->userdata('role') == 'admin') {
            $data['title'] = 'Data Peminjaman';
            $data['bookings'] = $this->Booking_model->get_all();
        } else {
            $data['title'] = 'Riwayat Peminjaman';
            $data['bookings'] = $this->Booking_model->get_by_mahasiswa($this->session->userdata('id_mahasiswa'));
        }
        
        $this->load->view('layout/header', $data);
        $this->load->view('booking/index', $data);
        $this->load->view('layout/footer');
    }

    public function add() {
        // Only mahasiswa can add bookings
        if ($this->session->userdata('role') != 'mahasiswa') {
            redirect('dashboard/admin');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('id_alat', 'Alat', 'required');
        $this->form_validation->set_rules('tanggal_pinjam', 'Tanggal Pinjam', 'required');
        $this->form_validation->set_rules('tanggal_kembali', 'Tanggal Kembali', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Ajukan Peminjaman';
            $data['alat'] = $this->Alat_model->get_available();
            
            $this->load->view('layout/header', $data);
            $this->load->view('booking/add', $data);
            $this->load->view('layout/footer');
        } else {
            $id_alat = $this->input->post('id_alat');
            $tanggal_pinjam = $this->input->post('tanggal_pinjam');
            $tanggal_kembali = $this->input->post('tanggal_kembali');
            $jumlah = $this->input->post('jumlah');
            
            // Validasi tanggal
            if (strtotime($tanggal_pinjam) > strtotime($tanggal_kembali)) {
                $this->session->set_flashdata('error', 'Tanggal kembali harus setelah tanggal pinjam!');
                redirect('booking/add');
            }
            
            // Validasi ketersediaan
            if (!$this->Alat_model->check_availability($id_alat, $tanggal_pinjam, $tanggal_kembali, $jumlah)) {
                $this->session->set_flashdata('error', 'Stok alat tidak mencukupi pada tanggal tersebut!');
                redirect('booking/add');
            }
            
            $data = array(
                'id_mahasiswa' => $this->session->userdata('id_mahasiswa'),
                'id_alat' => $id_alat,
                'tanggal_pinjam' => $tanggal_pinjam,
                'tanggal_kembali' => $tanggal_kembali,
                'jumlah' => $jumlah,
                'status' => 'menunggu',
                'keterangan' => $this->input->post('keterangan'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            $this->Booking_model->insert($data);
            $this->session->set_flashdata('success', 'Permintaan peminjaman berhasil diajukan!');
            redirect('booking');
        }
    }

    public function detail($id) {
        $data['title'] = 'Detail Peminjaman';
        $data['booking'] = $this->Booking_model->get_by_id($id);
        
        if (!$data['booking']) {
            $this->session->set_flashdata('error', 'Data peminjaman tidak ditemukan!');
            redirect('booking');
        }
        
        // Validasi akses (admin bisa lihat semua, mahasiswa hanya lihat miliknya)
        if ($this->session->userdata('role') == 'mahasiswa' && 
            $data['booking']->id_mahasiswa != $this->session->userdata('id_mahasiswa')) {
            redirect('booking');
        }
        
        $this->load->view('layout/header', $data);
        $this->load->view('booking/detail', $data);
        $this->load->view('layout/footer');
    }

    public function approve($id) {
        // Only admin can approve
        if ($this->session->userdata('role') != 'admin') {
            redirect('dashboard');
        }
        
        $booking = $this->Booking_model->get_by_id($id);
        
        if (!$booking) {
            $this->session->set_flashdata('error', 'Data peminjaman tidak ditemukan!');
            redirect('booking');
        }
        
        // Update status booking
        $data = array(
            'status' => 'disetujui',
            'updated_at' => date('Y-m-d H:i:s')
        );
        
        $this->Booking_model->update($id, $data);
        $this->session->set_flashdata('success', 'Peminjaman berhasil disetujui!');
        redirect('booking/detail/' . $id);
    }
    
    public function reject($id) {
        // Only admin can reject
        if ($this->session->userdata('role') != 'admin') {
            redirect('dashboard');
        }
        
        $booking = $this->Booking_model->get_by_id($id);
        
        if (!$booking) {
            $this->session->set_flashdata('error', 'Data peminjaman tidak ditemukan!');
            redirect('booking');
        }
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Tolak Peminjaman';
            $data['booking'] = $booking;
            
            $this->load->view('layout/header', $data);
            $this->load->view('booking/reject', $data);
            $this->load->view('layout/footer');
        } else {
            // Update status booking
            $data = array(
                'status' => 'ditolak',
                'keterangan' => $this->input->post('keterangan'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            $this->Booking_model->update($id, $data);
            $this->session->set_flashdata('success', 'Peminjaman berhasil ditolak!');
            redirect('booking/detail/' . $id);
        }
    }
    
    public function finish($id) {
        // Only admin can finish
        if ($this->session->userdata('role') != 'admin') {
            redirect('dashboard');
        }
        
        $booking = $this->Booking_model->get_by_id($id);
        
        if (!$booking) {
            $this->session->set_flashdata('error', 'Data peminjaman tidak ditemukan!');
            redirect('booking');
        }
        
        // Update status booking
        $data = array(
            'status' => 'selesai',
            'updated_at' => date('Y-m-d H:i:s')
        );
        
        $this->Booking_model->update($id, $data);
        $this->session->set_flashdata('success', 'Peminjaman berhasil diselesaikan!');
        redirect('booking/detail/' . $id);
    }
    
    public function cancel($id) {
        // Only mahasiswa can cancel their booking
        if ($this->session->userdata('role') != 'mahasiswa') {
            redirect('dashboard/admin');
        }
        
        $booking = $this->Booking_model->get_by_id($id);
        
        if (!$booking) {
            $this->session->set_flashdata('error', 'Data peminjaman tidak ditemukan!');
            redirect('booking');
        }
        
        // Check if this is the mahasiswa's booking
        if ($booking->id_mahasiswa != $this->session->userdata('id_mahasiswa')) {
            redirect('booking');
        }
        
        // Only can cancel if status is still 'menunggu'
        if ($booking->status != 'menunggu') {
            $this->session->set_flashdata('error', 'Peminjaman tidak dapat dibatalkan!');
            redirect('booking/detail/' . $id);
        }
        
        // Update status booking
        $data = array(
            'status' => 'dibatalkan',
            'updated_at' => date('Y-m-d H:i:s')
        );
        
        $this->Booking_model->update($id, $data);
        $this->session->set_flashdata('success', 'Peminjaman berhasil dibatalkan!');
        redirect('booking');
    }
}
        // Only admin can approve