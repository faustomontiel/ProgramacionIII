<?php
    require "alumno.php";
     $alumnoUno = new Alumno("77878977","fausto","montiel","1325");
     $alumnoDos = new Alumno("78789977","gaston","gomez","2555");
     $arrayAlumnosJson = array($alumnoUno,$alumnoDos);

   $file = fopen("json_file.json", "w");
     $alumnosEncode = json_encode($arrayAlumnosJson);
    fwrite($file, $alumnosEncode);
    fclose($file);
/*
    $alumnosDecode = json_decode($alumnosEncode);

     $file = fopen("csv_file.csv", "w");
    foreach ($alumnoUno as $item) {
        
    }
*/

    var_dump($arrayAlumnosJson);
    var_dump($_FILES);
    $_FILES["imagen"]["name"] = "hola.jpg";
    var_dump($_FILES["imagen"]["name"]);


    
?>
