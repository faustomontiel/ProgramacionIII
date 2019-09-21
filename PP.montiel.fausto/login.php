<?php
include_once "./Clases/usuarios.php";
$nombre = $_POST["nombre"];
$clave = $_POST["clave"];
$arrayUsuarios = Usuarios::leerArchivo();
$loginExito = "Login exitoso";

$aux = 0;

foreach($arrayUsuarios as $value)
{
    if(strcasecmp($value["nombre"], $nombre) == 0 && strcasecmp($value["clave"], $clave) == 0)
    {
        echo $loginExito;
        $aux++;
    }
    
}
    if($aux == 0)
    {
        echo "Nombre: $nombre o clave: $clave erroneos";

    }
?>