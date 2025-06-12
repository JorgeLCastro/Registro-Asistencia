<?php
include("cabecera.php");
include("data/clssConsultas.php");
?>


<section id="hero" class="hero section light-background">
    <div class="container" data-aos="zoom-out">

        <div class="row justify-content-center align-items-center g-2">
            <!-- Columna izquierda -->
            <div class="col-sm-4">
                <div class="card text-start h-100">
                    <div class="card-body">
                        <h4 class="card-title">Registro de Control</h4>
                        <div class="mb-3">
                            <label for="inputDNI" class="form-label">Ingrese su DNI</label>
                            <input
                                type="text"
                                class="form-control"
                                id="inputDNI"
                                placeholder="Dni"
                                maxlength="8"
                                oninput="validarNumero(event)" />

                            <small id="helpId" class="form-text text-muted">Para realizar una búsqueda</small>

                            <!-- Aquí se mostrarán los resultados -->
                            <div id="resultados" class="mt-2"></div>
                            <div id="contenedorBtnRegistrar" style="display: none;" class="mt-3">
                                <button id="btnRegistrarNuevo" class="btn btn-primary w-100">Registrar nuevo docente</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Columna derecha -->
            <div id="contenidoDocente" class="container" style="display: none; ">
                <div class="row justify-content-center">
                    <div class="col-12 d-flex justify-content-center">
                        <div class="card p-4 ficha-docente text-center" style="max-width: 2100px;">
                            <h5 id="idNombrePersona" class="text-uppercase fw-bold mb-3 text-center">Selecciona un docente</h5>
                            <h5 class="text-center"><strong>DNI:</strong> <span id="idDNI">---</span></h5>

                            <div class="row mt-1 ">
                                <!-- Columna 1: Ubicación -->
                                <div class="col-md-2 col-12 mb-4 text-center">
                                    <p class="seccion" style="font-size: 18px;">📍 Ubicación</p>
                                    <h6><strong>Dirección:</strong> <span id="idDireccion">---</span></h6>
                                    <h6><strong>Provincia:</strong> <span id="idProvincia">---</span></h6>
                                    <h6><strong>Distrito:</strong> <span id="idDistrito">---</span></h6>

                                </div>

                                <!-- Columna 2: Institución -->
                                <div class="col-md-2 col-12 mb-4 text-center">
                                    <p class="seccion" style="font-size: 18px;">🏫 Institución</p>
                                    <h6><strong>Institución:</strong> <span id="idNombreInstitucion">---</span></h6>
                                    <h6><strong>Gestión:</strong> <span id="idGestion">---</span></h6>
                                    <h6><strong>Tipo IE:</strong> <span id="idTipoIE">---</span></h6>
                                    <h6><strong>Zona:</strong> <span id="idZona">---</span></h6>
                                </div>

                                <!-- Columna 3: Laboral -->
                                <div class="col-md-3 col-12 mb-4 text-center">
                                    <p class="seccion" style="font-size: 18px;">💼 Laboral</p>
                                    <h6><strong>Cargo:</strong> <span id="idCargo">---</span></h6>
                                    <h6><strong>Tipo Trabajador:</strong> <span id="idTipoTrabajador">---</span></h6>
                                    <h6><strong>Sub Tipo Trabajador:</strong> <span id="idSubTipoTrabajador">---</span></h6>
                                    <h6><strong>Situación Laboral:</strong> <span id="idSituacionLaboral">---</span></h6>
                                </div>

                                <!-- Columna 4: Contacto -->
                                <div class="col-md-2 col-12 mb-4 text-center">
                                    <p class="seccion" style="font-size: 18px;">📞 Contacto</p>
                                    <h6><strong>Celular:</strong> <span id="idCelular">---</span></h6>
                                    <h6><strong>Email:</strong> <span id="idEmail">---</span></h6>
                                </div>

                                <!-- Columna 5: Personales -->
                                <div class="col-md-2 col-12 mb-4 text-center">
                                    <p class="seccion" style="font-size: 18px;">🧍 Personales</p>
                                    <h6><strong>F. Nacimiento:</strong> <span id="idFechaNacimiento">---</span></h6>
                                    <h6><strong>Sexo:</strong> <span id="idSexo">---</span></h6>
                                </div>
                                <button class="btn btn-warning mt-3" id="btnEditar" onclick="editarDatos()">Editar Datos</button> <!-- Botón de editar -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <br>


        <div id="idContenedorBotones" style="display: none;">
            <div class="mb-3" id="divSelectAreas">
                <label for="divSelectAreas" class="form-label">Selecciona la oficina a visitar</label>
                <select class="form-select" id="idSelectAreas" name="areas[]" multiple>
                    <?php
                    $areas = fnListarAreasAgrupadas();
                    $grupoActual = "";

                    foreach ($areas as $area) {
                        if ($grupoActual !== $area["unidad_organica"]) {
                            if ($grupoActual !== "") echo "</optgroup>";
                            $grupoActual = $area["unidad_organica"];
                            echo "<optgroup label='{$grupoActual}'>";
                        }
                        echo "<option value='{$area["id"]}'>{$area["oficina"]}</option>";
                    }
                    echo "</optgroup>";
                    ?>
                </select>


            </div>

            <a
                name=""
                id="idBtnEntrada"
                style="display: none;"
                class="btn btn-success"
                href="#"
                onclick="fnRegistroEntrada()"
                role="button">Ingreso</a>
            <a
                style="display: none;"
                name=""
                onclick="fnSalidadDocente()"
                id="idBtnSalida"
                class="btn btn-danger"
                href="#"
                role="button">Salida</a>


        </div>


    </div>

</section><!-- /Hero Section -->

