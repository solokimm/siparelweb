<?php
defined('BASEPATH') or exit('No direct script access allowed');

class VolunteersModel extends CI_Model
{
    public function table($pagination)
    {
        $curr_page = intval($pagination['start']);
        $limit_page = intval($pagination['length']);

        $structure_order = ['V.name', 'V.username', 'S.nama_satker', 'V.status', 'V.last_login', 'V.id'];
        foreach ($pagination['order'] as $key_order => $val_order) {
            $arr_order[] = $structure_order[$val_order['column']] . " " . strtoupper($val_order['dir']);
        }
        $fix_order = implode(',', $arr_order);

        $where = [];
        if ($pagination['search'] && $pagination['search']['value'] !== "") {
            $search = html_escape($pagination['search']['value']);
            $where[] = " V.name ILIKE '%$search%' OR V.username ILIKE '%$search%' ";
        }

        if (!empty($pagination['status']) && $pagination['status'] != "all") {
            $where[] = " V.status = '" . $pagination['status'] . "'";
        }

        if (!empty($pagination['group']) && $pagination['group'] != "all") {
            $where[] = " V.group_id = " . $pagination['group'];
        }

        $whereClause = (!empty($where)) ? "WHERE " . implode(" AND ", $where) : "";


        $sql = '
            SELECT 
                V.id,
                V.name,
                V.username,
                S.nama_satker AS "group_name",
                V.status,
                V.last_login
            FROM tb_volunteers V
            LEFT JOIN satker_bnn S ON S.id = V.group_id
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

    public function insertVolu($data)
    {
        $data['password'] = md5($data['password']);
        $data['invited_by'] = $this->session->userdata('id_user');
        $data['status'] = 'nonactive';
        $checkEmail = $this->db->get_where('tb_volunteers', ['email' => $data['email']]);
        if ($checkEmail->num_rows() > 0) {
            return FALSE;
        } else {
            $query = $this->db->insert('tb_volunteers', $data);
            if ($query) {
                return TRUE;
            }
        }
    }

    public function voluById($id)
    {
        $sql = '
            SELECT 
                V.id, 
                V.name, 
                V.nik, 
                V.gender, 
                V.address, 
                V.province_code, 
                V.city_code, 
                V.place_ofbirth, 
                V.date_ofbirth, 
                V.phone, 
                V.email, 
                (
					SELECT COUNT(N.id) 
					FROM tb_news N
					WHERE N.uploaded_by = V.id
				) AS total_reports,
                V.username, 
                V.group_id, 
                S.nama_satker AS group_name,
                V.status, 
                V.last_login, 
                V.invited_by, 
                V.image
            FROM tb_volunteers V 
            LEFT JOIN satker_bnn S ON S.id = V.group_id
            WHERE V.id = ' . $id . ' 
        ';

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $results =  $query->result_array();
            return $results[0];
        }
    }

    public function edit($data, $id)
    {
        $query = $this->db->update('tb_volunteers', $data, ['id' => $id]);

        if ($query) {
            return [
                'status' => 'success',
                'message' => 'Relawan berhasil diubah'
            ];
        }
    }

    public function delete($id)
    {
        $sql = "DELETE FROM tb_volunteers WHERE id = '$id'";
        $query = $this->db->query($sql);
        if ($query) {
            return [
                'status' => 'success',
                'message' =>  'Relawan berhasil dihapus'
            ];
        }
    }

    public function select2_groups($term)
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

    public function select2_prov($term)
    {
        $search = "AND name ILIKE '%$term%'";
        $sql = "
            SELECT 
                code AS id, 
                name AS text
            FROM tb_regencies
            WHERE code LIKE '__'
            {$search}
            ORDER BY name ASC
        ";
        $results = $this->db->query($sql);

        return $results->result_array();
    }

    public function select2_city($prov, $term)
    {
        $search = "AND name ILIKE '%$term%'";
        $sql = "
            SELECT 
                code AS id, 
                name AS text
            FROM tb_regencies
            WHERE code LIKE '$prov.__'
            {$search}
            ORDER BY name ASC
        ";
        $results = $this->db->query($sql);

        return $results->result_array();
    }
}
