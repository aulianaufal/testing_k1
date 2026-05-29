<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();


        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');
        $this->load->library('pdf');
    }


    public function index()
    {
        // Cek apakah ini adalah permintaan cetak
        $is_print_request = $this->input->post('action') === 'print' || $this->input->post('action') === 'pdf';


        $this->form_validation->set_rules('transaksi', 'Transaksi', 'required|in_list[barang_masuk,barang_keluar]');
        $this->form_validation->set_rules('tanggal', 'Periode Tanggal', 'required');


        if ($this->form_validation->run() == false) {
            // Jika validasi gagal, tampilkan form
            $data['title'] = "Laporan Transaksi";
            $this->template->load('template/dashboard', 'laporan/form', $data);
        } else {
            // Jika validasi berhasil, proses permintaan cetak
            $input = $this->input->post(null, true);
            $action = $this->input->post('action');
            $table = $input['transaksi'];
            $tanggal = $input['tanggal'];
            $pecah = explode(' - ', $tanggal);


            // Validate date format
            if (count($pecah) != 2 || empty($pecah[0]) || empty($pecah[1])) {
                set_pesan('Format tanggal tidak valid. Gunakan format: Tanggal Awal - Tanggal Akhir', false);
                redirect('laporan');
            }


            $mulai = date('Y-m-d', strtotime(trim($pecah[0])));
            $akhir = date('Y-m-d', strtotime(trim($pecah[1])));


            if ($mulai > $akhir) {
                set_pesan('Tanggal awal tidak boleh lebih besar dari tanggal akhir', false);
                redirect('laporan');
            }


            // Get data based on transaction type
            $query = [];
            if ($table == 'barang_masuk') {
                $query = $this->admin->getLaporanBarangMasuk($mulai, $akhir);
            } else {
                $query = $this->admin->getLaporanBarangKeluar($mulai, $akhir);
            }


            // Jika tidak ada data, tampilkan pesan dan kembali ke form
            if (empty($query)) {
                set_pesan('Tidak ada data untuk periode yang dipilih', false);
                redirect('laporan');
            }


            // Cetak laporan
            $this->_cetak($query, $table, $tanggal, $action);
        }
    }


    // Tambahkan method baru untuk menangani permintaan cetak langsung
   public function cetak()
{
    log_message('debug', 'Metode cetak dipanggil');
    // Validasi input
    $table = $this->input->post('transaksi');
    $tanggal = $this->input->post('tanggal');
    $action = $this->input->post('action', true);


    if (empty($table) || empty($tanggal)) {
        set_pesan('Parameter tidak lengkap', false);
        redirect('laporan');
    }


    $pecah = explode(' - ', $tanggal);
    if (count($pecah) != 2) {
        set_pesan('Format tanggal tidak valid', false);
        redirect('laporan');
    }


    $mulai = date('Y-m-d', strtotime(trim($pecah[0])));
    $akhir = date('Y-m-d', strtotime(trim($pecah[1])));


    // Get data
    $query = [];
    if ($table == 'barang_masuk') {
        $query = $this->admin->getLaporanBarangMasuk($mulai, $akhir);
    } else {
        $query = $this->admin->getLaporanBarangKeluar($mulai, $akhir);
    }


    // Cetak laporan
    $this->_cetak($query, $table, $tanggal, 'print');
}

private function _cetak($data, $table_type, $tanggal, $action = 'print')
{
    if (empty($data)) {
        $view_data = [
            'title' => 'Laporan ' . ($table_type == 'barang_masuk' ? 'Barang Masuk' : 'Barang Keluar'),
            'table_type' => $table_type,
            'tanggal' => $tanggal,
            'no_data' => true,
            'action' => $action
        ];
        $this->load->view('laporan/cetak', $view_data);
        return;
    }


    // Cetak laporan dalam format PDF atau HTML
    if ($action == 'pdf') {
        // Kode untuk mencetak dalam format PDF
    } else {
        // Tampilkan laporan dalam format HTML
        $view_data = [
            'title' => 'Laporan ' . ($table_type == 'barang_masuk' ? 'Barang Masuk' : 'Barang Keluar'),
            'table_type' => $table_type,
            'tanggal' => $tanggal,
            'data' => $data,
            'action' => $action
        ];
        $this->load->view('laporan/cetak', $view_data);
    }
}
   
}