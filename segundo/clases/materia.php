<?php
require_once ('ConexionDB.php');
class Materia{

    public $cuatrimestre;
    public $nombre;
    public $cupos;
    
    public function __construct($nombre,$cuatrimestre,$cupos)
    {
        $this->nombre=$nombre;
        $this->cuatrimestre=$cuatrimestre;       
        $this->cupos=$cupos;
    }


/*Inserta un usuario en la bd*/
    public function Insertar(){

        
        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('INSERT INTO materia (nombre,cuatrimestre,cupos) VALUES (:nombre,:cuatrimestre,:cupos)');
        
        $sentencia->bindValue(':nombre',$this->nombre,PDO::PARAM_STR);
        $sentencia->bindValue(':cuatrimestre',$this->cuatrimestre,PDO::PARAM_INT);
        $sentencia->bindValue(':cupos',$this->cupos,PDO::PARAM_INT);

        $sentencia->execute();
        if($sentencia->rowCount()>0){
            return true;
        }
        return false;
    }

/*Trae todos los usuarios*/ 
    public static function TraerTodos(){
        
        $retorno=false;
        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('SELECT * FROM usuarios');
        $sentencia->execute();
        
        if($sentencia->rowCount()>0){
            $retorno=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        }

        return $retorno;
    }

/*Trae el perfil del usuario(email) que es pasado como parametro*/
    public static function TraerPerfil($email){
        
        
        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('SELECT perfil FROM usuarios WHERE email=:email');
        $sentencia->bindValue(':email',$email,PDO::PARAM_STR);
        $sentencia->execute();
        
        if($sentencia->rowCount()>0){
            $retorno=$sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $retorno;
        }

        return false;
    }

/*Verifica si el email y la clave estan en la bd*/ 
    public static function TraerUno($nombre,$clave){
        
        
        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('SELECT * FROM usuarios WHERE nombre=:nombre AND clave=:clave');
        $sentencia->bindValue(':nombre',$nombre,PDO::PARAM_STR);
        $sentencia->bindValue(':clave',$clave,PDO::PARAM_STR);
        $sentencia->execute();
        
        if($sentencia->rowCount()>0){
            return true;
        }

        return false;
    }

    public static function TraerMateria($materia)
    {
        
        
        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('SELECT * FROM materia WHERE nombre=:materia');
        $sentencia->bindValue(':materia', $materia, PDO::PARAM_STR);
        $sentencia->execute();
        
        if($sentencia->rowCount()>0){
            return true;
        }

        return false;
    }
}

?>