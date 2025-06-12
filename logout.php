<?php
session_start();

// Registrar logout si había sesión activa
if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === true) {
    $usuario = $_SESSION['nombre_usuario'] ?? 'Usuario desconocido';
    $tiempo_sesion = isset($_SESSION['tiempo_login']) ? 
        (time() - $_SESSION['tiempo_login']) : 0;
    $tiempo_formateado = gmdate("H:i:s", $tiempo_sesion);
    
    // Log del logout
    error_log("Logout - Usuario: $usuario, Duración sesión: $tiempo_formateado, IP: " . 
              ($_SERVER['REMOTE_ADDR'] ?? 'Desconocida'));
}

// Limpiar todas las variables de sesión
$_SESSION = array();

// Destruir la cookie de sesión si existe
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destruir la sesión
session_destroy();

// Headers de seguridad
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Redirigir al login con mensaje
header("Location: login.php?logout=success");
exit();
?>