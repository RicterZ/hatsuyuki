<?php

include_once(__DIR__ . '/../includes/base.model.php');
include_once(__DIR__ . '/UserModel.php');


class UserModel extends BaseModel {

    protected $collection = 'users';
    protected $fields = array('username', 'password', 'email', 'salt');

    public function create($data) {
        $data['salt'] = md5(rand(0, 390212));
        $data['password'] = md5($data['password'] . $data['salt']);
        parent::create($data);
    }

    public function update($data) {
        if (array_key_exists('password', $data)) {
            $data['password'] = md5($data['password'] . $this->object['salt']);
        }
        parent::update($data);
    }

    public function check_user($username, $password) {
        $user = $this->db->findOne(array('username' => $username));
        if ($user) {
            if ($user['password'] == md5($password . $user['salt'])) {
                $this->object = $user;
                return true;
            }
        }
        return false;
    }

    public function get_todo() {
        $todo_list = array();
        foreach ($this->db->find(array('owner' => new MongoId($this->object['_id']))) as $todo) {
            array_push($todo_list, new ToDoModel($todo));
        }
        return $todo_list;
    }
}
