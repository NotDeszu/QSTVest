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
<!-- Contenido de graficas -->
<div class="container-fluid">
    <div class="row">
        <div class="col-10">
            <h3>Monitoreo de datos en tiempo real</h3>
            <p>A continuación se muestran las gráficas de los datos enviados desde el chaleco inteligente</p>
        </div>
        <div class="col-2">
            <button id="historial" class="btn btn-light">Historial</button>
                <script>
                    document.getElementById("historial").addEventListener("click", function() {
                    window.location.href = "historial.php";
                    });
                </script>
        </div>
    </div>
    
    <!-- First row with two charts side by side -->
    <div class="row">
        <!-- BPM Chart - Left -->
        <div class="col-md-6">
            <div class="blog__details__chart mb-4">
                <h4>Frecuencia Cardíaca (BPM)</h4>
                <canvas id="bpmChart" width="100%" height="300"></canvas>
            </div>
        </div>
        
        <!-- Decibels Chart - Right -->
        <div class="col-md-6">
            <div class="blog__details__chart mb-4">
                <h4>Decibeles (dB)</h4>
                <canvas id="dbChart" width="100%" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Second row with Gas chart and data panel side by side -->
    <div class="row">
        <!-- Gas Chart - Left -->
        <div class="col-md-6">
            <div class="blog__details__chart mb-4">
                <h4>Sensor de Gas</h4>
                <canvas id="gasChart" width="100%" height="300"></canvas>
            </div>
        </div>
        
        <!-- Data Panel - Right -->
        <div class="col-md-6">
            <div class="blog__details__sidebar">
                <div class="blog__details__sidebar__item">
                    <h4>Datos en tiempo real</h4>
                    <div id="latestData">
                        <p>Frecuencia Cardiaca: 78 BPM</p>
                        <p>Decibeles: 11 dB</p>
                        <p>Sensor de Gas: 849</p>
                        <p>Tiempo: 9:39:43 p.m.</p>
                    </div>
                    <div class="mt-3">
                        <button id="testDataBtn" class="btn btn-primary">Probar con datos de ejemplo</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Aqui termina el contenido de graficas -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script type="module">
    // Import the functions you need from the SDKs you need
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.22.2/firebase-app.js";
    import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.22.2/firebase-analytics.js";
    import { getDatabase, ref, onValue } from "https://www.gstatic.com/firebasejs/9.22.2/firebase-database.js";
    import { getAuth, signInWithEmailAndPassword, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/9.22.2/firebase-auth.js";
    
    // Your web app's Firebase configuration
    const firebaseConfig = {
        apiKey: "AIzaSyCzMlLlVZB-mX5BP3jKbQTaxHKKK2h-Z3k",
        authDomain: "qstvest.firebaseapp.com",
        databaseURL: "https://qstvest-default-rtdb.firebaseio.com",
        projectId: "qstvest",
        storageBucket: "qstvest.firestorage.app",
        messagingSenderId: "581299055269",
        appId: "1:581299055269:web:5f9b082b0a8b95b497fb4c",
        measurementId: "G-2JD2XZP620"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const analytics = getAnalytics(app);
    const auth = getAuth(app);
    const database = getDatabase(app);
    
    console.log("Firebase initialized in graficaChalecos.php");
    
    // Initialize chart data for each sensor
    let chartLabels = [];
    let bpmData = [];
    let dbData = [];
    let gasData = [];
    let bpmChart, dbChart, gasChart;
    
    // Function to initialize database listeners once authenticated
    function initializeFirebaseData() {
        console.log("Initializing Firebase data after authentication");
        
        // Reference to your ESP32 data in Firebase
        const bpmRef = ref(database, 'bpm001');
        const dbRef = ref(database, 'db001');
        const gasRef = ref(database, 'gas001');
        
        // Debug: List all available paths in the database
        const rootRef = ref(database, '/');
        onValue(rootRef, (snapshot) => {
            console.log("Available Firebase paths:", snapshot.val());
        }, (error) => {
            console.error("Error getting database references:", error);
            document.getElementById('latestData').innerHTML = `
                <p class="text-danger"><strong>Error de conexión:</strong> ${error.message}</p>
            `;
        });
        
        // Listen for BPM data changes in Firebase
        onValue(bpmRef, (snapshot) => {
            const bpmValue = snapshot.val();
            console.log("BPM data received:", bpmValue);
            
            if (bpmValue !== null) {
                // Keep only the last 10 data points
                if (bpmData.length > 9) {
                    bpmData.shift();
                }
                bpmData.push(Number(bpmValue));
                updateCharts();
            }
        }, (error) => {
            console.error("Error getting BPM data:", error);
        });
        
        // Listen for DB data changes in Firebase
        onValue(dbRef, (snapshot) => {
            const dbValue = snapshot.val();
            console.log("DB data received:", dbValue);
            
            if (dbValue !== null) {
                // Keep only the last 10 data points
                if (dbData.length > 9) {
                    dbData.shift();
                }
                dbData.push(Number(dbValue));
                updateCharts();
            }
        }, (error) => {
            console.error("Error getting DB data:", error);
        });
        
        // Listen for Gas data changes in Firebase
        onValue(gasRef, (snapshot) => {
            const gasValue = snapshot.val();
            console.log("Gas data received:", gasValue);
            
            if (gasValue !== null) {
                // Keep only the last 10 data points
                if (gasData.length > 9) {
                    gasData.shift();
                }
                gasData.push(Number(gasValue));
                updateCharts();
            }
        }, (error) => {
            console.error("Error getting Gas data:", error);
        });
    }
    
    // Check for authentication state
    onAuthStateChanged(auth, (user) => {
        if (user) {
            console.log("User already signed in:", user.email);
            initializeFirebaseData();
        } else {
            console.log("Attempting to sign in with default credentials...");
            // Try to sign in
            signInWithEmailAndPassword(auth, "fel@qstvest.com", "pass123")
            .then((userCredential) => {
                console.log("User signed in successfully:", userCredential.user.email);
                initializeFirebaseData();
            })
            .catch((error) => {
                console.error("Authentication failed:", error.code, error.message);
                document.getElementById('latestData').innerHTML = `
                    <p class="text-danger"><strong>Error de autenticación:</strong> ${error.message}</p>
                `;
            });
        }
    });
    
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
                            beginAtZero: true,
                            suggestedMin: 40,
                            suggestedMax: 200
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
                            beginAtZero: false,
                            suggestedMin: 0,
                            suggestedMax: 120
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
                options: {
                    ...chartOptions,
                    scales: {
                        ...chartOptions.scales,
                        y: {
                            ...chartOptions.scales.y,
                            suggestedMin: 0,
                            suggestedMax: 1000
                        }
                    }
                }
            });
        }
        
        console.log("Charts initialized successfully");
    }
    
    // Update the charts with new data
    function updateCharts() {
        // Add timestamp as label (convert to readable format)
        const date = new Date();
        const timeString = date.toLocaleTimeString();
        
        // Keep only the last 10 data points for better visualization
        if (chartLabels.length > 9) {
            chartLabels.shift();
        }
        
        // Add new data
        chartLabels.push(timeString);
        
        // Update charts - use non-animated updates to prevent zooming
        if (bpmChart) {
            bpmChart.data.labels = chartLabels;
            bpmChart.data.datasets[0].data = bpmData;
            bpmChart.update('none'); // Disable animation for updates
        }
        
        if (dbChart) {
            dbChart.data.labels = chartLabels;
            dbChart.data.datasets[0].data = dbData;
            dbChart.update('none'); // Disable animation for updates
        }
        
        if (gasChart) {
            gasChart.data.labels = chartLabels;
            gasChart.data.datasets[0].data = gasData;
            gasChart.update('none'); // Disable animation for updates
        }
        
        // Update latest data display
        updateLatestData();
    }
    
    // Function to update the latest data display
    function updateLatestData() {
        const latestDataElement = document.getElementById('latestData');
        if (latestDataElement) {
            const bpmVal = bpmData.length > 0 ? bpmData[bpmData.length - 1] : "N/A";
            const dbVal = dbData.length > 0 ? dbData[dbData.length - 1] : "N/A";
            const gasVal = gasData.length > 0 ? gasData[gasData.length - 1] : "N/A";
            const timeString = new Date().toLocaleTimeString();
            
            latestDataElement.innerHTML = `
                <p><strong>Frecuencia Cardíaca:</strong> ${bpmVal} BPM</p>
                <p><strong>Decibeles:</strong> ${dbVal} dB</p>
                <p><strong>Sensor de Gas:</strong> ${gasVal}</p>
                <p><strong>Tiempo:</strong> ${timeString}</p>
            `;

            // Check thresholds and show warnings
            if (bpmVal < 60 || bpmVal > 120) {
                latestDataElement.innerHTML += `<div class="alert alert-danger">¡Alerta! Frecuencia cardíaca fuera de rango: ${bpmVal} BPM</div>`;
            }

            if (dbVal > 85) {
                latestDataElement.innerHTML += `<div class="alert alert-warning">¡Alerta! Nivel de ruido alto: ${dbVal} dB</div>`;
            }

            if (gasVal > 700) {
                latestDataElement.innerHTML += `<div class="alert alert-danger">¡Alerta! Nivel de gas peligroso: ${gasVal}</div>`;
            }
            
            // Save data to MariaDB
            saveToMariaDB(bpmVal, dbVal, gasVal);
        }
    }
    
    // Function to send data to MariaDB via AJAX
    function saveToMariaDB(bpmVal, dbVal, gasVal) {
        // Only save data if we have values for all sensors
        if (bpmVal !== "N/A" && dbVal !== "N/A" && gasVal !== "N/A") {
            // Create data object
            const dataToSave = {
                bpm: bpmVal,
                db: dbVal,
                gas: gasVal,
                timestamp: new Date().toISOString().slice(0, 19).replace('T', ' '), // Format: YYYY-MM-DD HH:MM:SS
                userId: auth.currentUser ? auth.currentUser.uid : 'anonymous'
            };
            
            // Send data to server
            fetch('logsChalecos.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(dataToSave)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Data saved to MariaDB:', data.message);
                } else {
                    console.error('Error saving to MariaDB:', data.message);
                }
            })
            .catch(error => {
                console.error('Error sending data to server:', error);
            });
        }
    }
    
    // Initialize charts when DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log("DOM Content Loaded, initializing charts");
        initCharts();
        
        // Setup test data button
        document.getElementById('testDataBtn').addEventListener('click', function() {
            // Add test data
            if (chartLabels.length > 9) {
                chartLabels.shift();
                if (bpmData.length > 9) bpmData.shift();
                if (dbData.length > 9) dbData.shift();
                if (gasData.length > 9) gasData.shift();
            }
            
            const now = new Date().toLocaleTimeString();
            chartLabels.push(now);
            
            // Add random test values
            bpmData.push(Math.floor(70 + Math.random() * 45)); // 70-100 BPM
            dbData.push(Math.floor(50 + Math.random() * 50));  // 50-90 dB
            gasData.push(Math.floor(100 + Math.random() * 450)); // 100-500 Gas level
            
            // Update charts
            if (bpmChart) {
                bpmChart.data.labels = chartLabels;
                bpmChart.data.datasets[0].data = bpmData;
                bpmChart.update('none');
            }
            
            if (dbChart) {
                dbChart.data.labels = chartLabels;
                dbChart.data.datasets[0].data = dbData;
                dbChart.update('none');
            }
            
            if (gasChart) {
                gasChart.data.labels = chartLabels;
                gasChart.data.datasets[0].data = gasData;
                gasChart.update('none');
            }
            
            // Update latest data display
            updateLatestData();
            
            // Save test data to MariaDB as well
            const testBpm = bpmData[bpmData.length - 1];
            const testDb = dbData[dbData.length - 1];
            const testGas = gasData[gasData.length - 1];
            saveToMariaDB(testBpm, testDb, testGas);
        });
        
        // Add error handling for Firebase connection
        setTimeout(() => {
            if (bpmData.length === 0 && dbData.length === 0 && gasData.length === 0) {
                console.log("No data received from Firebase after 5 seconds");
                document.getElementById('latestData').innerHTML = `
                    <p class="text-danger"><strong>Error:</strong> No se pudieron obtener datos de Firebase. Verifique su conexión.</p>
                    <p>Paths esperados: bpm001, db001, gas001</p>
                    <p>Revise la consola del navegador para más información.</p>
                `;
            }
        }, 5000);
    });
    </script>
</body>
</html>