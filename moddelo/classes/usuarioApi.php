<?php
require_once "usuarioDao.php";
require_once "materiaDao.php";
require_once "usuario.php";

use \Firebase\JWT\JWT;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;   

class UsuarioApi
{
    public function guardarUsuario( Request $req, Response $res, $args)
     {
        try
        {
            $dataReceived       = $req->getParsedBody();
            if(sizeof($dataReceived) < 2){
                return $res->write("No se recibieron datos. O los datos son insuficientes.");
            }elseif ($dataReceived['tipo']!= "profesor" && $dataReceived['tipo']!= "alumno" && $dataReceived['tipo']!= "admin") {
                return $res->write("Tipo de usuario incorrecto");
            }

            $usuario = new Usuario($dataReceived["nombre"], $dataReceived["clave"],$dataReceived['tipo'] ?? "alumno" );
            UsuarioDAO::InsertarUsuario($usuario);
            return $res->write("Usuario Guardado con Exito.");
        } catch( exception $e ) {
            print "Error!!!<br/>" . $e->getMessage();
            die();
        }
    }

    public function loginUsuario( Request $req, Response $res, $args) {

        $dataReceived       = $req->getParsedBody();

        if(sizeof($dataReceived) < 2){
            return $res->write("No se recibieron datos. O los datos son insuficientes.");
        }

        $legajo = $dataReceived['legajo'];
        $password = $dataReceived['clave'];


        $salida = UsuarioDao::ValidarCredenciales($legajo,$password);

        if($salida){

            $currentTime = time();
            $payload = array(
                'iat' => $currentTime,
                'exp' => $currentTime+3600,
                'data' => $salida->tipo,
                'legajo' => $salida->legajo
            );
            $token = JWT::encode($payload,'serverkey');

            return $res->write($token);
        }
        else{
            return $res->write("Credenciales Incorrectas");
        }
        
    }

    function ActualizarUsuario(Request $req, Response $res, $args )
    {
        $legajo = $args["legajo"];;
        $usuario = UsuarioDAO::TraerUsuario($legajo);
        $usuarioAEditar = $usuario[0];
        $decoding = Middleware::validarToken($req,$res);
        $utipo = $decoding->data;
        if($utipo == "admin"){
            if($usuarioAEditar->tipo == "alumno"){
                $dataReceived = $req->getParsedBody();
                $usuarioAEditar->email = $dataReceived['email'];
    
                $origen = $_FILES["imageInput"]["tmp_name"];
                $uploadedFileOriginalName = $_FILES["imageInput"]["name"];
                $ext = pathinfo($uploadedFileOriginalName, PATHINFO_EXTENSION);
                $fileDestination = "IMG/".$usuarioAEditar->legajo."_".$usuarioAEditar->nombre.".".$ext;
                move_uploaded_file($origen, $fileDestination);
    
                $usuarioAEditar->foto = $fileDestination;
    
                $control = UsuarioDAO::EditarUsuarioAlumno($usuarioAEditar);
                if($control){
                    return $res->write("Alumno Editado");   
                }
                else {
                    return $res->write("Ha ocurrido un error");   
                }
    
            }elseif ($usuarioAEditar->tipo == "profesor") {
                $dataReceived = $req->getParsedBody();
                $usuarioAEditar->email = $dataReceived['email'];
                $nombreMateria = $dataReceived['nombreMateria'];
                $materia = MateriaDao::TraerMateria($nombreMateria);
                $materiaAEditar = $materia[0];
                $materiaAEditar->legajoProfesor = $usuarioAEditar->legajo;

                $control = UsuarioDao::EditarUsuarioProfesor($usuarioAEditar);
                if($control){
                    $controlMateria = MateriaDao::EditarMateriaProfesor($materiaAEditar);
                    if($controlMateria){
                        return $res->write("Profesor Editado");
                    }else {
                        return $res->write("Ha ocurrido un error 2");                       
                    }
                }else {
                    return $res->write("Ha ocurrido un error");                       
                }
            }else {
                $dataReceived = $req->getParsedBody();
                $usuarioAEditar->email = $dataReceived['email'];
                $nombreMateria = $dataReceived['nombreMateria'];

                $origen = $_FILES["imageInput"]["tmp_name"];
                $uploadedFileOriginalName = $_FILES["imageInput"]["name"];
                $ext = pathinfo($uploadedFileOriginalName, PATHINFO_EXTENSION);
                $fileDestination = "IMG/".$usuarioAEditar->legajo."_".$usuarioAEditar->nombre.".".$ext;
                move_uploaded_file($origen, $fileDestination);
    
                $usuarioAEditar->foto = $fileDestination;

                $materia = MateriaDao::TraerMateria($nombreMateria);
                $materiaAEditar = $materia[0];
                $materiaAEditar->legajoProfesor = $usuarioAEditar->legajo;

                $control = UsuarioDao::EditarUsuarioAlumno($usuarioAEditar);
                if($control){
                    $controlMateria = MateriaDao::EditarMateriaProfesor($materiaAEditar);
                    if($controlMateria){
                        return $res->write("Admin Editado");
                    }else {
                        return $res->write("Ha ocurrido un error 2");                       
                    }
                }else {
                    return $res->write("Ha ocurrido un error");                       
                }  
            }
        }
        
    }
}