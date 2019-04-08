    
<?php
    require_once "Humano.php";
    class Persona extends Humano
    {
        public $dni;
        public function __construct($dni,$nombre,$apellido){
            parent::__construct($nombre,$apellido);
            $this->dni = $dni;
        }
        public function ToJson()
        {
            return json_encode($this);
        }
    }
    
?>