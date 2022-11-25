<?php 
class Conexion{
    public function conectar(){
        $servername = '192.168.1.195, 1433';
        $connectioninfo = array ("Database"=>"SBDAMODS", "UID"=>"sa", "PWD"=>"@Bejerman", "CharacterSet"=> "UTF-8");
        $conPagos  = sqlsrv_connect($servername, $connectioninfo);
        return $conPagos ;
    }

}
?>