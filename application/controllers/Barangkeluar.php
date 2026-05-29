<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barangkeluar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = "Barang Keluar";
        $data['barangkeluar'] = $this->admin->getBarangKeluar();
        $this->template->load('template/dashboard', 'barang_keluar/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('tanggal_keluar', 'Tanggal', 'required');
        $this->form_validation->set_rules('id_jenis', 'Jenis Barang', 'required');
        $this->form_validation->set_rules('customer_id', 'customer', 'required');
        $this->form_validation->set_rules('nota', 'nota', 'required');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required');
        $this->form_validation->set_rules('jumlah_keluar', 'Jumlah Keluar', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('harga_setelah_potongan', 'Harga Beli', 'required|numeric|greater_than[0]');

    }

    public function add()
    {
        $this->_validasi();

        $data['jenis'] = $this->admin->get('jenis');
        $data['customer'] = $this->admin->get('customer');
        $data['title'] = "Barang Keluar";

        if ($this->form_validation->run() == FALSE) {
            $this->template->load('template/dashboard', 'barang_keluar/add', $data);
        } else {
            $input = $this->input->post(null, true);

            $this->db->trans_start();

            $barang = $this->admin->get('barang', ['id_barang' => $input['barang_id']]);
            if (!$barang) {
                set_pesan('Barang tidak ditemukan', false);
                redirect('barang_keluar/add');
            }

            $total = $input['jumlah_keluar'] * $input['harga_setelah_potongan'];

            // Isi default jika kosong
            $tunai = isset($input['tunai']) && $input['tunai'] !== '' ? $input['tunai'] : 0;
            $kredit = isset($input['kredit']) && $input['kredit'] !== '' ? $input['kredit'] : 0;
            $keterangan = isset($input['keterangan']) ? $input['keterangan'] : '';

            $insert = [
                'tanggal_keluar' => $input['tanggal_keluar'],
                'customer_id' => $input['customer_id'],
                'nota' => $input['nota'],
                'barang_id' => $input['barang_id'],
                'jumlah_keluar' => $input['jumlah_keluar'],
                'harga_setelah_potongan' => $input['harga_setelah_potongan'],
                'total' => $total,
                'tunai' => $tunai,
                'kredit' => $kredit,
                'keterangan' => $keterangan
            ];

            $this->admin->insert('barang_keluar', $insert);

            // Hanya update stok saja, tidak update harga_beli dan harga_setelah_potongan
            $this->admin->update('barang', 'id_barang', $input['barang_id'], [
                'stok' => $barang['stok'] - $input['jumlah_keluar']
            ]);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                set_pesan('Data gagal disimpan', false);
                redirect('barangkeluar/add');
            } else {
                set_pesan('Data berhasil disimpan');
                redirect('barangkeluar');
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        $this->db->trans_start();

        // Ambil data transaksi
        $transaksi = $this->admin->get('barang_keluar', ['id_barang_keluar' => $id]);

        if ($transaksi) {
            // Kembalikan stok
            $barang = $this->admin->get('barang', ['id_barang' => $transaksi['barang_id']]);
            $this->admin->update('barang', 'id_barang', $transaksi['barang_id'], [
                'stok' => $barang['stok'] + $transaksi['jumlah_keluar']
            ]);

            // Hapus transaksi
            $this->admin->delete('barang_keluar', 'id_barang_keluar', $id);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            set_pesan('Gagal menghapus data', false);
        } else {
            set_pesan('Data berhasil dihapus');
        }
        redirect('barangkeluar');
    }

    // AJAX untuk get detail barang
    public function get_barang_by_jenis($jenis_id)
    {
        $barang = $this->admin->get_barang_by_jenis($jenis_id);
        header('Content-Type: application/json');
        echo json_encode($barang);
        exit;
    }

    // Mendapatkan detail barang berdasarkan id (AJAX)
    public function get_barang_details($barang_id)
    {
        $barang = $this->admin->get('barang', ['id_barang' => $barang_id]);
        header('Content-Type: application/json');
        echo json_encode($barang);
        exit;
    }
}