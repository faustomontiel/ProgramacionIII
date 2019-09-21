<?php
require_once ('ConexionDB.php');
class Usuario{

    public $clave;
    public $nombre;
    public $tipo;
    public $email;
    public $foto;
    
    public function __construct($nombre,$clave,$tipo)
    {
        $this->nombre=$nombre;
        $this->clave=$clave;       
        $this->tipo=$tipo;
    }


/*Inserta un usuario en la bd*/
    public function Insertar(){

        
        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('INSERT INTO usuarios (nombre,clave,tipo) VALUES (:nombre,:clave,:tipo)');
        
        $sentencia->bindValue(':nombre',$this->nombre,PDO::PARAM_STR);
        $sentencia->bindValue(':clave',$this->clave,PDO::PARAM_STR);
        $sentencia->bindValue(':tipo',$this->tipo,PDO::PARAM_STR);

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
    public static function TraerPorLegajo($legajo){
        
        
        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('SELECT * FROM usuarios WHERE legajo=:legajo');
        $sentencia->bindValue(':legajo',$legajo,PDO::PARAM_INT);
        $sentencia->execute();
        
        if($sentencia->rowCount()>0){
            return true;
        }

        return false;
    }

    public static function EditarUsuarioAlumno($usuario){
        
        
        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('UPDATE usuarios SET email = :email WHERE legajo=:legajo');
        $consulta->bindValue(':legajo', $usuario->legajo, PDO::PARAM_INT);
        $sentencia->bindValue(':email', $usuario->email, PDO::PARAM_STR);
        $sentencia->execute();
        
        if($sentencia->rowCount()>0){
            return true;
        }

        return false;
    }

}

?>