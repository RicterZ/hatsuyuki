<?php


class BaseView {
    protected $request;
    protected $method;

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

        if (array_key_exists('user', $_SESSION)) {
            $this->request->user = new UserModel(unserialize($_SESSION['user']));
        } else {
            $this->request->user = NULL;
        }
    }

    public function dispatch() {
        $http_methods = array('get', 'post', 'put', 'delete', 'patch', 'head');
        $methods = get_class_methods($this);

        $this->method = strtolower($this->request->server->REQUEST_METHOD);
        if ((!in_array($this->method, $http_methods)) || (!in_array($this->method, $methods))) {
            return function() {
                return new \Klein\Response('Method not allowed', 405);
            };
        } else {
            return function($req=NULL, $response=NULL, $service=NULL, $app=NULL) {
                return call_user_func_array(array($this, $this->method), array($req, $response, $service, $app));
            };
        }

    }

    public function get() {return NULL;}
    public function post() {return NULL;}

    public function render($tpl, $data=array()) {
        $smarty = new Smarty();
        $data['user'] = $this->request->user ? $this->request->user->object : NULL;
        $data['request'] = $this->request;
        $smarty->escape_html = true;
        $smarty->assign('data', $data);
        return $smarty->fetch('./templates/' . $tpl);
    }
}
