<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class LoginController extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('LoginModel');
    }

    public function index()
    {
        $this->renderLogin('login');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url());
    }

    public function auth()
    {
        header('Content-Type:application/json');
        $data = [
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password'))
        ];
        $auth =  $this->LoginModel->auth($data);
        if ($auth->num_rows() == 1) {
            $data = $auth->row_array();
            $session = array(
                'id_user' => $data['id'],
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $data['role'],
                'status' => $data['status'],
                'login_status' => "active"
            );
            if ($data['status'] == "nonactive") {
                $otp = $this->sendOTP($data);
                echo json_encode([
                    "status" => "nonactive",
                    "user_id" => $data['id'],
                    "message" => "Aktifasi akun anda dengan memasukan otp yang dikirimkan ke alamat email Anda"
                ]);
                die();
            }
            $this->db->update('tb_users', ['last_login' => date('Y-m-d H:i:s')], ['id' => $data['id']]);
            $this->session->set_userdata($session);
            echo json_encode([
                "status" => "success"
            ]);
        } else {
            echo json_encode([
                "status" => "failed",
                "message" => "Email atau Password tidak terdaftar di sistem kami"
            ]);
        }
    }

    protected function sendOTP($data)
    {
        $mail = new PHPMailer(true);
        $data['otp_code'] = $this->generateOTP("user", $data['id']);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'kimdantest@gmail.com';
            $mail->Password = 'nryamrmauhyfiwqq';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('kimdantest@gmail.com', 'SIPAREL');
            $mail->addAddress($data['email'], $data['email']);
            $mail->isHTML(true);
            $mail->Subject = $data['otp_code'] . " adalah kode OTP kamu";

            $htmlContent = $this->load->view('_mail/send-otp', $data, TRUE);
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

    public function otp_activation()
    {
        header('Content-Type: application/json');
        try {
            $data = [
                "otp_code" => $this->input->post('otp'),
                "user_id" => intval($this->input->post('user_id'))
            ];

            $activation = $this->LoginModel->activation($data);
            if ($activation) {
                $query = $this->db
                    ->select('id, name, email, role, status')
                    ->where('id', $data['user_id'])
                    ->get('tb_users');
                $data = $query->row_array();
                $session = array(
                    'id_user' => $data['id'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'role' => $data['role'],
                    'status' => $data['status'],
                    'login_status' => "active"
                );
                $this->session->set_userdata($session);
                echo json_encode([
                    "status" => "success"
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Kode OTP tidak valid!"
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => "Terjadi kesalahan saat memproses permintaan."
            ]);
        }
    }
}
