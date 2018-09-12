<?php
//Autor: David Castillo Alvarado
//Documento: Estable la conexión con el servidos local
//Fuente: http://php.net/


function conectar1 () {
		$conexion = mysqli_connect("localhost", "root", "scarecrow101");
		mysqli_select_db($conexion ,"registro_temp");
		mysqli_query($conexion,"SET NAME 'utf8'");
		return $conexion;
}

?>