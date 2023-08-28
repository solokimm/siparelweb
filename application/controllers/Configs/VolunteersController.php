<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class VolunteersController extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('configs/VolunteersModel');
        $this->load->library('email');
    }

    public function index()
    {
        $this->title = 'Pengaturan Relawan';
        $this->data['customJs'] = [
            'assets/customJs/volunteers_management/main.js',
        ];
        $this->render('index', 'configs/volunteers');
    }

    public function details($id)
    {
        $this->title = 'Detail Relawan';
        $this->data['customJs'] = [
            'assets/customJs/volunteers_management/detail.js',
        ];
        $this->data['profile'] = $this->VolunteersModel->voluById($id);
        $this->render('detail', 'configs/volunteers');
    }

    public function table()
    {
        header('Content-Type:application/json');
        $pagination = $this->input->get();
        $result =  $this->VolunteersModel->table($pagination);
        echo json_encode($result);
    }

    public function invite()
    {
        header('Content-Type:application/json');
        $data = $this->input->post('data');
        // echo json_encode($data);
        $insertData = $this->VolunteersModel->insertVolu($data);
        if ($insertData) {
            $sendMail = $this->sendMail($data);
            echo json_encode($sendMail);
        } else if (!$insertData) {
            echo json_encode([
                "status" => "invalid",
                "message" => "Email tidak dapat digunakan"
            ]);
            die();
        }
    }

    protected function sendMail($data)
    {
        $mail = new PHPMailer(true);

        try {
            // Pengaturan SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'kimdantest@gmail.com';
            $mail->Password = 'nryamrmauhyfiwqq';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            // Pengaturan Email
            $mail->setFrom('kimdantest@gmail.com', 'SIPAREL');
            $mail->addAddress($data['email'], $data['username']);
            $mail->isHTML(true);
            $mail->Subject = 'Undangan Relawan SIPARELNEW';
            $mail->Body = $this->load->view('_mail/volunteer-invitation-message.html', $data, TRUE);

            // Kirim email
            $mail->send();
            return [
                'status' => 'success',
                'message' => 'Undangan telah dikirimkan ke email ' . $data['email']
            ];
        } catch (Exception $e) {
            echo 'Undangan gagal dikirimkan:', $mail->ErrorInfo;
        }
    }

    public function voluById()
    {
        header('Content-Type:application/json');
        $id = $this->input->post('id');
        //get groups by id
        $data = $this->VolunteersModel->voluById($id);
        echo json_encode($data);
    }

    public function edit()
    {
        header('Content-Type:application/json');
        $id = $this->input->post('id');
        $data = [
            'name' => $this->input->post('name'),
            'phone' => $this->input->post('phone'),
            'address' => $this->input->post('address'),
            'gender' => $this->input->post('gender'),
            'place_ofbirth' => $this->input->post('place_ofbirth'),
            'date_ofbirth' => $this->input->post('date_ofbirth'),
            'status' => $this->input->post('status'),
        ];
        $edit = $this->VolunteersModel->edit($data, $id);
        echo json_encode($edit);
    }

    public function delete()
    {
        header('Content-Type:application/json');
        $id = $this->input->post('id');
        $delete = $this->VolunteersModel->delete($id);
        echo json_encode($delete);
    }

    public function select2_groups()
    {
        header('Content-Type:application/json');
        $term = $this->input->get('term');
        $data = $this->VolunteersModel->select2_groups($term);
        echo json_encode($data);
    }

    public function select2_prov()
    {
        header('Content-Type:application/json');
        $term = $this->input->get('term');
        $data = $this->VolunteersModel->select2_prov($term);
        echo json_encode($data);
    }

    public function select2_city()
    {
        header('Content-Type: application/json');
        $prov = $this->input->get('prov');
        $query = $this->input->get('quest');
        $cities = $this->VolunteersModel->select2_city($prov, $query);
        echo json_encode($cities);
    }
}
