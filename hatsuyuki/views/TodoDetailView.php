<?php


class TodoDetailView extends BaseView {
    public function get($req=NULL) {
        $todo = new ToDoModel(array('_id' => new MongoId($req->id)));
        if ($todo->object) {
            echo '<pre>';
            print_r($todo);
            echo '</pre>';
            return NULL;
        } else {
            return new \Klein\Response('Not Found', 404);
        }
    }
}


$todo_detail_view = new TodoDetailView();