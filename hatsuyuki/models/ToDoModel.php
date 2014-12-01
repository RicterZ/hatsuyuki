<?php


class ToDoModel extends BaseModel {

    protected $collection = 'todo';
    protected $fields = array('title', 'detail', 'created_time', 'owner', 'status', 'parent');
    public $status = array(
        0 => 'Undo',
        1 => 'Doing',
        2 => 'Finished',
        3 => 'Disabled',
    );

    public function create($data) {
        $data['created_time'] = date('Y/m/d G:i');
        if (!$data['status'] == NULL) {
            if ($data['status'] > 2 || $data['status'] < 0) {
                $data['status'] = 0;
            }
        } else {
            $data['status'] = 0;
        }
        if (!array_key_exists('parent', $data)) {
            $data['parent'] = NULL;
        } else {
            $todo = new ToDoModel(array('_id' => new MongoId($data['parent'])));
            $data['owner'] = $todo->object['owner'];
        }
        parent::create($data);
    }

    public function get_sub_todo() {
        $todo_list = array();
        foreach ($this->db->find(array('parent' => $this->object['_id'])) as $todo) {
            array_push($todo_list, new ToDoModel($todo));
        }
        return $todo_list;
    }

    public function get_todo($id) {
        $todo_list = array();
        foreach ($this->db->find(array('owner' => new MongoId($id))) as $todo) {
            array_push($todo_list, new ToDoModel($todo));
        }
        return $todo_list;
    }

}