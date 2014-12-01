<?php


class TodoView extends BaseView {

    public function get() {
        if ($this->request->user) {
            return $this->render('todo.html');
        } else {
            $resp = new \Klein\Response();
            return $resp->redirect($GLOBALS['LOGIN_URI'], 302);
        }
    }

    public function post() {
        if ($this->request->user) {
            $todo = new ToDoModel();
            $todo->create(array(
                'title'  => $this->request->post->title,
                'detail' => $this->request->post->detail,
                'status' => $this->request->post->status,
                'owner'  => $this->request->user->object['_id']
            ));
            return json_encode($todo->object);
        } else {
            $resp = new \Klein\Response();
            return $resp->redirect($GLOBALS['LOGIN_URI'], 302);
        }
    }

}


$todo_view = new TodoView();