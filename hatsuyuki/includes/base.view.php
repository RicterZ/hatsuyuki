<?php


class BaseView {
    protected $request;

    function __construct() {
        $this->request = new stdClass();
        $this->request->get = new stdClass();
        foreach ($_GET as $key => $value) {
            $this->request->get->$key = $value;
        }

        $this->request->post = new stdClass();
        foreach ($_POST as $key => $value) {
            $this->request->post->$key = $value;
        }

        $this->request->server = new stdClass();
        foreach ($_SERVER as $key => $value) {
            $this->request->server->$key = $value;
        }

        $this->request->session = new stdClass();
        foreach ($_SESSION as $key => $value) {
            $this->request->session->$key = $value;
        }

        $this->request->files = new stdClass();
        foreach ($_FILES as $key => $value) {
            $this->request->files->$key = new stdClass();
            foreach ($value as $innerKey => $innerValue) {
                $this->request->files->$key->$innerKey = $innerValue;
            }
        }
    }

    public function dispatch() {
        if ($this->request->server->REQUEST_METHOD == 'GET') {
            return function() {return $this->get();};
        } else if ($this->request->server->REQUEST_METHOD == 'POST') {
            return function() {return $this->post();};
        }
    }

    public function get() {return NULL;}
    public function post() {return NULL;}

    public function render($data) {
        return json_encode($data);
    }
}