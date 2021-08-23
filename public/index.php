<?php
require_once "../bootstrap.php";
use Src\Controller\UserController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//http://127.0.0.1:8000/getusers?user_key=ff44fgf444&sort=name&response_type=xml
$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url_path = str_replace('/','', $url_path);

if ($url_path === 'getusers') {
    $url_query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    parse_str($url_query, $query_param_arr);

    if (isset($query_param_arr['user_key'])) {
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        $controller = new UserController($dbConnection, $requestMethod, $query_param_arr);
        $controller->processRequest();
    }
    header("HTTP/1.1 400 Bad Request");
    exit();
}

    header ('Location: web/login.php');  // перенаправление на нужную страницу
    exit();
