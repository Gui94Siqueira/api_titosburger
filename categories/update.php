<?php

require_once("../controller/controllerCategories.php");
require_once("../model/modelCategories.php");

if($_SERVER['REQUEST_METHOD'] == "PUT") {

    $query = $_SERVER['QUERY_STRING'];
    parse_str($query, $params);
    $id = $params["id"];

    $data = json_decode(file_get_contents("php://input"), true);

    $controllerCategories = new controllerCategories();
    $update = $controllerCategories->update($id, $data);

    if($update) {
        $msg = array("msg" => 'category was updated  successfully.');
        echo json_encode($msg);
    } else {
        $msg = array("msg" => "Error, category was not updated.");
        echo json_encode($msg); 
    }

} else {
    header("HTTP/1.1 405 Method Not Allowed");
}