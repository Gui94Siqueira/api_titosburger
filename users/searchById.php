<?php

    require_once "../controller/controllerUsers.php";
    require_once "../model/modelUsers.php";

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $data = json_decode(file_get_contents('php://input'), true);

        $id = $data['id'];

        $controllerUser = new controllerUsers();
        $result = $controllerUser->searchById($id);

        if($result) {
            $msg = array("user" => $result);
            echo json_encode($msg);
        } else {
            $msg = array("fail" => "user not existents");
            echo json_encode($msg);
        }
    } else {
        header("HTTP/1.1 405 Method Not Allowed");
    }

?>