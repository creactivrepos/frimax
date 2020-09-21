<?php

header('Content-Type: application/octet-stream');
header('Content-Transfer-Encoding: Binary'); 
header('Content-disposition: attachment; filename="listaOrdenes.csv"');

class lista{
    public $info;
    public $local;
    public $link;
    public $user;
    public $password;
    public $server;
    public $port;
    public $database;
    public $total_query;

    public function __construct(){
        $this->conect();
    }
    public function getSQL(){
        $sql = 'SELECT controlRecibe.Folio, controlVehiculo.noPedido, controlVehiculo.placa, controlVehiculo.noSerie, controlVehiculo.chasis, controlVehiculo.modelo, controlVehiculo.anio, controlRecibe.fecha, in_clientes.nombre AS nCliente, CONCAT(usuarios.nombre," ",usuarios.paterno," ",usuarios.materno) AS nRecibe, in_sucursales.nombre AS nSucursal, controlRecibe.status, in_estatus.nombre, controlRecibe.fechaEntrega, controlRecibe.fechaTerminado,controlRecibe.diasEstadia,controlRecibe.diasTerminado
        FROM controlRecibe 
        LEFT JOIN controlAdicional ON controlAdicional.idControlRecibe = controlRecibe.id
        LEFT JOIN controlVehiculo ON controlVehiculo.idControlRecibe = controlRecibe.id
        LEFT JOIN in_clientes ON in_clientes.id = controlRecibe.idCliente 
        LEFT JOIN in_estatus ON controlRecibe.proceso = in_estatus.id
        INNER JOIN usuarios ON usuarios.id = controlRecibe.usuarioRecibe
        INNER JOIN in_sucursales ON in_sucursales.id = usuarios.sucursal';

        return $sql;        
    }
    private function conect(){
        date_default_timezone_set("America/Mexico_City");
        $this->local = FALSE;
        if($this->local){
            $this->user         = 'consorcio';
            $this->password     = 'kFdE-ixlWQDG%I1+';
            $this->server       = 'localhost';
            $this->port         = '3306';
            $this->database     = 'recepcion_logistica';
        }
        else{
            $this->user         = 'dbo686363322';
            $this->password     = 'MsEQK#W+!9VV';
            $this->server       = 'db686363322.db.1and1.com';
            $this->port         = '3306';
            $this->database     = 'db686363322';
        }
        $this->link = mysqli_connect($this->server,$this->user, $this->password) or die($this->mysql_error);
        mysqli_select_db( $this->link, $this->database) or die($this->link->error);
    }
    public function query($value){
        $this->total_query++;
        $result = mysqli_query($this->link,$value);
        if (!$result){
            echo 'MySQL Error: '.mysqli_error();
            exit;
        }
        return $result;
    }
    public function fetch_array($value){
        return mysqli_fetch_array($value);
    }
    public function fetch_row($value){
        return mysqli_fetch_row($value);
    }
}

$lista = new lista();
$sql = $lista->getSQL();
$result = $lista->query($sql);
$csv_array = array();
$head_array[0] = array("Folio", "No. Pedido", "Placas", "No. Serie", "Marca", "Modelo", "Año", "Fecha Alta", "Cliente", "Nombre Recibe", "Sucursal", "status", "Estatus Actual", "Fecha Entrega","Fecha Terminado","dias Estadia","dias Terminado");

//var_dump($head_array);
//echo "<br />";
//recorremos los resulados y los volcamos en un array
if($result){
 while($row = $lista->fetch_row($result)){
    $csv_array[] = $row;
}
}

$outputBuffer = fopen("php://output", 'w');

foreach($head_array as $val) {
    fputcsv($outputBuffer, $val);
}

foreach($csv_array as $val) {
    fputcsv($outputBuffer, $val);
}
fclose($outputBuffer);
exit;
?>