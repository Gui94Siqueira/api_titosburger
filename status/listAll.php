<?php

require_once("../controller/controllerStatus.php");
require_once("../model/modelStatus.php");

//echo $_SERVER["REQUEST_METHOD"];

if($_SERVER["REQUEST_METHOD"] == "GET") {

    $controllerStatus = new controllerStatus();
    $list = $controllerStatus->getAll();

    $result = array('status' => $list);
    echo json_encode($result);

} else {
    header("HTTP/1.1 405 Method Not Allowed");
}