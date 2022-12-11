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

    $id = \App\Tablas\Usuario::logueado()->id;
    $fechaActual= Carbon::now()->locale('es_ES')->setTimezone('Europe/Madrid');
    $pdo = conectar();
    $sent = $pdo->prepare('SELECT fecha FROM citas WHERE id_cita = 
                            (SELECT max(id_cita) FROM citas WHERE id_usuario = :id)');
    $sent->execute([':id' => $id]);
    $fechaCita = $sent->fetch(PDO::FETCH_ASSOC);

    if ($fechaCita['fecha'] > $fechaActual->toDateString()) {
        $_SESSION['error'] = 'No puedes solicitar otra cita si tienes una pendiente de asistir.';
        return volver();
    }

    if ($fechaActual->hour > '20') {
        $fechaActual = $fechaActual->addDays()->hour(10)->minute(0)->second(0);
    }
    if ($fechaActual->hour < '10') {
        $fechaActual = $fechaActual->hour(10)->minute(0)->second(0);
    }
    ?>

<p><?= $fechaActual->toDateString() ?></p>
<p><?= $fechaCita['fecha'] ?></p>

    <!--     SELECT PARA LAS FECHAS DE LAS CITAS -->
    <form method="POST" action="/citaHora.php">
        <label for="fechas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">¿Cuándo desea su cita?</label>
        <select id="fechas" name="fechas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option selected>Elige tu fecha</option>
            <?php while ($fechaActual->daysInMonth <= 31 && $fechaActual->month != '2') : ?>
                <?php while ($fechaActual->isWeekend()) {
                    $fechaActual->addDay();
                }
                ?>
                <option value="<?= $fechaActual->toDateString() ?>">
                    <?= $fechaActual->isoFormat('L'); ?>
                </option>
                <?php $fechaActual->addDay(); ?>
            <?php endwhile ?>
        </select>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Enviar
        </button>
    </form>

    <script src="https://unpkg.com/flowbite@1.5.4/dist/flowbite.js"></script>
</body>

</html>