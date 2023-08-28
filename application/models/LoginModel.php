<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoginModel extends CI_Model
{
    public function auth($data)
    {
        $sql = "
            SELECT id, name, email, role, status FROM tb_users WHERE email = '" . $data['email'] . "' AND password = '" . $data['password'] . "'
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function activation($data)
    {
        $id = $data['user_id'];
        $otp = $data['otp_code'];
        $sql = "
            SELECT otp_code FROM otp WHERE user_id = $id ORDER BY id DESC
        ";
        $query = $this->db->query($sql);
        $row = $query->row_array();

        if ($row['otp_code'] === $otp) {
            $this->db->delete('otp', ['user_id' => $id]);
            $this->db->update('tb_users', ['status' => 'active', 'last_login' => date('Y-m-d H:i:s')], ['id' => $id]);
            return TRUE;
        } else {
            return FALSE;
            /* $response = [
                "status" => "error",
                "message" => "Kode OTP tidak valid"
            ]; */
        }
    }
}
