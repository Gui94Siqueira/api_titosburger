<?php
    require_once "../controller/controllerUsers.php";
    require_once "../model/modelUsers.php";

    if($_SERVER['REQUEST_METHOD'] == 'GET') {

        $controllerUsers = new controllerUsers();
        $result = $controllerUsers->listAll();

        if($result) {
            $msg = array("users" => $result);
            echo json_encode($msg);
        } else {
            $msg = array("users" => []);
            echo json_encode($msg);
        }
    } else {
        header("HTTP/1.1 405 Method Not Allowed");
    }

?>