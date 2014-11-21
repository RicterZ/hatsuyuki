<?php

include_once('config.php');


class BaseModel {

    var $id;
    var $object;
    var $collection;

    function __construct($id) {
        $_ = new MongoClient();
        if (!is_string($id) || !strlen($id) == 24) {
            throw new Exception('Invalid ObjectId');
        }
        $this->id = $id;
        $this->object = $_->selectDB(DB_NAME)->__get($this->collection);
    }

    function get() {
        return json_decode($this->object->findOne(array('_id'=>$this->$id)));
    }

    function update() {

    }
}

