<?php

include('mainController.php');

$sql = $mainController->generateNDR();

var_dump($sql);

?>