<div class="modal fade" id="modalEditarDatos" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="modalEditarLabel">Editar Datos del Docente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarDocente">
                    <div class="row">

                        <div class="col-md-6">
                            <h6>🧑 <strong>Datos de Identidad</strong></h6>
                            <label>Nombres</label>
                            <input type="text" id="editNombres" class="form-control mb-2">

                            <label>Apellido Paterno</label>
                            <input type="text" id="editApellidoPaterno" class="form-control mb-2">

                            <label>Apellido Materno</label>
                            <input type="text" id="editApellidoMaterno" class="form-control mb-2">
                        </div>

                        <!-- Ubicación -->
                        <div class="col-md-4">
                            <h6>📍 <strong>Ubicación</strong></h6>
                            <label>Dirección</label>
                            <input type="text" id="editDireccion" class="form-control mb-2">
                            <label>Provincia</label>
                            <input type="text" id="editProvincia" class="form-control mb-2">
                            <label>Distrito</label>
                            <input type="text" id="editDistrito" class="form-control mb-2">


                        </div>

                        <!-- Institución -->
                        <div class="col-md-4">
                            <h6>🏫 <strong>Institución</strong></h6>
                            <label>Institución</label>
                            <input type="text" id="editInstitucion" class="form-control mb-2">
                            <label>Gestión</label>
                            <select id="editGestion" class="form-control">
                                <option value="Convenio">Convenio</option>
                                <option value="Estatal">Estatal</option>
                                <option value="Privado">Privado</option>
                                <option value="Sede Administrativa">Sede Administrativa</option>
                                <option value="Otros">Otros</option>
                            </select>
                            <label>Zona</label>
                            <select id="editZona" class="form-control">
                                <option value="Urbana">Urbana</option>
                                <option value="Rural">Rural</option>
                                <option value="Otros">Otros</option>
                            </select>

                            <label>Tipo IE</label>
                            <select id="editTipoIE" class="form-control">
                                <option value="Multigrado">Multigrado</option>
                                <option value="Polidocente Completo">Polidocente Completo</option>
                                <option value="No Aplica">No Aplica</option>
                                <option value="Unidocente">Unidocente</option>
                                <option value="Otros">Otros</option>
                            </select>

                        </div>

                        <!-- Laboral -->
                        <div class="col-md-4">
                            <h6>💼 <strong>Laboral</strong></h6>
                            <label>Cargo</label>
                            <input type="text" id="editCargo" class="form-control mb-2">
                            <label>Tipo de Trabajador</label>
                            <select id="editTipoTrabajador" class="form-control">
                                <option value="Administrador">Administrador</option>
                                <option value="CAS">CAS</option>
                                <option value="CAS Indeterminado">CAS Indeterminado</option>
                                <option value="CAS Transitorio">CAS Transitorio</option>
                                <option value="Director de Sistema Administrador CAS">Director de Sistema Administrador CAS</option>
                                <option value="Docente">Docente</option>
                                <option value="Profesor por Horas CAS">Profesor por Horas CAS</option>
                                <option value="Otros">Otros</option>
                            </select>

                            <label>Sub Tipo de Trabajador</label>
                            <select id="editSubTipoTrabajador" class="form-control">
                                <option value="Directivo">Directivo</option>
                                <option value="Jerárquico">Jerárquico</option>
                                <option value="Técnico">Técnico</option>
                                <option value="Auxiliar">Auxiliar</option>
                                <option value="Especialistas Administrativos e Instituciones de las UGEL">Especialistas Administrativos e Instituciones de las UGEL</option>
                                <option value="Docente">Docente</option>
                                <option value="Auxiliar de Educación">Auxiliar de Educación</option>
                                <option value="PEC">PEC</option>
                                <option value="Otros">Otros</option>
                            </select>

                            <label>Situación Laboral</label>
                            <select id="editSituacionLaboral" class="form-control">
                                <option value="Encargado">Encargado</option>
                                <option value="Designado">Designado</option>
                                <option value="Vacante">Vacante</option>
                                <option value="Nombrado">Nombrado</option>
                                <option value="Contratado">Contratado</option>
                                <option value="Otros">Otros</option>
                            </select>

                        </div>

                        <!-- Contacto -->
                        <div class="col-md-6 mt-3">
                            <h6>📞 <strong>Contacto</strong></h6>
                            <label>Celular</label>
                            <input type="text" id="editCelular" class="form-control mb-2">
                            <label>Email</label>
                            <input type="email" id="editEmail" class="form-control mb-2">
                        </div>

                        <!-- Personales -->
                        <div class="col-md-6 mt-3">
                            <h6>🧍 <strong>Datos Personales</strong></h6>
                            <label>Fecha de Nacimiento</label>
                            <input type="date" id="editFechaNacimiento" class="form-control mb-2">
                            <label>Sexo</label>
                            <select id="editSexo" class="form-control">
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarEdicion()">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA REGISTRO DE NUEVO DOCENTE -->
<div class="modal fade" id="modalRegistroDocente" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Header del Modal -->
            <div class="modal-header bg-primary text-white">
                <div class="d-flex align-items-center">
                    <i class="bi bi-person-plus-fill fs-3 me-3"></i>
                    <div>
                        <h4 class="modal-title mb-0" id="modalRegistroLabel">Registrar Nuevo Docente</h4>
                        <small class="opacity-75">Complete todos los campos requeridos</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <!-- Body del Modal -->
            <div class="modal-body p-4">
                <form id="formRegistroDocente" novalidate>

                    <!-- Progreso de llenado -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-muted">Progreso del formulario</span>
                            <span class="small text-muted"><span id="progresoTexto">0</span>% completado</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" id="barraProgreso" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>

                    <!-- Sección 1: Información Personal -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 text-primary">
                                <i class="bi bi-person-circle me-2"></i>1. Información Personal
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="regDni" class="form-label fw-bold">
                                        DNI <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="regDni" maxlength="8"
                                        placeholder="12345678" required pattern="[0-9]{8}">
                                    <div class="invalid-feedback">DNI debe tener 8 dígitos</div>
                                </div>

                                <div class="col-md-3">
                                    <label for="regNombres" class="form-label fw-bold">
                                        Nombres <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="regNombres"
                                        placeholder="" required>
                                    <div class="invalid-feedback">Los nombres son obligatorios</div>
                                </div>

                                <div class="col-md-3">
                                    <label for="regApellidoPaterno" class="form-label fw-bold">
                                        Apellido Paterno <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="regApellidoPaterno"
                                        placeholder="" required>
                                    <div class="invalid-feedback">Apellido paterno es obligatorio</div>
                                </div>

                                <div class="col-md-3">
                                    <label for="regApellidoMaterno" class="form-label fw-bold">
                                        Apellido Materno
                                    </label>
                                    <input type="text" class="form-control" id="regApellidoMaterno"
                                        placeholder="">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="regFechaNacimiento" class="form-label fw-bold">
                                        Fecha de Nacimiento
                                    </label>
                                    <input type="date" class="form-control" id="regFechaNacimiento">
                                </div>

                                <div class="col-md-4">
                                    <label for="regSexo" class="form-label fw-bold">
                                        Sexo
                                    </label>
                                    <select class="form-select" id="regSexo">
                                        <option value="">Seleccionar</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="regCelular" class="form-label fw-bold">
                                        Celular
                                    </label>
                                    <input type="tel" class="form-control" id="regCelular"
                                        placeholder="" maxlength="9">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label for="regEmail" class="form-label fw-bold">
                                        Correo Electrónico
                                    </label>
                                    <input type="email" class="form-control" id="regEmail"
                                        placeholder="">
                                    <div class="invalid-feedback">Ingrese un email válido</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 2: Ubicación -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 text-info">
                                <i class="bi bi-geo-alt-fill me-2"></i>2. Ubicación
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="regDireccion" class="form-label fw-bold">
                                        Dirección Completa
                                    </label>
                                    <textarea class="form-control" id="regDireccion" rows="2"
                                        placeholder=""></textarea>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="regProvincia" class="form-label fw-bold">
                                        Provincia
                                    </label>
                                    <input type="text" class="form-control" id="regProvincia"
                                        placeholder="" value="">
                                </div>

                                <div class="col-md-4">
                                    <label for="regDistrito" class="form-label fw-bold">
                                        Distrito
                                    </label>
                                    <select class="form-select" id="regDistrito">
                                        <option value="">Seleccionar distrito</option>
                                        <option value="Lambayeque">Lambayeque</option>
                                        <option value="Chiclayo">Chiclayo</option>
                                        <option value="Ferreñafe">Ferreñafe</option>
                                        <option value="Mórrope">Mórrope</option>
                                        <option value="Olmos">Olmos</option>
                                        <option value="Pacora">Pacora</option>
                                        <option value="Salas">Salas</option>
                                        <option value="Túcume">Túcume</option>
                                        <option value="Illimo">Illimo</option>
                                        <option value="Jayanca">Jayanca</option>
                                        <option value="Motupe">Motupe</option>
                                        <option value="Chóchope">Chóchope</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="regZona" class="form-label fw-bold">
                                        Zona
                                    </label>
                                    <select class="form-select" id="regZona">
                                        <option value="">Seleccionar zona</option>
                                        <option value="Urbana">Urbana</option>
                                        <option value="Rural">Rural</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 3: Información Institucional -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 text-warning">
                                <i class="bi bi-building me-2"></i>3. Información Institucional
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="regInstitucion" class="form-label fw-bold">
                                        Nombre de la Institución Educativa
                                    </label>
                                    <input type="text" class="form-control" id="regInstitucion"
                                        placeholder="">
                                </div>

                                <div class="col-md-4">
                                    <label for="regGestion" class="form-label fw-bold">
                                        Gestión
                                    </label>
                                    <select class="form-select" id="regGestion">
                                        <option value="">Seleccionar</option>
                                        <option value="Estatal">Estatal</option>
                                        <option value="Privado">Privado</option>
                                        <option value="Convenio">Convenio</option>
                                        <option value="Sede Administrativa">Sede Administrativa</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="regTipoIE" class="form-label fw-bold">
                                        Tipo de I.E.
                                    </label>
                                    <select class="form-select" id="regTipoIE">
                                        <option value="">Seleccionar</option>
                                        <option value="Unidocente">Unidocente</option>
                                        <option value="Multigrado">Multigrado</option>
                                        <option value="Polidocente Completo">Polidocente Completo</option>
                                        <option value="No Aplica">No Aplica</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="regCargo" class="form-label fw-bold">
                                        Cargo
                                    </label>
                                    <input type="text" class="form-control" id="regCargo"
                                        placeholder="Profesor de Matemáticas">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 4: Información Laboral -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 text-success">
                                <i class="bi bi-briefcase-fill me-2"></i>4. Información Laboral
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="regTipoTrabajador" class="form-label fw-bold">
                                        Tipo de Trabajador
                                    </label>
                                    <select class="form-select" id="regTipoTrabajador">
                                        <option value="">Seleccionar</option>
                                        <option value="Docente">Docente</option>
                                        <option value="Administrador">Administrador</option>
                                        <option value="CAS">CAS</option>
                                        <option value="CAS Indeterminado">CAS Indeterminado</option>
                                        <option value="CAS Transitorio">CAS Transitorio</option>
                                        <option value="Director de Sistema Administrador CAS">Director de Sistema Administrador CAS</option>
                                        <option value="Profesor por Horas CAS">Profesor por Horas CAS</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="regSubTipoTrabajador" class="form-label fw-bold">
                                        Sub Tipo de Trabajador
                                    </label>
                                    <select class="form-select" id="regSubTipoTrabajador">
                                        <option value="">Seleccionar</option>
                                        <option value="Docente">Docente</option>
                                        <option value="Directivo">Directivo</option>
                                        <option value="Jerárquico">Jerárquico</option>
                                        <option value="Técnico">Técnico</option>
                                        <option value="Auxiliar">Auxiliar</option>
                                        <option value="Especialistas Administrativos e Instituciones de las UGEL">Especialistas Administrativos e Instituciones de las UGEL</option>
                                        <option value="Auxiliar de Educación">Auxiliar de Educación</option>
                                        <option value="PEC">PEC</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="regSituacionLaboral" class="form-label fw-bold">
                                        Situación Laboral
                                    </label>
                                    <select class="form-select" id="regSituacionLaboral">
                                        <option value="">Seleccionar</option>
                                        <option value="Nombrado">Nombrado</option>
                                        <option value="Contratado">Contratado</option>
                                        <option value="Encargado">Encargado</option>
                                        <option value="Designado">Designado</option>
                                        <option value="Vacante">Vacante</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen de datos -->
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-clipboard-check me-2"></i>Resumen de Datos
                            </h5>
                        </div>
                        <div class="card-body">
                            <div id="resumenDatos" class="row">
                                <div class="col-12 text-center text-muted">
                                    <i class="bi bi-info-circle fs-1 mb-3"></i>
                                    <p>Complete los campos para ver el resumen</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Footer del Modal -->
            <div class="modal-footer bg-light">
                <div class="d-flex justify-content-between w-100">
                    <div class="d-flex align-items-center">
                        <small class="text-muted">
                            <i class="bi bi-shield-check me-1"></i>
                            Los campos marcados con <span class="text-danger">*</span> son obligatorios
                        </small>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg me-1"></i>Cancelar
                        </button>
                        <button type="button" class="btn btn-success" id="btnGuardarDocente">
                            <i class="bi bi-check-lg me-1"></i>Guardar Docente
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS personalizado para el modal -->
<style>
    .modal-xl {
        max-width: 1200px;
    }

    .card {
        border: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
    }

    .card-header {
        border-bottom: 2px solid #e9ecef;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .invalid-feedback {
        display: block;
    }

    .progress {
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar {
        transition: width 0.3s ease;
    }

    #resumenDatos .resumen-item {
        background: #f8f9fa;
        border-radius: 6px;
        padding: 8px 12px;
        margin-bottom: 8px;
        border-left: 3px solid #0d6efd;
    }

    .modal-dialog-scrollable .modal-body {
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }

    /* Animaciones suaves */
    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .modal-xl {
            max-width: 95%;
            margin: 1rem auto;
        }

        .modal-dialog-scrollable .modal-body {
            max-height: calc(100vh - 150px);
        }
    }
