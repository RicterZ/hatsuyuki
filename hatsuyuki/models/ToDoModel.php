<?php

include_once(__DIR__ . '/../includes/mongo.php');


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
        if (!array_key_exists('parent', $data)) {
            $data['parent'] = NULL;
        } else {
            $todo = new ToDoModel(array('_id' => new MongoId($data['parent'])));
            $data['owner'] = $todo->object['owner'];
        }
        parent::create($data);
    }

    public function get_sub_todo() {
        $sub_todo_list = array();
        $sub_todo = $this->db->find(array('parent' => $this->object['_id']));
        foreach ($sub_todo as $todo) {
            array_push($sub_todo_list, new ToDoModel($todo));
        }
        return $sub_todo_list;
    }
}