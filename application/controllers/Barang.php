<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
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
        $data['title'] = "Barang";
        $data['barang'] = $this->admin->getBarang();
        $this->template->load('template/dashboard', 'barang/data', $data);
    }

    private function _validasi()
{
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('id_jenis', 'Jenis Barang', 'required');
        $this->form_validation->set_rules('id_satuan', 'Satuan Barang', 'required');
        $this->form_validation->set_rules('id_supplier', 'Supplier', 'required');
        $this->form_validation->set_rules('potongan1', 'Potongan 1', 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[20]');
        $this->form_validation->set_rules('potongan2', 'Potongan 2', 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[20]');
        $this->form_validation->set_rules('potongan3', 'Potongan 3', 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[20]');

        $this->form_validation->set_rules('ppn', 'PPN', 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[20]');
        $this->form_validation->set_rules('stok', 'Stok', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('harga_beli', 'Harga Beli', 'required|numeric');
        $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required|numeric');
    }


    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang";
            $data['jenis'] = $this->admin->get('jenis');
            $data['satuan'] = $this->admin->get('satuan');
            $data['supplier'] = $this->admin->get('supplier'); // TAMBAHKAN INI

            // Generate ID Barang
            $kode_terakhir = $this->admin->getMax('barang', 'id_barang');
            $kode_tambah = ($kode_terakhir) ? substr($kode_terakhir, -6, 6) : '000000';
            $kode_tambah++;
            $number = str_pad($kode_tambah, 6, '0', STR_PAD_LEFT);
            $data['id_barang'] = 'B' . $number;

            $this->template->load('template/dashboard', 'barang/add', $data);
        } else {
            $input = $this->input->post(null, true);

            // Hitung harga setelah potongan dan PPN
            $harga_beli = (float) $input['harga_beli'];

            // Hitung total potongan kumulatif
            $total_potongan = 1;
            $total_potongan *= (1 - $input['potongan1'] / 100);
            $total_potongan *= (1 - $input['potongan2'] / 100);
            $total_potongan *= (1 - $input['potongan3'] / 100);
            $total_potongan *= (1 - $input['potongan4'] / 100);

            // Harga setelah potongan
            $harga_setelah_potongan = $harga_beli * $total_potongan;

            // Harga setelah PPN
            $input['harga_setelah_potongan'] = $harga_setelah_potongan * (1 + $input['ppn'] / 100);

            // Harga jual diambil dari input (tidak dihitung)
            $input['harga_jual'] = (float) $input['harga_jual'];

            // Simpan data
            $insert = $this->admin->insert('barang', $input);
            if ($insert) {
                set_pesan('data berhasil disimpan');
                redirect('barang');
            } else {
                set_pesan('gagal menyimpan data');
                redirect('barang/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang";
            $data['jenis'] = $this->admin->get('jenis');
            $data['satuan'] = $this->admin->get('satuan');
            $data['supplier'] = $this->admin->get('supplier'); // Changed from $this->supplier to $this->admin
            $data['barang'] = $this->admin->get('barang', ['id_barang' => $id]);

            if (!$data['barang']) {
                set_pesan('Data barang tidak ditemukan', false);
                redirect('barang');
            }

            $this->template->load('template/dashboard', 'barang/edit', $data);
        } else {
            try {
                $input = $this->input->post(null, true);

                // Validate numeric values
                $harga_beli = (float) filter_var($input['harga_beli'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $input['potongan1'] = (float) filter_var($input['potongan1'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $input['potongan2'] = (float) filter_var($input['potongan2'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $input['potongan3'] = (float) filter_var($input['potongan3'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $input['potongan4'] = (float) filter_var($input['potongan4'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $input['ppn'] = (float) filter_var($input['ppn'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $input['harga_jual'] = (float) filter_var($input['harga_jual'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

                // Calculate cumulative discounts
                $total_potongan = 1;
                $total_potongan *= (1 - $input['potongan1'] / 100);
                $total_potongan *= (1 - $input['potongan2'] / 100);
                $total_potongan *= (1 - $input['potongan3'] / 100);
                $total_potongan *= (1 - $input['potongan4'] / 100);

                // Calculate final price after discounts and tax
                $harga_setelah_potongan = $harga_beli * $total_potongan;
                $input['harga_setelah_potongan'] = $harga_setelah_potongan * (1 + $input['ppn'] / 100);

                $update = $this->admin->update('barang', 'id_barang', $id, $input);

                if ($update) {
                    set_pesan('Data berhasil disimpan');
                } else {
                    throw new Exception('Gagal menyimpan data ke database');
                }
            } catch (Exception $e) {
                set_pesan($e->getMessage(), false);
                redirect('barang/edit/' . $id);
                return; // Exit after redirect
            }

            redirect('barang');
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('barang', 'id_barang', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('barang');
    }

    public function getstok($getId)
    {
        $id = encode_php_tags($getId);
        $query = $this->admin->cekStok($id);
        output_json($query);
    }
}
