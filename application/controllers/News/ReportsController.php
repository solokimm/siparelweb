<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ReportsController extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('news/ReportsModel');
    }

    public function index()
    {
        $this->title = 'Laporan Relawan';
        $this->data['customJs'] = [
            'assets/customJs/news/reports/main.js',
        ];
        $this->render('index', 'news/reports');
    }

    public function table()
    {
        header('Content-Type:application/json');
        $pagination = $this->input->get();
        $result =  $this->ReportsModel->table($pagination);
        echo json_encode($result);
    }

    public function details($id)
    {
        $this->title = 'Detail Laporan';
        $this->data['customJs'] = [
            'assets/customJs/news/reports/details.js',
        ];
        $this->data['details'] = $this->ReportsModel->report_details($id);
        $this->render('details', 'news/reports');
    }

    public function reportAction($method)
    {
        header('Content-Type:application/json');
        $news_id = $this->input->post('id');
        switch ($method) {
            case 'publish':
                $publish = $this->ReportsModel->updateStatus($news_id);
                echo json_encode($publish);
                break;

            case 'edit':
                $data = [
                    "title" => $this->input->post('title'),
                    "content" => $this->input->post('content')
                ];
                $edit = $this->ReportsModel->updateReport($news_id, $data);
                echo json_encode($edit);
                break;

            case 'delete':
                $delete = $this->ReportsModel->deleteReport($news_id);
                echo json_encode($delete);
                break;

            default:
                echo json_encode(["status" => "error", "message" => "Request tidak dikenal"]);
                break;
        }
    }
}
