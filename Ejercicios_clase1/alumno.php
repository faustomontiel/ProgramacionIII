<?php
class Alumno extends Persona
{
	public $legajo;
	public function __construct($nombre, $apellido, $dni, $legajo)
	{
		Parent::__construct($nombre, $apellido, $dni);
		$this->legajo = $legajo;
	}


	function toCsv(){
		$csv = $nombre",",$apellido",",$dni",",$legajo;
		return $csv;
	}
}
?>