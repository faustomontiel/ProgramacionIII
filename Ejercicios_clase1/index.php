<?php
	include 'Humano.php';
	include 'Persona.php';
	include 'Alumno.php';
	$humano = new Humano("Juan", "Perez");
	$persona = new Persona("Rodolfo", "Ramirez", "14269874");
	$alumno = new Alumno("Roman", "Pellita", "34165414", "14000");
	print_r(json_encode($humano));
	print_r(json_encode($persona));
    print_r(json_encode($alumno));
    
    $arhc = fopen("archivo.txt","w");
    fclose($arhc);



?>