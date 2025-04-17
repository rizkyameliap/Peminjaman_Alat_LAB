<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alat_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        return $this->db->get('alat')->result();
    }

    public function get_available() {
        return $this->db->get_where('alat', ['status' => 'tersedia'])->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('alat', ['id_alat' => $id])->row();
    }

    public function insert($data) {
        $this->db->insert('alat', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        return $this->db->update('alat', $data, ['id_alat' => $id]);
    }

    public function delete($id) {
        return $this->db->delete('alat', ['id_alat' => $id]);
    }

    public function check_availability($id_alat, $tanggal_pinjam, $tanggal_kembali, $jumlah) {
        // Dapatkan data alat
        $alat = $this->get_by_id($id_alat);
        if (!$alat || $alat->status != 'tersedia' || $alat->stok_total < $jumlah) {
            return false;
        }

        // Hitung total alat yang sedang dipinjam pada rentang tanggal tersebut
        $this->db->select_sum('jumlah');
        $this->db->from('booking');
        $this->db->where('id_alat', $id_alat);
        $this->db->where('status !=', 'ditolak');
        $this->db->group_start();
            $this->db->where('tanggal_pinjam <=', $tanggal_kembali);
            $this->db->where('tanggal_kembali >=', $tanggal_pinjam);
        $this->db->group_end();
        $query = $this->db->get();
        $total_dipinjam = $query->row()->jumlah ?? 0;

        // Cek apakah stok cukup
        return ($alat->stok_total - $total_dipinjam) >= $jumlah;
    }
}