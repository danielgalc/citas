<?php

session_start();

require '../vendor/autoload.php';

$id = \App\Tablas\Usuario::logueado()->id;


if (!App\Tablas\Usuario::esta_logueado()) {
        header('location: login.php');
    } else {
        $pdo = conectar();
        $sent = $pdo->prepare("SELECT * FROM citas WHERE id_usuario = :id");
        $sent->execute([':id' => $id]);
    }
    ?>

    <table>
        <thead>
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
                <th scope="col" class="py-3 px-6">
                    Acciones
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sent as $fila) : ?>
                <tr >
                    <th scope="row">
                        <?= $fila['id_cita'] ?>
                    </th>
                    <td class="py-4 px-6">
                        <?= $fila['fecha'] ?>
                    </td>
                    <td class="py-4 px-6">
                        <?= $fila['hora'] ?>
                    </td>
                    <td class="py-4 px-6">
                        <a href="borrarCita.php?id=<?= $fila['id_cita']?>">Borrar</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    </table>