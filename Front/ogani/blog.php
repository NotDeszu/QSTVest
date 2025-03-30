<?php
session_start();
include "../../funciones/usuario.php";
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ogani | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Chart.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    
    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
<!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>  

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="#"><img src="img/logo rm qs.png" alt=""></a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
                <li><a href="#"><i class="fa fa-shopping-cart"></i> <span>1</span></a></li>
            </ul>
            <div class="header__cart__price">item: <span>$150.00</span></div>
        </div>
        <div class="humberger__menu__widget">
            <!-- <div class="header__top__right__language">
                <img src="img/language.png" alt="">
                <div>English</div>
                <span class="arrow_carrot-down"></span>
                <ul>
                    <li><a href="#">Spanis</a></li>
                    <li><a href="#">English</a></li>
                </ul>
            </div> -->
            <div class="header__top__right__auth">
                <a href="controlador_cerrars2.php"><i class="fa fa-user"></i> 
                <?php
                    if(empty($_SESSION["usu_id"])){
                        echo "Iniciar Sesion";
                    }else{
                        echo "Cerrar Sesion";
                    }
                ?>
                </a>
            </div>
        </div>


        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i> 
                <?php
                    if(empty($_SESSION["usu_id"])){
                        echo " ";
                    }else{
                        echo $_SESSION["usu_email"];
                    }
                ?>
                </li>
                <li>Envios a toda la Republica Mexicana</li>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <?php
    include "../../menus/menuFront.php";
    ?>
    <!-- Header Section End -->


    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/chalecosVest.png">
    <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <div class="breadcrumb__option">
                        <p style="visibility: hidden;">Este texto es invisible.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

<!-- Blog Details Section Begin -->
<section class="blog-details spad">
    <?php
        if(empty($_SESSION["usu_id"])){
            include "chalecos/nochaleco.html";
        }else{
            include "chalecos/seleccionChaleco.html";
        }
    ?>
</section>
    <!-- Blog Details Section End -->

    <!-- Related Blog Section Begin -->
    <!-- Related Blog Section End -->

    <!-- Footer Section Begin -->
    <?php
    include "../../menus/footer.html";
    ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    
    <script type="module">
  // Import the functions you need from the SDKs you need
    import { initializeApp } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-app.js";
    import { getAnalytics } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-analytics.js";
    import { getDatabase, ref, onValue } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-database.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
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
        // BPM Chart
        const bpmCtx = document.getElementById('bpmChart').getContext('2d');
        bpmChart = new Chart(bpmCtx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Frecuencia Cardíaca (BPM)',
                    data: bpmData,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    pointRadius: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
        
        // DB Chart
        const dbCtx = document.getElementById('dbChart').getContext('2d');
        dbChart = new Chart(dbCtx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Decibeles (dB)',
                    data: dbData,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    pointRadius: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: false
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
        
        // Gas Chart
        const gasCtx = document.getElementById('gasChart').getContext('2d');
        gasChart = new Chart(gasCtx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Sensor de Gas',
                    data: gasData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    pointRadius: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
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
        
        // Update charts
        bpmChart.update();
        dbChart.update();
        gasChart.update();
        
        // Update latest data display
        document.getElementById('latestData').innerHTML = `
            <p><strong>Frecuencia Cardíaca:</strong> ${bpmVal} BPM</p>
            <p><strong>Decibeles:</strong> ${dbVal} dB</p>
            <p><strong>Sensor de Gas:</strong> ${gasVal}</p>
            <p><strong>Tiempo:</strong> ${timeString}</p>
        `;
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
        checkAndUpdateCharts();
    });
    
    // Listen for DB data changes in Firebase
    onValue(dbRef, (snapshot) => {
        currentDb = snapshot.val();
        checkAndUpdateCharts();
    });
    
    // Listen for Gas data changes in Firebase
    onValue(gasRef, (snapshot) => {
        currentGas = snapshot.val();
        checkAndUpdateCharts();
    });
    </script>

</body>

</html>