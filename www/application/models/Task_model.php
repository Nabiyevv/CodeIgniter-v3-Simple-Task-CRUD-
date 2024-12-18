<?php


class Task_model extends CI_Model
{

    public $name;
    public $image;
    public $description;
    public $deadline;

    public function get_count() {
        return $this->db->count_all('tasks');
    }

    public function getTasks()
    {
        $query = $this->db->get('tasks');

        return $query->result();
    }
    // public function getTasks($limit, $offset)
    // {
    //     $this->db->limit($limit, $offset);

    //     $query = $this->db->get('tasks');

    //     return $query->result();
    // }

    public function getTask($id)
    {
        $query = $this->db->get_where('tasks', array('id' => $id));
        return $query->row();
    }

    public function createTask($data)
    {
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->deadline = $data['deadline'];
        if(isset($data['image'])) {
            $this->image = $data['image'];
        }

        $this->db->insert('tasks', $this);
    }


    public function updateTask($id, $data)
    {
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->deadline = $data['deadline'];
        
        if(isset($data['image'])) {
            $this->image = $data['image'];
        }

        $this->db->update('tasks', $this, array('id' => $id));
    }

    public function deleteTask($id)
    {
        $this->db->delete('tasks', array('id' => $id));
    }

    public function searchTask($keyword)
    {
        $this->db->like('name', $keyword)
            ->or_like('deadline', $keyword);
            
        $query = $this->db->get('tasks');

        return $query->result();
    }



}