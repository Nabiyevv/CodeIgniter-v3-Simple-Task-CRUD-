<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Task_model'); 
        $this->load->library('session');
    }

	public function index() {

        $this->load->helper('pagination');

        // $pagination = setup_pagination(
        //     base_url('items/index'), 
        //     $this->Task_model->get_count(), // Total records
        //     3 // Per page
        // );


        // $result = $this->Task_model->getTasks(5, $pagination['offset']); 
        $result = $this->Task_model->getTasks(); 

        $this->load->view('task_list',[
            'tasks' => $result,
            // 'paginationLinks' => $pagination['links']
        ]);
    }

    public function create() {
        $this->load->view('create_task'); // Load the create TODO view
    }

    public function store() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('deadline', 'Deadline', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('create_task');
            return;
        }

        $data = $this->input->post(); 

        if(isset($_FILES['image'])) {
            $imageData = $this->uploadImage();
            if(isset($imageData['error'])) {
                $this->session->set_flashdata('error', $imageData['error']);
                redirect('create');
            }
            $imageName = $imageData['upload_data']['file_name'];
            $data['image'] = $imageName;
        }


        $this->Task_model->createTask($data);

        $this->session->set_flashdata('success', 'Task created successfully');

        redirect('home');
    }

    public function edit(int $id)
    {
        $task = $this->Task_model->getTask($id);
        $this->load->view('edit_task', ['task' => $task]);
    }



    public function update($id) {

        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            redirect('home');
        }

        $task = $this->Task_model->getTask($id);

        $taskImage = $task->image;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('deadline', 'Deadline', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('edit_task');
            return;
        }

        $data = $this->input->post();

        if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
            $imageData = $this->uploadImage();
            if(isset($imageData['error'])) {
                $this->session->set_flashdata('error', $imageData['error']);
                redirect('edit/'.$id);
            }
            $imageName = $imageData['upload_data']['file_name'];
            $data['image'] = $imageName;
            
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                if (file_exists('./uploads/images/' . $taskImage)) {
                    unlink('./uploads/images/' . $taskImage);
                }
            }
    
        }
        else
        {
            
            $data['image'] = $task->image;
        }

        $this->Task_model->updateTask($id, $data); 

        $this->session->set_flashdata('success', 'Task updated successfully');

        redirect('home');
    }

    public function delete($id) {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            redirect('home');
        }

        $this->Task_model->deleteTask($id);

        $this->session->set_flashdata('success', 'Task deleted successfully');
    }

    
    public function search() {
        header('Content-Type: application/json');

        $search = $this->input->post('search',TRUE);

        $result = $this->Task_model->searchTask($search);

        echo json_encode($result);
    }


    private function uploadImage()
    {
        $config['upload_path'] = "./uploads/images";
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 100;
        $config['max_width'] = 2024;
        $config['max_height'] = 1068;
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload('image')) {
            $error = array('error' => $this->upload->display_errors());

            return $error;
        } else {

            $data = array('upload_data' => $this->upload->data());

            return $data;
        }
    }



}
