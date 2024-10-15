<?php

    require_once "controller/controllerUsers.php";
    require_once "model/modelUsers.php";

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'];

        $controllerUsers = new controllerUsers();
        $result = $controllerUsers->update($id, $data);

        if($result) {
            $msg = array("msg" => "user update succesfully");
            echo json_encode($msg);
        } else {
            $msg = array("error" => "failed to update user");
            echo json_encode($msg);
        }
    }

?>