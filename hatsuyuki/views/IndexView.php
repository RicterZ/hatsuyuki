<?php

include_once(__DIR__ . '/../includes/base.view.php');
include_once(__DIR__ . '/../models/ToDoModel.php');
include_once(__DIR__ . '/../models/UserModel.php');



class IndexView extends BaseView {

    function get() {
        if ($user = $this->request->session->user) {
            $user = new UserModel(unserialize($user));
            return json_encode($user->get_todo());
        } else {
            return 'Welcome';
        }
    }

}


$index_view = new IndexView();