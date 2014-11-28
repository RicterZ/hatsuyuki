<?php


class IndexView extends BaseView {

    function get() {
        if ($user = $this->request->user) {
            $data = array(
                'title' =>  'Hatsuyuki',
                'todo' => $user->get_todo(),
            );
            return $this->render('index.html', $data);
        } else {
            return $this->render('index.html', array('title' => 'Hatsuyuki'));
        }
    }

}


$index_view = new IndexView();