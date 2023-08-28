<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RecapsModel extends CI_Model
{
    public function table($pagination)
    {
        $curr_page = intval($pagination['start']);
        $limit_page = intval($pagination['length']);

        $structure_order = ['V.name', 'N.title', 'G.name', 'N.participants'];
        foreach ($pagination['order'] as $key_order => $val_order) {
            $arr_order[] = $structure_order[$val_order['column']] . " " . strtoupper($val_order['dir']);
        }
        $fix_order = implode(',', $arr_order);

        $where = [];
        if ($pagination['search'] && $pagination['search']['value'] !== "") {
            $search = html_escape($pagination['search']['value']);
            $where[] = " N.title ILIKE '%$search%'";
        }

        $whereClause = (!empty($where)) ? "WHERE " . implode(" AND ", $where) : "";

        $sql = "
            SELECT
                N.*,
                G.name AS group_name,
                V.name AS volu_name
            FROM tb_news N
            LEFT JOIN tb_groups G ON G.id = N.group_id
            LEFT JOIN tb_volunteers V ON V.id = N.uploaded_by
            -- WHERE N.group_id = 2 AND N.status = 'published'
        " . $whereClause;

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
}
