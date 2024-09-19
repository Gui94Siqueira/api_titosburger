<?php

require_once("../controller/controllerProducts.php");
require_once("../model/modelProducts.php");

if($_SERVER['REQUEST_METHOD'] == "GET") {

    $id = $_GET['id'];

    $controllerProducts = new controllerProducts();
    $result = $controllerProducts->listByCategory($id);

    if($result) {
        $msg = array("product" => $result);
        echo json_encode($msg);
    } else {
        $msg = array("product" => "non-existent product");
        echo json_encode($msg);
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
}