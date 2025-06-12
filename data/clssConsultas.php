
<?php
include("bd.php");
ini_set('display_errors', 1);
error_reporting(E_ALL);
if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    controlador($accion);
}


function controlador($accion)
{
    switch ($accion) {
        case 'BUSCARDOCENTE':
            $dni = $_POST["datos"];
            fnListarDocentes($dni);
            break;
        case 'VERIFICARDOCENTESALIDA':
            $dni = $_POST["dni"];
            fnVerificarSalida($dni);
            break;
        case 'INSERTENTRADADOCENTE':
            $jsdatos = $_POST["jsDatos"];
            fnInsertEntrada($jsdatos);
            break;
        case 'UPDATESALIDADOCENTE':
            $dni = $_POST["dni"];
            fnUpdateSalida($dni);
            break;
        case 'VERIFICAR_ENTRADA_SIN_SALIDA':
            $dni = $_POST["dni"];
            fnVerificarEntradaSinSalida($dni);
            break;
        case 'LISTAR_REGISTROS':
            fnListarRegistros();
            break;
        case 'LISTAR_REGISTROS_POR_FECHA':
            $fecha = $_POST["fecha"];
            fnListarRegistrosPorFecha($fecha);
            break;
        case 'OBTENER_ULTIMO_REGISTRO_COMPLETO':
            $dni = $_POST["dni"];
            fnObtenerUltimoRegistroCompleto($dni);
            break;


        case 'EDITAR_DOCENTE_COMPLETO':
            $jsdatos = $_POST["jsDatos"];
            fnEditarDocenteCompleto($jsdatos);
            break;

        case 'FORZARCIERRE':
            fnCerrarRegistros();
            break;
            
        case 'REGISTRAR_NUEVO_DOCENTE':
            $jsdatos = $_POST["jsDatos"];
            fnRegistrarNuevoDocente($jsdatos);
            break;


        default:
            break;
    }
}


function fnListarRegistrosPorFecha($fecha)
{
    if (empty($fecha)) {
        $filtro = "v.entrada::date = CURRENT_DATE";
    } else {
        $filtro = "v.entrada::date = :fecha";
    }

    $sql = "
        SELECT v.id, p.dni, p.nombres, p.apellido_paterno, p.apellido_materno,
               v.entrada, v.salida, a.unidad_organica, a.oficina, v.areas_visita 
        FROM visita v
        INNER JOIN persona p ON v.persona_dni = p.dni
        INNER JOIN area_institucional a ON v.area_institucional_id = a.id
        WHERE $filtro
        ORDER BY v.entrada DESC
    ";

    $result = empty($fecha)
        ? executeQuery($sql)
        : executeQuery($sql, ['fecha' => $fecha]);

    echo json_encode(["estado" => true, "datos" => $result]);
}

