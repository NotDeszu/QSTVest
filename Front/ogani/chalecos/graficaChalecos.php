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
    
    <!-- Chart.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
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
    
    <script type="module">
    // Import the functions you need from the SDKs you need
    import { initializeApp } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-app.js";
    import { getAnalytics } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-analytics.js";
    import { getDatabase, ref, onValue } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-database.js";
    
    // Your web app's Firebase configuration
    const firebaseConfig = {
        apiKey: "AIzaSyCzMlLlVZB-mX5BP3jKbQTaxHKKK2h-Z3k",
        authDomain: "qstvest.firebaseapp.com",
        databaseURL: "https://qstvest-default-rtdb.firebaseio.com",
        projectId: "qstvest",
        storageBucket: "qstvest.firebasestorage.app",
        messagingSenderId: "581299055269",
        appId: "1:581299055269:web:5f9b082b0a8b95b497fb4c",
        measurementId: "G-2JD2XZP620"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const analytics = getAnalytics(app);
    const database = getDatabase(app);
    
    console.log("Firebase initialized in graficaChalecos.php");
    
    // Reference to your ESP32 data in Firebase with the new structure
    const bpmRef = ref(database, 'bpm001');
    const dbRef = ref(database, 'db001');
    const gasRef = ref(database, 'gas001');
    
    // Initialize chart data for each sensor
    let chartLabels = [];
    let bpmData = [];
    let dbData = [];
    let gasData = [];
    let bpmChart, dbChart, gasChart;
    
    // Initialize the charts
    function initCharts() {
        // Common chart options to maintain consistent sizing
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 2.5, // Wider than tall
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            animation: {
                duration: 0 // Disable animations to prevent zooming effect
            },
            layout: {
                padding: {
                    left: 10,
                    right: 30,
                    top: 20,
                    bottom: 10
                }
            },
            elements: {
                line: {
                    tension: 0.3 // Smooth curves
                },
                point: {
                    radius: 3
                }
            }
        };
        
        // BPM Chart
        const bpmCtx = document.getElementById('bpmChart');
        if (bpmCtx) {
            bpmChart = new Chart(bpmCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Frecuencia Cardíaca (BPM)',
                        data: bpmData,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    ...chartOptions,
                    scales: {
                        ...chartOptions.scales,
                        y: {
                            ...chartOptions.scales.y,
                            beginAtZero: true
                        }
                    }
                }
            });
        }
        
        // DB Chart
        const dbCtx = document.getElementById('dbChart');
        if (dbCtx) {
            dbChart = new Chart(dbCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Decibeles (dB)',
                        data: dbData,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    ...chartOptions,
                    scales: {
                        ...chartOptions.scales,
                        y: {
                            ...chartOptions.scales.y,
                            beginAtZero: false
                        }
                    }
                }
            });
        }
        
        // Gas Chart
        const gasCtx = document.getElementById('gasChart');
        if (gasCtx) {
            gasChart = new Chart(gasCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Sensor de Gas',
                        data: gasData,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2
                    }]
                },
                options: chartOptions
            });
        }
        
        console.log("Charts initialized successfully");
    }
    
    // Update the charts with new data
    function updateCharts(bpmValue, dbValue, gasValue) {
        // Add timestamp as label (convert to readable format)
        const date = new Date();
        const timeString = date.toLocaleTimeString();
        
        // Keep only the last 10 data points for better visualization
        if (chartLabels.length > 9) {
            chartLabels.shift();
            bpmData.shift();
            dbData.shift();
            gasData.shift();
        }
        
        // Add new data
        chartLabels.push(timeString);
        
        // Parse values appropriately
        const bpmVal = typeof bpmValue === 'object' && bpmValue !== null ? 
                      (bpmValue.value !== undefined ? bpmValue.value : Object.values(bpmValue)[0]) : 
                      bpmValue;
        
        const dbVal = typeof dbValue === 'object' && dbValue !== null ? 
                     (dbValue.value !== undefined ? dbValue.value : Object.values(dbValue)[0]) : 
                     dbValue;
        
        const gasVal = typeof gasValue === 'object' && gasValue !== null ? 
                      (gasValue.value !== undefined ? gasValue.value : Object.values(gasValue)[0]) : 
                      gasValue;
        
        // Add to datasets
        bpmData.push(bpmVal);
        dbData.push(dbVal);
        gasData.push(gasVal);
        
        // Update charts - use non-animated updates to prevent zooming
        if (bpmChart) {
            bpmChart.update('none'); // Disable animation for updates
        }
        if (dbChart) {
            dbChart.update('none'); // Disable animation for updates
        }
        if (gasChart) {
            gasChart.update('none'); // Disable animation for updates
        }
        
        // Update latest data display
        const latestDataElement = document.getElementById('latestData');
        if (latestDataElement) {
            latestDataElement.innerHTML = `
                <p><strong>Frecuencia Cardíaca:</strong> ${bpmVal} BPM</p>
                <p><strong>Decibeles:</strong> ${dbVal} dB</p>
                <p><strong>Sensor de Gas:</strong> ${gasVal}</p>
                <p><strong>Tiempo:</strong> ${timeString}</p>
            `;
        }
    }
    
    // Variable to track initialization and current values
    let initialized = false;
    let currentBpm = null;
    let currentDb = null;
    let currentGas = null;
    
    // Function to update when any data changes
    function checkAndUpdateCharts() {
        if (currentBpm !== null && currentDb !== null && currentGas !== null) {
            if (!initialized) {
                initCharts();
                initialized = true;
            }
            updateCharts(currentBpm, currentDb, currentGas);
        }
    }
    
    // Listen for BPM data changes in Firebase
    onValue(bpmRef, (snapshot) => {
        currentBpm = snapshot.val();
        console.log("BPM data received:", currentBpm);
        checkAndUpdateCharts();
    });
    
    // Listen for DB data changes in Firebase
    onValue(dbRef, (snapshot) => {
        currentDb = snapshot.val();
        console.log("DB data received:", currentDb);
        checkAndUpdateCharts();
    });
    
    // Listen for Gas data changes in Firebase
    onValue(gasRef, (snapshot) => {
        currentGas = snapshot.val();
        console.log("Gas data received:", currentGas);
        checkAndUpdateCharts();
    });
    
    // Initialize charts when document is ready
    document.addEventListener('DOMContentLoaded', function() {
        console.log("DOM Content Loaded, checking for chart elements");
        
        // Check if chart elements exist
        const bpmElement = document.getElementById('bpmChart');
        const dbElement = document.getElementById('dbChart');
        const gasElement = document.getElementById('gasChart');
        
        if (bpmElement && dbElement && gasElement) {
            console.log("All chart elements found, initializing charts");
            initCharts();
            initialized = true;
        } else {
            console.error("Chart elements not found", { 
                bpmFound: !!bpmElement, 
                dbFound: !!dbElement, 
                gasFound: !!gasElement 
            });
        }
    });
    </script>
</body>
</html>