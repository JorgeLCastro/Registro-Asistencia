<?php
session_start();

// Si ya está autenticado, redirigir
if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === true) {
    header('Location: registros.php');
    exit();
}

// Configuración simple para administrador
$CLAVE_ADMIN = 'Admin2025'; // Cambia esta contraseña
$MAX_INTENTOS = 5;
$TIEMPO_BLOQUEO = 300; // 15 minutos

// Inicializar contador de intentos
if (!isset($_SESSION['intentos_login'])) {
    $_SESSION['intentos_login'] = 0;
    $_SESSION['tiempo_bloqueo'] = 0;
}

$error = '';
$bloqueado = false;

// Verificar si está bloqueado
if ($_SESSION['intentos_login'] >= $MAX_INTENTOS) {
    $tiempo_restante = $_SESSION['tiempo_bloqueo'] - time();
    if ($tiempo_restante > 0) {
        $bloqueado = true;
        $minutos_restantes = ceil($tiempo_restante / 60);
        $error = "Demasiados intentos fallidos. Espere $minutos_restantes minutos.";
    } else {
        // Reset del bloqueo
        $_SESSION['intentos_login'] = 0;
        $_SESSION['tiempo_bloqueo'] = 0;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$bloqueado) {
    $claveIngresada = trim($_POST['password'] ?? '');
    
    if ($claveIngresada === $CLAVE_ADMIN) {
        // Login exitoso
        $_SESSION['intentos_login'] = 0;
        $_SESSION['tiempo_bloqueo'] = 0;
        $_SESSION['autenticado'] = true;
        $_SESSION['es_admin'] = true;
        $_SESSION['nombre_usuario'] = 'Administrador';
        $_SESSION['tiempo_login'] = time();
        
        header('Location: registros.php');
        exit();
    } else {
        // Login fallido
        $_SESSION['intentos_login']++;
        
        if ($_SESSION['intentos_login'] >= $MAX_INTENTOS) {
            $_SESSION['tiempo_bloqueo'] = time() + $TIEMPO_BLOQUEO;
            $error = "Demasiados intentos fallidos. Acceso bloqueado por 15 minutos.";
        } else {
            $intentos_restantes = $MAX_INTENTOS - $_SESSION['intentos_login'];
            $error = "Contraseña incorrecta. Intentos restantes: $intentos_restantes";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Administrador - UGEL Lambayeque</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            min-height: 100vh;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .logo-section {
            background: linear-gradient(45deg, #e74c3c, #c0392b);
            border-radius: 20px 20px 0 0;
        }
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            z-index: 10;
        }
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        .btn-admin {
            background: linear-gradient(45deg, #e74c3c, #c0392b);
            border: none;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-admin:hover {
            background: linear-gradient(45deg, #c0392b, #a93226);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(231, 76, 60, 0.3);
        }
        .attempts-indicator {
            background: linear-gradient(45deg, #f39c12, #e67e22);
            color: white;
            border: none;
        }
        .blocked-alert {
            background: linear-gradient(45deg, #e74c3c, #c0392b);
            color: white;
            border: none;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                <div class="login-card">
                    <!-- Header -->
                    <div class="logo-section text-white text-center py-4">
                        <i class="bi bi-shield-lock fs-1 mb-3"></i>
                        <h3 class="mb-2">UGEL Lambayeque</h3>
                        <p class="mb-0 opacity-75">Panel de Administración</p>
                    </div>
                    
                    <!-- Formulario -->
                    <div class="p-4">
                        <div class="text-center mb-4">
                            <h5 class="text-dark mb-2">🔐 Acceso Restringido</h5>
                            <p class="text-muted small">Solo personal autorizado</p>
                        </div>
                        
                        <!-- Alertas -->
                        <?php if ($error): ?>
                        <div class="alert <?= $bloqueado ? 'blocked-alert' : ($_SESSION['intentos_login'] > 2 ? 'attempts-indicator' : 'alert-danger') ?> d-flex align-items-center mb-3">
                            <i class="bi <?= $bloqueado ? 'bi-lock-fill' : 'bi-exclamation-triangle-fill' ?> me-2"></i>
                            <div><?= htmlspecialchars($error) ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Indicador de intentos -->
                        <?php if ($_SESSION['intentos_login'] > 0 && $_SESSION['intentos_login'] < $MAX_INTENTOS && !$bloqueado): ?>
                        <div class="alert attempts-indicator d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>Intentos:</strong> <?= $_SESSION['intentos_login'] ?>/<?= $MAX_INTENTOS ?>
                            </div>
                            <div class="progress" style="width: 60px; height: 8px;">
                                <div class="progress-bar bg-light" 
                                     style="width: <?= ($_SESSION['intentos_login'] / $MAX_INTENTOS) * 100 ?>%"></div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Formulario de login -->
                        <?php if (!$bloqueado): ?>
                        <form method="POST" id="loginForm">
                            <div class="mb-4">
                                <label for="password" class="form-label fw-bold">
                                    <i class="bi bi-key me-1"></i>Contraseña de Administrador
                                </label>
                                <div class="position-relative">
                                    <input 
                                        type="password" 
                                        name="password" 
                                        id="password"
                                        class="form-control form-control-lg pe-5" 
                                        placeholder="Ingrese la contraseña" 
                                        required 
                                        autocomplete="current-password"
                                        autofocus>
                                    <i class="bi bi-eye password-toggle" id="togglePassword"></i>
                                </div>
                            </div>
                            
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-admin btn-lg py-3" id="loginBtn">
                                    <i class="bi bi-shield-check me-2"></i>Acceder al Sistema
                                </button>
                            </div>
                        </form>
                        <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-hourglass-split fs-1 text-muted mb-3"></i>
                            <p class="text-muted">Sistema bloqueado temporalmente</p>
                            <div id="countdown" class="fs-5 fw-bold text-danger"></div>
                        </div>
                        <?php endif; ?>
                        
                        <hr class="my-4">
                        
                        <div class="d-grid">
                            <a href="index.php" class="btn btn-outline-secondary">
                                <i class="bi bi-house me-2"></i>Ir al Inicio
                            </a>
                        </div>
                        
                        <!-- Info de seguridad -->
                        <div class="mt-4 p-3 bg-light rounded">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-info-circle text-primary me-2"></i>
                                <small class="text-muted">
                                    <strong>Seguridad:</strong> Máximo <?= $MAX_INTENTOS ?> intentos. 
                                    Los accesos son registrados.
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Footer -->
                    <div class="text-center py-3 bg-light rounded-bottom">
                        <small class="text-muted">
                            <i class="bi bi-c-circle me-1"></i>
                            2025 Jorge Castro - Sistema Seguro
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle para mostrar/ocultar contraseña
        document.getElementById('togglePassword')?.addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
        
        // Prevenir envío múltiple
        document.getElementById('loginForm')?.addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Verificando acceso...';
            
            // Re-habilitar después de 3 segundos por si hay error
            setTimeout(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-shield-check me-2"></i>Acceder al Sistema';
            }, 3000);
        });
        
        <?php if ($bloqueado): ?>
        // Countdown para tiempo de bloqueo
        let timeLeft = <?= $_SESSION['tiempo_bloqueo'] - time() ?>;
        const countdownElement = document.getElementById('countdown');
        
        function updateCountdown() {
            if (timeLeft <= 0) {
                location.reload();
                return;
            }
            
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            countdownElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            timeLeft--;
        }
        
        updateCountdown();
        setInterval(updateCountdown, 1000);
        <?php endif; ?>
        
        // Auto-focus en el campo de contraseña
        document.getElementById('password')?.focus();
        
        // Efecto de typing en el placeholder (opcional)
        const passwordField = document.getElementById('password');
        if (passwordField && !<?= $bloqueado ? 'true' : 'false' ?>) {
            const originalPlaceholder = passwordField.placeholder;
            passwordField.placeholder = '';
            
            let i = 0;
            const typingEffect = setInterval(() => {
                if (i < originalPlaceholder.length) {
                    passwordField.placeholder += originalPlaceholder.charAt(i);
                    i++;
                } else {
                    clearInterval(typingEffect);
                }
            }, 100);
        }
    </script>
</body>
</html>