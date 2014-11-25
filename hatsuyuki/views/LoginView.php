<?php


class LoginView extends BaseView {

    public function get() {
        return 'Please POST ur username and password';
    }

    public function post() {
        $user = new UserModel();
        if ($user->check_user($this->request->post->username, $this->request->post->password)) {
            $_SESSION['user'] = serialize($user->object);
            return 'Success';
        } else {
            return 'Fail';
        }
    }

}


$login_view = new LoginView();