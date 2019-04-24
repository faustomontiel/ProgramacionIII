<?php

    class Proveedor{
        public $id;
        public $email;
        public $foto;

        public function __construct($id, $apellido,$email,$foto)
	{
		$this->id = $id;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->foto = $foto;
	}

    public function toTxt(){
    $file = fopen("proveedores.txt", "w"); 
    fwrite($file, $this->id ." ". $this->apellido ." ". $this->email ." ". $this->foto);
    fclose($file);
    }

    
    public function readTxt()
    {
        $archivo = "proveedores.txt";
        $vec = array();
        $contador = 0;
        $json;
        $i=0;
        $nombreComparar;

		if(!is_null($archivo))
		{
			while(!feof($archivo)){
                $vec[] = fgets($archivo);
                $vec[$i] = explode(" ",$vec[$i]);
                $i++;
            }
        }   	
        fclose($archivo);
        $json = json_encode($vec);
        $json = json_decode($json);

        foreach ($json as $item) {
            if(strcasecmp($item[1],$nombre)==0){
                echo $item[0] ." ". $item[1] ." ". $item[2] ." ". $item[3] ." ". $item[4];
                $contador++;
            }
        }
        if($contador == 0){
            echo "No existe proveedor ".$nombre;
        }

    }
}
?>