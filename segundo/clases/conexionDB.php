<?php
class Conexion{
    public $pdo;
    
    public function __construct(){ 
        $user='root';
        $pass="";
        try{
            $strCon='mysql:host=localhost:3306;dbname=usuario';
            $this->pdo=new PDO($strCon,$user,$pass);
        }catch(PDOException $e){
            echo "Error..<br/>" . $e->getMessage();
 
            die();
        }
    }
    public function GetConexion(){
        return $this->pdo;
    }
}
?>