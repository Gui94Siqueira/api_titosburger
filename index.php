<?php

header("Content-type: application/json");

$mensagem = array('msg' => 'API Titos Burger v1');

echo json_encode($mensagem);