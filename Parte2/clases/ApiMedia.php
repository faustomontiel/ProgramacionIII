<?php
require_once ('Media.php');
use Firebase\JWT\JWT;

class ApiMedia{

/*Agrega una media a la BD*/
    public static function AgregarMedia($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Mensaje="No se pudo cargar ";
        $retorno->Estado=409;
        $retorno->Exito=false;

        $param=$request->getParsedBody();
        //$media=new Media(null,$param['color'],$param['marca'],$param['precio'],$param['talle']);
        $objMedia=json_decode($param['media']);
        $media=new Media(null,$objMedia->color,$objMedia->marca,$objMedia->precio,$objMedia->talle);

        if($media->Insertar()){

            $retorno->Mensaje="Se cargo";
            $retorno->Estado=200;
            $retorno->Exito=true;
        }
        
        return $response->withJson($retorno,$retorno->Estado);
    }

/*Muestra todas las medias cargadas en la BD*/
    public static function MostrarMedias($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Mensaje="No hay medias para mostrar ";
        $retorno->Estado=409;
        
        $medias=Media::TraerTodos();
        if($medias){//ver si devuelve false si no hay medias
            
            return $response->withJson($medias,200);
        }

        return $response->withJson($retorno,$retorno->Estado);
        
        
    }

/*Elimina una media por ID de la BD*/
    public static function EliminarMedia($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Mensaje="No se pudo borrar";
        

        $param=$request->getParsedBody();
        $id=$param['id'];

        if(Media::Eliminar($id)){
            $retorno->Mensaje="Se borro la media con id: ".$id.".";
            return $response->withJson($retorno,200);
        }

        return $response->withJson($retorno,409);
        
        
    }

/*Modifica una media por ID de la bd*/
    public static function ModificarMedia($request,$response,$args){

        $retorno=new stdClass();
        $retorno->Mensaje="No se pudo modificar. Verifique el ID ingresado";

        $param=$request->getParsedBody();
        $media=new Media();
        $media->id=$param['id'];
        $media->marca=$param['marca'];
        $media->color=$param['color'];
        $media->precio=$param['precio'];
        $media->talle=$param['talle'];
        //var_dump($media);
        if($media->Modificar()){
            $retorno->Mensaje="Se modifico la media con ID ".$media->id;
            return $response->withJson($retorno,200);
        }

        return $response->withJson($retorno,409);

    }


    
}


?>