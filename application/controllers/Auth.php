<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('Auth_model', 'auth');
        $this->load->model('Admin_model', 'admin');
    }

    private function _has_login()
    {
        if ($this->session->has_userdata('login_session')) {
            redirect('dashboard');
        }
    }

    public function index()
    {
        $this->_has_login();

        // Di Auth.php controller
        $this->form_validation->set_rules('username', 'Username', 'required|trim', [
            'required' => 'Username wajib diisi'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim', [
            'required' => 'Password wajib diisi'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Aplikasi';
            $this->template->load('template/auth', 'auth/login', $data);
        } else {
            $input = $this->input->post(null, true);

            $cek_username = $this->auth->cek_username($input['username']);
            if ($cek_username > 0) {
                $password = $this->auth->get_password($input['username']);
                if (password_verify($input['password'], $password)) {
                    $user_db = $this->auth->userdata($input['username']);
                    if ($user_db['is_active'] != 1) {
                        $this->session->set_flashdata('login_error', 'Akun anda belum aktif/dinonaktifkan. Silahkan hubungi admin.');
                        redirect('auth');
                    } else {
                        $userdata = [
                            'user' => $user_db['id_user'],
                            'role' => $user_db['role'],
                            'timestamp' => time()
                        ];
                        $this->session->set_userdata('login_session', $userdata);
                        redirect('dashboard');
                    }
                } else {
                    $this->session->set_flashdata('login_error', '<div class="alert alert-danger">Password yang Anda masukkan salah</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('login_error', '<div class="alert alert-danger">Username tidak ditemukan</div>');
                redirect('auth');
            }
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('login_session');
        $this->session->set_flashdata('login_error', 'Anda telah berhasil logout.');
        redirect('auth');
    }
}
