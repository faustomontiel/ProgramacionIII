<?php


    var_dump($_FILES);
/*
    $origen = $_FILES["imagen"]["tmp_name"];
    move_uploaded_file($origen,"koalaImage.jpg");
*/  
    $origen = $_FILES["imagen"]["tmp_name"];
    $imagen = $_FILES["imagen"]["name"];

    $nombre = $_POST["Name"];
    $apellido = $_POST["Surname"];
    $imagen = explode(".",$imagen);
    $destino = $nombre.".".$apellido.".".end($imagen);

    
    /*
    $origen_2 = $_FILES["imagen2"]["tmp_name"];
    $desBackup = "./arch.jpg" ;
    if(file_exists($origen_2)){
        move_uploaded_file($origen_2,$desBackup);     
    }*/


    move_uploaded_file($origen,$destino);



?>