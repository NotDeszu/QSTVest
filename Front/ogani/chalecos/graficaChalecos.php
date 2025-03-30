<?php
require_once '../../../BD/conexion.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>chalecos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="../css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="../css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="../css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="../css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="../css/style.css" type="text/css">
</head>

<body>

<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__left">
                        <ul>
                            <li><i class="fa fa-envelope"></i>
                                <?php
                                if (empty($_SESSION["usu_id"])) {
                                    echo " ";
                                } else {
                                    echo $_SESSION["usu_email"];
                                }
                                ?>
                            </li>
                            <li>Envios a toda la republica Mexicana</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">
                        <div class="header__top__right__social">

                            <!-- Esta parte muestra un link hacia el panel administrador, si es que el usuario logeado tiene el rol de admin -->
                            <?php
                            if (isset($_SESSION["rol_id"])) {
                                if ($_SESSION["rol_id"] == 0) {
                                    echo " ";
                                } elseif ($_SESSION["rol_id"] == 1) { ?>
                                    <a href="../../indexAdmin.php">Pagina de Administrador</a>
                            <?php
                                } else {
                                    echo " ";
                                }
                            } else {
                                echo " ";
                            }
                            ?>
                            <?php
                            if (isset($_SESSION["rol_id"])) {
                                echo '<a href="HistoriaC.php">Ver Mis compras</a>';
                            }
                            ?>
                            <!-- fin -->
                            <a href="https://www.facebook.com/casakuri"><i class="fa fa-facebook"></i></a>
                            <a href="https://www.instagram.com/casa.kuri/"><i class="fa fa-instagram"></i></a>
                        </div>
                        <div class="header__top__right__auth">
                            <a href="../controlador_cerrars2.php"><i class="fa fa-user"></i>
                                <?php
                                if (empty($_SESSION["usu_id"])) {
                                    echo "Iniciar Sesion";
                                } else {
                                    echo "Cerrar Sesion";
                                }
                                ?>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Aqui termina el header top -->
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="header__logo">
                    <a href="../index.php"><img src="../img/logo rm qs.png" alt="" width="200"></a>
                </div>
            </div>
            <div class="col-lg-8">
                <nav class="header__menu">
                    <ul>
                        <li><a href="../index.php">Inicio</a></li>
                        <li><a href="../shop-grid.php">Productos</a></li>
                        <li><a href="../blog.php">Mis chalecos</a></li>
                        <li><a href="../contact.php">Contactanos</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="blog__details__content">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="blog__details__text">
                                <h3>Monitoreo de datos en tiempo real</h3>
                                <p>A continuación se muestran las gráficas de los datos enviados desde el chaleco inteligente</p>
                            </div>
                            
                            <!-- BPM Chart -->
                            <div class="blog__details__chart mb-5">
                                <h4>Frecuencia Cardíaca (BPM)</h4>
                                <canvas id="bpmChart" width="750" height="300"></canvas>
                            </div>
                            
                            <!-- Decibels Chart -->
                            <div class="blog__details__chart mb-5">
                                <h4>Decibeles (dB)</h4>
                                <canvas id="dbChart" width="750" height="300"></canvas>
                            </div>
                            
                            <!-- Gas Chart -->
                            <div class="blog__details__chart mb-5">
                                <h4>Sensor de Gas</h4>
                                <canvas id="gasChart" width="750" height="300"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="blog__details__sidebar">
                                <div class="blog__details__sidebar__item">
                                    <h4>Datos en tiempo real</h4>
                                    <div id="latestData">
                                        <p>Cargando datos...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>