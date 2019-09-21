<?php

    require_once "vendor\autoload.php";
    require_once "classes\usuarioApi.php";
    require_once "classes\materiaApi.php";
    require_once "classes\middleware.php";
    //require_once "classes\historialDao.php";

    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;   

    $config["displayErrorDetails"]    = true;
    $config["addContentLengthHeader"] = false;
    date_default_timezone_set("America/Argentina/Buenos_Aires");
    $app = new \Slim\App(["settings" => $config]);

    $app->group('/', function(){

        $tokenMiddleWare = function(Request $request, Response $response, $next){
            $decoding = Middleware::validarToken($request,$response);

            if( $decoding != "INVALID" )
            {
                $tipo = $decoding->data;
                $response = $next($request->withAttribute('tipo', $tipo),$response);
                return $response;
            }

            $response->write('<br>TOKEN INVALIDO<br>');
            return $response;
        };


        $this->post('usuario[/]', UsuarioApi::class . ":guardarUsuario");
        $this->post('usuario/{legajo}', UsuarioApi::class . ":ActualizarUsuario")->add($tokenMiddleWare);
        $this->post('login[/]', UsuarioApi::class . ":loginUsuario");
        $this->post('materia[/]', MateriaApi::class . ":guardarMateria")->add($tokenMiddleWare);
        $this->post('inscripcion/{idMateria}', MateriaApi::class . ":InscribirAlumno")->add($tokenMiddleWare);
        $this->get('materias[/]', MateriaApi::class . ":mostrarMaterias")->add($tokenMiddleWare);        

    });

    $app->run();