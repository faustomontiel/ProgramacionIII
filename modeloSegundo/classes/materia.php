<?php

    class Materia
    {
        public $id;
        public $nombre;
        public $cuatrimestre;
        public $cupos;
        public $legajoProfesor;

        public function __construct($inputNombre,$inputCuatrimestre,$inputCupos)
        {
            $this->nombre           = $inputNombre;
            $this->cuatrimestre     = $inputCuatrimestre;
            $this->cupos             = $inputCupos;

        }
    }


?>