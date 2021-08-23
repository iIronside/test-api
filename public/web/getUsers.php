<?php

require_once "../../bootstrap.php";
use Src\TableGateways\UserGateway;

$dbGateway = new UserGateway($dbConnection);

$findUser =  $dbGateway->findAll();
header('Content-Type: application/json');
echo json_encode($findUser);

//$data = array('1111'=> 'fdfgfdvf', '1111'=>'ddfdfd' ); // whatever you're serializing /;
//header('Content-Type: application/json');
//разметку до отправки
//echo $data;
//echo json_encode($data);