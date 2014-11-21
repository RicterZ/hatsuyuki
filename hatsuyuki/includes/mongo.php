<?php

include_once('config.php');


class BaseModel {

    protected $db;
    var $object;
    protected $collection;

    function __construct($data=null) {
        $mongodb = new MongoClient();
        $this->db = $mongodb->selectDB(DB_NAME)->selectCollection($this->collection);
        if ($data) {
            $this->get($data);
        }
    }

    public function get($data) {
        $this->object = $this->db->findOne($data);
        return $this->object;
    }

    public function update($data) {
        $this->is_array($data);
        foreach ($data as $key=>$value) {
            if ($key != '_id') {
                $this->object[$key] = $value;
            }
        }
        $this->db->update(array('_id'=>$this->object['_id']), $this->object);
        $this->object = $this->get(array('_id'=>$this->object['_id']));
    }

    public function create($data) {
        $this->is_array($data);
        $this->db->insert($data);
        $this->object = $data;
    }

    public function delete() {
        $this->db->remove(array('_id'=>$this->object['_id']));
        $this->object = NULL;
    }

    private function is_array($data) {
        if (!is_array($data)) {
            throw new Exception('Invalid type of document');
        }
    }
}

