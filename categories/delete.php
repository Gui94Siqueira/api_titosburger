<?php

require_once("../controller/controllerCategories.php");
require_once("../model/modelCategories.php");

if($_SERVER["REQUEST_METHOD"] == "DELETE") {

    $query = $_SERVER["QUERY_STRING"];
    parse_str($query, $params);
    $id = $params["id"];

    $controllerCateries = new controllerCategories();
    $delete = $controllerCateries->delete($id);

    if($id) {
        $msg = array("msg" => "Category was deleted successfully.");
        echo json_encode($msg);
    } else {
        $msg = array("msg" => "Error, Category was not deleted."); 
        echo json_encode($msg);
    }
} else {
    header("HTTP/1.1 Method Not Allowed");
}