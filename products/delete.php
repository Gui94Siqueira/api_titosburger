<?php

require_once("../controller/controllerProducts.php");
require_once("../model/modelProducts.php");

if($_SERVER['REQUEST_METHOD'] == "DELETE") {
    
    $query = $_SERVER["QUERY_STRING"];
    parse_str($query, $param);
    $id = $param['id'];

    $controllerProducts = new controllerProducts();
    $result = $controllerProducts->delete($id);

    if($result) {
        $msg = array("msg" => "The product was successfully deleted");
        echo json_encode($msg);
    } else {
        $msg = array("Error" => "Unable to delete product");
        echo json_encode($msg);
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
}