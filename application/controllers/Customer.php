<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
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
        $data['title'] = "customer";
        $data['customer'] = $this->admin->get('customer');
        $this->template->load('template/dashboard', 'customer/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_customer', 'Nama customer', 'required|trim');
        $this->form_validation->set_rules('alamat_customer', 'alamat customer', 'required');
        $this->form_validation->set_rules('telepon_customer', 'telepon customer', 'required');
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "customer";
            $this->template->load('template/dashboard', 'customer/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $save = $this->admin->insert('customer', $input);
            if ($save) {
                set_pesan('data berhasil disimpan.');
                redirect('customer');
            } else {
                set_pesan('data gagal disimpan', false);
                redirect('customer/add');
            }
        }
    }


    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "customer";
            $data['customer'] = $this->admin->get('customer', ['id_customer' => $id]);
            $this->template->load('template/dashboard', 'customer/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $update = $this->admin->update('customer', 'id_customer', $id, $input);

            if ($update) {
                set_pesan('data berhasil diedit.');
                redirect('customer');
            } else {
                set_pesan('data gagal diedit.');
                redirect('customer/edit/' . $id);
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('customer', 'id_customer', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('customer');
    }
}
