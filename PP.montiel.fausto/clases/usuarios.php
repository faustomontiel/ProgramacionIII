<?php
class Usuarios
{
    public $nombre;
    public $clave;
    public function __construct($nombre = null, $clave = null)
    {
        $this -> nombre = $nombre;
        $this -> clave = $clave;
    }

    public function retornarJSon()
    {
        return json_encode($this);
    }


    public function guardarArchivo()
    {
        $archivo = "usuarios.txt";
        $actual = $this -> retornarJSon();

        if(file_exists($archivo))
		{
			$archivo = fopen("usuarios.txt", "a");
		}else
		{
			$archivo = fopen("usuarios.txt", "w");
        }

        $renglon = $actual.="\r\n";

		fwrite($archivo, $renglon);
		fclose($archivo);
    }

    
    public static function leerArchivo()
    {
        $archivo = "usuarios.txt";
		if(file_exists($archivo))
		{
			$gestor = @fopen($archivo, "r");
			$arrayUsuarios = array();
			$i = 0;
			while (($bufer = fgets($gestor, 4096)) !== false)
        	{
        		$arrayUsuarios[$i] = json_decode($bufer, true);
        		$i++;
           	}
    		fclose($gestor);
    		return $arrayUsuarios;
		}
	}

}
?>
