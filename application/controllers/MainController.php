<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MainController extends My_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('MainModel');
    }

    function index()
    {
        $this->title = "Dashboard";
        $this->data['geodata'] = file_get_contents('assets/plugins/geodata/indonesiaLow.json');
        $this->data['customJs'] = [
            'assets/plugins/geodata/indonesiaLow.js',
            'assets/customJs/main_dashboard.js'
        ];
        $this->render('main_dashboard');
    }

    function countData()
    {
        header('Content-Type:application/json');
        $data =  $this->MainModel->countData();
        echo json_encode($data);
    }

    function leaderBoard()
    {
        header('Content-Type:application/json');
        $data =  $this->MainModel->leaderBoard();
        echo json_encode($data);
    }

    function myProfile()
    {
        $this->title = "Profil Saya";
        $this->data['customJs'] = [
            'assets/customJs/my_profile/main.js'
        ];
        $this->data['profile'] = $this->MainModel->myProfile();
        $this->render('index', 'configs/profile');
    }

    function getCurrentUserData()
    {
        header('Content-Type:application/json');
        $data = $this->MainModel->myProfile();
        echo json_encode($data);
    }

    function editProfile()
    {
        header('Content-Type:application/json');
        $image = file_get_contents($_FILES['gambar']['tmp_name']);
        $base64_image = base64_encode($image);
        $data = [
            'name' => $this->input->post('name'),
            'phone' => $this->input->post('phone'),
            'gender' => $this->input->post('gender'),
            'address' => $this->input->post('address'),
            'image' => json_encode($base64_image)
        ];
        $update = $this->MainModel->edit($data);
        echo json_encode($update);
    }

    function profileSettings()
    {
        $this->title = "Ubah Kata Sandi";
        $this->data['customJs'] = [
            'assets/customJs/profile_settings.js'
        ];
        $this->data['profile'] = $this->MainModel->myProfile();
        $this->render('profile_settings', 'configs/profile');
    }

    function changeEmail()
    {
        header('Content-Type:application/json');
        $data = [
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password'))
        ];

        $checkPassword = $this->checkPassword($data['password']);

        if ($checkPassword->num_rows() == 1) {
            $updateEmail = $this->MainModel->updateEmail($data);
            echo json_encode($updateEmail);
        } else {
            echo json_encode([
                'status' => 'invalid',
                'message' => 'Kata sandi tidak valid, periksa kembali kata sandi Anda'
            ]);
        }
    }

    protected function checkPassword($password)
    {
        $id = $this->session->userdata('id_user');
        $sql = "
            SELECT name FROM tb_users WHERE password = '$password' AND id = '$id'
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    function changePass()
    {
        header('Content-Type:application/json');
        $data = [
            'currPass' => md5($this->input->post('currPass')),
            'newPass' => md5($this->input->post('newPass')),
        ];

        $checkPassword = $this->checkPassword($data['currPass']);

        if ($checkPassword->num_rows() == 1) {
            $updatePass = $this->MainModel->updatePass($data);
            echo json_encode($updatePass);
        } else {
            echo json_encode([
                'status' => 'invalid',
                'message' => 'Kata sandi lama Anda tidak valid, mohon periksa kembali'
            ]);
        }
    }

    function changeStatus()
    {
        header('Content-Type:application/json');
        $changeStatus = $this->MainModel->changeStatus();
        echo json_encode($changeStatus);
    }
}
