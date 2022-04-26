<?php  

class conexion{
    const user='id18072711_admin'; //nombre de usuario
    const pass='~A2F6$G&/myM0cOf'; //contraseña de usuario
    const db='id18072711_iotpagina3'; //nombre de la base de datos
    const servidor='localhost'; //nombre del host

    public function conectarDB(){
        $conectar= new mysqli(self::servidor, self::user, self::pass, self::db);
        if($conectar->connect_error){
            die("Error en la conexion!".$conectar->connect_error);
        }
        return $conectar;
    }

}



?>