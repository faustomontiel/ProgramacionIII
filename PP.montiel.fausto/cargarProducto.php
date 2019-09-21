<?php
    include_once "./Clases/producto.php";

    $user = new Producto($_POST["id"],$_POST["nombre"],$_POST["precio"],null,$_POST["nombreUsuario"]);
    $user -> guardarArchivo();
?>