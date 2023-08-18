<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRACTICA #1</title>
</head>

<body>
    <form action="" method="post">
        <label for="">Ingrese un numero</label>
        <input type="number" name="numero" id="">
        <button type="submit">Enviar</button>
    </form>

    <?php

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $numero = $_POST["numero"];
        echo "tabla del " . $numero . "<br>";
        for ($i = 1; $i < 11; $i++) {
            $resultado = $numero * $i;
            echo $numero . "*" . $i . "=" . $resultado . "<br>";
        }
    }
    ?>
</body>

</html>