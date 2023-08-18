<?php

$_POST = isset($_POST['POST']) ? $_POST['POST'] : '' ;
$checkbox = isset ($_POST['genero']) ? $_POST['POST'] : '' ;
$_GET = isset($_GET['get']) ? $_GET['POST'] : '' ;

echo '<h1>'. $post . '</h1>';
echo '<h1>'. $get . '</h1>';
print_r($checkbox)

?>