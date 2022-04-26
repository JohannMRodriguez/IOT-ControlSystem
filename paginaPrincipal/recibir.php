<?php

require_once ('conexion.php');

$dispositivo=$_POST['dispositivo'];
$temperatura=$_POST['temperatura'];
$humedad=$_POST['humedad'];
//nuevas variables utilizadas
$motor=$_POST['motor'];

$conn = new conexion(); //creamos un objeto de la clase conexion

//actualizamos la tabla 'estado' con el comando UPDATE SQL
$queryUPDATE = "UPDATE `estado` SET `Temperatura`='$temperatura',`Humedad`='$humedad' WHERE `estado`.`Dispositivo` = '$dispositivo';";
$update= mysqli_query($conn->conectarDB(),$queryUPDATE);

//acomodamos la consulta, la escribimos
$queryINSERT="INSERT INTO `historico` (`Dispositivo`, `Hora de medición`, `Temperatura`, `Humedad`, `Motor`) VALUES ('$dispositivo', NOW(), '$temperatura', '$humedad', '$motor');";
$insert = mysqli_query($conn->conectarDB(), $queryINSERT);

//hacemos una consulta para extraer los datos para analisis y luego realizamos la consulta
$querySELECT="SELECT `Motor` FROM `estado` WHERE `Dispositivo`= 'NodeMCU';";
$result= mysqli_query($conn->conectarDB(),$querySELECT);

//agregamos una variable que almacena el vector formado por el valor de 'led' y 'servo'
$row=mysqli_fetch_row($result);
//echo "Datos recibidos <br>";
//echo "Dispositivo:" .$dispositivo ." - Temperatura:" .$temperatura ." - Humedad:" .$humedad;
echo "{MOTOR:".$row[0]."}";

?>