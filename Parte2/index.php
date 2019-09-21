<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;

require_once './vendor/autoload.php';
require_once './clases/ApiMedia.php';
require_once './clases/ApiUsuario.php';
require_once './clases/Middelware.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
$app = new \Slim\App(["settings" => $config]);


$app->post('[/]',ApiMedia::class . '::AgregarMedia');

$app->get('/medias[/]',ApiMedia::class . '::MostrarMedias')->add(\MW::class . '::MostrarPorPropietario')->add(\MW::class . ':MostrarColores')->add(\MW::class . ':MostrarPorEncargado');

$app->post('/usuarios[/]',ApiUsuario::class . '::AgregarUsuario');

$app->get('/',ApiUsuario::class . '::MostrarUsuarios')->add(\MW::class . '::MostrarTabla');

$app->post('/login[/]',ApiUsuario::class . '::LoginUsuario')->add(\MW::class . ':VerificarExistencia')->add(\MW::class . '::VerificarEmpty')->add(\MW::class . ':VerificarSeteo');
$app->get('/login[/]',ApiUsuario::class . '::VerificarJwt');


$app->delete('[/]',ApiMedia::class . '::EliminarMedia')->add(\MW::class . '::VerificarPropietario')->add(\MW::class . ':VerificarJwt');
$app->put('[/]',ApiMedia::class . '::ModificarMedia')->add(\MW::class . '::VerificarPropietario')->add(\MW::class . ':VerificarJwt');

$app->run();


?>