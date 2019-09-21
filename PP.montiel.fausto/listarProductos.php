<?php
    include_once "./Clases/producto.php";

        foreach(Producto::leerArchivo() as $val)
        {
            $id = $val["id"];
            $nombre = $val["nombre"];
            $precio = $val["precio"];
            $nombreUsuario = $val["nombreUsuario"];
            echo "<br> ID: $id NOMBRE: $nombre PRECIO: $precio NOMBRE USUARIO: $nombreUsuario <br>";
        }

        
        if($criterio = $_GET["criterio"]){

        foreach(Producto::leerArchivo() as $val)
        {
                if($criterio == $val["nombre"] || $criterio == $val["nombreUsuario"])
                {
                    $id = $val["id"];
                    $nombre = $val["nombre"];
                    $precio = $val["precio"];
                    $nombreUsuario = $val["nombreUsuario"];
                    echo "<br> ID: $id NOMBRE: $nombre PRECIO: $precio NOMBRE USUARIO: $nombreUsuario <br>";
                }
                }
        }    
            
?>