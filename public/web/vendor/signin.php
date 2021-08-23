<?php

session_start();

require_once "../../../bootstrap.php";
use Src\TableGateways\UserGateway;

$login = $_POST['login'];
$password = $_POST['password'];

$errorFields = array();

if ($login === '') {
    $errorFields['err'] = 'Введите имя';
}
else if ($password === '') {
    $errorFields['err'] = 'Введите пароль';
}

if (!empty($errorFields)) {
    $_SESSION['message'] = 'Все поля должны быть заполнен!';
    header('Location: ../login.php');
    die();
}
$password = md5($password);

$dbGateway = new UserGateway($dbConnection);
$getUser =  $dbGateway->checkUser($login, $password);

if (!empty($getUser)) {

    $user = $getUser[0];

    $_SESSION['user'] = [
        "id" => $user['id'],
        "full_name" => $user['name'],
        "avatar" => $user['photo'],
        "email" => $user['email']
    ];

    header('Location: ../users.php');

} else {
    $_SESSION['message'] = 'Не верное имя или пароль!';
    header('Location: ../login.php');

}

?>
