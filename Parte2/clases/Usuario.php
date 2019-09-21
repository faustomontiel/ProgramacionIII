<?php
require_once ('ConexionBD.php');
class Usuario{

    public $id;
    public $email;
    public $clave;
    public $nombre;
    public $apellido;
    public $perfil;
    public $foto;

    
    public function __construct($id=null,$email=null,$clave=null,$nombre=null,$apellido=null,$perfil=null,$foto=null)
    {
        $this->id=$id;
        $this->email=$email;
        $this->clave=$clave;
        $this->nombre=$nombre;
        $this->apellido=$apellido;
        $this->perfil=$perfil;
        $this->foto=$foto;
        
    }


/*Inserta un usuario en la bd*/
    public function Insertar(){

        
        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('INSERT INTO usuarios (email,clave,nombre,apellido,perfil,foto) VALUES (:email,:clave,:nombre,:apellido,:perfil,:foto)');
        
        $sentencia->bindValue(':email',$this->email,PDO::PARAM_STR);
        $sentencia->bindValue(':clave',$this->clave,PDO::PARAM_STR);
        $sentencia->bindValue(':nombre',$this->nombre,PDO::PARAM_STR);
        $sentencia->bindValue(':apellido',$this->apellido,PDO::PARAM_STR);
        $sentencia->bindValue(':perfil',$this->perfil,PDO::PARAM_STR);
        $sentencia->bindValue(':foto',$this->foto,PDO::PARAM_STR);
        
        
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
    public static function TraerUno($email,$clave){
        
        
        $objCon=new Conexion();
        $conexion=$objCon->GetConexion();
        $sentencia=$conexion->prepare('SELECT * FROM usuarios WHERE email=:email AND clave=:clave');
        $sentencia->bindValue(':email',$email,PDO::PARAM_STR);
        $sentencia->bindValue(':clave',$clave,PDO::PARAM_STR);
        $sentencia->execute();
        
        if($sentencia->rowCount()>0){
            return true;
        }

        return false;
    }

}

?>