<?php
include_once ("accesoDatos.php");
include_once ("user.php");
$op = isset($_POST['op']) ? $_POST['op'] : NULL;
switch ($op) {
    /*case 'accesoDatos':
    
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->RetornarConsulta("select titel AS titulo, interpret AS interprete, jahr AS anio "
                                                        . "FROM cds");
        $consulta->execute();
        
        $consulta->setFetchMode(PDO::FETCH_INTO, new cd);
        
        foreach ($consulta as $cd) {
        
            print_r($cd->MostrarDatos());
            print("
                    ");
        }
        break;
 
    case 'mostrarTodos':
        $cds = cd::TraerTodosLosCd();
        
        foreach ($cds as $cd) {
            
            print_r($cd->MostrarDatos());
            print("
                    ");
        }

        break;*/
    case 'insertaUser':
    
        $miUser = new user();
        $miUser->nombre = "admin";
        $miUser->clave = "admin";
        $miUser->sexo = "femenino";
        $miUser->perfil = "admin";
        
        $miUser->InsertarElUser();
        echo "ok";
        
        break;/*
    case 'modificarCd':
    
        $id = $_POST['id'];        
        $titulo = $_POST['titulo'];
        $anio = $_POST['anio'];
        $interprete = $_POST['interprete'];
    
        echo cd::ModificarCD($id, $titulo, $anio, $interprete);
            
        break;
    case 'eliminarCd':
    
        $miCD = new cd();
        $miCD->id = 66;
        
        $miCD->EliminarCD($miCD);
        echo "ok";
        
        break;
        */
        
    default:
        echo ":(";
        break;
}
?>