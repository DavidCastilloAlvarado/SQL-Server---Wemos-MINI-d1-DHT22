<?php
//Autor: David Castillo Alvarado
//Documento: Introduce información directamente al servidor
//Fuente: http://php.net/

require_once ('conectar1.php');
$conexion = conectar1();

$Serie       = $_POST ['serie'];
$Temperatura = $_POST ['temp'];



mysqli_query($conexion, "INSERT INTO `data` (`id`, `fecha`, `Serie`, `Temperatura`) VALUES (NULL, CURRENT_TIMESTAMP, '$Serie', '$Temperatura');");

mysqli_close($conexion);

echo "Datos ingresados correctamente";

?>