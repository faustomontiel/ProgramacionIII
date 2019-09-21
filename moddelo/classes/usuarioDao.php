<?php

    include_once 'classes\accesodatos.php';

    class UsuarioDAO
    {
        public $tipo;
        public $nombre;
        public $clave;
        public $legajo;

        public static function InsertarUsuario( $usuario )
        {
            
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO usuario (legajo,nombre, clave,tipo)"
                                                        . "VALUES(null,
                                                        :nombre, :clave, :tipo)");
            
            $consulta->bindValue(':nombre', $usuario->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $usuario->clave, PDO::PARAM_STR);
            $consulta->bindValue(':tipo', $usuario->tipo, PDO::PARAM_STR);

            $salida = $consulta->execute(); 
        }

        public static function ValidarCredenciales($legajo, $clave)
        {    
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuario WHERE legajo <=>:legajo and clave<=>:clave");        
            $consulta->bindValue(':legajo', $legajo, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $clave, PDO::PARAM_STR);
            $salida = $consulta->execute();
            $usuarioResultado = $consulta->fetchObject('usuarioDao');
            return $usuarioResultado; 
        }

        public static function TraerTodosLosUsuarios()
        {    
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuario");        

            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_CLASS,"usuarioDao"); 
        }

        public static function TraerUsuario($id)
        {    
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuario WHERE legajo <=>:id");        
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_CLASS,"usuarioDao"); 
        }

        public static function EditarUsuarioAlumno($usuario)
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE usuario SET email = :email, foto = :foto WHERE legajo <=>:id");
            $consulta->bindValue(':id', $usuario->legajo, PDO::PARAM_INT);
            $consulta->bindValue(':email', $usuario->email, PDO::PARAM_STR);
            $consulta->bindValue(':foto', $usuario->foto, PDO::PARAM_STR);

            $salida = $consulta->execute();

            return $salida;
        }

        public static function EditarUsuarioProfesor($usuario)
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE usuario SET email = :email WHERE legajo <=>:id");
            $consulta->bindValue(':id', $usuario->legajo, PDO::PARAM_INT);
            $consulta->bindValue(':email', $usuario->email, PDO::PARAM_STR);

            $salida = $consulta->execute();

            return $salida;
        }

    }


?>
