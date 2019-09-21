<?php

    class Usuario
    {
        public $tipo;
        public $nombre;
        public $clave;
        public $legajo;
        public $email;
        public $foto;

        public function __construct($inputNombre,$inputClave,$inputTipo)
        {
            $this->nombre   = $inputNombre;
            $this->clave    = $inputClave;
            $this->tipo     = $inputTipo;
        }
    }


?>