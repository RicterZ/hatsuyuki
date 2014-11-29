<?php


class IndexView extends BaseView {

    function get() {
        if ($user = $this->request->user) {
            $todo = new ToDoModel();
            $data = array(
                'title' =>  'Hatsuyuki',
                'todo' => $todo->get_todo($user->object['_id']),
            );
            return $this->render('index.html', $data);
        } else {
            return $this->render('index.html', array('title' => 'Hatsuyuki'));
        }
    }

}


$index_view = new IndexView();