<?php

require_once("../controller/controllerProducts.php");
require_once("../model/modelProducts.php");

if($_SERVER['REQUEST_METHOD'] == "PUT") {
    
    
    $query = $_SERVER["QUERY_STRING"];
    parse_str($query, $param);
    $id = $param['id'];

    $data = json_decode(file_get_contents("php://input"), true);

    $controllerProducts = new controllerProducts();
    $result = $controllerProducts->update($id, $data);

    if($result) {
        $msg = array("msg" => "Product updated successfully");
        echo json_encode($msg);
    } else {
        $msg = array("Error" => "Unable to update the product");
        echo json_encode($msg);
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
}