function fnRegistrarNuevoDocente($jsDatos)
{
    global $conectar;
    try {
        $data = json_decode($jsDatos, true);

        if (!$data) {
            echo json_encode(['estado' => false, 'mensaje' => 'Datos no válidos']);
            return;
        }

        // Validaciones básicas
        if (empty($data['dni']) || !preg_match('/^\d{8}$/', $data['dni'])) {
            echo json_encode(['estado' => false, 'mensaje' => 'DNI debe tener 8 dígitos']);
            return;
        }

        if (empty($data['nombres']) || empty($data['apellido_paterno'])) {
            echo json_encode(['estado' => false, 'mensaje' => 'Nombres y apellido paterno son obligatorios']);
            return;
        }

        // Verificar si el DNI ya existe
        $sqlVerificar = "SELECT COUNT(*) as cantidad FROM persona WHERE dni = :dni";
        $stmtVerificar = $conectar->prepare($sqlVerificar);
        $stmtVerificar->bindParam(':dni', $data['dni']);
        $stmtVerificar->execute();
        $existeDocente = $stmtVerificar->fetch(PDO::FETCH_ASSOC);
        $stmtVerificar->closeCursor();

        if ($existeDocente['cantidad'] > 0) {
            echo json_encode(['estado' => false, 'mensaje' => 'Ya existe un docente registrado con este DNI']);
            return;
        }

        // Validar email si se proporciona
        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['estado' => false, 'mensaje' => 'El email no tiene un formato válido']);
            return;
        }

        // Iniciar transacción
        $conectar->beginTransaction();

        // Preparar consulta de inserción
        $sql = "
            INSERT INTO persona (
                dni, nombres, apellido_paterno, apellido_materno,
                fecha_nacimiento, sexo, celular, email,
                direccion, provincia, distrito, zona,
                nombre_institucion_educativa, gestion, tipo_ie,
                cargo, tipo_trabajador, sub_tipo_trabajador, situacion_laboral
            ) VALUES (
                :dni, :nombres, :apellido_paterno, :apellido_materno,
                :fecha_nacimiento, :sexo, :celular, :email,
                :direccion, :provincia, :distrito, :zona,
                :nombre_institucion_educativa, :gestion, :tipo_ie,
                :cargo, :tipo_trabajador, :sub_tipo_trabajador, :situacion_laboral
            )
        ";

        $stmt = $conectar->prepare($sql);

        // Preparar datos para la inserción
        $datosInsercion = [
            ':dni' => $data['dni'],
            ':nombres' => ucwords(strtolower(trim($data['nombres']))),
            ':apellido_paterno' => ucwords(strtolower(trim($data['apellido_paterno']))),
            ':apellido_materno' => !empty($data['apellido_materno']) ? ucwords(strtolower(trim($data['apellido_materno']))) : null,
            ':fecha_nacimiento' => !empty($data['fecha_nacimiento']) ? $data['fecha_nacimiento'] : null,
            ':sexo' => !empty($data['sexo']) ? $data['sexo'] : null,
            ':celular' => !empty($data['celular']) ? $data['celular'] : null,
            ':email' => !empty($data['email']) ? strtolower(trim($data['email'])) : null,
            ':direccion' => !empty($data['direccion']) ? trim($data['direccion']) : null,
            ':provincia' => !empty($data['provincia']) ? ucwords(strtolower(trim($data['provincia']))) : 'Lambayeque',
            ':distrito' => !empty($data['distrito']) ? ucwords(strtolower(trim($data['distrito']))) : null,
            ':zona' => !empty($data['zona']) ? $data['zona'] : null,
            ':nombre_institucion_educativa' => !empty($data['institucion']) ? ucwords(strtolower(trim($data['institucion']))) : null,
            ':gestion' => !empty($data['gestion']) ? $data['gestion'] : null,
            ':tipo_ie' => !empty($data['tipo_ie']) ? $data['tipo_ie'] : null,
            ':cargo' => !empty($data['cargo']) ? ucwords(strtolower(trim($data['cargo']))) : null,
            ':tipo_trabajador' => !empty($data['tipo_trabajador']) ? $data['tipo_trabajador'] : null,
            ':sub_tipo_trabajador' => !empty($data['sub_tipo_trabajador']) ? $data['sub_tipo_trabajador'] : null,
            ':situacion_laboral' => !empty($data['situacion_laboral']) ? $data['situacion_laboral'] : null
        ];

        // Ejecutar inserción
        $stmt->execute($datosInsercion);

        // Confirmar transacción
        $conectar->commit();

        // Respuesta exitosa
        echo json_encode([
            'estado' => true,
            'mensaje' => 'Docente registrado exitosamente',
            'dni' => $data['dni'],
            'nombre_completo' => trim($datosInsercion[':nombres'] . ' ' . $datosInsercion[':apellido_paterno'] . ' ' . $datosInsercion[':apellido_materno'])
        ]);
    } catch (PDOException $e) {
        // Revertir transacción en caso de error
        $conectar->rollBack();

        // Log del error (opcional)
        error_log("Error al registrar docente: " . $e->getMessage());

        // Respuesta de error
        if ($e->getCode() == 23000) {
            // Error de duplicado
            echo json_encode(['estado' => false, 'mensaje' => 'Ya existe un docente con este DNI']);
        } else {
            echo json_encode(['estado' => false, 'mensaje' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    } catch (Exception $e) {
        // Revertir transacción
        $conectar->rollBack();

        // Log del error
        error_log("Error general al registrar docente: " . $e->getMessage());

        // Respuesta de error
        echo json_encode(['estado' => false, 'mensaje' => 'Error interno del servidor: ' . $e->getMessage()]);
    }
}

function fnListarRegistros()
{
    $sql = "
        SELECT v.id, p.dni, p.nombres, p.apellido_paterno, p.apellido_materno,
               v.entrada, v.salida, a.unidad_organica, a.oficina, v.areas_visita
        FROM visita v
        INNER JOIN persona p ON v.persona_dni = p.dni
        INNER JOIN area_institucional a ON v.area_institucional_id = a.id
        ORDER BY v.entrada DESC 
    ";

    $result = executeQuery($sql);
    return $result;
}

function executeQuery(string $query, array $params = []): array
{
    global $conectar;
    try {
        $orden = $conectar->prepare($query);
        $orden->execute($params);
        $datos = $orden->fetchAll(PDO::FETCH_ASSOC);
        $orden->closeCursor();
        return $datos;
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        return [];
    }
}

function executeQueryv2($query)
{
    global $conectar;
    try {

        $stmt = $conectar->query($query);

        if (!$stmt) {
            throw new Exception("Error en la consulta SQL");
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        return [];
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}


function fnListarAreasAgrupadas()
{
    $sql = "SELECT unidad_organica, oficina, id FROM area_institucional ORDER BY unidad_organica, oficina";
    return executeQuery($sql);
}

function fnVerificarSalida($dni)
{
    $sql = "
        SELECT 
        COUNT(*) cantidad
        FROM visita where persona_dni = :dni AND salida is NULL AND cerrado_forzado IS NULL";

    echo json_encode(executeQuery($sql, params: ["dni" => $dni])[0]);
}
function fnListarDocentes($dni)
{
    global $conectar;
    try {
        $sql = "SELECT * FROM persona WHERE dni LIKE :dni LIMIT 10;";
        $orden = $conectar->prepare($sql);

        $orden->bindValue(':dni',  $dni . '%', PDO::PARAM_STR);

        $orden->execute();
        $lista = $orden->fetchAll(PDO::FETCH_ASSOC);
        $orden->closeCursor();


        echo json_encode(array('datos' => $lista, "respuesta" => "ok"));
    } catch (\Throwable $th) {

        echo json_encode(array('datos' => [], "respuesta" => "error", "mensaje" => $th->getMessage()));
    }
}



function fnInsertEntrada($jsDatos)
{
    global $conectar;
    try {
        $data = json_decode($jsDatos, true);
        //echo $jsDatos;
        $conectar->beginTransaction();

        $sql = "        
            INSERT INTO visita 
            (persona_dni,area_institucional_id,entrada,areas_visita)
            VALUES
            (:persona_id,:area_institucional_id,CURRENT_TIMESTAMP, :js_areas_visita);
        ";
        $js_datax_areas = json_encode($data["areas_visita"]);
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':persona_id', $data["dni"]);
        $stmt->bindParam(':area_institucional_id', $data["area_id"]);
        $stmt->bindParam(':js_areas_visita', $js_datax_areas);

        $stmt->execute();
        $conectar->commit();
        echo json_encode(['estado' => true, 'mensaje' => 'Registrado :)']);
    } catch (Exception $e) {
        $conectar->rollBack();
        echo json_encode(['estado' => false, 'mensaje' => 'Error al procesar la solicitud. Detalles: ' . $e->getMessage()]);
    }
}

function fnUpdateSalida($dni)
{
    global $conectar;
    try {
        $conectar->beginTransaction();

        $sql = "
            WITH ultima_visita AS (
                SELECT id
                FROM visita
                WHERE persona_dni = :persona_id AND salida IS NULL AND cerrado_forzado IS NULL
                ORDER BY entrada DESC
                LIMIT 1
            )
            UPDATE visita
            SET salida = CURRENT_TIMESTAMP
            WHERE id IN (SELECT id FROM ultima_visita)
        ";

        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':persona_id', $dni);
        $stmt->execute();

        $conectar->commit();
        echo json_encode(['estado' => true, 'mensaje' => 'SALIDA UPDATE :)']);
    } catch (Exception $e) {
        $conectar->rollBack();
        echo json_encode(['estado' => false, 'mensaje' => 'Error al procesar la solicitud. Detalles: ' . $e->getMessage()]);
    }
}

function fnVerificarEntradaSinSalida($dni)
{
    $sql = "
        SELECT COUNT(*) as cantidad
        FROM visita
        WHERE persona_dni = :dni AND salida IS NULL AND cerrado_forzado IS NULL
    ";

    $resultado = executeQuery($sql, ['dni' => $dni]);

    echo json_encode([
        "entradaSinSalida" => $resultado[0]['cantidad'] > 0
    ]);
}


function fnEditarDocenteCompleto($jsdatos)
{
    global $conectar;
    try {
        $data = json_decode($jsdatos, true); // Convierte los datos JSON en un array asociativo

        if (!$data) {
            // Si los datos no son válidos
            echo json_encode(['estado' => false, 'mensaje' => 'Datos no válidos']);
            return;
        }

        // Procede con la actualización de datos
        $sql = "
        UPDATE persona SET 
            nombres = :nombres,
            apellido_paterno = :apellido_paterno,
            apellido_materno = :apellido_materno,
            direccion = :direccion,
            provincia = :provincia,
            distrito = :distrito,
            zona = :zona,
            nombre_institucion_educativa = :institucion,
            gestion = :gestion,
            tipo_ie = :tipo_ie,
            cargo = :cargo,
            tipo_trabajador = :tipo_trabajador,
            sub_tipo_trabajador = :sub_tipo_trabajador,
            situacion_laboral = :situacion_laboral,
            celular = :celular,
            email = :email,
            fecha_nacimiento = :fecha_nacimiento,
            sexo = :sexo
        WHERE dni = :dni";

        $stmt = $conectar->prepare($sql);
        $stmt->execute([
            ':nombres' => $data['nombres'],
            ':apellido_paterno' => $data['apellido_paterno'],
            ':apellido_materno' => $data['apellido_materno'],
            ':direccion' => $data['direccion'],
            ':provincia' => $data['provincia'],
            ':distrito' => $data['distrito'],
            ':zona' => $data['zona'],
            ':institucion' => $data['institucion'],
            ':gestion' => $data['gestion'],
            ':tipo_ie' => $data['tipo_ie'],
            ':cargo' => $data['cargo'],
            ':tipo_trabajador' => $data['tipo_trabajador'],
            ':sub_tipo_trabajador' => $data['sub_tipo_trabajador'],
            ':situacion_laboral' => $data['situacion_laboral'],
            ':celular' => $data['celular'],
            ':email' => $data['email'],
            ':fecha_nacimiento' => $data['fecha_nacimiento'],
            ':sexo' => $data['sexo'],
            ':dni' => $data['dni']
        ]);

        echo json_encode(['estado' => true, 'mensaje' => 'Datos actualizados correctamente']);
    } catch (Exception $e) {
        // Si ocurre un error, se captura y se devuelve un mensaje de error
        echo json_encode(['estado' => false, 'mensaje' => 'Error: ' . $e->getMessage()]);
    }
}

function fnCerrarRegistros()
{
    global $conectar;
    try {

        //echo $jsDatos;
        $conectar->beginTransaction();

        $sql = "        
            UPDATE visita set cerrado_forzado = current_timestamp;
        ";

        $stmt = $conectar->prepare($sql);

        $stmt->execute();
        $conectar->commit();
        echo json_encode(['estado' => true, 'mensaje' => 'FORZADO JORGE CTMRE :)']);
    } catch (Exception $e) {
        $conectar->rollBack();
        echo json_encode(['estado' => false, 'mensaje' => 'Error al procesar la solicitud. Detalles: ' . $e->getMessage()]);
    }
}


function fnObtenerUltimoRegistroCompleto($dni)
{
    global $conectar;
    try {
        $sql = "
            SELECT 
                v.areas_visita,
                v.entrada,
                v.salida,
                p.nombres,
                p.apellido_paterno,
                p.apellido_materno,
                a.unidad_organica,
                a.oficina
            FROM visita v
            INNER JOIN persona p ON v.persona_dni = p.dni
            INNER JOIN area_institucional a ON v.area_institucional_id = a.id
            WHERE v.persona_dni = :dni 
            AND v.salida IS NOT NULL 
            ORDER BY v.salida DESC 
            LIMIT 1
        ";

        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        if ($resultado) {
            // Procesar las áreas visitadas
            $areasVisitadas = 'No especificadas';

            if (!empty($resultado['areas_visita'])) {
                try {
                    $areasJson = json_decode($resultado['areas_visita'], true);
                    if (is_array($areasJson) && count($areasJson) > 0) {
                        $nombresAreas = array_map(function ($area) {
                            return $area['oficina'] ?? 'Sin nombre';
                        }, $areasJson);
                        $areasVisitadas = implode(', ', $nombresAreas);
                    }
                } catch (Exception $e) {
                    // Si hay error al decodificar JSON, usar área principal
                    $areasVisitadas = $resultado['oficina'] ?? 'No especificada';
                }
            } else {
                // Si no hay áreas en JSON, usar la oficina principal
                $areasVisitadas = $resultado['oficina'] ?? 'No especificada';
            }

            // Formatear hora de entrada
            $horaEntrada = 'N/A';
            if (!empty($resultado['entrada'])) {
                $fechaEntrada = new DateTime($resultado['entrada']);
                $horaEntrada = $fechaEntrada->format('h:i A');
            }

            echo json_encode([
                'estado' => true,
                'datos' => [
                    'areas_visitadas' => $areasVisitadas,
                    'hora_entrada' => $horaEntrada,
                    'nombre_completo' => trim($resultado['nombres'] . ' ' . $resultado['apellido_paterno'] . ' ' . $resultado['apellido_materno'])
                ]
            ]);
        } else {
            echo json_encode([
                'estado' => false,
                'mensaje' => 'No se encontró registro de visita'
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'estado' => false,
            'mensaje' => 'Error al obtener datos: ' . $e->getMessage()
        ]);
    }
}
