<?php

require_once ("../controller/controllerUsers.php");
require_once ("../model/modelUsers.php");

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);

    $controllerUsers = new controllerUsers();
    $result = $controllerUsers->save($data);


    if($result) {
        $msg = array("msg" => "user created");
        echo json_encode($msg);
    } else {
        $msg = array("error" => "failed to create user");
        echo json_encode($msg);
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
}


?>