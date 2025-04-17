<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Mahasiswa_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
    }

    public function index() {
        // Redirect ke login
        redirect('auth/login');
    }

    public function login() {
        if ($this->session->userdata('logged_in')) {
            echo "Sudah login sebagai: " . $this->session->userdata('role');
            // Biarkan redirect tetap ada
            $role = $this->session->userdata('role');
            if ($role === 'admin') {
                redirect('dashboard/admin');
            } else {
                redirect('dashboard');
            }
            return;
        }
    
        $this->form_validation->set_rules('nim', 'NIM', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
    
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/login');
            return;
        }
    
        $nim = $this->input->post('nim', TRUE);
        $password = $this->input->post('password', TRUE);
    
        echo "Mencoba login dengan NIM: " . $nim . "<br>";
    
        if ($nim === 'admin' && $password === 'admin123') {
            echo "Login admin berhasil, mengatur session... <br>";
            $this->session->set_userdata([
                'logged_in' => TRUE,
                'nim' => 'admin',
                'nama' => 'Administrator',
                'role' => 'admin'
            ]);
            
            echo "Session setelah login admin: <pre>";
            print_r($this->session->userdata());
            echo "</pre>";
            
            redirect('dashboard/admin');
            return;
        }
    
        $user = $this->Mahasiswa_model->verify_login($nim, $password);
        
        echo "Hasil verify_login: <pre>";
        var_dump($user);
        echo "</pre>";
    
        if ($user) {
            echo "Login mahasiswa berhasil, mengatur session... <br>";
            $this->session->set_userdata([
                'logged_in' => TRUE,
                'id_mahasiswa' => $user->id_mahasiswa,
                'nim' => $user->nim,
                'nama' => $user->nama,
                'role' => 'mahasiswa'
            ]);
            
            echo "Session setelah login mahasiswa: <pre>";
            print_r($this->session->userdata());
            echo "</pre>";
            
            redirect('dashboard');
        } else {
            echo "Login gagal! <br>";
            $this->session->set_flashdata('error', 'NIM atau Password salah!');
            redirect('auth/login');
        }
    }
}


