<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        return $this->db->get('mahasiswa')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('mahasiswa', ['id_mahasiswa' => $id])->row();
    }

    public function get_by_nim($nim) {
        return $this->db->get_where('mahasiswa', ['nim' => $nim])->row();
    }

    public function insert($data) {
        $this->db->insert('mahasiswa', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        return $this->db->update('mahasiswa', $data, ['id_mahasiswa' => $id]);
    }

    public function delete($id) {
        return $this->db->delete('mahasiswa', ['id_mahasiswa' => $id]);
    }

    // 🔐 Login checker yang otomatis hash password jika belum di-hash
    public function verify_login($nim, $password) {
        $this->db->where('nim', $nim);
        $query = $this->db->get('mahasiswa');
        $user = $query->row();

        if ($user) {
            // Jika password belum di-hash (misal masih plaintext)
            if (strlen($user->password) < 60 || substr($user->password, 0, 4) !== '$2y$') {
                if ($user->password === $password) {
                    // Auto-hash & update password
                    $hashed = password_hash($password, PASSWORD_DEFAULT);
                    $this->update($user->id_mahasiswa, ['password' => $hashed]);

                    // Return user object dengan password baru
                    $user->password = $hashed;
                    return $user;
                }
            }

            // Jika password sudah di-hash, verifikasi normal
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }

        return false;
    }

    // 🔄 Fungsi untuk hashing semua password plaintext di tabel mahasiswa
    public function hash_all_plain_passwords() {
        $mahasiswa = $this->db->get('mahasiswa')->result();

        foreach ($mahasiswa as $mhs) {
            if (strlen($mhs->password) < 60 || substr($mhs->password, 0, 4) !== '$2y$') {
                $hashed = password_hash($mhs->password, PASSWORD_DEFAULT);
                $this->db->where('id_mahasiswa', $mhs->id_mahasiswa);
                $this->db->update('mahasiswa', ['password' => $hashed]);
            }
        }
    }
}
