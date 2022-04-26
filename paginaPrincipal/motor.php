<?php
//Este archivo solo actualiza el estado del motor

//Con esta instruccion hago que vuelva a cargar la pagina actuadoresCSS.html una vez que hace el envio de los datos
header('Location: http://iotpagina3.000webhostapp.com/paginaPrincipal/actuador.php');


require_once('conexion.php');


$dispositivo=$_GET['dispositivo'];
$motor=$_GET['motor'];


$conn=new conexion();


//Hacemos la consulta de SQL para actualizar tabla ESTADO
$queryUPDATE="UPDATE `estado` SET `Motor` = '$motor' WHERE `estado`.`Dispositivo` = '$dispositivo';";
//primer parametro la conexion, el segundo la consulta
$update= mysqli_query($conn->conectardb(),$queryUPDATE);

?>