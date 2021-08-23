<?php

session_start();

require_once "../../../bootstrap.php";
use Src\TableGateways\UserGateway;


$name = $_POST['full_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];

$errorFields = array();

if ($name === '') {
    $errorFields['err'] = 'Заполните поле ФИО!';
}
else if ($email === '') {
    $errorFields['err'] = 'Заполните поле Почта!';
}
else if ( !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errorFields['err'] = 'Не верный формат почтового адреса';
}
else if ($_FILES['avatar']['size'] === 0) {
    $errorFields['err'] = 'Выберите картинку';
}
else if ($password === '') {
    $errorFields['err'] = 'Заполните поле Пароль!';
}
else if (strlen($password) < 8) {
    $errorFields['err'] = 'Пароль должен содержать из более  7 символов!';
}
else if ($password_confirm === '') {
    $errorFields['err'] = 'Подтвердите пароль';
}

if (!empty($errorFields)) {
    $_SESSION['message'] = $errorFields['err'];
    header('Location: ../register.php');
    die();

}

if ($password === $password_confirm) {


    $dbGateway = new UserGateway($dbConnection);

    $findUser =  $dbGateway->findName($name);
    if ($findUser > 0) {
        $_SESSION['message'] = 'Такой пользователь уже существует!';
        header('Location: ../register.php');
        die();
    }

    $findEmail =  $dbGateway->findEmail($email);
    if ($findEmail > 0) {
        $_SESSION['message'] = 'Этот почтовый адрес уже используется!';
        header('Location: ../register.php');
        die();
    }

    $path = 'img/' . time() . $_FILES['avatar']['name'];
    if (!move_uploaded_file($_FILES['avatar']['tmp_name'], '../../' . $path)) {
        $_SESSION['message'] = 'Ошибка при загрузке фото';
        header('Location: ../register.php');
        die();
    }

    $password = md5($password);

    $input = array(
        'name' => $name,
        'email'  => $email,
        'photo' => $path,
        'user_key' => $password
    );

    $dbGateway = new UserGateway($dbConnection);
    $result =  $dbGateway->insert($input);

    $_SESSION['message'] = 'Регистрация прошла успешно!';
    header('Location: ../login.php');


} else {
    $_SESSION['message'] = 'Пароли не совпадают';
    header('Location: ../register.php');
}

?>
