<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Point del gordo Alonso - Makis, Alitas & Chaufa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg,rgb(238, 0, 20),rgb(255, 2, 2));
            color: white;
            line-height: 1.4;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            background: rgba(0,0,0,0.8);
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .logo {
            font-size: 2.8rem;
            font-weight: bold;
            color: #ffc048;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.5);
            line-height: 0.9;
            text-align: center;
        }

        .subtitle {
            font-size: 1.3rem;
            color: #ffffff;
            opacity: 0.9;
        }

        .section {
            background: rgba(255,255,255,0.95);
            color: #333;
            margin: 25px 0;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .section-title {
            font-size: 2.2rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            color: #ff4757;
            text-transform: uppercase;
            border-bottom: 3px solid #ffc048;
            padding-bottom: 10px;
        }

        .menu-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .menu-item:last-child {
            border-bottom: none;
        }

        .item-info {
            flex: 1;
        }

        .item-name {
            font-size: 1.4rem;
            font-weight: bold;
            color: #2c2c2c;
            margin-bottom: 8px;
        }

        .item-description {
            font-size: 0.95rem;
            color: #666;
            margin-bottom: 8px;
        }

        .item-includes {
            font-size: 0.9rem;
            color: #ff4757;
            font-weight: 500;
        }

        .price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #ffc048;
            background: #2c2c2c;
            padding: 8px 15px;
            border-radius: 25px;
            min-width: 80px;
            text-align: center;
        }

        .double-price {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .double-price .price {
            font-size: 1.2rem;
            padding: 5px 10px;
        }

        .alitas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .alitas-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #ff4757;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .highlight-box {
            background: linear-gradient(135deg, #ff4757, #ff3838);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin: 20px 0;
            text-align: center;
        }

        .highlight-title {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .sabores-list {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
        }

        .sabores-title {
            font-weight: bold;
            color: #ff4757;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .logo {
                font-size: 2.5rem;
            }
            
            .section-title {
                font-size: 1.8rem;
            }
            
            .menu-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .alitas-grid {
                grid-template-columns: 1fr;
            }
        }

        .wave-decoration {
            height: 60px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z' fill='%23ffc048'%3E%3C/path%3E%3C/svg%3E") no-repeat center/cover;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div style="display: flex; align-items: center; justify-content: center; gap: 20px; flex-wrap: wrap; margin-bottom: 15px;">
                <img src="assets/img/logocomida.png" alt="Logo" style="width: 80px; height: 80px;">
                <div class="logo">EL DESMADRE<br>DEL SABOR</div>
            </div>
            <div class="subtitle">Makis • Alitas • Chaufa • Hamburguesas</div>
        </div>

        <!-- HAMBURGUESAS -->
        <div class="section">
            <h2 class="section-title">🍔 Hamburguesas</h2>
            <div class="menu-item">
                <div class="item-info">
                    <div class="item-name">Hamburguesa Clásica</div>
                    <div class="item-description">Hamburguesa tradicional con todos los agregados que desees</div>
                </div>
                <div class="price">S/ 10</div>
            </div>
        </div>

        <!-- CHAUFA -->
        <div class="section">
            <h2 class="section-title">🍛 Chaufa</h2>
            <div class="menu-item">
                <div class="item-info">
                    <div class="item-name">Chaufa de Pollo</div>
                    <div class="item-description">Delicioso arroz chaufa peruano con pollo</div>
                </div>
                <div class="price">S/ 12</div>
            </div>
            
            <div class="highlight-box">
                <div class="highlight-title">COMBO CHAUFA</div>
                <div style="display: flex; justify-content: space-around; align-items: center; flex-wrap: wrap; gap: 20px; margin-top: 15px;">
                    <div>
                        <div style="font-size: 1.2rem; margin-bottom: 5px;">Con 4 Alitas</div>
                        <div style="font-size: 1.8rem; font-weight: bold;">S/ 20</div>
                    </div>
                    <div>
                        <div style="font-size: 1.2rem; margin-bottom: 5px;">Con 6 Alitas</div>
                        <div style="font-size: 1.8rem; font-weight: bold;">S/ 25</div>
                    </div>
                </div>
                <div style="margin-top: 15px; font-size: 0.9rem;">
                    Incluye: Chaufa + Papas + Alitas + Gaseosa
                </div>
            </div>
        </div>

        <div class="wave-decoration"></div>

        <!-- MAKIS -->
        <div class="section">
            <h2 class="section-title">🍣 Makis</h2>
            
            <div class="menu-item">
                <div class="item-info">
                    <div class="item-name">6 Piezas</div>
                    <div class="item-includes">INCLUYE: 1 sabor • 1 salsa acevichada • 1 salsa dulce • 1 palito</div>
                </div>
                <div class="price">S/ 10</div>
            </div>

            <div class="menu-item">
                <div class="item-info">
                    <div class="item-name">12 Piezas</div>
                    <div class="item-includes">INCLUYE: 2 sabores • 1 salsa acevichada • 1 salsa dulce • 1 palito</div>
                </div>
                <div class="price">S/ 16</div>
            </div>

            <div class="menu-item">
                <div class="item-info">
                    <div class="item-name">18 Piezas</div>
                    <div class="item-includes">INCLUYE: 2 sabores • 1 salsa acevichada • 2 salsas dulces • 2 palitos</div>
                </div>
                <div class="price">S/ 24</div>
            </div>

            <div class="menu-item">
                <div class="item-info">
                    <div class="item-name">24 Piezas</div>
                    <div class="item-includes">INCLUYE: 2 sabores • 1 salsa acevichada • 2 salsas dulces • 2 palitos</div>
                </div>
                <div class="price">S/ 30</div>
            </div>

            <div class="menu-item">
                <div class="item-info">
                    <div class="item-name">40 Piezas</div>
                    <div class="item-includes">INCLUYE: 3 sabores • 2 salsas acevichadas • 1 salsa dulce • 3 palitos</div>
                </div>
                <div class="price">S/ 40</div>
            </div>

            <div class="menu-item">
                <div class="item-info">
                    <div class="item-name">50 Piezas</div>
                    <div class="item-includes">INCLUYE: 4 sabores • 2 salsas acevichadas • 1 salsa dulce • 4 palitos</div>
                </div>
                <div class="price">S/ 52</div>
            </div>

            <div class="menu-item">
                <div class="item-info">
                    <div class="item-name">60 Piezas</div>
                    <div class="item-includes">INCLUYE: 5 sabores • 2 salsas acevichadas • 1 salsa dulce • 5 palitos</div>
                </div>
                <div class="price">S/ 62</div>
            </div>
        </div>

        <!-- ALITAS -->
        <div class="section">
            <h2 class="section-title">🔥 Alitas</h2>
            
            <div class="sabores-list">
                <div class="sabores-title">SABORES DISPONIBLES:</div>
                <div style="display: flex; gap: 20px; flex-wrap: wrap; justify-content: center;">
                    <span style="background: #ff4757; color: white; padding: 8px 15px; border-radius: 20px; font-weight: bold;">BBQ</span>
                    <span style="background: #ff4757; color: white; padding: 8px 15px; border-radius: 20px; font-weight: bold;">ACEVICHADO</span>
                    <span style="background: #ff4757; color: white; padding: 8px 15px; border-radius: 20px; font-weight: bold;">BUFFALO</span>
                </div>
            </div>

            <div class="alitas-grid">
                <div class="alitas-item">
                    <div>
                        <div style="font-weight: bold; font-size: 1.1rem;">4 Unidades</div>
                    </div>
                    <div class="price">S/ 12</div>
                </div>
                
                <div class="alitas-item">
                    <div>
                        <div style="font-weight: bold; font-size: 1.1rem;">8 Unidades</div>
                    </div>
                    <div class="price">S/ 24</div>
                </div>
                
                <div class="alitas-item">
                    <div>
                        <div style="font-weight: bold; font-size: 1.1rem;">12 Unidades</div>
                    </div>
                    <div class="price">S/ 36</div>
                </div>
                
                <div class="alitas-item">
                    <div>
                        <div style="font-weight: bold; font-size: 1.1rem;">16 Unidades</div>
                    </div>
                    <div class="price">S/ 48</div>
                </div>
                
                <div class="alitas-item">
                    <div>
                        <div style="font-weight: bold; font-size: 1.1rem;">20 Unidades</div>
                    </div>
                    <div class="price">S/ 54</div>
                </div>
            </div>
        </div>

        <div class="wave-decoration"></div>

        <!-- FOOTER -->
        <div style="text-align: center; padding: 30px; background: rgba(0,0,0,0.8); border-radius: 15px; margin-top: 30px;">
            <div style="font-size: 1.5rem; font-weight: bold; color: #ffc048; margin-bottom: 10px;">
                ¡Gracias por elegirnos!
            </div>
            <div style="font-size: 1rem; opacity: 0.9;">
                El Desmadre del Sabor - La fusión perfecta
            </div>
        </div>
    </div>
</body>
</html>