</style>

<!-- MODAL PARA REGISTRO DE NUEVO DOCENTE -->
<div class="modal fade" id="modalRegistroDocente" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Header del Modal -->
            <div class="modal-header bg-primary text-white">
                <div class="d-flex align-items-center">
                    <i class="bi bi-person-plus-fill fs-3 me-3"></i>
                    <div>
                        <h4 class="modal-title mb-0" id="modalRegistroLabel">Registrar Nuevo Docente</h4>
                        <small class="opacity-75">Complete todos los campos requeridos</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <!-- Body del Modal -->
            <div class="modal-body p-4">
                <form id="formRegistroDocente" novalidate>

                    <!-- Progreso de llenado -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-muted">Progreso del formulario</span>
                            <span class="small text-muted"><span id="progresoTexto">0</span>% completado</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" id="barraProgreso" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>

                    <!-- Sección 1: Información Personal -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 text-primary">
                                <i class="bi bi-person-circle me-2"></i>1. Información Personal
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="regDni" class="form-label fw-bold">
                                        DNI <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="regDni" maxlength="8"
                                        placeholder="12345678" required pattern="[0-9]{8}">
                                    <div class="invalid-feedback">DNI debe tener 8 dígitos</div>
                                </div>

                                <div class="col-md-3">
                                    <label for="regNombres" class="form-label fw-bold">
                                        Nombres <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="regNombres"
                                        placeholder="Juan Carlos" required>
                                    <div class="invalid-feedback">Los nombres son obligatorios</div>
                                </div>

                                <div class="col-md-3">
                                    <label for="regApellidoPaterno" class="form-label fw-bold">
                                        Apellido Paterno <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="regApellidoPaterno"
                                        placeholder="García" required>
                                    <div class="invalid-feedback">Apellido paterno es obligatorio</div>
                                </div>

                                <div class="col-md-3">
                                    <label for="regApellidoMaterno" class="form-label fw-bold">
                                        Apellido Materno
                                    </label>
                                    <input type="text" class="form-control" id="regApellidoMaterno"
                                        placeholder="López">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="regFechaNacimiento" class="form-label fw-bold">
                                        Fecha de Nacimiento
                                    </label>
                                    <input type="date" class="form-control" id="regFechaNacimiento">
                                </div>

                                <div class="col-md-4">
                                    <label for="regSexo" class="form-label fw-bold">
                                        Sexo
                                    </label>
                                    <select class="form-select" id="regSexo">
                                        <option value="">Seleccionar</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="regCelular" class="form-label fw-bold">
                                        Celular
                                    </label>
                                    <input type="tel" class="form-control" id="regCelular"
                                        placeholder="999999999" maxlength="9">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label for="regEmail" class="form-label fw-bold">
                                        Correo Electrónico
                                    </label>
                                    <input type="email" class="form-control" id="regEmail"
                                        placeholder="usuario@ejemplo.com">
                                    <div class="invalid-feedback">Ingrese un email válido</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 2: Ubicación -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 text-info">
                                <i class="bi bi-geo-alt-fill me-2"></i>2. Ubicación
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="regDireccion" class="form-label fw-bold">
                                        Dirección Completa
                                    </label>
                                    <textarea class="form-control" id="regDireccion" rows="2"
                                        placeholder="Av. Principal 123, Urbanización Los Olivos"></textarea>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="regProvincia" class="form-label fw-bold">
                                        Provincia
                                    </label>
                                    <input type="text" class="form-control" id="regProvincia"
                                        placeholder="Lambayeque" value="Lambayeque">
                                </div>

                                <div class="col-md-4">
                                    <label for="regDistrito" class="form-label fw-bold">
                                        Distrito
                                    </label>
                                    <select class="form-select" id="regDistrito">
                                        <option value="">Seleccionar distrito</option>
                                        <option value="Lambayeque">Lambayeque</option>
                                        <option value="Chiclayo">Chiclayo</option>
                                        <option value="Ferreñafe">Ferreñafe</option>
                                        <option value="Mórrope">Mórrope</option>
                                        <option value="Olmos">Olmos</option>
                                        <option value="Pacora">Pacora</option>
                                        <option value="Salas">Salas</option>
                                        <option value="Túcume">Túcume</option>
                                        <option value="Illimo">Illimo</option>
                                        <option value="Jayanca">Jayanca</option>
                                        <option value="Motupe">Motupe</option>
                                        <option value="Chóchope">Chóchope</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="regZona" class="form-label fw-bold">
                                        Zona
                                    </label>
                                    <select class="form-select" id="regZona">
                                        <option value="">Seleccionar zona</option>
                                        <option value="Urbana">Urbana</option>
                                        <option value="Rural">Rural</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 3: Información Institucional -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 text-warning">
                                <i class="bi bi-building me-2"></i>3. Información Institucional
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="regInstitucion" class="form-label fw-bold">
                                        Nombre de la Institución Educativa
                                    </label>
                                    <input type="text" class="form-control" id="regInstitucion"
                                        placeholder="I.E. San José de Chiclayo">
                                </div>

                                <div class="col-md-4">
                                    <label for="regGestion" class="form-label fw-bold">
                                        Gestión
                                    </label>
                                    <select class="form-select" id="regGestion">
                                        <option value="">Seleccionar</option>
                                        <option value="Estatal">Estatal</option>
                                        <option value="Privado">Privado</option>
                                        <option value="Convenio">Convenio</option>
                                        <option value="Sede Administrativa">Sede Administrativa</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="regTipoIE" class="form-label fw-bold">
                                        Tipo de I.E.
                                    </label>
                                    <select class="form-select" id="regTipoIE">
                                        <option value="">Seleccionar</option>
                                        <option value="Unidocente">Unidocente</option>
                                        <option value="Multigrado">Multigrado</option>
                                        <option value="Polidocente Completo">Polidocente Completo</option>
                                        <option value="No Aplica">No Aplica</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="regCargo" class="form-label fw-bold">
                                        Cargo
                                    </label>
                                    <input type="text" class="form-control" id="regCargo"
                                        placeholder="Profesor de Matemáticas">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 4: Información Laboral -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 text-success">
                                <i class="bi bi-briefcase-fill me-2"></i>4. Información Laboral
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="regTipoTrabajador" class="form-label fw-bold">
                                        Tipo de Trabajador
                                    </label>
                                    <select class="form-select" id="regTipoTrabajador">
                                        <option value="">Seleccionar</option>
                                        <option value="Docente">Docente</option>
                                        <option value="Administrador">Administrador</option>
                                        <option value="CAS">CAS</option>
                                        <option value="CAS Indeterminado">CAS Indeterminado</option>
                                        <option value="CAS Transitorio">CAS Transitorio</option>
                                        <option value="Director de Sistema Administrador CAS">Director de Sistema Administrador CAS</option>
                                        <option value="Profesor por Horas CAS">Profesor por Horas CAS</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="regSubTipoTrabajador" class="form-label fw-bold">
                                        Sub Tipo de Trabajador
                                    </label>
                                    <select class="form-select" id="regSubTipoTrabajador">
                                        <option value="">Seleccionar</option>
                                        <option value="Docente">Docente</option>
                                        <option value="Directivo">Directivo</option>
                                        <option value="Jerárquico">Jerárquico</option>
                                        <option value="Técnico">Técnico</option>
                                        <option value="Auxiliar">Auxiliar</option>
                                        <option value="Especialistas Administrativos e Instituciones de las UGEL">Especialistas Administrativos e Instituciones de las UGEL</option>
                                        <option value="Auxiliar de Educación">Auxiliar de Educación</option>
                                        <option value="PEC">PEC</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="regSituacionLaboral" class="form-label fw-bold">
                                        Situación Laboral
                                    </label>
                                    <select class="form-select" id="regSituacionLaboral">
                                        <option value="">Seleccionar</option>
                                        <option value="Nombrado">Nombrado</option>
                                        <option value="Contratado">Contratado</option>
                                        <option value="Encargado">Encargado</option>
                                        <option value="Designado">Designado</option>
                                        <option value="Vacante">Vacante</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen de datos -->
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-clipboard-check me-2"></i>Resumen de Datos
                            </h5>
                        </div>
                        <div class="card-body">
                            <div id="resumenDatos" class="row">
                                <div class="col-12 text-center text-muted">
                                    <i class="bi bi-info-circle fs-1 mb-3"></i>
                                    <p>Complete los campos para ver el resumen</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Footer del Modal -->
            <div class="modal-footer bg-light">
                <div class="d-flex justify-content-between w-100">
                    <div class="d-flex align-items-center">
                        <small class="text-muted">
                            <i class="bi bi-shield-check me-1"></i>
                            Los campos marcados con <span class="text-danger">*</span> son obligatorios
                        </small>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg me-1"></i>Cancelar
                        </button>
                        <button type="button" class="btn btn-success" id="btnGuardarDocente">
                            <i class="bi bi-check-lg me-1"></i>Guardar Docente
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS personalizado para el modal -->
<style>
    .modal-xl {
        max-width: 1200px;
    }

    .card {
        border: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
    }

    .card-header {
        border-bottom: 2px solid #e9ecef;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .invalid-feedback {
        display: block;
    }

    .progress {
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar {
        transition: width 0.3s ease;
    }

    #resumenDatos .resumen-item {
        background: #f8f9fa;
        border-radius: 6px;
        padding: 8px 12px;
        margin-bottom: 8px;
        border-left: 3px solid #0d6efd;
    }

    .modal-dialog-scrollable .modal-body {
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }

    /* Animaciones suaves */
    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .modal-xl {
            max-width: 95%;
            margin: 1rem auto;
        }

        .modal-dialog-scrollable .modal-body {
            max-height: calc(100vh - 150px);
        }
    }
