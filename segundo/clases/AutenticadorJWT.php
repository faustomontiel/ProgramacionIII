<?php
use Firebase\JWT\JWT;
class AutenticadorJWT
{
    private static $miClaveSecreta = '123';
    private static $tipoEncriptacion = ['HS256'];
    private static $aud = null;
    
      
    public static function CrearToken($datos)
    {
        $ahora = time(); //Variable de tiempo para poder expirar el token
        
        $payload = array(
              'iat'=>$ahora,
              'exp' => $ahora + 190000000000000,
              //'aud' => self::Aud(),
              'data' => $datos,
              'app'=> "API REST PARA COMANDA 2018"
          );
       
        return JWT::encode($payload, self::$miClaveSecreta);
    }
      
    public static function VerificarToken($token)
    {
        
        if (empty($token)|| $token=="") {
            throw new Exception("El token esta vacio.");
        }
        try {
            //var_dump($token); die();
            $decodificado = JWT::decode($token, self::$miClaveSecreta, self::$tipoEncriptacion);

            return true;
        } catch (ExpiredException $e) { //En caso de token invalido o fuera de tiempo (regularmente solo la segunda)
            throw new Exception("Clave fuera de tiempo\n".($e->getMessage()));
        }

        return false;

    }

    public static function ObtenerPayLoad($token)
    {
        return JWT::decode($token, self::$miClaveSecreta, self::$tipoEncriptacion);
    }

    public static function ObtenerData($token)
    {
        $payload = AutenticadorJWT::ObtenerPayLoad($token);
        return $payload->data;
    }
}