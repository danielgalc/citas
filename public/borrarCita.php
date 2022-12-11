<?php

require '../vendor/autoload.php';
$id = obtener_get('id');
$pdo = conectar();
$sent = $pdo->prepare('DELETE FROM citas WHERE id_cita = :id');
$sent->execute([':id' => $id]);

header('Location: /gestionarCita.php');