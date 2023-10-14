<?php
include $_SERVER['DOCUMENT_ROOT'] . '/veterinaria-php-puro/db/db.php';

function obtenerRazas()
{
    $query = "SELECT tbl_especies.nombre as especie, tbl_razas.id_raza, tbl_razas.nombre, tbl_razas.estado, tbl_razas.fecha 
    FROM tbl_razas INNER JOIN tbl_especies ON tbl_especies.id_especie = tbl_razas.id_especie";
    $ejecutar = conectarDb()->prepare($query);
    $ejecutar->execute();
    $data = $ejecutar->fetchAll(PDO::FETCH_OBJ);

    return $data;
}

function obtenerPacientes()
{
    $query = "SELECT * from tbl_pacientes";
    $smt = conectarDb()->prepare($query);
    $smt->execute();
    $data = $smt->fetchAll(PDO::FETCH_OBJ);

    return $data;
}

function crearRegistroPaciente($post, $files)
{

    $image = guardarImagen($files);

    $query = "INSERT INTO tbl_pacientes 
    (
        nombre, enfermedades, vacunas, id_raza, imagen, fecha_creacion, 
        fecha_actualizacion, creado_por, actualizado_por, fecha
    ) VALUES
    (
        :nombre, :enfermedades, :vacunas, :id_raza, :imagen, :fecha_creacion, 
        :fecha_actualizacion, :creado_por, :actualizado_por, :fecha)";

    $enfermedadesSeleccionadas = $post['enfermedades'];
    $aux=[];
    foreach($enfermedadesSeleccionadas as $enf){
        $aux[]=$enf;
    }
    $enfermedadesCont = implode(", ", $aux);

    $vacunasSeleccionadas = $post['vacunas'];
    $aux2=[];
    foreach($vacunasSeleccionadas as $vf){
        $aux2[]=$vf;
    }
    $vacunasCont = implode(", ", $aux2);

    $data = [
        ':nombre' => $post['nombre'], ':enfermedades' => $enfermedadesCont, ':vacunas' => $vacunasCont,
        ':id_raza' => $post['id_raza'], ':imagen' => $image, ':fecha_creacion' => date('Y-m-d H:i:s'),
        ':fecha_actualizacion' => date('Y-m-d H:i:s'), ':creado_por' => 1,
        ':actualizado_por' => 1, ':fecha' => date('Y-m-d')
    ];
    $stmt = conectarDb()->prepare($query);
    $stmt->execute($data);
    header('Location: index.php');
}

function guardarImagen($files)
{
    $carpeta = 'imagenes';

    $infoExtension = explode(".", $files["name"]);
    //$infoExtension = pathinfo($files['name']); 
    $extension = $infoExtension[1];

    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
    $aleatorio = substr(str_shuffle($permitted_chars), 0, 10);

    $imagen = $carpeta . "/" . $aleatorio . "." . $extension;
    $tmp = $files["tmp_name"];

    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777);
    } 

    if (!move_uploaded_file($tmp, $imagen)) {
        return null;
    }

    return $imagen;
}


function borrarPaciente($id)
{
    try {
        $query = "DELETE FROM tbl_pacientes WHERE id_paciente = :id_paciente";
        $stmt = conectarDb()->prepare($query);
        $data = [':id_paciente' => $id];
        $stmt->execute($data);
        header('Location: index.php');
    } catch (PDOException $e) {
        $_SESSION['error'] = "error";
        $_SESSION['error-message'] = "<script>
        Swal.fire({
            title: 'Error',
            text: '" . $e->getMessage() . "',
            showCancelButton: true,
            icon: 'error',
            confirmButtonText: 'Continuar',
            cancelButtonText: `Cancelar`,
        })
    </script>";
    }
}


function obtenerData($id){
    $query = "SELECT * from tbl_pacientes WHERE id_paciente = $id";
    $smt = conectarDb()->prepare($query);
    $smt->execute();
    $data = $smt->fetchAll(PDO::FETCH_OBJ);

    return $data;
}

function obtenerEnfermedades($id){
    $query = "SELECT enfermedades from tbl_pacientes WHERE id_paciente = $id";
    $smt = conectarDb()->prepare($query);
    $smt->execute();
    $data = $smt->fetchAll(PDO::FETCH_OBJ);
    $enfermedades = $data[0]->enfermedades;
    $enfermedadesArray = explode(',',$enfermedades);
    return $enfermedadesArray;
}
function obtenerVacunas($id){
    $query = "SELECT vacunas from tbl_pacientes WHERE id_paciente = $id";
    $smt = conectarDb()->prepare($query);
    $smt->execute();
    $data = $smt->fetchAll(PDO::FETCH_OBJ);
    $vacunas = $data[0]->vacunas;
    $vacunasArray = explode(',',$vacunas);
    return $vacunasArray;
}

function updatePaciente($post, $files) {
    $enfermedadesSeleccionadas = $post['enfermedades'];
    $aux = [];
    foreach ($enfermedadesSeleccionadas as $enf) {
        $aux[] = $enf;
    }
    $enfermedadesCont = implode(", ", $aux);

    $vacunasSeleccionadas = $post['vacunas'];
    $aux2 = [];
    foreach ($vacunasSeleccionadas as $vf) {
        $aux2[] = $vf;
    }
    $vacunasCont = implode(", ", $aux2);

   
    $dataUpdate = [
        ':nombre' => $post['nombre'],
        ':enfermedades' => $enfermedadesCont,
        ':vacunas' => $vacunasCont,
        ':id_raza' => $post['id_raza'],
        ':fecha_creacion' => $post['fecha_creacion'],
        ':fecha_actualizacion' => date('Y-m-d H:i:s'),
        ':id_paciente' => $post["id_pacientePost"]
    ];


    if ($files['error'] !== 4) {
        $imagen = editImagen($post['id_pacientePost'], $files);
        
        $dataUpdate[':imagen'] = $imagen;
    }

    
    $query = "UPDATE tbl_pacientes 
              SET nombre = :nombre, enfermedades = :enfermedades, vacunas = :vacunas,
                  id_raza = :id_raza, fecha_creacion = :fecha_creacion, fecha_actualizacion = :fecha_actualizacion";

    
    if ($files['error'] !== 4) {
        $query .= ", imagen = :imagen";
    }

    $query .= " WHERE id_paciente = :id_paciente";

    
    $stmt = conectarDb()->prepare($query);
    $stmt->execute($dataUpdate);
    header('Location: index.php');
}



function editImagen($id, $file){
    $carpeta = 'imagenes';

    $query = "SELECT imagen FROM tbl_pacientes where id_paciente = $id";
    $smt = conectarDb()->prepare($query);
    $smt->execute();
    $query = $smt->fetchAll(PDO::FETCH_OBJ);

    $name = $query[0]->imagen;
    
    if(!unlink($name)){
        return null;
    }
    
     $carpeta = 'imagenes';

     $infoExtension = explode(".", $file["name"]);
    
     $extension = $infoExtension[1];

     $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
     $aleatorio = substr(str_shuffle($permitted_chars), 0, 10);

     $imagen = $carpeta . "/" . $aleatorio . "." . $extension;
     $tmp = $file["tmp_name"];

     if (!file_exists($carpeta)) {
         mkdir($carpeta, 0777);
     } 

     if (!move_uploaded_file($tmp, $imagen)) {
         return null;
     }

    return $imagen;

}