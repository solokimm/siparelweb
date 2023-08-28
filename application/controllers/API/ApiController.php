<?php

defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class ApiController extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ApiModel');
    }

    public function login_post()
    {
        header('Content-Type:application/json');
        $data = [
            "email" => $this->post('email'),
            "password" => $this->post('password')
        ];
        $auth = $this->ApiModel->authLogin($data);
        return $this->response($auth, 200);
    }

    public function all_reports_get()
    {
        header('Content-Type:application/json');
        $data = $this->ApiModel->all_reports();
        return $this->response($data, 200);
    }

    public function report_details_get()
    {
        header('Content-Type:application/json');
        $id = $this->input->get('id');
        $data = $this->ApiModel->report_details($id);
        return $this->response($data, 200);
    }

    public function notification_get()
    {
        header('Content-Type:application/json');
        $data = $this->ApiModel->all_notification();
        return $this->response($data, 200);
    }

    public function gallery_post()
    {
        header('Content-Type:application/json');
        $id = $this->input->post('user_id');
        $data = $this->ApiModel->gallery($id);
        return $this->response($data, 200);
    }

    public function activation_post()
    {
        header('Content-Type:application/json');
        $id = $this->input->post('user_id');
        $form_data = [
            "nik" => $this->input->post('nik'),
            "gender" => $this->input->post('gender'),
            "place_ofbirth" => $this->input->post('place_ofBirth'),
            "date_ofbirth" => $this->input->post('date_ofBirth'),
        ];
        $activation = $this->ApiModel->activation($id, $form_data);
        return $this->response($activation, 200);
    }

    /*  public function add_report_post()
    {
        header('Content-Type:application/json');
        $data = [
            "location_name" => $this->input->post('location_name'),
            "location_lat" => $this->input->post('location_lat'),
            "location_lng" => $this->input->post("location_lng"),
            "title" => $this->input->post("title"),
            "content" => $this->input->post("content"),
            "uploaded_by" => $this->input->post("user_id"),
            "group_id" => $this->input->post("user_group"),
            "upload_timestamp" => date("Y-m-d H:i:s"),
            "participants" => $this->input->post("participants")
        ];

        $upload_path = 'assets/news/' . date("Ymd") . '/' . rand(1000, 9999);
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'jpg|png';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
        if ($_FILES['images']['name']) {
            foreach ($_FILES['images']['name'] as $key => $image_name) {
                $_FILES['userfile']['name'] = $_FILES['images']['name'][$key];
                $_FILES['userfile']['type'] = $_FILES['images']['type'][$key];
                $_FILES['userfile']['tmp_name'] = $_FILES['images']['tmp_name'][$key];
                $_FILES['userfile']['error'] = $_FILES['images']['error'][$key];
                $_FILES['userfile']['size'] = $_FILES['images']['size'][$key];

                if ($this->upload->do_upload('userfile')) {
                    $data_image = $this->upload->data();
                    $file_names[] = base_url($upload_path) . '/' . $data_image['file_name'];
                }
            }
        }
        $images = implode(', ', $file_names);
        $data['image_url'] = $images;
        $add = $this->ApiModel->add_report($data);
        return $this->response($add, 200);
    } */
    // edited
    public function add_reports_post()
    {
        header('Content-Type:application/json');
        $data = [
            "location_name" => $this->post('location_name'),
            "location_lat" => $this->post('location_lat'),
            "location_lng" => $this->post("location_lng"),
            "title" => $this->post("title"),
            "content" => $this->post("content"),
            "uploaded_by" => $this->post("user_id"),
            "group_id" => $this->post("user_group"),
            "upload_timestamp" => date("Y-m-d H:i:s"),
            "participants" => $this->post("participants"),
            "image" => json_encode($this->post("image"))
        ];
        $add = $this->ApiModel->add_report($data);
        return $this->response($add, 200);
    }

    public function user_profile_post()
    {
        header('Content-Type:application/json');
        $id = $this->input->post('user_id');
        $data = $this->ApiModel->user_profile($id);
        return $this->response($data, 200);
    }

    public function edit_profile_post()
    {
        header('Content-Type:application/json');
        $id = $this->post('user_id');
        $data = [
            "name" => $this->post("name"),
            "gender" => $this->post("gender"),
            "place_ofbirth" => $this->post("place_ofbirth"),
            "date_ofbirth" => $this->post("date_ofbirth"),
            "address" => $this->post("address"),
            "phone" => $this->post("phone"),
            "province_code" => $this->post("province_code"),
            "city_code" => $this->post("city_code")
        ];
        $edit = $this->ApiModel->edit_profile($id, $data);
        return $this->response($edit, 200);
    }

    public function change_password_post()
    {
        header('Content-Type:application/json');
        $id = $this->input->post('user_id');
        $data = [
            "currPassword" => md5($this->input->post("currPassword")),
            "newPassword" => md5($this->input->post("newPassword")),
            "confirmPassword" => md5($this->input->post("confirmPassword"))
        ];
        $changePass = $this->ApiModel->change_password($id, $data);
        return $this->response($changePass, 200);
    }

    public function change_image_post()
    {
        header('Content-Type: application/json');

        $id = $this->post('user_id');
        $image = json_encode($this->post("image"));
        $update_image = $this->db->update('tb_volunteers', ['image' => $image], ['id' => $id]);
        /* if ($_FILES['image']['name']) {
            $upload_path = './assets/volunteers/' . $id . '/avatars/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|png';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $data = $this->upload->data();
                $image_path = base_url('assets/volunteers/' . $id . '/avatars/') . $data['file_name'];
                $update_image = $this->db->update('tb_volunteers', ['image' => $image_path], ['id' => $id]);
                if ($update_image) {
                    $response = [
                        "metadata" => [
                            "code" => 200,
                            "message" => "Success"
                        ],
                        "response" => [
                            "status" => "complete",
                            "message" => "Foto profil berhasil diubah"
                        ]
                    ];
                } else {
                    $response = [
                        "metadata" => [
                            "code" => 500,
                            "message" => "Internal server error"
                        ],
                    ];
                }
            } else {
                $response = [
                    "metadata" => [
                        "code" => 500,
                        "message" => "Internal server error"
                    ],
                    "response" => [
                        "status" => "error",
                        "message" => $this->upload->display_errors()
                    ]
                ];
            }
        } else {
            $response = [
                "metadata" => [
                    "code" => 500,
                    "message" => "Internal server error"
                ],
            ];
        } */
        $this->response($update_image, 200);
    }

    public function province_list_post()
    {
        header('Content-Type: application/json');
        $province = $this->ApiModel->province_list();
        return $this->response($province, 200);
    }

    public function city_list_post()
    {
        header('Content-Type: application/json');
        $province = $this->post('province_code');
        $city_list = $this->ApiModel->city_list($province);
        return $this->response($city_list, 200);
    }
}