</style>









































<!-- jQuery (requerido para usar $.ajax) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- script
 script
 script
 script
 script
 script
 script
 script
 script
 script
 script
 script
 script
 script
-->


<script>
    // ===== JAVASCRIPT PARA EL MODAL DE REGISTRO DE DOCENTE =====

    $(document).ready(function() {
        // Inicializar funcionalidades del modal
        inicializarModalDocente();
    });

    function inicializarModalDocente() {
        // Event listeners
        configurarEventListeners();

        // Validaciones en tiempo real
        configurarValidacionesEnVivo();

        // Configurar cálculo de progreso
        configurarCalculoProgreso();
    }

    function configurarEventListeners() {
        // Abrir modal desde el botón de registrar nuevo
        $('#btnRegistrarNuevo').off('click').on('click', function() {
            const dni = $('#inputDNI').val();
            abrirModalRegistro(dni);
        });

        // Guardar docente
        $('#btnGuardarDocente').on('click', function() {
            guardarNuevoDocente();
        });

        // Validar DNI solo números
        $('#regDni').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').substring(0, 8);
            validarCampoDNI();
        });

        // Validar celular solo números
        $('#regCelular').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').substring(0, 9);
        });

        // Validar email
        $('#regEmail').on('blur', function() {
            validarEmail();
        });

        // Actualizar resumen cuando cambien los campos principales
        $('#regNombres, #regApellidoPaterno, #regApellidoMaterno, #regDni, #regInstitucion, #regCargo').on('input', function() {
            actualizarResumen();
        });

        // Actualizar resumen cuando cambien los selects
        $('#regSexo, #regDistrito, #regGestion, #regTipoTrabajador, #regSituacionLaboral').on('change', function() {
            actualizarResumen();
        });
    }

    function configurarValidacionesEnVivo() {
        // Validación en tiempo real para campos requeridos
        $('#regNombres, #regApellidoPaterno').on('input', function() {
            const valor = $(this).val().trim();
            if (valor.length >= 2) {
                $(this).removeClass('is-invalid').addClass('is-valid');
            } else {
                $(this).removeClass('is-valid').addClass('is-invalid');
            }
            calcularProgreso();
        });
    }

    function configurarCalculoProgreso() {
        // Campos que se consideran para el progreso
        const camposProgreso = [
            '#regDni', '#regNombres', '#regApellidoPaterno', '#regSexo',
            '#regCelular', '#regEmail', '#regDireccion', '#regDistrito',
            '#regInstitucion', '#regGestion', '#regCargo', '#regTipoTrabajador'
        ];

        camposProgreso.forEach(campo => {
            $(campo).on('input change', calcularProgreso);
        });

        // Calcular progreso inicial
        calcularProgreso();
    }

    function abrirModalRegistro(dni = '') {
        // Limpiar formulario
        limpiarFormulario();

        // Prellenar DNI si viene del input
        if (dni && dni.length === 8) {
            $('#regDni').val(dni);
            validarCampoDNI();
        }

        // Resetear progreso
        calcularProgreso();

        // Mostrar modal
        const modal = new bootstrap.Modal(document.getElementById('modalRegistroDocente'));
        modal.show();

        // Foco en el primer campo vacío
        setTimeout(() => {
            if (!$('#regDni').val()) {
                $('#regDni').focus();
            } else {
                $('#regNombres').focus();
            }
        }, 500);
    }

    function limpiarFormulario() {
        // Limpiar todos los campos
        $('#formRegistroDocente')[0].reset();

        // Remover clases de validación
        $('#formRegistroDocente .form-control, #formRegistroDocente .form-select')
            .removeClass('is-valid is-invalid');

        // Limpiar resumen
        $('#resumenDatos').html(`
        <div class="col-12 text-center text-muted">
            <i class="bi bi-info-circle fs-1 mb-3"></i>
            <p>Complete los campos para ver el resumen</p>
        </div>
    `);

        // Resetear progreso
        $('#barraProgreso').css('width', '0%');
        $('#progresoTexto').text('0');
    }

    function validarCampoDNI() {
        const dni = $('#regDni').val();
        const dniRegex = /^\d{8}$/;

        if (dniRegex.test(dni)) {
            $('#regDni').removeClass('is-invalid').addClass('is-valid');
            return true;
        } else {
            $('#regDni').removeClass('is-valid').addClass('is-invalid');
            return false;
        }
    }

    function validarEmail() {
        const email = $('#regEmail').val();
        if (!email) return true; // Email es opcional

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (emailRegex.test(email)) {
            $('#regEmail').removeClass('is-invalid').addClass('is-valid');
            return true;
        } else {
            $('#regEmail').removeClass('is-valid').addClass('is-invalid');
            return false;
        }
    }

    function calcularProgreso() {
        const campos = [{
                id: '#regDni',
                peso: 15
            },
            {
                id: '#regNombres',
                peso: 15
            },
            {
                id: '#regApellidoPaterno',
                peso: 10
            },
            {
                id: '#regSexo',
                peso: 5
            },
            {
                id: '#regCelular',
                peso: 5
            },
            {
                id: '#regEmail',
                peso: 5
            },
            {
                id: '#regDireccion',
                peso: 5
            },
            {
                id: '#regDistrito',
                peso: 5
            },
            {
                id: '#regInstitucion',
                peso: 10
            },
            {
                id: '#regGestion',
                peso: 5
            },
            {
                id: '#regCargo',
                peso: 10
            },
            {
                id: '#regTipoTrabajador',
                peso: 10
            }
        ];

        let progresoTotal = 0;

        campos.forEach(campo => {
            const valor = $(campo.id).val();
            if (valor && valor.trim() !== '') {
                progresoTotal += campo.peso;
            }
        });

        // Actualizar barra de progreso
        $('#barraProgreso').css('width', progresoTotal + '%');
        $('#progresoTexto').text(progresoTotal);

        // Cambiar color según progreso
        const barra = $('#barraProgreso');
        barra.removeClass('bg-danger bg-warning bg-success');

        if (progresoTotal < 40) {
            barra.addClass('bg-danger');
        } else if (progresoTotal < 80) {
            barra.addClass('bg-warning');
        } else {
            barra.addClass('bg-success');
        }
    }

    function actualizarResumen() {
        const datos = obtenerDatosFormulario();

        // Verificar si hay datos suficientes para mostrar resumen
        if (!datos.nombres && !datos.apellido_paterno && !datos.dni) {
            $('#resumenDatos').html(`
            <div class="col-12 text-center text-muted">
                <i class="bi bi-info-circle fs-1 mb-3"></i>
                <p>Complete los campos para ver el resumen</p>
            </div>
        `);
            return;
        }

        const nombreCompleto = `${datos.nombres} ${datos.apellido_paterno} ${datos.apellido_materno}`.trim();

        let html = `
        <div class="col-md-6">
            <div class="resumen-item">
                <strong>👤 Nombre:</strong><br>
                <span class="text-primary">${nombreCompleto || 'No especificado'}</span>
            </div>
            <div class="resumen-item">
                <strong>🆔 DNI:</strong> 
                <span class="badge bg-primary">${datos.dni || 'No especificado'}</span>
            </div>
            <div class="resumen-item">
                <strong>📱 Contacto:</strong><br>
                ${datos.celular ? `📞 ${datos.celular}` : '📞 No especificado'}<br>
                ${datos.email ? `📧 ${datos.email}` : '📧 No especificado'}
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="resumen-item">
                <strong>🏫 Institución:</strong><br>
                <span class="text-success">${datos.institucion || 'No especificada'}</span>
            </div>
            <div class="resumen-item">
                <strong>💼 Cargo:</strong><br>
                <span class="text-warning">${datos.cargo || 'No especificado'}</span>
            </div>
            <div class="resumen-item">
                <strong>📍 Ubicación:</strong><br>
                ${datos.distrito || 'No especificado'}, ${datos.provincia || 'Lambayeque'}
            </div>
        </div>
    `;

        $('#resumenDatos').html(html);
    }

    function obtenerDatosFormulario() {
        return {
            dni: $('#regDni').val().trim(),
            nombres: $('#regNombres').val().trim(),
            apellido_paterno: $('#regApellidoPaterno').val().trim(),
            apellido_materno: $('#regApellidoMaterno').val().trim(),
            fecha_nacimiento: $('#regFechaNacimiento').val(),
            sexo: $('#regSexo').val(),
            celular: $('#regCelular').val().trim(),
            email: $('#regEmail').val().trim(),
            direccion: $('#regDireccion').val().trim(),
            provincia: $('#regProvincia').val().trim() || 'Lambayeque',
            distrito: $('#regDistrito').val(),
            zona: $('#regZona').val(),
            institucion: $('#regInstitucion').val().trim(),
            gestion: $('#regGestion').val(),
            tipo_ie: $('#regTipoIE').val(),
            cargo: $('#regCargo').val().trim(),
            tipo_trabajador: $('#regTipoTrabajador').val(),
            sub_tipo_trabajador: $('#regSubTipoTrabajador').val(),
            situacion_laboral: $('#regSituacionLaboral').val()
        };
    }

    function validarFormularioCompleto() {
        let esValido = true;
        const errores = [];

        // Validar campos obligatorios
        const camposObligatorios = [{
                id: '#regDni',
                nombre: 'DNI'
            },
            {
                id: '#regNombres',
                nombre: 'Nombres'
            },
            {
                id: '#regApellidoPaterno',
                nombre: 'Apellido Paterno'
            }
        ];

        camposObligatorios.forEach(campo => {
            const valor = $(campo.id).val().trim();
            if (!valor) {
                $(campo.id).addClass('is-invalid');
                errores.push(campo.nombre);
                esValido = false;
            } else {
                $(campo.id).removeClass('is-invalid').addClass('is-valid');
            }
        });

        // Validar DNI específicamente
        if (!validarCampoDNI()) {
            errores.push('DNI debe tener 8 dígitos');
            esValido = false;
        }

        // Validar email si está presente
        if (!validarEmail()) {
            errores.push('Email debe tener formato válido');
            esValido = false;
        }

        // Mostrar errores si los hay
        if (!esValido) {
            Swal.fire({
                title: 'Campos requeridos',
                html: `Por favor complete los siguientes campos:<br><br>
                   <ul class="text-start">
                       ${errores.map(error => `<li>${error}</li>`).join('')}
                   </ul>`,
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
        }

        return esValido;
    }

    function guardarNuevoDocente() {
        // Validar formulario
        if (!validarFormularioCompleto()) {
            return;
        }

        // Obtener datos
        const datos = obtenerDatosFormulario();

        // Confirmar guardado
        Swal.fire({
            title: '¿Confirmar registro?',
            html: `
            <div class="text-start">
                <p><strong>Se registrará el siguiente docente:</strong></p>
                <ul>
                    <li><strong>DNI:</strong> ${datos.dni}</li>
                    <li><strong>Nombre:</strong> ${datos.nombres} ${datos.apellido_paterno} ${datos.apellido_materno}</li>
                    <li><strong>Institución:</strong> ${datos.institucion || 'No especificada'}</li>
                    <li><strong>Cargo:</strong> ${datos.cargo || 'No especificado'}</li>
                </ul>
            </div>
        `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-check-lg me-1"></i>Sí, registrar',
            cancelButtonText: '<i class="bi bi-x-lg me-1"></i>Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                ejecutarRegistroDocente(datos);
            }
        });
    }

    function ejecutarRegistroDocente(datos) {
        // Mostrar loading
        Swal.fire({
            title: 'Registrando docente...',
            html: 'Por favor espere mientras se procesa la información',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Enviar datos al servidor
        $.ajax({
            method: 'POST',
            url: 'data/clssConsultas.php',
            data: {
                accion: 'REGISTRAR_NUEVO_DOCENTE',
                jsDatos: JSON.stringify(datos)
            },
            success: function(response) {
                procesarRespuestaRegistro(response, datos);
            },
            error: function(xhr, status, error) {
                console.error('Error en el registro:', error);
                mostrarErrorRegistro('Error de conexión con el servidor');
            }
        });
    }

    function procesarRespuestaRegistro(response, datos) {
        try {
            const resultado = JSON.parse(response);

            if (resultado.estado === true) {
                // Registro exitoso
                Swal.fire({
                    title: '¡Docente registrado exitosamente!',
                    html: `
                    <div class="text-center">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        <p class="mt-3 mb-3">
                            <strong>${datos.nombres} ${datos.apellido_paterno}</strong><br>
                            ha sido registrado correctamente
                        </p>
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-primary" onclick="seleccionarDocenteRecienRegistrado('${datos.dni}')">
                                <i class="bi bi-person-check me-2"></i>Seleccionar este docente
                            </button>
                            <button type="button" class="btn btn-success" onclick="registrarOtroDocente()">
                                <i class="bi bi-person-plus me-2"></i>Registrar otro docente
                            </button>
                        </div>
                    </div>
                `,
                    icon: 'success',
                    showConfirmButton: true,
                    confirmButtonText: 'Cerrar',
                    allowOutsideClick: false
                }).then(() => {
                    // Cerrar modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalRegistroDocente'));
                    if (modal) {
                        modal.hide();
                    }
                });

            } else {
                mostrarErrorRegistro(resultado.mensaje || 'Error desconocido al registrar');
            }

        } catch (error) {
            console.error('Error al procesar respuesta:', error);
            mostrarErrorRegistro('Error al procesar la respuesta del servidor');
        }
    }

    function mostrarErrorRegistro(mensaje) {
        Swal.fire({
            title: 'Error en el registro',
            text: mensaje,
            icon: 'error',
            confirmButtonText: 'Intentar nuevamente',
            footer: '<small>Si el problema persiste, contacte al administrador del sistema</small>'
        });
    }

    function seleccionarDocenteRecienRegistrado(dni) {
        // Cerrar el modal de registro
        const modal = bootstrap.Modal.getInstance(document.getElementById('modalRegistroDocente'));
        if (modal) {
            modal.hide();
        }

        // Cerrar cualquier SweetAlert abierto
        Swal.close();

        // Buscar y seleccionar el docente recién registrado
        setTimeout(() => {
            $('#inputDNI').val(dni);
            $('#inputDNI').trigger('keyup');

            // Dar tiempo para que aparezcan los resultados
            setTimeout(() => {
                // Hacer clic en el primer resultado (que debería ser el recién registrado)
                $('.list-group-item').first().trigger('click');
            }, 1000);
        }, 500);
    }

    function registrarOtroDocente() {
        // Cerrar SweetAlert
        Swal.close();

        // Limpiar formulario pero mantener modal abierto
        limpiarFormulario();

        // Foco en DNI
        setTimeout(() => {
            $('#regDni').focus();
        }, 300);
    }

    // ===== FUNCIONES AUXILIARES =====

    function capitalizarTexto(texto) {
        return texto.toLowerCase().replace(/\b\w/g, function(l) {
            return l.toUpperCase();
        });
    }

    // Auto-capitalizar nombres y apellidos
    $('#regNombres, #regApellidoPaterno, #regApellidoMaterno').on('blur', function() {
        const valor = $(this).val();
        if (valor) {
            $(this).val(capitalizarTexto(valor));
            actualizarResumen();
        }
    });

    // Auto-capitalizar institución
    $('#regInstitucion').on('blur', function() {
        const valor = $(this).val();
        if (valor) {
            $(this).val(capitalizarTexto(valor));
            actualizarResumen();
        }
    });

    // Validación de edad mínima (18 años)
    $('#regFechaNacimiento').on('change', function() {
        const fechaNacimiento = new Date($(this).val());
        const hoy = new Date();
        const edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
        const mesActual = hoy.getMonth();
        const mesNacimiento = fechaNacimiento.getMonth();

        if (mesActual < mesNacimiento || (mesActual === mesNacimiento && hoy.getDate() < fechaNacimiento.getDate())) {
            edad--;
        }

        if (edad < 18) {
            $(this).addClass('is-invalid');
            Swal.fire({
                title: 'Edad mínima requerida',
                text: 'El docente debe ser mayor de 18 años',
                icon: 'warning',
                timer: 3000
            });
        } else {
            $(this).removeClass('is-invalid').addClass('is-valid');
        }
    });

    // Autocompletar provincia por defecto
    $('#regProvincia').val('Lambayeque');

    // Prevenir envío del formulario con Enter
    $('#formRegistroDocente').on('submit', function(e) {
        e.preventDefault();
        guardarNuevoDocente();
    });
</script>
<script>
    $(document).ready(function() {
        $('#idSelectAreas').select2({
            placeholder: "Selecciona una o varias oficinas",
            width: '100%'
        });
    });
</script>
<script>
    $('#btnRegistrarNuevo').off('click').on('click', function() {
    const dni = $('#inputDNI').val();
    
    if (!dni || dni.length !== 8) {
        Swal.fire("DNI requerido", "Ingrese un DNI válido de 8 dígitos para registrar.", "warning");
        $('#inputDNI').focus();
        return;
    }
    
    // Abrir modal de registro
    abrirModalRegistro(dni);
});

    // ✅ Variable global para controlar selección
    let selectedIndex = -1;

    // ✅ Validación de números en el input
    function validarNumero(event) {
        let dni = event.target.value;
        event.target.value = dni.replace(/[^0-9]/g, ''); // Solo números
    }

    $(document).ready(function() {
        // ✅ Al escribir en el input
        $('#inputDNI').on('input', validarNumero);

        $('#inputDNI').on('keyup', function() {
            const valor = $(this).val();
            const prevSelectedIndex = selectedIndex;

            if (valor.length >= 2) {
                $.ajax({
                    method: "POST",
                    url: "data/clssConsultas.php",
                    data: {
                        accion: "BUSCARDOCENTE",
                        datos: valor
                    },
                    success: function(resultado) {
                        let resulParsee = JSON.parse(resultado);
                        let html = '';

                        if (resulParsee.datos.length > 0) {
                            console.log(resulParsee)
                            html = '<ul class="list-group">';
                            $.each(resulParsee.datos, function(index, persona) {
                                html += `<li class="list-group-item" 
                                  data-dni="${persona["dni"]}" 
                                  data-distrito="${persona.distrito}" 
                                  data-direccion="${persona.direccion}" 
                                  data-tipo_ie="${persona.tipo_ie}" 
                                  data-gestion="${persona.gestion}" 
                                  data-zona="${persona.zona}" 
                                  data-nivel_educativo="${persona.nivel_educativo}" 
                                  data-nombre_institucion_educativa="${persona.nombre_institucion_educativa}" 
                                  data-tipo_trabajador="${persona.tipo_trabajador}" 
                                  data-sub_tipo_trabajador="${persona.sub_tipo_trabajador}" 
                                  data-cargo="${persona.cargo}" 
                                  data-situacion_laboral="${persona.situacion_laboral}" 
                                  data-fecha_nacimiento="${persona.fecha_nacimiento}" 
                                  data-sexo="${persona.sexo}" 
                                  data-apellido_paterno="${persona.apellido_paterno}" 
                                  data-apellido_materno="${persona.apellido_materno}" 
                                  data-nombres="${persona.nombres}" 
                                  data-celular="${persona.celular}" 
                                  data-email="${persona.email}" 
                                  data-provincia="${persona.provincia}" 
                                  data-distrito_institucional="${persona.distrito_institucional}">
                                    ${persona.dni} - ${persona.nombres} ${persona.apellido_paterno}
                                </li>`;
                            });
                            html += '</ul>';
                            document.getElementById("contenedorBtnRegistrar").style.display = "none";
                        } else {
                            html = '<p class="text-muted" style="font-size:18px">No se encuentra registrado pase a registrarse.</p>';
                            document.getElementById("contenedorBtnRegistrar").style.display = "block";

                        }

                        $('#resultados').html(html);

                        let items = $('#resultados .list-group-item');
                        if (items.length > 0 && prevSelectedIndex >= 0 && prevSelectedIndex < items.length) {
                            selectedIndex = prevSelectedIndex;
                            actualizarSeleccion(items);
                        } else {
                            selectedIndex = -1;

                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error en la solicitud AJAX:", error);
                    }
                });
            } else {
                $('#resultados').html('');
                selectedIndex = -1;
                document.getElementById("contenedorBtnRegistrar").style.display = "block";
            }
        });

        // ✅ Teclas especiales: flechas y Enter
        $(document).on('keydown', '#inputDNI', function(event) {
            let items = $('#resultados .list-group-item');
            if (items.length === 0) return;

            if (event.key === 'ArrowDown') {
                event.preventDefault();
                selectedIndex = (selectedIndex + 1) % items.length;
                actualizarSeleccion(items);
            } else if (event.key === 'ArrowUp') {
                event.preventDefault();
                selectedIndex = (selectedIndex - 1 + items.length) % items.length;
                actualizarSeleccion(items);
            } else if (event.key === 'Enter') {
                event.preventDefault();
                if (selectedIndex >= 0) {
                    const selectedItem = items.eq(selectedIndex);
                    selectedItem.trigger('click'); // ⬅️ Esto ya oculta la lista y llena los datos
                    // NO pongas $('#resultados').html('') aquí, ya se hace dentro del evento 'click'
                    selectedIndex = -1;
                }
            }
        });

        function actualizarSeleccion(items) {
            items.removeClass('active');
            if (selectedIndex >= 0 && selectedIndex < items.length) {
                items.eq(selectedIndex).addClass('active');
            }
        }

        // ✅ Cuando se hace clic en un docente
        $(document).on('click', '.list-group-item', function() {
            document.getElementById("contenidoDocente").style.display = "block";
            document.getElementById("idContenedorBotones").style.display = "block";

            const dni = $(this).data('dni');
            const distrito = $(this).data('distrito');
            const direccion = $(this).data('direccion');
            const tipoIE = $(this).data('tipo_ie');
            const gestion = $(this).data('gestion');
            const zona = $(this).data('zona');
            const nivelEducativo = $(this).data('nivel_educativo');
            const nombreInstitucion = $(this).data('nombre_institucion_educativa');
            const tipoTrabajador = $(this).data('tipo_trabajador');
            const subTipoTrabajador = $(this).data('sub_tipo_trabajador');
            const cargo = $(this).data('cargo');
            const situacionLaboral = $(this).data('situacion_laboral');
            const fechaNacimiento = $(this).data('fecha_nacimiento');
            const sexo = $(this).data('sexo');
            const apellidoPaterno = $(this).data('apellido_paterno');
            const apellidoMaterno = $(this).data('apellido_materno');
            const nombres = $(this).data('nombres');
            const celular = $(this).data('celular');
            const email = $(this).data('email');
            const provincia = $(this).data('provincia');
            const distritoInstitucional = $(this).data('distrito_institucional');

            // ✅ Completa los campos
            $('#idNombrePersona').text(`${nombres} ${apellidoPaterno} ${apellidoMaterno}`);
            $('#idDNI').text(dni);
            $('#idDistrito').text(distrito);
            $('#idDireccion').text(direccion);
            $('#idTipoIE').text(tipoIE);
            $('#idGestion').text(gestion);
            $('#idZona').text(zona);
            $('#idNivelEducativo').text(nivelEducativo);
            $('#idNombreInstitucion').text(nombreInstitucion);
            $('#idTipoTrabajador').text(tipoTrabajador);
            $('#idSubTipoTrabajador').text(subTipoTrabajador);
            $('#idCargo').text(cargo);
            $('#idSituacionLaboral').text(situacionLaboral);
            $('#idFechaNacimiento').text(fechaNacimiento);
            $('#idSexo').text(sexo);
            document.getElementById("editNombres").value = nombres;
            document.getElementById("editApellidoPaterno").value = apellidoPaterno;
            document.getElementById("editApellidoMaterno").value = apellidoMaterno;
            $('#idCelular').text(celular);
            $('#idEmail').text(email);
            $('#idProvincia').text(provincia);
            $('#idDistritoInstitucional').text(distritoInstitucional);

            $('#inputDNI').val(dni);
            $('#resultados').html('');

            // ✅ Verificación AJAX extra
            $.ajax({
                method: "POST",
                url: "data/clssConsultas.php",
                data: {
                    accion: 'VERIFICARDOCENTESALIDA',
                    dni: dni
                },
                success: function(response) {
                    try {
                        var result = JSON.parse(response);
                        console.log(result)
                        if (result.cantidad === 0) {
                            $("#idSelectAreas").show();
                            $("#divSelectAreas").show();
                            $("#idBtnEntrada").show();
                            $("#idBtnSalida").hide();
                        } else if (result.cantidad === 1) {
                            console.log("Jorgito quiere con la My")
                            $("#idSelectAreas").hide();
                            $("#divSelectAreas").hide();
                            $("#idBtnEntrada").hide();
                            $("#idBtnSalida").show();
                        }
                    } catch (e) {
                        console.log("Error al parsear JSON: ", e);
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Error: " + error);
                }
            });
        });
    });
</script>



<script>
    function editarDatos() {
        $('#editDireccion').val($('#idDireccion').text());
        $('#editProvincia').val($('#idProvincia').text());
        $('#editDistrito').val($('#idDistrito').text());
        $('#editZona').val($('#idZona').text());
        $('#editInstitucion').val($('#idNombreInstitucion').text());
        $('#editGestion').val($('#idGestion').text());
        $('#editTipoIE').val($('#idTipoIE').text());
        $('#editCargo').val($('#idCargo').text());
        $('#editTipoTrabajador').val($('#idTipoTrabajador').text());
        $('#editSubTipoTrabajador').val($('#idSubTipoTrabajador').text());
        $('#editSituacionLaboral').val($('#idSituacionLaboral').text());
        $('#editCelular').val($('#idCelular').text());
        $('#editEmail').val($('#idEmail').text());
        $('#editFechaNacimiento').val($('#idFechaNacimiento').text());
        $('#editSexo').val($('#idSexo').text().charAt(0)); // M o F

        let modal = new bootstrap.Modal(document.getElementById('modalEditarDatos'));
        modal.show();
    }

    function guardarEdicion() {
        const datos = {
            dni: $('#idDNI').text(),
            nombres: $('#editNombres').val(),
            apellido_paterno: $('#editApellidoPaterno').val(),
            apellido_materno: $('#editApellidoMaterno').val(),
            direccion: $('#editDireccion').val(),
            provincia: $('#editProvincia').val(),
            distrito: $('#editDistrito').val(),
            zona: $('#editZona').val(),
            institucion: $('#editInstitucion').val(),
            gestion: $('#editGestion').val(),
            tipo_ie: $('#editTipoIE').val(),
            cargo: $('#editCargo').val(),
            tipo_trabajador: $('#editTipoTrabajador').val(),
            sub_tipo_trabajador: $('#editSubTipoTrabajador').val(),
            situacion_laboral: $('#editSituacionLaboral').val(),
            celular: $('#editCelular').val(),
            email: $('#editEmail').val(),
            fecha_nacimiento: $('#editFechaNacimiento').val(),
            sexo: $('#editSexo').val()
        };

        // Verifica los datos antes de enviarlos
        console.log("Datos enviados:", datos);

        $.ajax({
            method: 'POST',
            url: 'data/clssConsultas.php',
            data: {
                accion: 'EDITAR_DOCENTE_COMPLETO',
                jsDatos: JSON.stringify(datos)
            },
            success: function(response) {
                console.log("Respuesta del servidor: ", response); // Verifica lo que el servidor devuelve

                try {
                    const result = JSON.parse(response); // Intenta parsear la respuesta
                    console.log(result)
                    if (result.estado === true) {
                        Swal.fire("¡Actualizado!", result.mensaje, "success");

                        // Actualizar el DOM sin recargar la página
                        $('#idNombrePersona').text(`${datos.nombres} ${datos.apellido_paterno} ${datos.apellido_materno}`);
                        $('#idApellidoPaterno').text(datos.apellido_paterno);
                        $('#idApellidoMaterno').text(datos.apellido_materno);

                        $('#idDireccion').text(datos.direccion);
                        $('#idProvincia').text(datos.provincia);
                        $('#idDistrito').text(datos.distrito);
                        $('#idZona').text(datos.zona);
                        $('#idNombreInstitucion').text(datos.institucion);
                        $('#idGestion').text(datos.gestion);
                        $('#idTipoIE').text(datos.tipo_ie);
                        $('#idCargo').text(datos.cargo);
                        $('#idTipoTrabajador').text(datos.tipo_trabajador);
                        $('#idSubTipoTrabajador').text(datos.sub_tipo_trabajador);
                        $('#idSituacionLaboral').text(datos.situacion_laboral);
                        $('#idCelular').text(datos.celular);
                        $('#idEmail').text(datos.email);
                        $('#idFechaNacimiento').text(datos.fecha_nacimiento);
                        $('#idSexo').text(datos.sexo);

                        // Cerrar el modal
                        let modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarDatos'));
                        modal.hide();
                    } else {
                        Swal.fire("Error", result.mensaje, "error");
                    }
                } catch (e) {
                    console.error("Error al parsear JSON:", e);
                    Swal.fire("Error", "La respuesta del servidor es inválida", "error");
                }
            },
            error: function() {
                Swal.fire("Error", "Fallo en la conexión con el servidor", "error");
            }
        });
    }



    function fnRegistroEntrada() {
        var jsAreasSelect = [];
        $('#idSelectAreas option:selected').each(function() {
            jsAreasSelect.push({
                id: parseInt($(this).val()),
                oficina: $(this).text()
            });
        });


        const areasSeleccionadas = $('#idSelectAreas').val(); // 👈 esto devuelve un array de IDs seleccionados
        const dniPersona = $('#idDNI').text();

        if (!areasSeleccionadas || areasSeleccionadas.length === 0) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Falta seleccionar al menos un área",
            });
            return;
        }

        // Puedes enviar todas las áreas o solo tomar la primera si es obligatorio uno solo
        console.log(areasSeleccionadas);
        const areaId = areasSeleccionadas[0]; // 🟡 usa el primero de la lista

        const jsDatos = {
            area_id: parseInt(areaId),
            dni: dniPersona,
            areas_visita: (jsAreasSelect)
        };

        $.ajax({
            method: "POST",
            url: "data/clssConsultas.php",
            data: {
                accion: 'INSERTENTRADADOCENTE',
                jsDatos: JSON.stringify(jsDatos)
            },
            success: function(response) {
                console.log("Resultado de mrd" + response)
                try {

                    const result = JSON.parse(response);

                    if (result.estado === true) {
                        const horaActual = new Date().toLocaleTimeString('es-PE', {
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit',
                            hour12: true
                        });

                        Swal.fire({
                            title: "Entrada registrada correctamente",
                            html: `<p style="font-size: 1.5rem; margin-top: 10px;">🕒 Hora: <strong>${horaActual}</strong></p>`,
                            icon: "success"
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire("Error", result.mensaje, "error");
                    }
                } catch (e) {
                    Swal.fire("Error", "Respuesta inválida del servidor", "error");
                    console.log(e)
                }
            },
            error: function() {
                Swal.fire("Error", "Fallo en la conexión con el servidor", "error");
            }
        });
    }



    function fnSalidadDocente() {
        let dniDocenteDeMrd = document.getElementById("idDNI").innerText;

        $.ajax({
            method: "POST",
            url: "data/clssConsultas.php",
            data: {
                accion: 'UPDATESALIDADOCENTE',
                dni: dniDocenteDeMrd
            },
            success: function(response) {
                console.log("Respuesta del servidor: ", response);

                try {
                    var result = JSON.parse(response);
                    if (result.estado === true) {
                        const horaActual = new Date().toLocaleTimeString('es-PE', {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: true
                        });

                        // ✅ OBTENER DATOS COMPLETOS ANTES DE MOSTRAR EL MODAL
                        obtenerDatosCompletosParaTicket(dniDocenteDeMrd, horaActual);

                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Error en el Registro, Llamar al encargado de sistemas",
                        });
                    }
                } catch (e) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Error en el Registro, Llamar al encargado de sistemas",
                    });
                }
            },
            error: function(xhr, status, error) {
                console.log("Error: " + error);
            }
        });
    }

    function obtenerDatosCompletosParaTicket(dni, horaSalida) {
        $.ajax({
            method: "POST",
            url: "data/clssConsultas.php",
            data: {
                accion: 'OBTENER_ULTIMO_REGISTRO_COMPLETO',
                dni: dni
            },
            success: function(response) {
                try {
                    var resultado = JSON.parse(response);
                    if (resultado.estado === true && resultado.datos) {
                        // Guardar datos en variable global para el ticket
                        window.datosTicketActual = {
                            dni: dni,
                            nombreCompleto: $('#idNombrePersona').text(),
                            institucion: $('#idNombreInstitucion').text() || 'N/A',
                            cargo: $('#idCargo').text() || 'N/A',
                            fecha: new Date().toLocaleDateString('es-PE', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            }),
                            horaSalida: horaSalida,
                            areasVisitadas: resultado.datos.areas_visitadas || 'No especificadas',
                            horaEntrada: resultado.datos.hora_entrada || 'N/A'
                        };

                        // Ahora mostrar el modal con las áreas correctas
                        mostrarModalTicket(horaSalida);
                    } else {
                        console.error('No se pudieron obtener los datos completos');
                        // Fallback: usar datos básicos
                        window.datosTicketActual = obtenerDatosTicketBasico(horaSalida);
                        mostrarModalTicket(horaSalida);
                    }
                } catch (e) {
                    console.error('Error al procesar datos del ticket:', e);
                    // Fallback: usar datos básicos
                    window.datosTicketActual = obtenerDatosTicketBasico(horaSalida);
                    mostrarModalTicket(horaSalida);
                }
            },
            error: function() {
                console.error('Error al obtener datos completos');
                // Fallback: usar datos básicos
                window.datosTicketActual = obtenerDatosTicketBasico(horaSalida);
                mostrarModalTicket(horaSalida);
            }
        });
    }

    function mostrarModalTicket(horaActual) {
        Swal.fire({
            title: "¡Salida registrada correctamente!",
            html: `
            <div class="text-center mb-4">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                <p class="fs-4 mt-3">🕒 <strong>${horaActual}</strong></p>
            </div>
            
            <div class="d-grid gap-3">
                <button type="button" class="btn btn-primary btn-lg py-3" onclick="imprimirTicket(); Swal.close();">
                    <i class="bi bi-printer me-2"></i> Imprimir Ticket de Salida
                </button>
            </div>
        `,
            width: '450px',
            showConfirmButton: true,
            confirmButtonText: "Continuar sin imprimir",
            allowOutsideClick: false
        }).then(() => {
            location.reload();
        });
    }
    // Función fallback para datos básicos (en caso de error)
    function obtenerDatosTicketBasico(horaSalida = null) {
        return {
            dni: $('#idDNI').text() || 'N/A',
            nombreCompleto: $('#idNombrePersona').text() || 'N/A',
            institucion: $('#idNombreInstitucion').text() || 'N/A',
            cargo: $('#idCargo').text() || 'N/A',
            fecha: new Date().toLocaleDateString('es-PE', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            }),
            horaSalida: horaSalida || new Date().toLocaleTimeString('es-PE', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            }),
            areasVisitadas: 'No se pudieron obtener las áreas visitadas',
            horaEntrada: 'N/A'
        };
    }

    // ✅ FUNCIÓN MEJORADA: Imprimir ticket DIRECTO (sin vista previa)
    function imprimirTicket() {
        // Usar los datos globales obtenidos de la BD
        const datos = window.datosTicketActual || obtenerDatosTicketBasico();

        // Crear ventana de impresión OCULTA
        const ventanaImpresion = window.open('', '_blank', 'width=1,height=1,left=-1000,top=-1000');

        const ticketHTML = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Ticket de Salida</title>
            <style>
                @media print {
                    @page {
                        size: 80mm auto;
                        margin: 5mm;
                    }
                    body { margin: 0; }
                }
                
                body {
                    font-family: 'Courier New', monospace;
                    font-size: 12px;
                    line-height: 1.4;
                    width: 80mm;
                    margin: 0 auto;
                    padding: 10px;
                }
                
                .header {
                    text-align: center;
                    border-bottom: 2px solid #000;
                    padding-bottom: 10px;
                    margin-bottom: 15px;
                }
                
                .logo {
                    font-size: 18px;
                    font-weight: bold;
                    margin-bottom: 5px;
                }
                
                .subtitle {
                    font-size: 11px;
                    margin-bottom: 5px;
                }
                
                .ticket-number {
                    font-size: 10px;
                    margin-top: 5px;
                }
                
                .section {
                    margin-bottom: 15px;
                }
                
                .label {
                    font-weight: bold;
                    display: inline-block;
                    width: 120px;
                }
                
                .center {
                    text-align: center;
                }
                
                .divider {
                    border-top: 1px dashed #000;
                    margin: 15px 0;
                }
                
                .footer {
                    text-align: center;
                    font-size: 10px;
                    margin-top: 20px;
                }
                
                .status-section {
                    text-align: center;
                    background: #f0f0f0;
                    padding: 10px;
                    margin: 15px 0;
                    border: 1px solid #000;
                }
                
                .areas-section {
                    background: #f9f9f9;
                    padding: 8px;
                    border: 1px solid #ccc;
                    margin: 10px 0;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <div class="logo">🏛️ UGEL LAMBAYEQUE</div>
                <div class="subtitle">Sistema de Control de Visitas</div>
                <div class="ticket-number">TICKET #${Date.now().toString().slice(-6)}</div>
            </div>
            
            <div class="status-section">
                <div style="font-size: 14px; font-weight: bold; margin-bottom: 5px;">
                    ✅ SALIDA REGISTRADA
                </div>
                <div style="font-size: 12px;">
                    ${datos.fecha}
                </div>
            </div>
            
            <div class="section">
                <div><span class="label">DNI:</span> ${datos.dni}</div>
                <div><span class="label">Visitante:</span></div>
                <div style="margin-left: 10px; font-weight: bold;">${datos.nombreCompleto}</div>
            </div>
            
            <div class="section">
                <div><span class="label">Institución:</span></div>
                <div style="margin-left: 10px;">${datos.institucion}</div>
                <div><span class="label">Cargo:</span> ${datos.cargo}</div>
            </div>
            
            <div class="divider"></div>
            
            <div class="section">
                <div><span class="label">Hora Entrada:</span> ${datos.horaEntrada}</div>
                <div><span class="label">Hora Salida:</span></div>
                <div style="font-size: 16px; font-weight: bold; text-align: center; margin: 10px 0;">
                    🕐 ${datos.horaSalida}
                </div>
            </div>
            
            <div class="areas-section">
                <div style="font-weight: bold; margin-bottom: 5px;">🏢 Áreas Visitadas:</div>
                <div style="font-size: 11px; line-height: 1.3;">
                    ${datos.areasVisitadas}
                </div>
            </div>
            
            <div class="divider"></div>
            
            <div class="footer">
                <div style="font-weight: bold; margin-bottom: 10px;">¡Gracias por su visita!</div>
                <div>UGEL Lambayeque</div>
                <div>www.ugel-lambayeque.gob.pe</div>
                <div style="margin-top: 15px; font-size: 8px; border-top: 1px solid #ccc; padding-top: 5px;">
                    Generado el: ${new Date().toLocaleString('es-PE')}
                </div>
            </div>
        </body>
        </html>
    `;

        ventanaImpresion.document.write(ticketHTML);
        ventanaImpresion.document.close();

        // IMPRIMIR INMEDIATAMENTE (sin mostrar ventana)
        setTimeout(function() {
            ventanaImpresion.print();

            // Cerrar la ventana oculta después de imprimir
            setTimeout(function() {
                ventanaImpresion.close();
            }, 1000);
        }, 100);

        // Mostrar mensaje de confirmación inmediato
        Swal.fire({
            title: '🖨️ Enviando a impresión...',
            text: 'El ticket se está imprimiendo directamente',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false,
            allowOutsideClick: false
        });
    }



    // ===== FUNCIÓN PARA OBTENER DATOS DEL TICKET =====
    function obtenerDatosTicket() {
        // Obtener áreas visitadas del último registro
        let areasVisitadas = 'No especificadas';
        try {
            const areas = [];
            $('#idSelectAreas option:selected').each(function() {
                areas.push($(this).text());
            });
            if (areas.length > 0) {
                areasVisitadas = areas.join(', ');
            }
        } catch (e) {
            console.log('Error obteniendo áreas:', e);
        }

        const datos = {
            dni: $('#idDNI').text() || 'N/A',
            nombreCompleto: $('#idNombrePersona').text() || 'N/A',
            institucion: $('#idNombreInstitucion').text() || 'N/A',
            cargo: $('#idCargo').text() || 'N/A',
            fecha: new Date().toLocaleDateString('es-PE', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            }),
            horaSalida: new Date().toLocaleTimeString('es-PE', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            }),
            areasVisitadas: areasVisitadas
        };

        return datos;
    }
</script>



<?php include("pie.php"); ?>