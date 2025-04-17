<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        $this->db->select('booking.*, mahasiswa.nim, mahasiswa.nama as nama_mahasiswa, alat.nama_alat');
        $this->db->from('booking');
        $this->db->join('mahasiswa', 'mahasiswa.id_mahasiswa = booking.id_mahasiswa');
        $this->db->join('alat', 'alat.id_alat = booking.id_alat');
        $this->db->order_by('booking.tanggal_pinjam', 'DESC');
        return $this->db->get()->result();
    }

    public function get_by_id($id) {
        $this->db->select('booking.*, mahasiswa.nim, mahasiswa.nama as nama_mahasiswa, alat.nama_alat');
        $this->db->from('booking');
        $this->db->join('mahasiswa', 'mahasiswa.id_mahasiswa = booking.id_mahasiswa');
        $this->db->join('alat', 'alat.id_alat = booking.id_alat');
        $this->db->where('booking.id_booking', $id);
        return $this->db->get()->row();
    }

    public function get_by_mahasiswa($id_mahasiswa) {
        $this->db->select('booking.*, alat.nama_alat, alat.kode_alat');
        $this->db->from('booking');
        $this->db->join('alat', 'alat.id_alat = booking.id_alat');
        $this->db->where('booking.id_mahasiswa', $id_mahasiswa);
        $this->db->order_by('booking.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function insert($data) {
        $this->db->insert('booking', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        return $this->db->update('booking', $data, ['id_booking' => $id]);
    }

    public function delete($id) {
        return $this->db->delete('booking', ['id_booking' => $id]);
    }

    public function get_pending_bookings() {
        $this->db->select('booking.*, mahasiswa.nim, mahasiswa.nama as nama_mahasiswa, alat.nama_alat');
        $this->db->from('booking');
        $this->db->join('mahasiswa', 'mahasiswa.id_mahasiswa = booking.id_mahasiswa');
        $this->db->join('alat', 'alat.id_alat = booking.id_alat');
        $this->db->where('booking.status', 'menunggu');
        $this->db->order_by('booking.created_at', 'ASC');
        return $this->db->get()->result();
    }
}