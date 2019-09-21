<?php
class Producto
{
    public $id;
    public $nombre;
    public $precio;
    public $imagen;
    public $nombreUsuario;
    public function __construct($id = null,$nombre = null, $precio = null,$imagen = null,$nombreUsuario = null)
    {
        $this -> id = $id;
        $this -> nombre = $nombre;
        $this -> precio = $precio;
        $this -> imagen = $imagen;
        $this -> nombreUsuario = $nombreUsuario;
    }

    public function retornarJSon()
    {
        return json_encode($this);
    }


    public function guardarArchivo()
    {
        $archivo = "productos.txt";
        $actual = $this -> retornarJSon();

        if(file_exists($archivo))
		{
			$archivo = fopen("productos.txt", "a");
		}else
		{
			$archivo = fopen("productos.txt", "w");
        }

        $renglon = $actual.="\r\n";

        fwrite($archivo, $renglon);
		fclose($archivo);
    }

    
    public static function leerArchivo()
    {
        $archivo = "productos.txt";
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