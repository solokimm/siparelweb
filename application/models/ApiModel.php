<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ApiModel extends CI_Model
{
    public function authLogin($data)
    {
        $email = $data['email'];
        $password = md5($data['password']);

        try {
            $sql = "
                SELECT 
                    V.id, 
                    V.name, 
                    V.email, 
                    V.username, 
                    V.group_id,
                    V.phone,
                    S.nama_satker AS group_name
                FROM tb_volunteers V
                LEFT JOIN satker_bnn S ON S.id = V.group_id
                WHERE V.email = '$email' AND V.password = '$password'
            ";
            if ($query = $this->db->query($sql)) {
                if ($query->num_rows() === 1) {
                    $user_data = $query->row_array();
                    $this->db->update('tb_volunteers', ['last_login' => date("Y-m-d H:i:s")], ['id' => $user_data['id']]);
                    $response = [
                        "metadata" => [
                            "code" => 200,
                            "message" => "Login Berhasil"
                        ],
                        "response" => $user_data
                    ];
                } else {
                    $response = [
                        "metadata" => [
                            "code" => 401,
                            "message" => "Email atau password tidak terdaftar"
                        ],
                    ];
                }
            } else {
                throw new Exception("Database Query Failed");
            }
        } catch (Exception $e) {
            $response = [
                "metadata" => [
                    "code" => 500,
                    "message" => "Internal Server Error"
                ],
            ];
        }

        return $response;
    }

    public function all_reports()
    {
        try {
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
                WHERE N.status = 'published'
            ";
            $query = $this->db->query($sql);
            if (!$query) {
                $response = [
                    "metadata" => [
                        "code" => 500,
                        "message" => "Internal Server Error"
                    ],
                ];
            } else {
                $response = [
                    "metadata" => [
                        "code" => 200,
                        "message" => "Success"
                    ],
                    "response" => $query->result_array()
                ];
            }
        } catch (Exception $e) {
            $response = [
                "metadata" => [
                    "code" => 500,
                    "message" => "Internal Server Error"
                ],
            ];
        }

        return $response;
    }

    public function report_details($id)
    {
        try {
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
                    N.group_id, 
                    G.name AS group_name,
                    N.upload_timestamp, 
                    N.status, 
                    N.participants, 
                    N.published_by,
                    U.name AS publisher_name
                FROM tb_news N
                LEFT JOIN tb_groups G ON G.id = N.group_id
                LEFT JOIN tb_users U ON U.id = N.published_by
                WHERE N.status = 'published' AND N.id  = $id 
            ";
            $query = $this->db->query($sql);
            if (!$query) {
                $response = [
                    "metadata" => [
                        "code" => 500,
                        "message" => "Internal Server Error"
                    ],
                ];
            } else {
                $response = [
                    "metadata" => [
                        "code" => 200,
                        "message" => "Success"
                    ],
                    "response" => $query->result_array()
                ];
            }
        } catch (Exception $e) {
            $response = [
                "metadata" => [
                    "code" => 500,
                    "message" => "Internal Server Error"
                ],
            ];
        }

        return $response;
    }

    public function all_notification()
    {
        try {
            $sql = "
                SELECT 
                    N.id, 
                    N.news_id, 
                    N.user_id, 
                    V.name as uploader_name,
                    N.upload_time
                FROM tb_news_log N
                LEFT JOIN tb_volunteers V ON V.id = N.user_id
            ";
            $query = $this->db->query($sql);
            if (!$query) {
                $response = [
                    "metadata" => [
                        "code" => 500,
                        "message" => "Internal Server Error"
                    ],
                ];
            } else {
                $response = [
                    "metadata" => [
                        "code" => 200,
                        "message" => "Success"
                    ],
                    "response" => $query->result_array()
                ];
            }
        } catch (Exception $e) {
            $response = [
                "metadata" => [
                    "code" => 500,
                    "message" => "Internal Server Error"
                ],
            ];
        }

        return $response;
    }

    public function gallery($user_id)
    {
        try {
            $sql = "
                SELECT
                    N.id,
                    N.image
                FROM tb_news N
                WHERE N.uploaded_by = $user_id
            ";
            $query = $this->db->query($sql);

            // var_dump($query->result());
            $datas = $query->result();
            foreach ($datas as $key => $row) {
                $datas[$key]->image = json_decode($datas[$key]->image);
            }
            return $datas;

            if (!$query) {
                $response = [
                    "metadata" => [
                        "code" => 500,
                        "message" => "Internal Server Error"
                    ],
                ];
            } else {

                $result = [];
                if ($query->num_rows() > 0) {
                    $image = [];
                    $result = $query->result();
                    foreach ($result as $row) {
                        $images[] = $row->image;
                    }

                    $result_array = array();

                    foreach ($images as $image) {
                        $image_array = array_map('trim', explode(',', $image));
                        $result_array[] = $image_array;
                    }

                    foreach ($result_array as $key => $urls) {
                        $result["image[$key]"] = $urls;
                    }
                }

                $response = [
                    "metadata" => [
                        "code" => 200,
                        "message" => "Success"
                    ],
                    "response" => $result
                ];
            }
        } catch (Exception $e) {
            $response = [
                "metadata" => [
                    "code" => 500,
                    "message" => "Internal Server Error"
                ],
            ];
        }

        return $response;
    }

    public function activation($user_id, $data)
    {
        try {
            /* begin:: NIK Validation */
            $curr_nik = $this->db->select('nik')->get_where('tb_volunteers', ['id' => $user_id])->row_array();
            if ($curr_nik['nik'] === $data['nik']) {
                $data['status'] = "active";
                $data['last_login'] = date("Y-m-d H:i:s");

                $query = $this->db->update('tb_volunteers', $data, ['id' => $user_id]);
                if (!$query) {
                    $response = [
                        "metadata" => [
                            "code" => 500,
                            "message" => "Internal Server Error"
                        ],
                    ];
                } else {
                    $response = [
                        "metadata" => [
                            "code" => 200,
                            "message" => "Success"
                        ],
                        "response" => [
                            "status" => "complete",
                            "message" => "Data berhasil disimpan"
                        ]
                    ];
                }
            } else {
                $response = [
                    "metadata" => [
                        "code" => 401,
                        "message" => "NIK tidak sama dengan yang terdaftar di sistem kami!"
                    ],
                ];
            }
            /* end:: NIK Validation */
        } catch (Exception $e) {
            $response = [
                "metadata" => [
                    "code" => 500,
                    "message" => "Internal Server Error"
                ],
            ];
        }

        return $response;
    }

    public function add_report($data)
    {
        try {
            $query = $this->db->insert('tb_news', $data);
            if (!$query) {
                $response = [
                    "metadata" => [
                        "code" => 500,
                        "message" => "Internal Server Error"
                    ],
                ];
            } else {
                $response = [
                    "metadata" => [
                        "code" => 200,
                        "message" => "Success"
                    ],
                    "response" => [
                        "status" => "complete",
                        "message" => "Data berhasil disimpan"
                    ]
                ];
            }
        } catch (Exception $e) {
            $response = [
                "metadata" => [
                    "code" => 500,
                    "message" => "Internal Server Error"
                ],
            ];
        }

        return $response;
    }

    public function user_profile($id)
    {
        try {
            $sql = "
                SELECT 
                    id, 
                    name, 
                    nik, 
                    gender, 
                    address, 
                    place_ofbirth, 
                    date_ofbirth, 
                    phone, 
                    email, 
                    username
                FROM public.tb_volunteers
                WHERE id = $id
            ";
            $query = $this->db->query($sql);
            if (!$query) {
                $response = [
                    "metadata" => [
                        "code" => 500,
                        "message" => "Internal Server Error"
                    ],
                ];
            } else {
                $response = [
                    "metadata" => [
                        "code" => 200,
                        "message" => "Success"
                    ],
                    "response" => $query->result_array()
                ];
            }
        } catch (Exception $e) {
            $response = [
                "metadata" => [
                    "code" => 500,
                    "message" => "Internal Server Error"
                ],
            ];
        }

        return $response;
    }

    public function edit_profile($id, $data)
    {
        try {
            $query = $this->db->update('tb_volunteers', $data, ['id' => $id]);
            if (!$query) {
                $response = [
                    "metadata" => [
                        "code" => 500,
                        "message" => "Internal Server Error"
                    ],
                ];
            } else {
                $response = [
                    "metadata" => [
                        "code" => 200,
                        "message" => "Success"
                    ],
                    "response" => [
                        "status" => "complete",
                        "message" => "Data berhasil disimpan"
                    ]
                ];
            }
        } catch (Exception $e) {
            $response = [
                "metadata" => [
                    "code" => 500,
                    "message" => "Internal Server Error"
                ],
            ];
        }

        return $response;
    }

    public function change_password($user_id, $data)
    {
        try {
            /* begin:: check password */
            $curr_pass = $this->db->select('password')->get_where('tb_volunteers', ['id' => $user_id])->row_array();
            if ($curr_pass['password'] === $data['currPassword']) {
                if ($data['newPassword'] === $data['confirmPassword']) {
                    $query = $this->db->update('tb_volunteers', ['password' => $data['newPassword']], ['id' => $user_id]);
                    if (!$query) {
                        $response = [
                            "metadata" => [
                                "code" => 500,
                                "message" => "Internal Server Error"
                            ],
                        ];
                    } else {
                        $response = [
                            "metadata" => [
                                "code" => 200,
                                "message" => "Success"
                            ],
                            "response" => [
                                "status" => "complete",
                                "message" => "Kata sandi berhasil diubah"
                            ]
                        ];
                    }
                } else {
                    $response = [
                        "metadata" => [
                            "code" => 401,
                            "message" => "Harap konfirmasi kata sandi dengan benar"
                        ],
                    ];
                }
            } else {
                $response = [
                    "metadata" => [
                        "code" => 401,
                        "message" => "Kata sandi salah, harap masukan kata sandi sebelum nya dengan benar"
                    ],
                ];
            }
            /* end:: check password */
        } catch (Exception $e) {
            $response = [
                "metadata" => [
                    "code" => 500,
                    "message" => "Internal Server Error"
                ],
            ];
        }

        return $response;
    }

    public function province_list()
    {
        try {
            $sql = "
                SELECT 
                    code AS id, 
                    name AS text
                    FROM tb_regencies
                    WHERE code LIKE '__'
                ORDER BY name ASC
            ";
            $query = $this->db->query($sql);
            if (!$query) {
                $response = [
                    "metadata" => [
                        "code" => 500,
                        "message" => "Internal Server Error"
                    ],
                ];
            } else {
                $response = [
                    "metadata" => [
                        "code" => 200,
                        "message" => "Success"
                    ],
                    "response" => $query->result_array()
                ];
            }
        } catch (Exception $e) {
            $response = [
                "metadata" => [
                    "code" => 500,
                    "message" => "Internal Server Error"
                ],
            ];
        }

        return $response;
    }

    public function city_list($province)
    {
        try {
            $sql = "
                SELECT 
                    code AS id, 
                    name AS text
                    FROM tb_regencies
                    WHERE code LIKE '$province.__'
                ORDER BY name ASC
            ";
            $query = $this->db->query($sql);
            if (!$query) {
                $response = [
                    "metadata" => [
                        "code" => 500,
                        "message" => "Internal Server Error"
                    ],
                ];
            } else {
                $response = [
                    "metadata" => [
                        "code" => 200,
                        "message" => "Success"
                    ],
                    "response" => $query->result_array()
                ];
            }
        } catch (Exception $e) {
            $response = [
                "metadata" => [
                    "code" => 500,
                    "message" => "Internal Server Error"
                ],
            ];
        }

        return $response;
    }
}
