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
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li class="active"><a href="./index.php">Home</a></li>
                <li><a href="./shop-grid.php">Shop</a></li>
                <li><a href="#">Pages</a>
                    <ul class="header__menu__dropdown">
                        <li><a href="./shop-details.php">Shop Details</a></li>
                        <li><a href="./shoping-cart.php">Shoping Cart</a></li>
                        <li><a href="./checkout.php">Check Out</a></li>
                        <li><a href="./blog-details.php">Blog Details</a></li>
                    </ul>
                </li>
                <li><a href="./blog.php">Blog</a></li>
                <li><a href="./contact.php">Contact</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
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
                        <h2>QST Vest, llevando la seguridad del futuro a cada trabajador hoy.</h2>
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
            include "nochaleco.html";
        }else{
            include "graficaChalecos.html";
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
    
    // Reference to your ESP32 data in Firebase
    // Change 'esp32_data' to match your actual Firebase path where ESP32 data is stored
    const dataRef = ref(database, '/gas');
    
    // Initialize chart data
    let chartLabels = [];
    let chartData = [];
    let chart;
    
    // Initialize the chart
    function initChart() {
        const ctx = document.getElementById('sensorChart').getContext('2d');
        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Datos del Sensor',
                    data: chartData,
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
                    },
                    title: {
                        display: true,
                        text: 'Datos del ESP32 en tiempo real'
                    }
                }
            }
        });
    }
    
    // Update the chart with new data
    function updateChart(newData) {
        // Add timestamp as label (convert to readable format)
        const date = new Date();
        const timeString = date.toLocaleTimeString();
        
        // Keep only the last 10 data points for better visualization
        if (chartLabels.length > 9) {
            chartLabels.shift();
            chartData.shift();
        }
        
        // Add new data
        chartLabels.push(timeString);
        // If newData is a simple value (number or string), use it directly
        // Otherwise, try to extract the value property
        const dataValue = typeof newData === 'object' && newData !== null ? 
                         (newData.value !== undefined ? newData.value : Object.values(newData)[0]) : 
                         newData;
        
        chartData.push(dataValue);
        
        // Update chart
        chart.update();
        
        // Update latest data display
        document.getElementById('latestData').innerHTML = `
            <p><strong>Último valor:</strong> ${dataValue}</p>
            <p><strong>Tiempo:</strong> ${timeString}</p>
        `;
    }
    
    // Listen for data changes in Firebase
    onValue(dataRef, (snapshot) => {
        const data = snapshot.val();
        if (data) {
            // If chart is not initialized yet, initialize it
            if (!chart) {
                initChart();
            }
            
            // If data is an object with multiple entries (historical data)
            if (typeof data === 'object' && !Array.isArray(data) && Object.keys(data).length > 1) {
                // Convert object to array
                const dataArray = Object.entries(data).map(([key, value]) => {
                    // Handle both value-only data and object data
                    return {
                        key: key,
                        value: typeof value === 'object' ? value.value : value,
                        // Use the key as timestamp if it's numeric, otherwise use current time
                        timestamp: !isNaN(Number(key)) ? Number(key) : Date.now() - (Object.keys(data).length - Object.keys(data).indexOf(key)) * 1000
                    };
                });
                
                // Sort by key (assuming keys are sequential or timestamps)
                dataArray.sort((a, b) => a.timestamp - b.timestamp);
                
                // Reset chart data
                chartLabels = [];
                chartData = [];
                
                // Get the last 10 entries or less
                const recentData = dataArray.slice(-10);
                
                // Add data to chart
                recentData.forEach(entry => {
                    const date = new Date(entry.timestamp);
                    chartLabels.push(date.toLocaleTimeString());
                    chartData.push(entry.value);
                });
                
                // Update chart
                chart.update();
                
                // Update latest data display with the most recent entry
                if (recentData.length > 0) {
                    const latestEntry = recentData[recentData.length - 1];
                    const date = new Date(latestEntry.timestamp);
                    document.getElementById('latestData').innerHTML = `
                        <p><strong>Último valor:</strong> ${latestEntry.value}</p>
                        <p><strong>Tiempo:</strong> ${date.toLocaleTimeString()}</p>
                    `;
                }
            } else {
                // If it's a single data point or simple structure, update the chart
                updateChart(data);
            }
        }
    });
    </script>

</body>

</html>