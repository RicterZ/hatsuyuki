<?php

require_once(__DIR__ . '/../hatsuyuki/includes/config.php');
include_once(__DIR__ . '/../hatsuyuki/includes/base.model.php');
include_once(__DIR__ . '/../hatsuyuki/models/UserModel.php');
include_once(__DIR__ . '/../hatsuyuki/models/ToDoModel.php');


class ToDoModelTest extends PHPUnit_Framework_TestCase {

    public function testInsertToDo() {
        $user = new UserModel();
        $user->create(array(
            'username' => 'ricter',
            'password' => '123qwe!@#',
            'email'    => 'ricterzheng@gmail.com'
        ));

        $todo = new ToDoModel();
        $todo->create(array(
            'title'  => 'Piapiapia with Cee',
            'detail' => 'I want to piapiapia with Cee.',
            'owner'  => $user->object['_id'],
            'status' => 0
        ));

        $this->assertEquals($todo->object['title'], 'Piapiapia with Cee');
        $this->assertEquals($todo->object['detail'], 'I want to piapiapia with Cee.');
        $this->assertEquals($todo->object['owner'], $user->object['_id']);
        $this->assertEquals($todo->object['status'], 0);

        return $user;
    }

    /**
     * @depends testInsertToDo
     */
    public function testGetToDo($user) {
        $todo = new ToDoModel();
        $todo_list = $todo->get_todo($user->object['_id']);
        $this->assertEquals(count($todo_list), 1);
        $this->assertEquals($todo_list[0]->object['title'], 'Piapiapia with Cee');
        return $todo_list[0];
    }

    /**
     * @depends testGetToDo
     */
    public function testInsertSubToDo($todo) {
        $sub_todo = new ToDoModel();
        $sub_todo->create(array(
            'title'  => 'Kiss first',
            'detail' => '',
            'status' => 0,
            'parent' => $todo->object['_id']
        ));
        $this->assertEquals($sub_todo->object['parent'], $todo->object['_id']);

        return $todo;
    }

    /**
     * @depends testInsertSubToDo
     */
    public function testGetSubToDo($todo) {
        $sub_todo = $todo->get_sub_todo();
        $this->assertEquals(count($sub_todo), 1);

        $sub_todo = $sub_todo[0];

        $nothing = $sub_todo->get_sub_todo();
        $this->assertEquals(count($nothing), 0);

        $sub_todo->delete();
        return $todo;
    }

    /**
     * @depends testInsertSubToDo
     */
    public function testUpdateToDo($todo) {
        $todo->update(array(
            'status' => 2
        ));
        $this->assertEquals($todo->object['status'], 2);

        return $todo;
    }

    /**
     * @depends testUpdateToDo
     */
    public function testDeleteToDo($todo) {
        $user = new UserModel(array('_id' => $todo->object['owner']));
        $user->delete();

        $todo->delete();
        $this->assertEquals($todo->object, NULL);
    }

} 