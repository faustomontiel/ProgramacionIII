<?php

    include_once 'classes\accesodatos.php';

    class AlumnoMateriaDao
    {
        public $id;
        public $alumnoId;
        public $materiaId;

        public  static function insertarMAlumnoMateria($alumnoMateria)
        {
            try{
                $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    
                $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO materia_alumno (id,alumno_id, materia_id)"
                                                                . "VALUES(null,
                                                                    :alumno_id, :materia_id)");
                $consulta->bindValue(':alumno_id', $alumnoMateria->alumnoId, PDO::PARAM_INT);
                $consulta->bindValue(':materia_id', $alumnoMateria->materiaId, PDO::PARAM_INT);
                $salida = $consulta->execute();
                return $salida;
                }
                catch( exception $ex ){
                    return "FAILURE";
                }
        }

        public static function traerMateriasPorAlumno($alumno){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM materia_alumno WHERE alumno_id <=> :alumno");
            $consulta->bindValue(':alumno', $alumno, PDO::PARAM_INT);
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_CLASS,"AlumnoMateriaDao"); 
        }
    }
    