<?php

use App\Tablas\Usuario;

 session_start() ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/output.css" rel="stylesheet">
    <title>Portal</title>
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.4/dist/flowbite.min.css" />
</head>

<body>
    <?php
    require '../vendor/autoload.php';

    $codigo = obtener_post('codigo');
    $nombre = obtener_post('nombre');
    $password = obtener_post('password');
    $password_repeat = obtener_post('password_repeat');

    $clases_label = [];
    $clases_input = [];
    $error = [];

    $clases_label_error = "text-red-700 dark:text-red-500";
    $clases_input_error = "bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500 dark:bg-red-100 dark:border-red-400";

    foreach (['codigo', 'password', 'password_repeat'] as $e) {
        $clases_label[$e] = '';
        $clases_input[$e] = '';
    }

    if (isset($codigo, $nombre, $password, $password_repeat)) {
        $pdo = conectar();

        if ($codigo == '') {
            $error['codigo'] = 'El codigo es obligatorio.';
        } else if (mb_strlen($codigo) > 255) {
            $error['codigo'] = 'El codigo de usuario es demasiado largo.';
        } else if (\App\Tablas\Usuario::existe($login, $pdo)) {
            $error['codigo'] = 'El codigo ya existe.';
        }

        if ($nombre == '') {
            $error['nombre'] = 'El nombre es obligatorio.';
        } else if (mb_strlen($codigo) > 255) {
            $error['nombre'] = 'El nombre de usuario es demasiado largo.';
        } else if (\App\Tablas\Usuario::existe($login, $pdo)) {
            $error['nombre'] = 'El nombre ya existe.';
        }

        if ($password != $password_repeat) {
            $error['password'] = 'Las contraseñas no coinciden.';
        }

        if ($password == '') {
            $error['password'] = 'La contraseña es obligatoria.';
        }

        if ($password_repeat == '') {
            $error['password_repeat'] = 'La contraseña es obligatoria.';
        }

        if (empty($error)) {
            // Registrar
            Usuario::registrar($codigo, $nombre, $password, $pdo);
            $_SESSION['exito'] = 'El usuario se ha registrado correctamente.';
            return redirigir_login();
        } else {
            foreach (['codigo', 'password', 'password_repeat'] as $e) {
                if (isset($error[$e])) {
                    $clases_input[$e] = $clases_input_error;
                    $clases_label[$e] = $clases_label_error;
                }
            }
        }
    }
    ?>
    <div class="container mx-auto">
        <?php require '../src/_menu.php' ?>
        <div class="mx-72">
            <form action="" method="POST">
                <div class="mb-6">
                    <label for="codigo" class="block mb-2 text-sm font-medium <?= $clases_label['codigo'] ?>">Nombre de usuario</label>
                    <input type="text" name="codigo" id="codigo" class="border text-sm rounded-lg block w-full p-2.5 <?= $clases_input['codigo'] ?>" value="<?= hh($codigo) ?>">
                    <?php if (isset($error['codigo'])): ?>
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-bold">¡Error!</span> <?= $error['codigo'] ?></p>
                    <?php endif ?>
                </div>
                <div class="mb-6">
                    <label for="nombre" class="block mb-2 text-sm font-medium <?= $clases_label['nombre'] ?>">Nombre de usuario</label>
                    <input type="text" name="nombre" id="nombre" class="border text-sm rounded-lg block w-full p-2.5 <?= $clases_input['nombre'] ?>" value="<?= hh($nombre) ?>">
                    <?php if (isset($error['nombre'])): ?>
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-bold">¡Error!</span> <?= $error['nombre'] ?></p>
                    <?php endif ?>
                </div>
                <div class="mb-6">
                    <label for="password" class="block mb-2 text-sm font-medium <?= $clases_label['password'] ?>">Contraseña</label>
                    <input type="password" name="password" id="password" class="border text-sm rounded-lg block w-full p-2.5  <?= $clases_input['password'] ?>">
                    <?php if (isset($error['password'])): ?>
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-bold">¡Error!</span> <?= $error['password'] ?></p>
                    <?php endif ?>
                </div>
                <div class="mb-6">
                    <label for="password_repeat" class="block mb-2 text-sm font-medium <?= $clases_label['password_repeat'] ?>">Confirmar contraseña</label>
                    <input type="password" name="password_repeat" id="password_repeat" class="border text-sm rounded-lg block w-full p-2.5  <?= $clases_input['password_repeat'] ?>">
                    <?php if (isset($error['password_repeat'])): ?>
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-bold">¡Error!</span> <?= $error['password_repeat'] ?></p>
                    <?php endif ?>
                </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Registrar</button>
            </form>
        </div>
    </div>
    <script src="https://unpkg.com/flowbite@1.5.4/dist/flowbite.js"></script>
</body>

</html>