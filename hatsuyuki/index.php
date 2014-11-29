<?php
session_start();
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/includes/config.php');
include_once(__DIR__ . '/includes/base.model.php');
include_once(__DIR__ . '/models/UserModel.php');
include_once(__DIR__ . '/models/ToDoModel.php');

include_once(__DIR__ . '/includes/base.view.php');
include_once(__DIR__ . '/views/IndexView.php');
include_once(__DIR__ . '/views/LoginView.php');
include_once(__DIR__ . '/views/RegisterView.php');
include_once(__DIR__ . '/views/TodoDetailView.php');


$klein = new \Klein\Klein();


$klein->respond('/index.php/', $index_view->dispatch());
$klein->respond('/index.php/login/?', $login_view->dispatch());
$klein->respond('/index.php/register/?', $register_view->dispatch());
$klein->respond('@/index.php/todo/(?P<id>[a-z0-9]{24})/?', $todo_detail_view->dispatch());


$klein->dispatch();

