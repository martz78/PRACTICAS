<?php
$server="localhost:3316";
$user="root";
$pwd="";
$db="db_ventas";

$conexion = new mysqli($server,$user,$pwd,$db);
if($conexion)
{
    //echo "Bueno";
}
?>