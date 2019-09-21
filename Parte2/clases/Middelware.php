<?php
use Slim\Http\Message;
require_once ('Usuario.php');
require_once ('Media.php');

class MW{


    /*Si lo campos existen pasa al siguiente callable*/ 

    public function VerificarSeteo($request,$response,$next){
        $retorno=new stdClass();
        $retorno->mensaje="";
        
        if(isset($_POST['email']) && isset($_POST['clave'])){

            $response=$next($request,$response);
            return $response;
        }
        if(!isset($_POST['email']) && isset($_POST['clave'])){

            $retorno->mensaje="Debe ingresar el email";
            return $response->withJson($retorno,409);

        }else{

            if(isset($_POST['email']) && !isset($_POST['clave'])){

                $retorno->mensaje="Debe ingresar la clave";
                return $response->withJson($retorno,409);

            }else{
                $retorno->mensaje="Debe ingresar email y clave";
                return $response->withJson($retorno,409);
            }
        }
        

        return $response;
    }



    /*Si lo campos "email" y "clave" estan cargados pasa al siguiente callable*/ 

    public static function VerificarEmpty($request,$response,$next){
        $retorno=new stdClass();
        $retorno->mensaje="";
        
        if(!empty($_POST['email']) && !empty($_POST['clave'])){

            $response=$next($request,$response);
            return $response;
        }
        if(empty($_POST['email']) && !empty($_POST['clave'])){

            $retorno->mensaje="El campo email esta vacio";
            return $response->withJson($retorno,409);

        }else{

            if(!empty($_POST['email']) && empty($_POST['clave'])){

                $retorno->mensaje="El campo clave esta vacio";
                return $response->withJson($retorno,409);

            }else{
                $retorno->mensaje="Los campos email y clave estan vacios";
                return $response->withJson($retorno,409);
            }
        }
        

        return $response;
    }



    /*Si el usuario existe pasa al siguiente callable.(verifica por email)*/ 

    public function VerificarExistencia($request,$response,$next){

        $retorno=new stdClass();
        $retorno->mensaje="El usuario no existe";
       
        $parametros=$request->getParsedBody();
        $email=$parametros['email'];
        $clave=$parametros['clave'];
        
        if(Usuario::TraerUno($email,$clave)){

            $response=$next($request,$response);//existe 
            return $response;
        }else{

            return $response->withJson($retorno,409);
        }

        return $response;

    }



    /*Si el token no está vencido, pasa al siguiente callable*/ 

    public function VerificarJwt($request,$response,$next){
            
        $retorno=new stdClass();
        
        $parametros=$request->getParsedBody();
        $token=$parametros['token'];
        
            
        try{
            AutenticadorJWT::VerificarToken($token);//en caso de fallar lanza excepcion
            $response=$next($request,$response);
            return $response;

        }catch(Exception $e){
            $retorno->error=$e->getMessage();
            return $response->withJson($retorno,409);
        }
        return $response;

    }



    
    
    /*Si el usuario(perfil) es encargado pasa al siguiente callable*/ 

    public static function VerificarPropietario($request,$response,$next){
            
        $retorno=new stdClass();
        $retorno->mensaje="No es propietario";
        $parametros=$request->getParsedBody();
        $token=$parametros['token'];
        
        
        $datos=AutenticadorJWT::ObtenerData($token);
        
        $perfilUsuario=Usuario::TraerPerfil($datos->email);

        /*si viene por put verifico que sea propietario o encargado*/
        if($request->IsPut()){

            if($perfilUsuario[0]['perfil']=='propietario' || $perfilUsuario[0]['perfil']=='encargado'){

                $response=$next($request,$response);
                return $response;
            }else{
                $retorno->mensaje="Debe ser propietario o encargado";
                return $response->withJson($retorno->mensaje,409);
            }
        }
        
        if($perfilUsuario[0]['perfil']=='propietario'){

            $response=$next($request,$response);
            return $response;
        }
        
        
        return $response->withJson($retorno->mensaje,409);

    }

    
    
    /*Si el usuario(perfil) es encargado pasa al siguiente callable*/ 

