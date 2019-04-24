<?php
    require "proveedor.php";

    $prov = new Proveedor($_POST["id"],$_POST["apellido"],$_POST["email"],$_POST["foto"]);
    $prov->toTxt();

    
?>