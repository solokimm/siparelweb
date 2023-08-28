<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ReportsModel extends CI_Model
{
    public function table($pagination)
    {
        $curr_page = intval($pagination['start']);
        $limit_page = intval($pagination['length']);

        $structure_order = ['N.upload_timestamp', 'N.title', 'V.name', 'N.status', 'V.id'];
        foreach ($pagination['order'] as $key_order => $val_order) {
            $arr_order[] = $structure_order[$val_order['column']] . " " . strtoupper($val_order['dir']);
        }
        $fix_order = implode(',', $arr_order);

        $where = [];
        if ($pagination['search'] && $pagination['search']['value'] !== "") {
            $search = html_escape($pagination['search']['value']);
            $where[] = " N.title ILIKE '%$search%'";
        }

        $whereClause = (!empty($where)) ? "AND " . implode(" AND ", $where) : "";

        $sql = "
           SELECT
                N.*,
                N.status AS news_status,
                N.group_id,
                S.nama_satker AS group_name,
                V.name AS volu_name
            FROM tb_news N
            LEFT JOIN satker_bnn S ON S.id = N.group_id
            LEFT JOIN tb_volunteers V ON V.id = N.uploaded_by
            -- WHERE N.group_id = 2 
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

    public function report_details($id)
    {
        $sql = "
            SELECT 
                N.id, 
                N.location_name, 
                N.location_lat, 
                N.location_lng, 
                N.title, 
                N.content, 
                N.image, 
                N.uploaded_by,
                V.name AS volunteer_name,
                N.group_id, 
                G.name AS group_name,
                N.upload_timestamp, 
                N.status, 
                N.participants, 
                N.published_by,
                U.name AS publisher_name
            FROM tb_news N
            LEFT JOIN tb_groups G ON G.id = N.group_id
            LEFT JOIN tb_volunteers V ON V.id = N.uploaded_by
            LEFT JOIN tb_users U ON U.id = N.published_by
            WHERE N.id  = $id 
        ";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function updateStatus($id)
    {
        try {
            if ($id) {
                $data = [
                    "published_by" => $this->session->userdata('id_user'),
                    "status" => "published"
                ];
                $query = $this->db->update('tb_news', $data, ['id' => $id]);
                if ($query) {
                    $response = [
                        "status" => "success",
                        "message" => "Dipublikasikan!"
                    ];
                } else {
                    $response = [
                        "status" => "failed",
                        "message" => "Proses publikasi gagal!"
                    ];
                }
            } else {
                $response = [
                    "status" => "error",
                    "message" => "ID tidak ditemukan!"
                ];
            }
        } catch (Exception $e) {
            $response = [
                "status" => "error",
                "message" => "Internal Server Error!"
            ];
        }
        return $response;
    }

    public function deleteReport($id)
    {
        try {
            if ($id) {
                $query = $this->db->delete('tb_news', ['id' => $id]);
                if ($query) {
                    $response = [
                        "status" => "success",
                        "message" => "Laporan berhasil dihapus!"
                    ];
                } else {
                    $response = [
                        "status" => "failed",
                        "message" => "Gagal menghapus laporan!"
                    ];
                }
            } else {
                $response = [
                    "status" => "error",
                    "message" => "ID tidak ditemukan!"
                ];
            }
        } catch (Exception $e) {
            $response = [
                "status" => "error",
                "message" => "Internal Server Error!"
            ];
        }
        return $response;
    }

    public function updateReport($id, $data)
    {
        try {
            if ($id) {
                $query = $this->db->update('tb_news', $data, ['id' => $id]);
                if ($query) {
                    $response = [
                        "status" => "success",
                        "message" => "Laporan berhasil diubah!"
                    ];
                } else {
                    $response = [
                        "status" => "failed",
                        "message" => "Gagal mengubah laporan!"
                    ];
                }
            } else {
                $response = [
                    "status" => "error",
                    "message" => "ID tidak ditemukan!"
                ];
            }
        } catch (Exception $e) {
            $response = [
                "status" => "error",
                "message" => "Internal Server Error!"
            ];
        }
        return $response;
    }
}
