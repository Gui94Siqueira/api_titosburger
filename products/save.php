<?php

require_once("../controller/controllerProducts.php");
require_once("../model/modelProducts.php");

if($_SERVER['REQUEST_METHOD'] == "POST") {

    $data = json_decode(file_get_contents("php://input"), true);

    $controllerProducts = new controllerProducts();
    $product = $controllerProducts->save($data);

    if($product) {
        $msg = array("msg" => "Nine products successfully registered");
        echo json_encode($msg);
    } else {
        $msg = array("Error" => "Failure to register product");
        echo json_encode($msg);
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
}