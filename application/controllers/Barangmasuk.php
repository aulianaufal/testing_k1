<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barangmasuk extends CI_Controller
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
        $data['title'] = "Barang Masuk";
        $data['barangmasuk'] = $this->admin->getBarangMasuk();
        $this->template->load('template/dashboard', 'barang_masuk/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('id_jenis', 'Jenis Barang', 'required');
        $this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
        $this->form_validation->set_rules('nota', 'nota', 'required');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required');
        $this->form_validation->set_rules('jumlah_masuk', 'Jumlah Masuk', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('harga_setelah_potongan', 'Harga Beli', 'required|numeric|greater_than[0]');

    }

    public function add()
    {
        $this->_validasi();

        $data['jenis'] = $this->admin->get('jenis');
        $data['supplier'] = $this->admin->get('supplier');
        $data['title'] = "Barang Masuk";

        if ($this->form_validation->run() == FALSE) {
            $this->template->load('template/dashboard', 'barang_masuk/add', $data);
        } else {
            $input = $this->input->post(null, true);

            $this->db->trans_start();

            $barang = $this->admin->get('barang', ['id_barang' => $input['barang_id']]);
            if (!$barang) {
                set_pesan('Barang tidak ditemukan', false);
                redirect('barang_masuk/add');
            }

            $total = $input['jumlah_masuk'] * $input['harga_setelah_potongan'];

            // Isi default jika kosong
            $tunai = isset($input['tunai']) && $input['tunai'] !== '' ? $input['tunai'] : 0;
            $kredit = isset($input['kredit']) && $input['kredit'] !== '' ? $input['kredit'] : 0;
            $keterangan = isset($input['keterangan']) ? $input['keterangan'] : '';

            $insert = [
                'tanggal' => $input['tanggal'],
                'supplier_id' => $input['supplier_id'],
                'nota' => $input['nota'],
                'barang_id' => $input['barang_id'],
                'jumlah_masuk' => $input['jumlah_masuk'],
                'harga_setelah_potongan' => $input['harga_setelah_potongan'],
                'total' => $total,
                'tunai' => $tunai,
                'kredit' => $kredit,
                'keterangan' => $keterangan
            ];

            $this->admin->insert('barang_masuk', $insert);

            // Hanya update stok saja, tidak update harga_beli dan harga_setelah_potongan
            $this->admin->update('barang', 'id_barang', $input['barang_id'], [
                'stok' => $barang['stok'] + $input['jumlah_masuk']
            ]);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                set_pesan('Data gagal disimpan', false);
                redirect('barangmasuk/add');
            } else {
                set_pesan('Data berhasil disimpan');
                redirect('barangmasuk');
            }
        }
    }
    // Mendapatkan daftar barang berdasarkan jenis (AJAX)
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

    public function delete($getId = null)  // Tambahkan default value null
    {
        if (!$getId) {
            set_pesan('ID tidak valid', false);
            redirect('barangmasuk');
        }

        $id = encode_php_tags($getId);
        $this->db->trans_start();

        // Get the transaction details first
        $transaksi = $this->admin->get('barang_masuk', ['transaksi_id' => $id]);

        if ($transaksi) {
            // Update the stock
            $barang = $this->admin->get('barang', ['id_barang' => $transaksi['barang_id']]);
            $new_stok = $barang['stok'] - $transaksi['jumlah_masuk'];

            $this->admin->update('barang', 'id_barang', $transaksi['barang_id'], [
                'stok' => $new_stok
            ]);

            // Delete the transaction
            $this->admin->delete('barang_masuk', 'transaksi_id', $id);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            set_pesan('Data gagal dihapus.', false);
        } else {
            set_pesan('Data berhasil dihapus.');
        }
        redirect('barangmasuk');
    }


}