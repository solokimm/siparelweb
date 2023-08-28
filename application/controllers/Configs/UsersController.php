<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class UsersController extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('configs/UsersModel');
        $this->load->library('email');
    }

    public function index()
    {
        $this->title = 'Pengaturan Pengguna';
        $this->data['customJs'] = [
            'assets/customJs/users_management/main.js',
        ];
        $this->render('index', 'configs/users');
    }

    public function table()
    {
        header('Content-Type:application/json');
        $pagination = $this->input->get();
        $result =  $this->UsersModel->table($pagination);
        echo json_encode($result);
    }

    public function add()
    {
        header('Content-Type:application/json');
        $data = [
            'name' => $this->input->post('name'),
            'nip' => $this->input->post('nip'),
            'email' => $this->input->post('email'),
            'satker_id' => $this->input->post('satker_id'),
            'role' => $this->input->post('role'),
            'password' => $this->input->post('password')
        ];
        $user_id = $this->UsersModel->add($data);
        if ($user_id) {
            $sendMail = $this->sendMail($data, $user_id);
            echo json_encode($sendMail);
        }
    }

    public function details($id)
    {
        $this->title = 'Detail Pengguna';
        $this->data['customJs'] = [
            'assets/customJs/users_management/detail.js',
        ];
        $this->data['profile'] = $this->UsersModel->userById($id);
        $this->render('detail', 'configs/users');
    }

    protected function sendMail($data)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'mail.siparel.id';
            $mail->SMTPAuth = true;
            $mail->Username = 'noreply-email@siparel.id';
            $mail->Password = 'J=f#jEmU;f?R';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('noreply-email@siparel.id', 'noreply');
            $mail->addAddress($data['email'], $data['email']);
            $mail->isHTML(true);
            $mail->Subject = 'Undangan Pengurus SIPARELNEW';

            $htmlContent = $this->load->view('_mail/invitation-message.html', $data, TRUE);
            $mail->Body = $htmlContent;

            $mail->send();
            return [
                'status' => 'success',
                'message' => 'Undangan telah dikirimkan ke email ' . $data['email']
            ];
        } catch (Exception $e) {
            echo 'Undangan gagal dikirimkan:', $mail->ErrorInfo;
        }
    }

    public function userById()
    {
        header('Content-Type:application/json');
        $id = $this->input->post('id');
        $data = $this->UsersModel->userById($id);
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
            'role' => $this->input->post('role'),
            'status' => $this->input->post('status')
        ];
        $edit = $this->UsersModel->edit($data, $id);
        echo json_encode($edit);
    }

    public function delete()
    {
        header('Content-Type:application/json');
        $id = $this->input->post('id');
        $delete = $this->UsersModel->delete($id);
        echo json_encode($delete);
    }

    public function select2_satker()
    {
        header('Content-Type:application/json');
        $term = $this->input->get('term');
        $data = $this->UsersModel->select2_satker($term);
        echo json_encode($data);
    }
}
