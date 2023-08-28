<?php

session_start();
if (isset($_SESSION['username'])){
    header('Location: login.php');
}
$username = isset($_POST['username'])? $_POST['username']: '';
$password = isset($_POST['password'])? $_POST['password']: '';

$userdb = 'vane';
$passdb = '123';

if (($username != '' || $password != '')
&& $userdb == $username && $passdb == $password 
){
    $_SESSION['username'] = $username;
    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica 3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<div class="row container">
    <form action="login.php" method="post">
        <div class="col-md-6 mt-2">
            <label for="username">Escribe tu usuario </label>
            <input class="form-control" type="text" name="username" id="">
        </div>
        <div class="col-md-6 mt-2">
            <label for="password">Escribe tu contraseña </label>
            <input class="form-control" type="password" name="password" id="">
        </div>
        <div class="col-md-6 mt-2">
            <button type="submit" class="btn btn-primary">Logearse</button>
        </div>
    </form>
</div>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</html>