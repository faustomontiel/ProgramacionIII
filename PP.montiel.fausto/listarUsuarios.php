<?php
include_once "./Clases/usuarios.php";
$nombre = $_GET["nombre"];
$arrayUsuarios = Usuarios::leerArchivo();
$aux = 0;

foreach($arrayUsuarios as $value)
{
    if(strcasecmp($value["nombre"], $nombre) == 0)
    {
        $clave = $value["clave"];
        echo "Nombre: $nombre Clave: $clave";
        $aux++;
    }
    
}
    if($aux == 0)
    {
        echo "No existe $nombre";

    }
?>