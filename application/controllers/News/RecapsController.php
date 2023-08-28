<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RecapsController extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('news/RecapsModel');
    }

    public function index()
    {
        $this->title = 'Rekap Laporan';
        $this->data['customJs'] = [
            'assets/customJs/news/news_recap/main.js',
        ];
        $this->render('index', 'news/news_recap');
    }

    public function table()
    {
        header('Content-Type:application/json');
        $pagination = $this->input->get();
        $result =  $this->RecapsModel->table($pagination);
        echo json_encode($result);
    }
}
