<?php
include("cabecera.php");
include("data/clssConsultas.php");
session_start();
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header('Location: login.php');
    exit();
}
?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<div class="container mt-5">


    <div class="row justify-content-center">

        <div class="col-lg-11">
            <div class="card shadow">
                <a
                    name=""
                    id="btnCierreFotzados"
                    class="btn btn-danger"
                    href="#"
                    role="button"
                    onclick="fnCierreForzado()">Forzar Cierre de Visitas de Docentes</a>

                   

                <br>
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="text-white"><i class="bi bi-clock-history me-2"></i>Registro de Entradas y Salidas</h4>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablaRegistros" class="table table-striped table-bordered table-hover align-middle text-center">

                            <thead class="table-light">
                                <div class="mb-2 d-flex align-items-center gap-2">
                                    <label for="filtroFecha" class="form-label fw-bold mb-0">📅 Filtrar por fecha:</label>
                                    <input type="date" id="filtroFecha" class="form-control form-control-sm w-auto">
                                    <button id="btnDescargar" class="btn btn-sm btn-success">⬇️ Descargar</button>
                                     <a href="logout.php" class="btn btn-sm btn-outline-danger">Cerrar sesión</a>
                                </div>

                                <hr>
                                <tr>
                                    <th>#</th>
                                    <th>DNI</th>
                                    <th>Docente</th>
                                    <th>Área</th>
                                    <th>Entrada</th>
                                    <th>Salida</th>
                                    <th>Tiempo transcurrido</th> <!-- ✅ NUEVA COLUMNA -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Se llena dinámicamente por AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-end text-muted">
                    Última actualización: <span id="fechaActual"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts de DataTables y jQuery -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    function fnCierreForzado() {

        $.ajax({
            method: "POST",
            url: "data/clssConsultas.php",
            data: {
                accion: "FORZARCIERRE"
            },
            success: function(respuesta) {

                console.log(respuesta);
                const res = JSON.parse(respuesta);
                if (res.estado === true) {
                    let timerInterval;
                    Swal.fire({
                        title: "Forzando cierre de vistas",
                        html: "Cerrando visitas <b></b> .",
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                            const timer = Swal.getPopup().querySelector("b");
                            timerInterval = setInterval(() => {
                                timer.textContent = `${Swal.getTimerLeft()}`;
                            }, 100);
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            console.log("I was closed by the timer");
                            location.reload(); // 👈 Recarga aquí
                        }
                    });

                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!",
                        footer: '<a href="#">Why do I have this issue?</a>'
                    });
                }
            }
        });
    }
</script>
<script>
    let tabla = null; // Variable global para almacenar el DataTable

    function cargarFecha() {
        const ahora = new Date();
        const fechaFormateada = ahora.toLocaleString('es-PE');
        $('#fechaActual').text(fechaFormateada);
    }

    function cargarRegistros() {
        const fecha = $('#filtroFecha').val();

        $.ajax({
            method: "POST",
            url: "data/clssConsultas.php",
            data: {
                accion: "LISTAR_REGISTROS_POR_FECHA",
                fecha: fecha
            },
            success: function(respuesta) {
                const res = JSON.parse(respuesta);
                if (res.estado) {
                    const datosTabla = [];

                    res.datos.forEach((registro, index) => {
                        const entrada = new Date(registro.entrada);
                        const horaEntrada = entrada.toLocaleTimeString('es-PE', {
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit',
                            hour12: true
                        });
                        const fechaEntrada = entrada.toLocaleDateString('es-PE');

                        let salidaTexto = `<span class="badge bg-danger">Pendiente</span>`;
                        let tiempoTranscurrido = 'En curso ⏳';

                        if (registro.salida) {
                            const salida = new Date(registro.salida);
                            const horaSalida = salida.toLocaleTimeString('es-PE', {
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit',
                                hour12: true
                            });
                            const fechaSalida = salida.toLocaleDateString('es-PE');

                            salidaTexto = `
                            <span class="badge bg-secondary">
                                <div class="mb-1">${horaSalida}</div>
                                ${fechaSalida}
                            </span>`;

                            const diffMs = salida - entrada;
                            const diffTotalSec = Math.floor(diffMs / 1000);
                            const horas = Math.floor(diffTotalSec / 3600);
                            const minutos = Math.floor((diffTotalSec % 3600) / 60);
                            const segundos = diffTotalSec % 60;
                            tiempoTranscurrido = `${horas} h ${minutos} min ${segundos} s`;
                        }

                        let jsVisitas = JSON.parse(registro["areas_visita"]);
                        let listaHtml = "";
                        console.log(jsVisitas)



                        // Verificar si jsVisitas es un array válido y no está vacío
                        if (Array.isArray(jsVisitas) && jsVisitas.length > 0) {


                            jsVisitas.forEach(area => {
                                console.log("ID:", area.id);
                                console.log("Oficina:", area.oficina);
                                listaHtml = jsVisitas.map(area => `<span class="badge bg-secondary me-1">${area.oficina}</span>`).join(' ');

                            });
                        } else {
                            // Si jsVisitas está vacío o no es un array, asignar un mensaje predeterminado
                            listaHtml = `<span class="badge bg-light text-muted">Sin oficinas</span>`;

                        }

                        datosTabla.push([
                            index + 1,
                            registro.dni,
                            `${registro.nombres} ${registro.apellido_paterno} ${registro.apellido_materno}`,
                            listaHtml,
                            `<span class="badge bg-success"><div class="mb-1">${horaEntrada}</div>${fechaEntrada}</span>`,
                            salidaTexto,
                            `<span class="badge bg-info">${tiempoTranscurrido}</span>`
                        ]);
                    });

                    // ✅ Solo limpiar y actualizar datos (sin destruir)
                    tabla.clear().rows.add(datosTabla).draw();

                    const ahora = new Date();
                    $('#fechaActual').text(ahora.toLocaleString('es-PE'));
                }
            }
        });
    }

    $(document).ready(function() {
        // Establecer fecha inicial
        const hoy = new Date().toISOString().split('T')[0];
        $('#filtroFecha').val(hoy);

        // ✅ Inicializar DataTable solo una vez
        tabla = $('#tablaRegistros').DataTable({
            autoWidth: false,
            language: {
                lengthMenu: "Mostrar _MENU_ registros por página",
                zeroRecords: "No se encontraron resultados",
                info: "Mostrando página _PAGE_ de _PAGES_",
                infoEmpty: "No hay registros disponibles",
                infoFiltered: "(filtrado de _MAX_ registros totales)",
                search: "Buscar:",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior"
                }
            }
        });

        cargarRegistros();

        $('#filtroFecha').on('change', function() {
            cargarRegistros();
        });

        setInterval(cargarRegistros, 10000000   ); // actualiza cada 10s
    });



    $('#btnDescargar').on('click', function() {
        const fecha = $('#filtroFecha').val();
        if (!fecha) {
            Swal.fire("¡Error!", "Por favor selecciona una fecha antes de descargar.", "warning");
            return;
        }
        window.location.href = `descargar_registros.php?fecha=${fecha}`;
    });
</script>

<?php include("pie.php"); ?>