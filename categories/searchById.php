<?php

require_once("../controller/controllerCategories.php");
require_once("../model/modelCategories.php");


if($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];

    $controllerCategories = new controllerCategories();
    $search = $controllerCategories->searchById($id);

    if($search) {
        $msg = array("category" => $search);
        echo json_encode($msg);
    } else {
        $msg = array("category" => [], "msg" => "category not found.");
        echo json_encode($msg);
    }
} else {
    header("HTTP/1.1 Method Not Allowed");
}