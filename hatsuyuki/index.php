<?php
session_start();
//ini_set("display_errors", "On");
//error_reporting(E_ALL | E_STRICT);

require_once __DIR__ . '/vendor/autoload.php';
include_once(__DIR__ . '/views/IndexView.php');
include_once(__DIR__ . '/views/LoginView.php');


$klein = new \Klein\Klein();


$klein->respond('/index.php/', $index_view->dispatch());
$klein->respond('/index.php/login', $login_view->dispatch());


$klein->dispatch();

