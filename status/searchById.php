<?php

require_once ("../controller/controllerStatus.php");
require_once ("../model/modelStatus.php");

if($_SERVER["REQUEST_METHOD"] == "GET") {

    $id = $_GET["id"];

    $controllerStatus = new controllerStatus();
    $search = $controllerStatus->getById($id);

    if($search) {
        $msg = array("status" => $search);
        echo json_encode($msg);
    } else {
        $msg = array("status" => [], "msg" => "Not exists result for ID.");
        echo json_encode($msg);
    }

} else {
    header("HTTP/1.1 405 Method Not Allowed");
}