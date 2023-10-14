<?php
require '../../controllers/PacientesController.php';
require  '../../constantes.php';

$css = CDN_BS_CSS;
$js = CDN_BS_JS;
$icons = CDN_ICONOS;

$data=obtenerRazas();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    crearRegistroPaciente($_POST, $_FILES['imagenes']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear paciente</title>
    <?= $css ?>
    <?= $icons ?>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #FFC0CB;">
        <a class="navbar-brand" href="../../index.php"> <img src="../../img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">Veterinaria UNIVO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item text-white">
                    <a class="nav-link" href="../especies/index.php">Especies</a>
                </li>
                <li class="nav-item text-white">
                    <a class="nav-link " href="../razas/index.php">Razas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Pacientes</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="row p-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="text-white">Crear paciente</h3>
                </div>
                <div class="card-body">
                    <form action="insert.php" enctype="multipart/form-data" method="post">
                        <div class="row">
                            <!--Nombre-->
                            <div class="col-md-6 mt-2">
                                <label for="nombre"><b>Escriba el nombre del paciente:</b></label>
                                <input class="form-control" type="text" name="nombre" id="nombre">
                            </div>
                            <!--Enfermedades-->
                            <div class="col-md-6 mt-2">
                                <label for="enfermedades"><b>Seleccione las enfermedades:</b></label><br>
                                <div class="form-group form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="enfermedades[]" value="Sarna" id="enfermedades">
                                    <label class="form-check-label" for="Sarna">Sarna</label>
                                </div>
                                <div class="form-group form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="enfermedades[]" value="Rabia" id="enfermedades">
                                    <label class="form-check-label" for="Rabia">Rabia</label>
                                </div>
                                <div class="form-group form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="enfermedades[]" value="Gripe" id="enfermedades">
                                    <label class="form-check-label" for="Gripe">Gripe</label>
                                </div> 
                                <div class="form-group form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="enfermedades[]" value="Jiote" id="enfermedades">
                                    <label class="form-check-label" for="Jiote">Jiote</label>
                                </div>
                                <div class="form-group form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="enfermedades[]" value="Ninguna" id="enfermedades">
                                    <label class="form-check-label" for="enfermedades">Ninguna</label>
                                </div>
                            </div>
                            <!--Vacunas-->
                            <div class="col-md-6 mt-2">
                                <label for="vacunas"><b>Seleccione las vacunas:</b></label><br>
                                <div class="form-group form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="vacunas[]" value="Distemper" id="vacunas">
                                    <label class="form-check-label" for="Distemper">Distemper</label>
                                </div>
                                <div class="form-group form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="vacunas[]" value="Parvovirus" id="vacunas">
                                    <label class="form-check-label" for="Parvovirus">Parvovirus</label>
                                </div>
                                <div class="form-group form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="vacunas[]" value="Leptospirosis" id="vacunas">
                                    <label class="form-check-label" for="Leptospirosis">Leptospirosis</label>
                                </div> 
                                <div class="form-group form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="vacunas[]" value="Rabia" id="vacunas">
                                    <label class="form-check-label" for="Rabia">Rabia</label>
                                </div>
                                <div class="form-group form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="vacunas[]" value="Ninguna" id="vacunas">
                                    <label class="form-check-label" for="Ninguna">Ninguna</label>
                                </div>
                            </div>
                            <!--Raza-->
                            <div class="col-md-6 mt-2">
                                <label for="nombre"><b>Seleccione la raza:</b></label>
                                <select name="id_raza" required class="form-control">
                                    <option value="" disabled selected>-- Seleccione la raza --</option>
                                    <?php foreach ($data as $raza) { ?>
                                        <option value="<?=$raza->id_raza?>"><?=$raza->nombre?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <!--Fecha-->
                            <div class="col-md-6 mt-2">
                                <label for="fecha"><b>Fecha</b></label>
                                <input class="form-control" type="date" name="fecha" id="fecha">
                            </div>
                            <!--Imagen-->
                            <div class="col-md-6 mt-2">
                                <label for="imagenes"><b>Seleccionar imagen</b></label>
                                <input required class="form-control" type="file" name="imagenes" id="imagenes">
                            </div>
                            <div class="col-md-12 mt-2">
                                <button class="btn btn-primary" type="submit">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?= $js ?>
</body>

</html>