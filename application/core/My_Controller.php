<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    protected $data = [];
    protected $title = '';

    public function render($file, $folder = null)
    {
        if ($this->session->userdata('login_status') != 'active') {
            redirect(base_url());
        } else {
            $path = ($folder) ? $folder . '/' . $file : $file;
            $this->data['session_profile'] = $this->db->select('id, name, role, image')->where(['id' => $this->session->userdata('id_user')])->get('tb_users')->row_array();
            $this->data['title'] = $this->title;
            $this->load->view('_base/_head', $this->data);
            $this->load->view($path, $this->data);
            $this->load->view('_base/_foot', $this->data);
        }
    }

    public function renderLogin($file, $folder = null)
    {
        if ($this->session->userdata('login_status') == 'active') {
            redirect(base_url('dashboard'));
        } else {
            $path = ($folder) ? $folder . '/' . $file : $file;
            $this->data['title'] = "SIPARELNEW";
            $this->load->view('_base/login/_head', $this->data);
            $this->load->view($path, $this->data);
            $this->load->view('_base/login/_foot', $this->data);
        }
    }

    protected function generateOTP($x, $id)
    {
        $for_id = ($x == "volunteer") ? "volunteer_id" : "user_id";
        $otp = '';
        $characters = '0123456789';
        $char_length = strlen($characters);

        for ($i = 0; $i < 6; $i++) {
            $otp .= $characters[rand(0, $char_length - 1)];
        }
        $this->db->insert('otp', ['otp_code' => $otp, $for_id => $id]);

        return $otp;
    }
}
