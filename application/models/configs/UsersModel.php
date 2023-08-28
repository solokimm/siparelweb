<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UsersModel extends CI_Model
{
    public function table($pagination)
    {
        $curr_page = intval($pagination['start']);
        $limit_page = intval($pagination['length']);

        $structure_order = ['U.name', 'S.nama_satker', 'U.role', 'U.status', 'U.last_login', 'U.id'];
        foreach ($pagination['order'] as $key_order => $val_order) {
            $arr_order[] = $structure_order[$val_order['column']] . " " . strtoupper($val_order['dir']);
        }
        $fix_order = implode(',', $arr_order);

        $where = [];
        if ($pagination['search'] && $pagination['search']['value'] !== "") {
            $search = html_escape($pagination['search']['value']);
            $where[] = " U.name ILIKE '%$search%' OR U.email ILIKE '%$search%' ";
        }

        if (!empty($pagination['role']) && $pagination['role'] != "all") {
            $where[] = " U.role = '" . $pagination['role'] . "'";
        }
        if (!empty($pagination['status']) && $pagination['status'] != "all") {
            $where[] = " U.status = '" . $pagination['status'] . "'";
        }

        $whereClause = (!empty($where)) ? "WHERE " . implode(" AND ", $where) : "";


        $sql = '
            SELECT 
                U.id,
                U.name,
                U.role, 
                U.satker_id,
                S.nama_satker AS satker_name,
                U.status,
                U.last_login
            FROM tb_users U
            LEFT JOIN satker_bnn S ON S.id = U.satker_id
            WHERE U.id != 0 AND U.id != ' . $this->session->userdata('id_user') . '
        ' . $whereClause;

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
        $data['password'] = md5($data['password']);
        $data['created_by'] = $this->session->userdata('id_user');
        $data['status'] = 'nonactive';
        $query = $this->db->insert('tb_users', $data);
        $inserted_id = $this->db->insert_id();

        if ($query) {
            return $inserted_id;
        }
    }

    public function userById($id)
    {
        $sql = '
            SELECT 
                U.id, 
                U.name, 
                U.role,
                U.nip,
                U.email, 
                U.phone, 
                U.gender, 
                U.address, 
                U.satker_id,
                S.nama_satker AS group_name, 
                (
					SELECT COUNT(V.id) 
					FROM tb_volunteers V
					WHERE V.invited_by = U.id
				) AS total_volunteers,
                U.image, 
                U.status
            FROM tb_users U
            LEFT JOIN satker_bnn S ON S.id = U.satker_id
            WHERE U.id = ' . $id . ' 
        ';

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $results =  $query->result_array();
            return $results[0];
        }
    }

    public function edit($data, $id)
    {
        $query = $this->db->update('tb_users', $data, ['id' => $id]);

        if ($query) {
            return [
                'status' => 'success',
                'message' => 'Pengguna berhasil diubah'
            ];
        }
    }

    public function delete($id)
    {
        $data = $this->userCheck($id);
        if (!$data) {
            return [
                'status' => 'failed',
                'message' =>  'Pengguna tidak dapat ditemukan!'
            ];
        } else {
            $sql = "DELETE FROM tb_users WHERE id = '$id'";
            $query = $this->db->query($sql);
            if ($query) {
                return [
                    'status' => 'success',
                    'message' =>  'Pengguna berhasil dihapus'
                ];
            }
        }
    }

    protected function userCheck($id)
    {
        $sql = "SELECT name FROM tb_users WHERE id = $id";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function select2_satker($term)
    {

        $where = "WHERE nama_satker ILIKE '%$term%'";
        $sql = "
            SELECT 
                id,
                nama_satker AS text
            FROM satker_bnn
            {$where}
        ";
        $results = $this->db->query($sql);
        return $results->result_array();
    }
}
