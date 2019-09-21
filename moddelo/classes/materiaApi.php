<?php

    require_once "materiaDao.php";
    require_once "materia.php";
    require_once "materiaAlumnoDao.php";
    require_once "materiaAlumno.php";
    require_once "usuarioDao.php";
    require_once "usuario.php";

    use \Firebase\JWT\JWT;
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    class materiaApi
    {
        public function guardarMateria( Request $req, Response $res, $args)
        {
            try
            {
                $dataReceived       = $req->getParsedBody();

                if(sizeof($dataReceived) < 2){
                    return $res->write("No se recibieron datos. O los datos son insuficientes.");
                }
                $decoding = Middleware::validarToken($req,$res);
                $utipo = $decoding->data;
                if($utipo == "admin"){
                    
                    $materia = new Materia($dataReceived["nombre"], $dataReceived["cuatrimestre"],$dataReceived["cupos"]);
                    $valor = MateriaDao::InsertarMateria($materia);
                    if($valor)
                    return $res->write("Materia Guardada con Exito.");
                    else
                    return $res->write("Materia no ha podido guardarse.");

                }else {
                    return $res->write("Usted no es admin.");

                }
                
            } catch( exception $e ) {
                print "Error!!!<br/>" . $e->getMessage();
                die();
            }
        }

        public static function InscribirAlumno(Request $req, Response $res, $args)
        {
            $decoding = Middleware::validarToken($req,$res);
            $utipo = $decoding->data;

            if($utipo == "admin"){
                $dataReceived       = $req->getParsedBody();
                $materia = $args['idMateria'];
                $usuario = $dataReceived['usuarioLegajo'];
                $usuariodb = UsuarioDAO::TraerUsuario($usuario);
                $materiadb = MateriaDao::TraerMateriaId($materia);
                $materiaAInscribir = $materiadb[0];
                $usuarioAInscribir = $usuariodb[0];
                if($materiaAInscribir->cupos != 0 && $usuarioAInscribir->tipo == "alumno"){
                    $materiaAlumno = new MateriaAlumno($materiaAInscribir->id, $usuarioAInscribir->legajo);
                    $control = AlumnoMateriaDao::insertarMAlumnoMateria($materiaAlumno);
                    if ($control) {
                        $materiaAInscribir->cupos = $materiaAInscribir->cupos -1;
                        $control = MateriaDao::EditarMateria($materiaAInscribir);
                        return $res->write("Alumno inscripto en la materia " . $materiaAInscribir->nombre);    
                    }
                    else {
                        return $res->write("Error al inscribir el alumno");
                    }
                }
                else {
                    return $res->write("No hay cupo");
                }
            }            
        }

        public static function mostrarMaterias(Request $req, Response $res, $args)
        {
            $decoding = Middleware::validarToken($req,$res);
            $utipo = $decoding->data;
            $ulegajo = $decoding->legajo;
            if ($utipo = "admin") {
                $materias = MateriaDao::TraerTodasLasMaterias();
                return $materias;
            }
            elseif ($utipo = "profesor") {
                $materia = MateriaDao::TraerMateriaIdProfesor($ulegajo);
                return $materia->nombre;
            }
            else {
                # code...
            }
        }
    }
    