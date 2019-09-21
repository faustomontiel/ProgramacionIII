<?php
use Firebase\JWT\JWT;

require_once ('usuario.php');
require_once ('materia.php');
require_once ('AutenticadorJWT.php');

class ApiUsuarios{

/*Agrega un usuario a la bd */
    public static function AgregarUsuario($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Mensaje="No se pudo cargar el usuario";
        $retorno->Estado=409;
        
        $parametros=$request->getParsedBody();

        //$objUsuario=json_decode($parametros['usuario']);
        $nombre=$parametros['nombre'];
        $clave=$parametros['clave'];
        $tipo=$parametros['tipo'];
        //obtengo la foto
        $usuario=new Usuario($nombre,$clave,$tipo);

        if($usuario->Insertar()){

            //$archivos["foto"]->moveTo($destino.$nombreFoto);
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
        $nombre=$parametros['nombre'];
        $clave=$parametros['clave'];
        
        $datos=array("nombre"=>$nombre,"clave"=>$clave);

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

    function ActualizarUsuario(Request $req, Response $res, $args )
    {
        $legajo = $args["legajo"];
        $usuario = Usuario::TraerPorLegajo($legajo);
        $usuarioAEditar = $usuario[0];
        //$decoding = Middleware::validarToken($req,$res);
        //$utipo = $decoding->data;
            if($usuarioAEditar->tipo == "alumno"){
                $dataReceived = $req->getParsedBody();
                $usuarioAEditar->email = $dataReceived['email'];
    
                /*$origen = $_FILES["imageInput"]["tmp_name"];
                $uploadedFileOriginalName = $_FILES["imageInput"]["name"];
                $ext = pathinfo($uploadedFileOriginalName, PATHINFO_EXTENSION);
                $fileDestination = "IMG/".$usuarioAEditar->legajo."_".$usuarioAEditar->nombre.".".$ext;
                move_uploaded_file($origen, $fileDestination);
                */
                //$usuarioAEditar->foto = $fileDestination;
    
                $control = Usuario::EditarUsuarioAlumno($usuarioAEditar);
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
                $materia = Materia::TraerMateria($nombreMateria);
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

?>