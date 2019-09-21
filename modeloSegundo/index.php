<?php
    require_once "vendor\autoload.php";
    require_once "classes\usuarioApi.php";
    require_once "classes\materiaApi.php";
    require_once "classes\middleware.php";

    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;   

    $config["displayErrorDetails"]    = true;
    $config["addContentLengthHeader"] = false;
    $app = new \Slim\App(["settings" => $config]);
    $app->group('/', function(){

        $this->post('usuario[/]', UsuarioApi::class . ":guardarUsuario");
        $this->post('usuario/{legajo}', UsuarioApi::class . ":ActualizarUsuario");
        $this->post('login[/]', UsuarioApi::class . ":loginUsuario")
        ->add(\Middleware::class . '::VerificarEmpty')
        ->add(\Middleware::class . ':VerificarSeteo');
        $this->post('materia[/]', MateriaApi::class . ":guardarMateria")
        ->add(\Middleware::class . ':VerificarAdmin');
        $this->post('inscripcion/{idMateria}', MateriaApi::class . ":InscribirAlumno")
        ->add(\Middleware::class . ':VerificarAlumno');
        $this->get('materias[/]', MateriaApi::class . ":mostrarMaterias");
        $this->get('materias/{id}', MateriaApi::class . ":mostrarMateriasId");        

    });

    $app->run();