<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GroupsController extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('configs/GroupsModel');
    }

    public function index()
    {
        $this->title = 'Pengaturan Grup';
        $this->data['customJs'] = [
            'assets/customJs/groups_management.js',
        ];
        $this->render('index', 'configs/groups');
    }

    public function table()
    {
        header('Content-Type:application/json');
        $pagination = $this->input->get();
        $result =  $this->GroupsModel->table($pagination);
        echo json_encode($result);
    }

    public function add()
    {
        header('Content-Type:application/json');
        $data = $this->input->post('groupName');
        $add = $this->GroupsModel->add($data);
        echo json_encode($add);
    }

    public function groupById()
    {
        header('Content-Type:application/json');
        $id = $this->input->post('id');
        //get groups by id
        $data = $this->GroupsModel->groupById($id);
        echo json_encode($data);
    }

    public function edit()
    {
        header('Content-Type:application/json');
        $data = [
            'id' => $this->input->post('id'),
            'name' => $this->input->post('groupName')
        ];
        $edit = $this->GroupsModel->edit($data);
        echo json_encode($edit);
    }

    public function delete()
    {
        header('Content-Type:application/json');
        $id = $this->input->post('id');
        $delete = $this->GroupsModel->delete($id);
        echo json_encode($delete);
    }
}
