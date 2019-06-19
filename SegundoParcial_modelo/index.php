<?php
	//namespace Firebase\JWT;
    //use \Firebase\JWT\JWT;
    //include_once ("./POO/accesoDatos.php");
    //include_once ("./POO/user.php");
    require "./POO/accesoDatos.php";
    require "./POO/user.php";
    require "vendor/autoload.php";
    
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Psr\Http\Message\ResponseInterface as Response;
	$app = new \Slim\App;

	$app->post('/usuario', function (Request $request, Response $response) {

        try{
            
            $datos=$request->getParsedBody(); 
            
            $miUser = new User($datos['nombre'],$datos['clave'],$datos['sexo'],"usuario");        
            $miUser->InsertarElUser();


        }catch(Exception $exception)
		{
			throw new Exception("error ",$exception);
		}
});
    
$app->post('/login', function (Request $request, Response $response) {

    try{
        
        $datos=$request->getParsedBody(); 
        
        $miUser = new User($datos['nombre'],$datos['clave'],$datos['sexo'],"usuario");        
        $esta = $miUser->TraerElUser($datos['nombre']);

        var_dump($esta);
       /* if($esta == 1){
            echo "okk";
        }else{
            echo "Usuario inexistente";
        }*/

        
    }catch(Exception $exception)
    {
        throw new Exception("error ",$exception);
    }
});




$app->run();
?>