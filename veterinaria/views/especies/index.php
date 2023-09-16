<?php
require '../../db/db.php';
require '../../constantes.php';
$css = CDN_BS_CSS;
$js = CDN_BS_JS;
$query = "SELECT * FROM tbl_especies";
$ejecutar = $conn->prepare($query);
$ejecutar->execute();
$data = $ejecutar->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?= $css ?>
</head>

<body>
    
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary">
                <div class="d flex justify-content-around"></div>
                <h3 class="text-white">Listado De Especies</h3>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-stripped">
                    <thead class="thead-dark">
                        <th>Nombre: </th>
                        <th>Estado: </th>
                        <th>Fecha Creacion: </th>
                        <th>Acciones </th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($data as $especies) {
                        ?>
                            <tr>
                                <td><?= $especies->nombre ?></td>
                                <td><?= $especies->estado ?></td>
                                <td><?= $especies->fecha ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?= $js ?>
</body>

</html>