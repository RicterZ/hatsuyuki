<?php


class BaseModel {

    public $object;
    protected $db;
    protected $collection;
    protected $fields;

    function __construct($data=null) {
        $mongodb = new MongoClient(DB_CONN, array('username' => DB_USER, 'password' => DB_PASS));
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
        foreach ($data as $key => $value) {
            if ($key != '_id') {
                $this->object[$key] = $value;
            }
        }
        $this->db->update(array('_id' => $this->object['_id']), $this->object);
        $this->object = $this->get(array('_id' => $this->object['_id']));
    }

    public function create($data) {
        $this->is_array($data);
        $this->check_fields($data);
        $this->db->insert($data);
        $this->object = $data;
    }

    public function delete() {
        $this->db->remove(array('_id' => $this->object['_id']));
        $this->object = NULL;
    }

    private function is_array($data) {
        if (!is_array($data)) {
            throw new Exception('Invalid type of document');
        }
    }

    private function check_fields($data) {
        foreach ($this->fields as $field) {
            if (!array_key_exists($field, $data)) {
                throw new Exception('Invalid fields of this model');
            }
        }
    }
}

