<?php


class RegisterView extends BaseView {

    public function get() {
        return 'Please POST your email, username and password';
    }

    public function post() {
        $user = new UserModel();
        $user->get(array('$or' => array(
            array('username' => $this->request->post->username),
            array('email'    => $this->request->post->email),
        )));
        if ($user->object) {
            return 'user existed';
        } else {
            $user->create(array(
                'username' => $this->request->post->username,
                'email'    => $this->request->post->email,
                'password' => $this->request->post->password,
            ));
            return 'user created';
        }
    }

}


$register_view = new RegisterView();