<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SearchAreaController extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('news/SearchAreaModel');
    }

    public function index()
    {
        $this->title = 'Cari Area';
        $this->data['customJs'] = [
            'assets/customJs/news/search_area/main.js',
        ];
        $this->render('index', 'news/search_area');
    }

    public function getNewsData()
    {
        header('Content-Type:application/json');
        $data = $this->SearchAreaModel->getNewsData();
        echo json_encode($data);
    }
}
