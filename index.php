<?php
include("cabecera.php");
?>

<!-- Hero Section Mejorado -->
<section id="hero" class="hero section position-relative overflow-hidden">
    <!-- Background con gradiente animado -->
    <div class="hero-bg"></div>
    
    <!-- Partículas animadas -->
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <div class="container position-relative" data-aos="zoom-out">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-lg-10">
                
                <!-- Logo y título principal -->
                <div class="text-center mb-5">
                    <div class="hero-logo mb-4" data-aos="fade-down">
                        <img src="assets/img/logo-ugel.png" alt="UGEL Lambayeque" class="logo-img mb-3" 
                             onerror="this.style.display='none'; document.querySelector('.logo-fallback').style.display='block';">
                        <div class="logo-fallback" style="display: none;">
                            <i class="bi bi-building display-1 text-primary mb-3"></i>
                        </div>
                    </div>
                    
                    <h1 class="hero-title" data-aos="fade-up" data-aos-delay="200">
                        <span class="text-primary fw-bold">UGEL</span> 
                        <span class="text-dark">Lambayeque</span>
                    </h1>
                    
                    <div class="hero-subtitle" data-aos="fade-up" data-aos-delay="400">
                        <p class="lead mb-4">
                            Sistema de 
                            <span class="typed-text">
                                <span class="typed" data-typed-items="Control de Visitas, Registro de Personal, Gestión de Horarios, Control de Asistencia"></span>
                                <span class="typed-cursor typed-cursor--blink" aria-hidden="true"></span>
                            </span>
                        </p>
                        <p class="text-muted fs-5">
                            Tecnología al servicio de la educación
                        </p>
                    </div>
                </div>

                <!-- Botones de acción principales -->
                <div class="text-center mb-5" data-aos="fade-up" data-aos-delay="600">
                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                        <a href="control.php" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-lg">
                            <i class="bi bi-person-check-fill me-2"></i>
                            Control de Visitas
                        </a>
                        <a href="registros.php" class="btn btn-outline-primary btn-lg px-5 py-3 rounded-pill">
                            <i class="bi bi-clipboard-data me-2"></i>
                            Ver Registros
                        </a>
                    </div>
                </div>

                <!-- Redes sociales -->
                <div class="text-center" data-aos="fade-up" data-aos-delay="800">
                    <p class="text-muted mb-3">Síguenos en nuestras redes sociales</p>
                    <div class="social-links d-flex justify-content-center gap-3">
                        <a href="https://www.facebook.com/UgelLambayeque.Oficial" class="social-link facebook" target="_blank">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/ugel.lambayeque/" class="social-link instagram" target="_blank">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-link youtube" target="_blank">
                            <i class="bi bi-youtube"></i>
                        </a>
                        <a href="#" class="social-link website" target="_blank">
                            <i class="bi bi-globe"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Sección de características -->
<section class="features-section py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h2 class="display-5 fw-bold text-dark mb-3" data-aos="fade-up">
                    Sistema Integral de Gestión
                </h2>
                <p class="lead text-muted" data-aos="fade-up" data-aos-delay="200">
                    Modernizamos los procesos administrativos con tecnología de vanguardia
                </p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Característica 1 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card h-100">
                    <div class="feature-icon">
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                    <h4 class="feature-title">Control de Visitas</h4>
                    <p class="feature-description">
                        Registro eficiente de entrada y salida de visitantes con seguimiento en tiempo real.
                    </p>
                    <div class="feature-stats">
                        <span class="stat-number" id="totalVisitasHoy">0</span>
                        <span class="stat-label">visitas hoy</span>
                    </div>
                </div>
            </div>

            <!-- Característica 2 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-card h-100">
                    <div class="feature-icon">
                        <i class="bi bi-clipboard-data"></i>
                    </div>
                    <h4 class="feature-title">Reportes Inteligentes</h4>
                    <p class="feature-description">
                        Generación automática de reportes con análisis estadístico y exportación a Excel.
                    </p>
                    <div class="feature-stats">
                        <span class="stat-number" id="totalRegistrosMes">0</span>
                        <span class="stat-label">registros este mes</span>
                    </div>
                </div>
            </div>

            <!-- Característica 3 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="feature-card h-100">
                    <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h4 class="feature-title">Seguridad Avanzada</h4>
                    <p class="feature-description">
                        Sistema seguro con autenticación, registros de auditoría y backup automático.
                    </p>
                    <div class="feature-stats">
                        <span class="stat-number">99.9%</span>
                        <span class="stat-label">uptime</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sección de estadísticas -->
<section class="stats-section py-5 bg-primary text-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-item">
                    <i class="bi bi-people-fill display-4 mb-3"></i>
                    <h3 class="stat-counter" data-target="1250">0</h3>
                    <p class="mb-0">Visitantes Registrados</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-item">
                    <i class="bi bi-building display-4 mb-3"></i>
                    <h3 class="stat-counter" data-target="45">0</h3>
                    <p class="mb-0">Instituciones Conectadas</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-item">
                    <i class="bi bi-clock-history display-4 mb-3"></i>
                    <h3 class="stat-counter" data-target="24">0</h3>
                    <p class="mb-0">Horas de Operación</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-item">
                    <i class="bi bi-graph-up display-4 mb-3"></i>
                    <h3 class="stat-counter" data-target="98">0</h3>
                    <p class="mb-0">% Satisfacción</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CSS personalizado -->
