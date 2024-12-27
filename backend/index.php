<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conecta a la base de datos  con usuario, contraseña y nombre de la BD
$servidor = "localhost"; $usuario = "root"; $contrasenia = "Froilan1988"; $nombreBaseDatos = "api";
$conexionBD = new mysqli($servidor, $usuario, $contrasenia, $nombreBaseDatos);


// Consulta datos y recepciona una clave para consultar dichos datos con dicha clave
if (isset($_GET["consultar"])){
    $sqlClientes = mysqli_query($conexionBD,"SELECT * FROM cliente WHERE id=".$_GET["consultar"]);
    if(mysqli_num_rows($sqlClientes) > 0){
        $clientes = mysqli_fetch_all($sqlClientes,MYSQLI_ASSOC);
        echo json_encode($clientes);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
//borrar pero se le debe de enviar una clave ( para borrado )
if (isset($_GET["borrar"])){
    $sqlClientes = mysqli_query($conexionBD,"DELETE FROM cliente WHERE id=".$_GET["borrar"]);
    if($sqlClientes){
        echo json_encode(["success"=>1]);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
//Inserta un nuevo registro y recepciona en método post los datos de nombre y correo
if(isset($_GET["insertar"])){
    $data = json_decode(file_get_contents("php://input"));
    $nombres=$data->nombres;
    $apellidos=$data->apellidos;
    $correo_electronico=$data->correo_electronico;
        if(($correo_electronico!="")&&($nombres!="")&&($apellidos!="")){
            
    $sqlClientes = mysqli_query($conexionBD,"INSERT INTO cliente(nombres,apellidos,correo_electronico) VALUES('$nombres','$apellidos','$correo_electronico') ");
    echo json_encode(["success"=>1]);
        }
    exit();
}
// Actualiza datos pero recepciona datos de nombre, correo y una clave para realizar la actualización
if(isset($_GET["actualizar"])){
    
    $data = json_decode(file_get_contents("php://input"));

    $id=(isset($data->id))?$data->id:$_GET["actualizar"];
    $nombres=$data->nombres;
    $apellidos=$data->apellidos;
    $correo_electronico=$data->correo_electronico;
    
    $sqlClientes = mysqli_query($conexionBD,"UPDATE cliente SET nombres='$nombres',apellidos='$apellidos',correo_electronico='$correo_electronico' WHERE id='$id'");
    echo json_encode(["success"=>1]);
    exit();
}
// Consulta todos los registros de la tabla empleados
$sqlClientes = mysqli_query($conexionBD,"SELECT * FROM cliente ");
if(mysqli_num_rows($sqlClientes) > 0){
    $clientes = mysqli_fetch_all($sqlClientes,MYSQLI_ASSOC);
    echo json_encode($clientes);
}
else{ echo json_encode([["success"=>0]]); }


?>