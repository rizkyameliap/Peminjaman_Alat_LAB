<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{
    public function __construct()
{
    parent::__construct();
    $this->load->library('session');
    $this->load->helper('url'); // <<-- Tambahkan ini!

    if (!$this->session->userdata('logged_in')) {
        redirect('auth/login');
    }

    $this->load->model('Booking_model');
}




    public function index()
    {
        $data = [
            'title' => 'Welcome',
            'page' => 'home',
            'user' => $this->session->userdata('user'),
        ];

        if ($data['user']->role == "mahasiswa") {
            $data['booking'] = $this->Booking_model->getByUserId($data['user']->id);
        } else {
            $data['pending_count'] = $this->Booking_model->countPending();
        }

        $this->load->view('layout/header', $data);
        $this->load->view('home', $data);
        $this->load->view('layout/footer');
    }
}