<style>
:root {
    --primary-color: #2c3e50;
    --secondary-color: #3498db;
    --accent-color: #e74c3c;
    --text-dark: #2c3e50;
    --text-light: #7f8c8d;
    --bg-light: #f8f9fa;
}

/* Hero Section */
#hero {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
}

.hero-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 50%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
        radial-gradient(circle at 40% 80%, rgba(120, 219, 255, 0.3) 0%, transparent 50%);
    animation: gradientShift 15s ease infinite;
}

@keyframes gradientShift {
    0%, 100% { transform: rotate(0deg) scale(1); }
    33% { transform: rotate(120deg) scale(1.1); }
    66% { transform: rotate(240deg) scale(0.9); }
}

/* Partículas animadas */
.particles {
    position: absolute;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.particle {
    position: absolute;
    width: 4px;
    height: 4px;
    background: rgba(255, 255, 255, 0.6);
    border-radius: 50%;
    animation: float 6s infinite linear;
}

.particle:nth-child(1) { left: 10%; animation-delay: 0s; animation-duration: 8s; }
.particle:nth-child(2) { left: 20%; animation-delay: 2s; animation-duration: 10s; }
.particle:nth-child(3) { left: 60%; animation-delay: 4s; animation-duration: 6s; }
.particle:nth-child(4) { left: 80%; animation-delay: 6s; animation-duration: 12s; }
.particle:nth-child(5) { left: 90%; animation-delay: 8s; animation-duration: 9s; }

@keyframes float {
    0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
    10% { opacity: 1; }
    90% { opacity: 1; }
    100% { transform: translateY(-100px) rotate(360deg); opacity: 0; }
}

/* Logo y título */
.logo-img {
    max-width: 120px;
    height: auto;
    filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
}

.hero-title {
    font-size: 4rem;
    font-weight: 900;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    margin-bottom: 2rem;
}

.hero-subtitle {
    font-size: 1.5rem;
    color: rgba(255, 255, 255, 0.9);
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}

.typed-text {
    color: #ffffff;
    font-weight: 600;
}

/* Botones */
.btn-primary {
    background: linear-gradient(45deg, #e74c3c, #c0392b);
    border: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(231, 76, 60, 0.4);
}

.btn-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-primary:hover::before {
    left: 100%;
}

.btn-outline-primary {
    border: 2px solid #fff;
    color: #fff;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-3px);
    color: #fff;
    border-color: #fff;
}

/* Redes sociales */
.social-links {
    display: flex;
    gap: 1rem;
}

.social-link {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #fff;
    text-decoration: none;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.social-link:hover {
    transform: translateY(-5px) scale(1.1);
    color: #fff;
}

.social-link.facebook:hover { background: #3b5998; }
.social-link.instagram:hover { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); }
.social-link.youtube:hover { background: #ff0000; }
.social-link.website:hover { background: #2c3e50; }

/* Sección de características */
.features-section {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

.feature-card {
    background: #fff;
    border-radius: 20px;
    padding: 2.5rem 2rem;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    border: 1px solid rgba(255,255,255,0.8);
    position: relative;
    overflow: hidden;
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.feature-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin: 0 auto 1.5rem;
    box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
}

.feature-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 1rem;
}

.feature-description {
    color: var(--text-light);
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.feature-stats {
    padding-top: 1rem;
    border-top: 1px solid #eee;
}

.stat-number {
    display: block;
    font-size: 2rem;
    font-weight: 900;
    color: var(--secondary-color);
}

.stat-label {
    font-size: 0.9rem;
    color: var(--text-light);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Sección de estadísticas */
.stats-section {
    background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
    position: relative;
}

.stats-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="rgba(255,255,255,0.05)"><polygon points="1000,100 1000,0 0,100"/></svg>');
    background-size: cover;
}

.stat-item {
    position: relative;
    z-index: 2;
}

.stat-counter {
    font-size: 3rem;
    font-weight: 900;
    margin-bottom: 0.5rem;
    display: block;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-subtitle {
        font-size: 1.2rem;
    }
    
    .feature-card {
        padding: 2rem 1.5rem;
    }
    
    .stat-counter {
        font-size: 2.5rem;
    }
}

/* Animación de contador */
.counting {
    animation: countUp 2s ease-out;
}

@keyframes countUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<!-- JavaScript para animaciones -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Contador animado
    const counters = document.querySelectorAll('.stat-counter');
    
    const animateCounter = (counter) => {
        const target = parseInt(counter.getAttribute('data-target'));
        const increment = target / 100;
        let current = 0;
        
        const updateCounter = () => {
            if (current < target) {
                current += increment;
                counter.textContent = Math.ceil(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };
        
        updateCounter();
    };
    
    // Intersection Observer para activar contadores
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target.querySelector('.stat-counter');
                if (counter && !counter.classList.contains('counting')) {
                    counter.classList.add('counting');
                    animateCounter(counter);
                }
            }
        });
    });
    
    document.querySelectorAll('.stat-item').forEach(item => {
        observer.observe(item);
    });
    
    // Cargar estadísticas reales (opcional)
    cargarEstadisticasReales();
});

function cargarEstadisticasReales() {
    // Aquí puedes hacer una llamada AJAX para obtener estadísticas reales
    /* 
    $.ajax({
        url: 'data/clssConsultas.php',
        method: 'POST',
        data: { accion: 'OBTENER_ESTADISTICAS_GENERALES' },
        success: function(response) {
            // Actualizar los números con datos reales
        }
    });
    */
}
</script>

<?php
include("pie.php");
?>