<?php

session_start();

use Carbon\Carbon;

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.4/dist/flowbite.min.css" />
    <title>Portal</title>
</head>


<body>
    
    <?php

    require '../vendor/autoload.php';
    require '../src/_alerts.php';

    $id = \App\Tablas\Usuario::logueado()->id;

    if (!App\Tablas\Usuario::esta_logueado()) {
        header('location: login.php');
    } else {
        $pdo = conectar();
        $sent = $pdo->prepare("SELECT * FROM citas WHERE id_usuario = :id");
        $sent->execute([':id' => $id]);
    }
    ?>


    <nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="flex flex-wrap justify-end items-center mx-auto max-w-screen-xl px-4 md:px-6 py-2.5">
        <div class="flex items-center">
            <!-- Nombre del ususario -->
            <?php if (\App\Tablas\Usuario::esta_logueado()) : ?>
                <p class="mr-6 text-sm font-medium text-gray-500 dark:text-white">
                    <?= hh(\App\Tablas\Usuario::logueado()->usuario) ?>
                </p>
            <?php endif ?>
            <!-- Botón de logout -->
            <?php if (\App\Tablas\Usuario::esta_logueado()) : ?>
                <a href="/logout.php" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                    Logout
                </a>
            <?php endif ?>
        </div>
    </div>
</nav>



<div class="flex flex wrap justify-center">
    <table class="w-1/2 text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="py-3 px-6">
                    Nº cita
                </th>
                <th scope="col" class="py-3 px-6">
                    Fecha
                </th>
                <th scope="col" class="py-3 px-6">
                    Hora
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sent as $fila) : ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <?= $fila['id_cita'] ?>
                    </th>
                    <td class="py-4 px-6">
                        <?= $fila['fecha'] ?>
                    </td>
                    <td class="py-4 px-6">
                        <?= $fila['hora'] ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    </div>

    <div class="flex flex-wrap justify-center">
        <a href="fechaCita.php" class="mt-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">SOLICITAR UNA CITA</a>
        <a href="gestionarCita.php" class="mt-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">GESTIONAR MIS CITAS</a>
    </div>
    <script src="https://unpkg.com/flowbite@1.5.4/dist/flowbite.js"></script>
</body>

</html>