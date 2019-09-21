<?php

    class MateriaAlumno
    {
        public $id;
        public $materiaId;
        public $alumnoId;

        public function __construct($materiaIdInput,$alumnoIdInput)
        {
            $this->materiaId    = $materiaIdInput;
            $this->alumnoId     = $alumnoIdInput;

        }
    }


?>