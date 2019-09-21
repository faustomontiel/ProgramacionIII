<?php
    include_once "./Clases/usuarios.php";

    $user = new Usuarios($_POST["nombre"], $_POST["clave"]);
    $user -> guardarArchivo();
?>
