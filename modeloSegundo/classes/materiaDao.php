<?php

    include_once 'classes\accesodatos.php';

    class MateriaDao
    {
        public $id;
        public $nombre;
        public $cuatrimestre;
        public $cupos;

        public static function InsertarMateria( $materia )
        {
            
            try{
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO materia (id,nombre, cuatrimestre,cupos)"
                                                            . "VALUES(null,
                                                                :nombre, :cuatrimestre, :cupos)");
            $consulta->bindValue(':nombre', $materia->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':cuatrimestre', $materia->cuatrimestre, PDO::PARAM_STR);
            $consulta->bindValue(':cupos', $materia->cupos, PDO::PARAM_INT);
            $salida = $consulta->execute();
            return $salida;
            }
            catch( exception $ex ){
                return "FAILURE";
            }
        }

        public static function TraerMateria($materia)
        {    
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM materia WHERE nombre <=>:materia");        
            $consulta->bindValue(':materia', $materia, PDO::PARAM_STR);
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_CLASS,"materiaDao"); 
        }

        public static function TraerMateriaId($materia)
        {    
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM materia WHERE id <=>:id");        
            $consulta->bindValue(':id', $materia, PDO::PARAM_INT);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_CLASS,"materiaDao"); 
        }

        public static function TraerMateriaIdProfesor($profesor)
        {    
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM materia WHERE legajo_profesor <=>:legajo_profesor");        
            $consulta->bindValue(':legajo_profesor', $profesor, PDO::PARAM_INT);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_CLASS,"materiaDao"); 
        }
        
        public static function TraerTodasLasMaterias()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM materia");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_CLASS,"materiaDao"); 
        }
        
        public static function TraerTodasLasMateriasAlumno($alumno)
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT materia.nombre FROM materia_alumno, materia WHERE materia.id = materia_alumno.materia_id AND materia_alumno.alumno_id <=> :alumno_id");
            $consulta->bindValue(':alumno_id', $alumno, PDO::PARAM_INT);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_CLASS,"materiaDao"); 
        }

        public static function EditarMateriaProfesor($materia)
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE materia SET legajo_profesor = :legajo_profesor WHERE id <=>:id");
            $consulta->bindValue(':id', $materia->id, PDO::PARAM_INT);
            $consulta->bindValue(':legajo_profesor', $materia->legajoProfesor, PDO::PARAM_STR);

            $salida = $consulta->execute();

            return $salida;
        }

        public static function EditarMateria($materia)
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE materia SET cupos = :cupos WHERE id <=>:id");
            $consulta->bindValue(':id', $materia->id, PDO::PARAM_INT);
            $consulta->bindValue(':cupos', $materia->cupos, PDO::PARAM_INT);

            $salida = $consulta->execute();

            return $salida;
        }

       
    }
    