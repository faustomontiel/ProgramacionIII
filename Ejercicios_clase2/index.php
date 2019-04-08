<?php
    require "alumno.php";
    var $alumnoUno = new Alumno($_POST["77878977"],$_POST["fausto"],$_POST["montiel"],$_POST["1325"]);
    var $alumnoDos = new Alumno($_POST["78789977"],$_POST["gaston"],$_POST["gomez"],$_POST["2555"]);
    var $arrayAlumnosJson = array($alumnoUno,$alumnoDos);
    
    var $file = fopen("json_file.json", "w");
    var $string = json_encode($arrayAlumnosJson);
    fwrite($file, $string);
    fclose($file);
?>
