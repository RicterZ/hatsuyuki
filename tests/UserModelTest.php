<?php

include_once(__DIR__ . '/../hatsuyuki/models/UserModel.php');


class UserModelTest extends PHPUnit_Framework_TestCase {

    public function testInsertUser() {
        $user = new UserModel();
        $user->create(array(
            'username'=>'ricter',
            'password'=>'123456',
            'email'=>'ricterzheng@gmail.com'
        ));
        $this->assertEquals($user->object['username'], 'ricter');
        $this->assertEquals($user->object['password'], '123456');
        $this->assertEquals($user->object['email'], 'ricterzheng@gmail.com');

        return $user;
    }

    /**
     * @depends testInsertUser
     */
    public function testGetUser($user) {
        $user->get(array('_id'=>new MongoId($user->object['_id'])));
        $this->assertEquals($user->object['username'], 'ricter');
        $this->assertEquals($user->object['password'], '123456');
        $this->assertEquals($user->object['email'], 'ricterzheng@gmail.com');

        return $user;
    }

    /**
     * @depends testGetUser
     */
    public function testUpdateUser($user) {
        $user->update(array('username'=>'cee', '_id'=>'546ec9d241585e6c910041a1'));
        $this->assertEquals($user->object['username'], 'cee');
        $this->assertEquals($user->object['password'], '123456');
        $this->assertNotEquals($user->object['_id'], '546ec9d241585e6c910041a1');

        return $user;
    }

    /**
     * @depends testUpdateUser
     */
    public function testRemoveUser($user) {
        $user->delete();
        $this->assertEquals($user->object, NULL);
    }

    public static function tearDownAfterClass() {
        $mongodb = new MongoClient();
        $db = $mongodb->selectDB(DB_NAME)->selectCollection('users');
        $db->remove(array());
    }
}
