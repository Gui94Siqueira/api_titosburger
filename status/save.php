<?php

require_once("../controller/controllerStatus.php");
require_once("../model/modelStatus.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $data = json_decode(file_get_contents("php://input"), true);

    if(array_key_exists("status", $data)){
        $controllerStatus = new controllerStatus();
        $save = $controllerStatus->save($data);
    
        if($save) {
            $msg = array("msg" => "Create status with success.");
            echo json_encode($msg);
        } else {
            $msg = array("msg" => "Error, status not created");
        }
    } else {
        header("HTTP/1.1 400 Bad Request");
        $msg = array("error" => "Parameter 'status' not exists!");
        echo json_encode($msg);
    }
   
} else {
    header("HTTP/1.1 405 Method Not Allowed");
}