<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.4/dist/flowbite.min.css" />
    <link href="/css/output.css" rel="stylesheet">
    <title>Solicitar cita</title>
</head>

<body>
    <?php
    require '../vendor/autoload.php';

    use Carbon\Carbon;

    $fechaNow = Carbon::now()->locale('es_ES')->setTimezone('Europe/Madrid')->toDateString();
    $fecha = obtener_post('fechas');
    if ($fechaNow != $fecha) {
        $fecha_citas = Carbon::create($fecha)->locale('es_ES')->setTimezone('Europe/Madrid')->hour(10);
    } else {
        $fecha_citas = Carbon::create($fecha)->locale('es_ES')->setTimezone('Europe/Madrid')->addHour();
    }
    ?>
    <p><?= $fecha_citas ?></p>
    <!--     SELECT PARA LAS FECHAS DE LAS CITAS -->
    <form method="POST" action="insertarCita.php">
        <input type="hidden" name="fecha" value="<?= $fecha_citas->toDateString() ?>">
        <label for="horas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">¿Cuándo desea su cita?</label>
        <select id="horas" name="horas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option selected>Elige tu hora</option>
            <?php while ($fecha_citas->hour < '21') : ?>
                <option value="<?= $fecha_citas->toTimeString('minute') ?>">
                    <?= $fecha_citas->toTimeString('minute') ?>
                </option>
                <?php $fecha_citas->addMinute(15) ?>
            <?php endwhile ?>
        </select>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Enviar
        </button>
    </form>

    <script src="https://unpkg.com/flowbite@1.5.4/dist/flowbite.js"></script>
</body>

</html>