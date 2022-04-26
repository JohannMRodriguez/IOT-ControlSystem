<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <title>Panel de Control</title>
    <link rel="stylesheet" href="style_actuador.css">
    <link rel="shortcut icon" href="favicon.svg">
</head>
<body>
    <div class="container">
        <div class="form">
            <h2>EA IOT - Proyecto Final</h2>
            <h2>Control de Motor</h2>
            <div><h3 style='color: #fff;'>
            <div class="mb-3">
                <label for="disabledTextInput" class="form-label">Dispositivo:</label>
                <input type="text" placeholder="NodeMCU ESP32S" style="font-size: 18px;">
            </div>
            <br><br>
            <div class="motor">
                <button style='background-color:red;  color:white; border-radius: 10px; border-color: rgb(255, 0, 0);' 
                    type='button' onClick=location.href='/paginaPrincipal/motor.php?dispositivo=NodeMCU&motor=0'><h2 style="background: red;">OFF</h2>
                </button>
                <button style='background-color:rgb(94, 255, 0); color:white; border-radius: 10px; border-color: rgb(25, 255, 4);' 
                    type='button' onClick=location.href='/paginaPrincipal/motor.php?dispositivo=NodeMCU&motor=1'><h2 style="background: rgb(94, 255, 0);">ON</h2>
                </button>
                <br><br>
            </div>
            <div class="verify_state">
                <?php
                    require_once('conexion.php');
                    $conn=new conexion();

                    //Hacemos la consulta de SQL para filtrar el estado de la tarjeta
                    $querySELECT="SELECT `Motor` FROM `estado` WHERE `dispositivo`= 'NodeMCU';";
                    //primer parametro la conexion, el segundo la consulta
                    $result= mysqli_query($conn->conectarDB(),$querySELECT);

                    //Creo una variable $row (fila) en la cual vamos a guardar la fila que nos da como resultado la consulta SELECT
                    $row=mysqli_fetch_row($result);

                    if($row[0]==1){
                        echo "El motor se encuentra ENCENDIDO";
                    }else if($row[0]==0){
                        echo "El motor se encuentra APAGADO";
                    }else{
                        echo "Valor invalido para motor";
                    }
                ?>
            </div>
        </div>
        <br><br><br>
        <div class="back">
            <img src="caret-left-solid.svg" alt="back-icon" style="width:10px; background-color: darkgrey;">
            <a href="http://iotpagina3.000webhostapp.com">&nbsp;&nbsp;Inicio</a>
        </div>
    </div>
</body>
</html>