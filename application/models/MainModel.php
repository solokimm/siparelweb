<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MainModel extends CI_Model
{
    public function countData()
    {
        $volu = "
            SELECT name FROM tb_volunteers
        ";
        $countVolu = $this->db->query($volu)->num_rows();

        $reports = "
            SELECT title FROM tb_news
        ";

        $countReports = $this->db->query($reports)->num_rows();

        return [
            'volunteers' => $countVolu,
            'reports' => $countReports
        ];
    }

    public function leaderBoard()
    {
        $sql = "
            SELECT
                --nanti foto profil relawan
                v.name AS volunteer_name, 
                COUNT(n.id) AS total_news
            FROM tb_volunteers v
            LEFT JOIN tb_news n ON v.id = n.uploaded_by
            GROUP BY v.id, v.name
            ORDER BY total_news DESC
            LIMIT 3;
        ";
        $query = $this->db->query($sql);
        if ($query) {
            return $query->result_array();
        }
    }

    public function myProfile()
    {
        $id = $this->session->userdata('id_user');
        $sql = "
            SELECT 
                id, 
                name, 
                role, 
                nip, 
                email, 
                phone, 
                gender, 
                address, 
                satker_id, 
                image, 
                status, 
                last_login, 
                created_by
            FROM tb_users 
            WHERE id = $id
        ";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function edit($data)
    {
        $id = $this->session->userdata('id_user');
        $query = $this->db->update('tb_users', $data, ['id' => $id]);

        if ($query) {
            return [
                'status' => 'success',
                'message' => 'Informasi berhasil diubah'
            ];
        }
    }

    public function updateEmail($data)
    {
        $id = $this->session->userdata('id_user');
        $sql = "
            UPDATE tb_users
            SET email = '" . $data['email'] . "'
            WHERE password = '" . $data['password'] . "'
            AND id = '$id'
        ";
        $query = $this->db->query($sql);
        if ($query) {
            return [
                'status' => 'success',
                'message' => 'Email berhasil diubah'
            ];
        }
    }

    public function updatePass($data)
    {
        $id = $this->session->userdata('id_user');
        $sql = "
            UPDATE tb_users
            SET password = '" . $data['newPass'] . "'
            WHERE password = '" . $data['currPass'] . "'
            AND id = '$id'
        ";
        $query = $this->db->query($sql);
        if ($query) {
            return [
                'status' => 'success',
                'message' => 'Kata sandi berhasil diubah'
            ];
        }
    }

    public function changeStatus()
    {
        $id = $this->session->userdata('id_user');
        $sql = "
            UPDATE tb_users
            SET status = 'nonactive'
            WHERE id = '$id'
        ";
        $query = $this->db->query($sql);
        if ($query) {
            return [
                'status' => 'success',
                'message' => 'Akun berhasil dinonaktifkan'
            ];
        }
    }
}