    public static function VerificarEncargado($request,$response,$next){
            
        $retorno=new stdClass();
        $retorno->mensaje="No es encargado";
        $parametros=$request->getParsedBody();
        $token=$parametros['token'];
        
        
        $datos=AutenticadorJWT::ObtenerData($token);
        $perfilUsuario=Usuario::TraerPerfil($datos->email);

        if($perfilUsuario[0]['perfil']=='encargado'){

            $response=$next($request,$response);
            return $response;
        }
        
        
        return $response->withJson($retorno->mensaje,409);

    }

    
    
    /*Si es encargado muetra todas las medias sin ID y pasa al siguiente callable(mostrarColores)*/

    public function MostrarPorEncargado($request,$response,$next){

        //$parametros=$request->getParsedBody();
        $token=$_GET['token'];
        
        
        $datos=AutenticadorJWT::ObtenerData($token);
        $perfilUsuario=Usuario::TraerPerfil($datos->email);

        if($perfilUsuario[0]['perfil']=='encargado'){

            $arrayMedias=Media::TraerTodos();
            $arrayRetorno=array();
            foreach($arrayMedias as $media){

                $m=new stdClass();
                $m->marca=$media['marca'];
                $m->color=$media['color'];
                $m->precio=$media['precio'];
                $m->talle=$media['talle'];

                array_push($arrayRetorno,$m);
            }

            $response->getBody()->write(json_encode($arrayRetorno));
            $response=$next($request,$response);
  
        }

        $response=$next($request,$response);
        return $response;
    }

    
    
    /*Filtra los colores distintos*/

    public function MostrarColores($request,$response,$next){

        $token=$_GET['token'];
        $datos=AutenticadorJWT::ObtenerData($token);
        $perfilUsuario=Usuario::TraerPerfil($datos->email);

        if($perfilUsuario[0]['perfil']=='encargado'){
            $arrayMedias=Media::TraerTodos();
            $arrayRetorno=array();
            
            foreach($arrayMedias as $media){

                $esta=false;

                if(count($arrayRetorno)==0){
                    array_push($arrayRetorno,$media['color']);
                    continue;
                }

                for($i=0;$i<count($arrayRetorno);$i++){

                    if($arrayRetorno[$i]===$media['color']){

                        $esta=true;
                        break;
                    }
                }

                if($esta){

                    continue;
                }else{
                    $esta=false;
                    array_push($arrayRetorno,$media['color']);
                }

            }

            $response->getBody()->write("\nColores distintos: ".json_encode($arrayRetorno));
            return $response;

        }

        $response=$next($request,$response);
        return $response;

    }

   
   
    /*Si es propietario y se ingresa ID muestra uno, sino va a la api y muestra todos*/

    public function MostrarPorPropietario($request,$response,$next){

        //$parametros=$request->getParsedBody();
        $token=$_GET['token'];
        
        
        $datos=AutenticadorJWT::ObtenerData($token);
        $perfilUsuario=Usuario::TraerPerfil($datos->email);

        if($perfilUsuario[0]['perfil']=='propietario'){

            if(isset($_GET['id']) && !empty($_GET['id'])){

                $media=Media::TraerUno($_GET['id']);
                return $response->withJson($media,200);
            }
            
            $response=$next($request,$response);
  
        }

        return $response;

        

    }



   
    /*Muestra tabla de los usuarios si tiene como param "tabla=si"*/
    public function MostrarTabla($request,$response,$next){

        if(isset($_GET['tabla']) && !empty($_GET['tabla'])){

            if($_GET['tabla']=='si'){

                $arrayUsuarios=Usuario::TraerTodos();
                $tabla="<table border='1'><tr><td>ID</td><td>NOMBRE</td><td>APELLIDO</td><td>PERFIL</td><td>FOTO</td></tr>";
                foreach($arrayUsuarios as $usuario){

                    $tabla.="<tr><td>".$usuario['id']."</td><td>".$usuario['nombre']."</td><td>".$usuario['apellido']."</td><td>".$usuario['perfil']."</td><td><img src='fotos/usuariosRegistrados/".$usuario['foto']."' width=100 height=100></img></td></tr>";
                    
                }

                $tabla.="</table>";

                $response->getBody()->write($tabla);

            }else{
                $response=$next($request,$response);
            }
        }else{
            $response=$next($request,$response);
        }

        return $response;

        

    }


}

       





?>