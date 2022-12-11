<?php 
session_start();

use Carbon\Carbon;

require '../vendor/autoload.php';

$fecha = obtener_post('fecha');
$hora = obtener_post('horas');
$id_usuario = \App\Tablas\Usuario::logueado()->id;

$fechaActual = Carbon::now()->locale('es_ES')->setTimezone('Europe/Madrid');


// Solicitud de citas

$pdo = $pdo ?? conectar();
$sent = $pdo->prepare('INSERT INTO citas (fecha, hora, id_usuario) VALUES (:fecha, :hora, :id_usuario)');
$sent->execute([':fecha' => $fecha, ':hora' => $hora, ':id_usuario' => $id_usuario]);

$_SESSION['exito'] = "Cita solicitada correctamente.";

return volver();
