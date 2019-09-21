<?php
use Firebase\JWT\JWT;

require_once ('Usuario.php');
require_once ('AutenticadorJWT.php');

class ApiUsuario{

/*Agrega un usuario a la bd */
    public static function AgregarUsuario($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Mensaje="No se pudo cargar el usuario";
        $retorno->Estado=409;
        
        $parametros=$request->getParsedBody();
        $objUsuario=json_decode($parametros['usuario']);
        //obtengo la foto
        $archivos= $request->getUploadedFiles();
        $foto=$archivos['foto']->getClientFilename();
        //extension
        $extension= explode(".", $foto);
        $extension=array_reverse($extension);
        $nombreFoto=$objUsuario->email.".".$extension[0];//guardo por email
        $destino="./fotos/usuariosRegistrados/";

        $usuario=new Usuario(null,$objUsuario->email,$objUsuario->clave,$objUsuario->nombre,$objUsuario->apellido,$objUsuario->perfil,$nombreFoto);

        if($usuario->Insertar()){

            $archivos["foto"]->moveTo($destino.$nombreFoto);
            $retorno->Mensaje="Se cargo el usuario";
            $retorno->Estado=200;
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
        $email=$parametros['email'];
        $clave=$parametros['clave'];
        
        $datos=array("email"=>$email,"clave"=>$clave);

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