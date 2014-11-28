<?php

require_once(__DIR__ . '/../hatsuyuki/includes/config.php');
include_once(__DIR__ . '/../hatsuyuki/includes/base.model.php');
include_once(__DIR__ . '/../hatsuyuki/models/UserModel.php');
include_once(__DIR__ . '/../hatsuyuki/models/ToDoModel.php');


class UserModelTest extends PHPUnit_Framework_TestCase {

    public function testInsertUser() {
        $user = new UserModel();
        $user->create(array(
            'username' => 'ricter',
            'password' => '123456',
            'email'    => 'ricterzheng@gmail.com'
        ));
        $this->assertEquals($user->object['username'], 'ricter');
        $this->assertEquals($user->object['password'], md5('123456' . $user->object['salt']));
        $this->assertEquals($user->object['email'], 'ricterzheng@gmail.com');

        return $user;
    }

    /**
     * @depends testInsertUser
     */
    public function testGetUser($user) {
        $user->get(array('_id' => new MongoId($user->object['_id'])));
        $this->assertEquals($user->object['username'], 'ricter');
        $this->assertEquals($user->object['password'], md5('123456' . $user->object['salt']));
        $this->assertEquals($user->object['email'], 'ricterzheng@gmail.com');

        return $user;
    }

    /**
     * @depends testGetUser
     */
    public function testUpdateUser($user) {
        $user->update(array(
            'username' => 'cee',
            '_id'      => '546ec9d241585e6c910041a1',
            'password' => 'cee_is_j0j0'
        ));
        $this->assertEquals($user->object['username'], 'cee');
        $this->assertEquals($user->object['password'], md5('cee_is_j0j0' . $user->object['salt']));
        $this->assertNotEquals($user->object['_id'], '546ec9d241585e6c910041a1');

        return $user;
    }

    /**
     * @depends testUpdateUser
     */
    public function testCheckUser() {
        $user = new UserModel();
        $this->assertEquals($user->check_user('cee', 'cee_is_not_j0j0'), false);
        $this->assertEquals($user->check_user('cee', 'cee_is_j0j0'), true);

        return $user;
    }

     /**
     * @depends testCheckUser
     */
    public function testRemoveUser($user) {
        $user->delete();
        $this->assertEquals($user->object, NULL);
    }

}
