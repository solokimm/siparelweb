<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SearchAreaModel extends CI_Model
{
    public function getNewsData()
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
                V.name AS volu_name,
                V.image AS volu_picture,
                N.group_id, 
                G.name AS group_name,
                N.upload_timestamp, 
                N.status, 
                N.participants, 
                N.published_by,
                U.name AS publisher_name
            FROM tb_news N
            LEFT JOIN tb_volunteers V on V.id = N.uploaded_by
            LEFT JOIN tb_groups G ON G.id = N.group_id
            LEFT JOIN tb_users U ON U.id = N.published_by
        ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
