<?php

require_once("../controller/controllerCategories.php");
require_once("../model/modelCategories.php");

if($_SERVER['REQUEST_METHOD'] == "GET") {

    $controllerCategories = new controllerCategories();
    $listAll = $controllerCategories->listAll();

    if($listAll) {
        $msg = array("categories" => $listAll);
        echo json_encode($msg);
    } else {
        $msg = array("categories" => []);
        echo json_encode($msg);
    }
} else {
    header("HTTP/1.1 405 MEthod Not Allowed");
}