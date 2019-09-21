<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;

require_once './vendor/autoload.php';
require_once './clases/ApiMaterias.php';
require_once './clases/ApiUsuarios.php';
require_once './clases/Middelware.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
$app = new \Slim\App(["settings" => $config]);

$app->post('/usuarios[/]',ApiUsuarios::class . '::AgregarUsuario');

$app->post('/login[/]',ApiUsuarios::class . '::LoginUsuario')->add(\MW::class . ':VerificarExistencia')->add(\MW::class . '::VerificarEmpty')->add(\MW::class . ':VerificarSeteo');

$app->post('/materia[/]',ApiMaterias::class . '::AgregarMateria');

$app->post('/usuarios/{legajo}',ApiUsuarios::class . '::AgregarUsuario');
//$app->get('/login[/]',ApiUsuario::class . '::VerificarJwt');
/*

$app->delete('[/]',ApiMedia::class . '::EliminarMedia')->add(\MW::class . '::VerificarPropietario')->add(\MW::class . ':VerificarJwt');
$app->put('[/]',ApiMedia::class . '::ModificarMedia')->add(\MW::class . '::VerificarPropietario')->add(\MW::class . ':VerificarJwt');
*/
$app->run();


?>