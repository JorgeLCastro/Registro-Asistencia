<?php
include("data/clssConsultas.php");


if (!isset($_GET['fecha'])) {
    die("Fecha no especificada.");
}

$fecha = $_GET['fecha'];
header('Content-Type: text/csv; charset=utf-8');
header("Content-Disposition: attachment; filename=registros_$fecha.csv");

$output = fopen("php://output", "w");

// Encabezados
fputcsv($output, ['#', 'DNI', 'Nombre completo', 'Área', 'Entrada', 'Salida', 'Tiempo transcurrido']);

$registros = obtenerRegistrosPorFecha($fecha);

$i = 1;
foreach ($registros as $row) {
    $entrada = date_create($row['entrada']);
    $salida = $row['salida'] ? date_create($row['salida']) : null;

    // Calcular tiempo transcurrido
    if ($salida) {
        $diff = date_diff($entrada, $salida);
        $tiempoTranscurrido = sprintf('%d h %d min %d s', 
            $diff->h + ($diff->d * 24), // total horas
            $diff->i, 
            $diff->s
        );
    } else {
        $tiempoTranscurrido = 'En curso';
    }

    fputcsv($output, [
        $i++,
        $row['dni'],
        $row['nombres'] . ' ' . $row['apellido_paterno'] . ' ' . $row['apellido_materno'],
        $row['unidad_organica'] . ' - ' . $row['oficina'],
        date_format($entrada, 'd/m/Y h:i:s A'),
        $salida ? date_format($salida, 'd/m/Y h:i:s A') : 'Pendiente',
        $tiempoTranscurrido
    ]);
}

fclose($output);

// Función auxiliar (por si no la tienes ya)
function obtenerRegistrosPorFecha($fecha)
{
    global $conectar;

    $sql = "
        SELECT v.id, p.dni, p.nombres, p.apellido_paterno, p.apellido_materno,
               v.entrada, v.salida, a.unidad_organica, a.oficina
        FROM visita v
        INNER JOIN persona p ON v.persona_dni = p.dni
        INNER JOIN area_institucional a ON v.area_institucional_id = a.id
        WHERE v.entrada::date = :fecha
        ORDER BY v.entrada DESC
    ";

    return executeQuery($sql, ['fecha' => $fecha]);
}
