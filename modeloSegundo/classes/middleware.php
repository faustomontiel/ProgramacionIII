<?php
    use \Firebase\JWT\JWT;
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;   

    class Middleware
    {
        public static function validarToken(Request $req, Response $res){
            $packageReceived = $req->getHeader('token');
    
            if(empty($packageReceived[0]) || $packageReceived[0] === ""){
                throw new Exception("TOKEN VACIO");
            }
            
            try {
                $decode = JWT::decode($packageReceived[0],'serverkey',['HS256']);
        
                return $decode;
            } catch ( Exception $th) {
                
                return "INVALID";
            }
    
        }
        public static function VerificarAdmin($request,$response,$next){
            
            $retorno=new stdClass();
            $retorno->mensaje="No es ADMIN";
        
            $decoding = self::validarToken($request,$response);
            $utipo = $decoding->data;
            
            if($utipo == "admin"){
                        
                $response=$next($request,$response);
                return $response;
            }
            
            return $response->withJson($retorno->mensaje,409);
    
        }
        public static function VerificarAlumno($request,$response,$next){
            
            $retorno=new stdClass();
            $retorno->mensaje="No es ALUMNO";
        
            $decoding = self::validarToken($request,$response);
            $utipo = $decoding->data;
            
            if($utipo == "alumno"){
                        
                $response=$next($request,$response);
                return $response;
            }
            
            return $response->withJson($retorno->mensaje,409);
    
        }
    public function VerificarSeteo($request,$response,$next){
        $retorno=new stdClass();
        $retorno->mensaje="";
        
        if(isset($_POST['legajo']) && isset($_POST['clave'])){

            $response=$next($request,$response);
            return $response;
        }
        if(!isset($_POST['legajo']) && isset($_POST['clave'])){

            $retorno->mensaje="Debe ingresar el legajo";
            return $response->withJson($retorno,409);

        }else{

            if(isset($_POST['legajo']) && !isset($_POST['clave'])){

                $retorno->mensaje="Debe ingresar la clave";
                return $response->withJson($retorno,409);

            }else{
                $retorno->mensaje="Debe ingresar legajo y clave";
                return $response->withJson($retorno,409);
            }
        }
        

        return $response;
    }



    /*Si lo campos "email" y "clave" estan cargados pasa al siguiente callable*/ 

    public static function VerificarEmpty($request,$response,$next){
        $retorno=new stdClass();
        $retorno->mensaje="";
        
        if(!empty($_POST['legajo']) && !empty($_POST['clave'])){

            $response=$next($request,$response);
            return $response;
        }
        if(empty($_POST['legajo']) && !empty($_POST['clave'])){

            $retorno->mensaje="El campo legajo esta vacio";
            return $response->withJson($retorno,409);

        }else{

            if(!empty($_POST['legajo']) && empty($_POST['clave'])){

                $retorno->mensaje="El campo clave esta vacio";
                return $response->withJson($retorno,409);

            }else{
                $retorno->mensaje="Los campos legajo y clave estan vacios";
                return $response->withJson($retorno,409);
            }
        }
        

        return $response;
    
    }
    





    }

?>