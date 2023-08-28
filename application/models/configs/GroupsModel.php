<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GroupsModel extends CI_Model
{
    public function table($pagination)
    {
        $curr_page = intval($pagination['start']);
        $limit_page = intval($pagination['length']);

        $structure_order = ['name', 'members', 'id'];
        foreach ($pagination['order'] as $key_order => $val_order) {
            $arr_order[] = $structure_order[$val_order['column']] . " " . strtoupper($val_order['dir']);
        }
        $fix_order = implode(',', $arr_order);

        $where = "";
        if ($pagination['search'] && $pagination['search']['value'] !== "") {
            $search = html_escape($pagination['search']['value']);
            $where .= " WHERE name ILIKE '%$search%' ";
        }

        $sql = "
            SELECT 
                id,
                name,
                members
            FROM tb_groups
            {$where}
        ";

        $query_all = $this->db->query("{$sql} ORDER BY {$fix_order}");
        $total_all = intval($query_all->num_rows());

        $query_limit = ($limit_page < 0) ? $query_all : $this->db->query("{$sql} ORDER BY {$fix_order} LIMIT {$limit_page} OFFSET {$curr_page}");

        $total_pagination = ceil($total_all / $limit_page);

        $generate = [
            "draw" => isset($pagination['draw']) ? intval($pagination['draw']) : 0,
            "recordsTotal" => $total_all,
            "recordsFiltered" => $total_all,
            "data" => ($total_pagination === 1) ? $query_all->result_array() : $query_limit->result_array()
        ];

        return $generate;
    }

    public function add($data)
    {
        if ($data) {
            $sql = "INSERT INTO tb_groups (name) VALUES ('$data')";
            $query = $this->db->query($sql);
            if ($query) {
                return [
                    'status' => 'success',
                    'message' => 'Group ditambahkan'
                ];
            }
        }
    }

    public function groupById($id)
    {
        $sql = "
            SELECT * FROM tb_groups
            WHERE id = {$id}
        ";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return [
                'status' => 'success',
                'data' => $query->result_array()
            ];
        } else {
            return [
                'status' => 'failed'
            ];
        }
    }

    public function edit($data)
    {
        $id = $data['id'];
        $name = $data['name'];

        $sql = "
            UPDATE tb_groups
            SET name = '{$name}'
            WHERE id = '{$id}'
        ";

        $query = $this->db->query($sql);

        if ($query) {
            return [
                'status' => 'success',
                'message' => 'Group berhasil diubah'
            ];
        }
    }

    public function delete($id)
    {
        $data = $this->membersCheck($id);
        if (!$data) {
            return [
                'status' => 'failed',
                'message' =>  'Group tidak dapat ditemukan!'
            ];
        } else {
            $sql = "DELETE FROM tb_groups WHERE id = '$id'";
            $query = $this->db->query($sql);
            if ($query) {
                return [
                    'status' => 'success',
                    'message' =>  'Group berhasil dihapus'
                ];
            }
        }
    }

    protected function membersCheck($id)
    {
        $sql = "SELECT members FROM tb_groups WHERE id = '$id'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->row();
        }
    }
}
