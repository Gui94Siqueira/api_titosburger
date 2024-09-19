<?php

require_once("../controller/controllerProducts.php");
require_once("../model/modelProducts.php");

if($_SERVER['REQUEST_METHOD'] == "GET") {

    $controllerProducts = new controllerProducts();
    $result = $controllerProducts->listAll();

    if($result) {
        $msg = array("Products" => $result);
        echo json_encode($msg);
    } else {
        $msg = array("Products" => "[]");
        echo json_encode($msg);
    }
} else {
    header("HTTP/1.1 405 Method Not allowed");
}