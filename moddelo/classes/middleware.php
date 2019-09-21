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
    }

?>