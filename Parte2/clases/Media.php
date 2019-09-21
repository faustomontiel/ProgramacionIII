<?php
require_once ('ConexionBD.php');

class Media{

    public $id;
    public $color;
    public $marca;
    public $precio;
    public $talle;

    public function __construct($id=null,$color=null,$marca=null,$precio=null,$talle=null)
    {
        $this->id=$id;
        $this->color=$color;
        $this->marca=$marca;
        $this->precio=$precio;
        $this->talle=$talle;
     
    }

    public function Insertar(){
        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('INSERT INTO medias (color,marca,precio,talle) VALUES (:color,:marca,:precio,:talle)');
        
        $sentencia->bindValue(':color',$this->color,PDO::PARAM_STR);
        $sentencia->bindValue(':marca',$this->marca,PDO::PARAM_STR);
        $sentencia->bindValue(':precio',$this->precio,PDO::PARAM_INT);
        $sentencia->bindValue(':talle',$this->talle,PDO::PARAM_STR);
        
        $sentencia->execute();
        if($sentencia->rowCount()>0){
            return true;
        }

        return false;
    }

    public static function TraerTodos(){
       
        $retorno=false;
        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('SELECT * FROM medias');
        $sentencia->execute();
        
        if($sentencia->rowCount()>0){
            
            $retorno=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        }

        return $retorno;

    }

    public static function TraerUno($id){
       
        $retorno=false;
        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('SELECT * FROM medias WHERE id=:id');
        $sentencia->bindValue(':id',$id,PDO::PARAM_INT);
        $sentencia->execute();
        
        if($sentencia->rowCount()>0){
            
            $retorno=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        }

        return $retorno;

    }

    public static function Eliminar($id){
        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('DELETE FROM medias WHERE id=:id');
        
        $sentencia->bindValue(':id',$id,PDO::PARAM_INT);

        $sentencia->execute();
        if($sentencia->rowCount()>0){
            return true;
        }

        return false;
    }

    public function Modificar(){
        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('UPDATE medias SET color=:color,marca=:marca,precio=:precio,talle=:talle WHERE id=:id');
        $sentencia->bindValue(':id',$this->id,PDO::PARAM_INT);
        $sentencia->bindValue(':color',$this->color,PDO::PARAM_STR);
        $sentencia->bindValue(':marca',$this->marca,PDO::PARAM_STR);
        $sentencia->bindValue(':precio',$this->precio,PDO::PARAM_INT);
        $sentencia->bindValue(':talle',$this->talle,PDO::PARAM_STR);
        
        $sentencia->execute();
        if($sentencia->rowCount()>0){
            return true;
        }

        return false;
    }
}
?>