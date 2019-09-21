<?php
use Firebase\JWT\JWT;

require_once ('materia.php');
require_once ('AutenticadorJWT.php');

class ApiMaterias{

/*Agrega un usuario a la bd */
    public static function AgregarMateria($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Mensaje="No se pudo cargar la materia";
        $retorno->Estado=409;
        
        $parametros=$request->getParsedBody();

        $tipo=$parametros['tipo'];
        $nombre=$parametros['nombre'];
        $cuatrimestre=$parametros['cuatrimestre'];
        $cupos=$parametros['cupos'];

        $materia=new Materia($nombre,$cuatrimestre,$cupos);

        if($tipo == "admin"){
            if($materia->Insertar()){

                //$archivos["foto"]->moveTo($destino.$nombreFoto);
                $retorno->Mensaje="Se cargo la materia";
                $retorno->Estado=200;
            }
        }

        return $response->withJson($retorno,$retorno->Estado);

    }


/*Muestra todos los usuarios*/
    public static function MostrarUsuarios($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Mensaje="No hay usuarios para mostrar ";
        
        $usuarios=Usuario::TraerTodos();
        if($usuarios){
            return $response->withJson($usuarios,200);
        }

        return $response->withJson($retorno,409);
    }



/*Crea el token(previamente se valida en mw si existe el usuario)*/
    public static function LoginUsuario($request,$response,$args){
        $retorno=new stdClass();
        
       
        $parametros=$request->getParsedBody();
        $nombre=$parametros['nombre'];
        $clave=$parametros['clave'];
        
        $datos=array("nombre"=>$nombre,"clave"=>$clave);

        $retorno->token=AutenticadorJWT::CrearToken($datos);

        return $response->withJson($retorno,200);

        
    }



/*Verifica si el token esta activo*/
    public static function VerificarJwt($request,$response,$args){
        $retorno=new stdClass();
        $retorno->mensaje="El token esta activo";
       
        $token=$_GET['token'];
        
        AutenticadorJWT::VerificarToken($token);//en caso de fallar lanza excepcion

        return $response->withJson($retorno,200);

        
    }
    
}

?>