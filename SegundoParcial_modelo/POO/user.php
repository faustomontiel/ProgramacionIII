<?php
class User
{
    public $nombre;
    public $clave;
    public $sexo;
    public $perfil;
    public function __construct($nombre, $clave,$sexo,$perfil)
	{
		$this->nombre = $nombre;
        $this->clave = $clave;
        $this->sexo = $sexo;
        $this->perfil = $perfil;
	}
     
    public static function TraerElUser($nombre)
    {    
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT COUNT(*) FROM user WHERE nombre = :nombre");        
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);       
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_NUM);
                                                
        return $consulta; 
    }
    
    public function InsertarElUser()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO user (nombre, clave, sexo, perfil)"
                                                    . "VALUES(:nombre, :clave, :sexo, :perfil)");
        
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':sexo', $this->sexo, PDO::PARAM_STR);
        $consulta->bindValue(':perfil', $this->perfil, PDO::PARAM_STR);
        $consulta->execute();   
    }
    /*
    public static function ModificarCD($id, $titulo, $anio, $cantante)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE cds SET titel = :titulo, interpret = :cantante, 
                                                        jahr = :anio WHERE id = :id");
        
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':titulo', $titulo, PDO::PARAM_INT);
        $consulta->bindValue(':anio', $anio, PDO::PARAM_INT);
        $consulta->bindValue(':cantante', $cantante, PDO::PARAM_STR);
        return $consulta->execute();
    }
    public static function EliminarCD($cd)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM cds WHERE id = :id");
        
        $consulta->bindValue(':id', $cd->id, PDO::PARAM_INT);
        return $consulta->execute();
    }
    */
}
?>