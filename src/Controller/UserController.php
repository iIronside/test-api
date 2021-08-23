<?php
namespace Src\Controller;

use SimpleXMLElement;
use Src\TableGateways\UserGateway;

class UserController {

    private $db;
    private $requestMethod;
    private $queryParamArr;

    private $personGateway;

    public function __construct($db, $requestMethod, $queryParamArr)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->queryParamArr = $queryParamArr;

        $this->personGateway = new UserGateway($db);
    }

    public function processRequest()
    {
        $response = null;

        if ($this->checkKey()) {
            switch ($this->requestMethod) {
                case 'GET':
                    if (isset($this->queryParamArr['sort'])) {
                        $sortParam = $this->queryParamArr['sort'];

                        if ($sortParam === 'name' or  $sortParam === 'email') {
                            $response = $this->getAllUsersSort($sortParam );
                        }
                        else {
                            $response = $this->wrongSearchParam();
                        }
                    }
                    else {
                        $response = $this->getAllUsers();
                    }
                    break;
                case 'POST':
//                $response = $this->createUser();
                    break;
                case 'PUT':
//                $response = $this->updateUser();
                    break;
                case 'DELETE':
//                $response = $this->deleteUser();
                    break;
                default:
                    $response = $this->notFoundResponse();
                    break;
            }
        }
        else {
            $response = $this->wrongUserKey();
        }

        if (isset($this->queryParamArr['response_type'])) {
            $responseType = $this->queryParamArr['response_type'];

            if ($responseType === 'xml') {

                $xml = $this->arrayToXml($response );
                echo $xml;
            }
            else {
                echo json_encode($response);
            }
        }
        else {
            echo json_encode($response);
        }
    }

    private function getAllUsers()
    {
        $result = $this->personGateway->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['users'] = $result;
        return $response;
    }

    private function getAllUsersSort($sortParam)
    {
        $result = $this->personGateway->findAllSort($sortParam);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['users'] = $result;
        return $response;
    }

    private function checkKey()
    {
        if (isset($this->queryParamArr['user_key'])) {
            $key = $this->queryParamArr['user_key'];
            $result = $this->personGateway->findKey($key);

            if ($result > 0) {
                return true;
            }
        }
        return false;
    }

    private function wrongUserKey() {
        $response['status_code_header'] = 'HTTP/1.1 400 Wrong user key';
        $response['body'] = ['error' => 'Invalid key'];
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }

    private function wrongSearchParam()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Wrong search parameter';
        $response['body'] = null;
        return $response;
    }

    private function arrayToXml ($array, $rootElement = null, $xml = null) {
        $_xml = $xml;
        if ($_xml === null) {
            $_xml = new SimpleXMLElement ($rootElement !== null ? $rootElement : '<root/>');
        }
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                $this->arrayToXml ($v, $k, $_xml->addChild($k));
            }
            else {
                $_xml->addChild($k, $v);
            }
        }
        return $_xml->asXML();
    }
}