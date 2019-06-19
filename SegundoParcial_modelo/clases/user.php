<?php
class User
{
    public $nombre;
    public $clave;
    public $sexo;
    public $perfil;

    public function __construct($nombre, $clave,$sexo,$perfil)
	{
		$this->nombre = $nombre;
        $this->clave = $clave;
        $this->sexo = $sexo;
        $this->perfil = $perfil;
	}
    
}