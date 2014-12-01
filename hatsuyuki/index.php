<?php
session_start();
require_once(__DIR__ . '/includes/config.php');
require_once(__DIR__ . '/vendor/autoload.php');


if (DEBUG) {
    ini_set("display_errors", "On");
    error_reporting(E_ALL | E_STRICT);
}


require_once(__DIR__ . '/includes/include.php');


$klein = new \Klein\Klein();
$klein->respond('/index.php/', $index_view->dispatch());
$klein->respond('/index.php/login/?', $login_view->dispatch());
$klein->respond('/index.php/register/?', $register_view->dispatch());
$klein->respond('/index.php/todo/?', $todo_view->dispatch());
$klein->respond('@/index.php/todo/(?P<id>[a-z0-9]{24})/?', $todo_detail_view->dispatch());
$klein->dispatch();

