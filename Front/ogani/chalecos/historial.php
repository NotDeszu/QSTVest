<?php
// Start the session BEFORE any output
session_start();

// Include your database connection file
// Make sure this path is correct relative to this file's location
require_once '../../../BD/conexion.php'; // Uses $conn from this file

// --- Check if user is logged in ---
if (!isset($_SESSION["usu_email"])) {
    // Option 1: Redirect to login page if not logged in
    // header('Location: /path/to/your/login.php'); // Adjust path as needed
    // exit();

    // Option 2: Show an error message and stop execution
    die("Access Denied: You must be logged in to view this page.");
}

// --- Get the User ID (Email) from the session ---
$target_user_id = $_SESSION["usu_email"];

// --- Initialize variables ---
$chartData = ['labels' => [], 'bpm' => [], 'db' => [], 'gas' => []]; // Default empty data
$error_message = null;

// Check if the connection variable exists and is valid
if (isset($conn) && $conn instanceof mysqli) {

    try {
        // --- SQL Query using Prepared Statement (More Secure with mysqli) ---
        // Select data for the logged-in user, ordered by time. Limit for performance.
        $sql = "SELECT timestamp, bpm, db_level, gas_level
                FROM chaleco_data
                WHERE user_id = ?  -- Placeholder for the user ID
                ORDER BY timestamp ASC
                LIMIT 100"; // Example: Limit to the latest 100 readings

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            // Error preparing statement
            throw new Exception("Database prepare error: " . $conn->error);
        }

        // Bind the session user email to the placeholder (s = string)
        $stmt->bind_param("s", $target_user_id);

        // Execute the statement
        if (!$stmt->execute()) {
            throw new Exception("Database execute error: " . $stmt->error);
        }

        // Get the result set
        $result = $stmt->get_result();

        // --- Process Data for Chart.js ---
        $labels = [];
        $bpmData = [];
        $dbData = [];
        $gasData = [];

        // Fetch data row by row as associative array
        while ($row = $result->fetch_assoc()) {
            // Format timestamp for better readability on the chart axis if desired
            $formatted_timestamp = date('Y-m-d H:i:s', strtotime($row['timestamp']));
            $labels[] = $formatted_timestamp;
            $bpmData[] = $row['bpm'];
            $dbData[] = $row['db_level'];
            $gasData[] = $row['gas_level'];
        }

        $chartData = [
            'labels' => $labels,
            'bpm' => $bpmData,
            'db' => $dbData,
            'gas' => $gasData,
        ];

        // Close the statement
        $stmt->close();

    } catch (Exception $e) {
        // --- Handle Errors ---
        // Log the error in a real application instead of displaying it directly
        $error_message = "An error occurred: " . $e->getMessage();
    }

    // Close the connection (optional, PHP often closes it automatically at script end)
    // $conn->close(); // Uncomment if you want to explicitly close it

} else {
    // Error if $conn wasn't properly set up in conexion.php
    $error_message = "Database connection is not available.";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chaleco Data Chart</title>
    <!-- Include Chart.js library (use a local copy or CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .chart-container {
            position: relative;
            height: 60vh; /* Adjust height as needed */
            width: 80vw;  /* Adjust width as needed */
            margin: auto;
        }
        .error { color: red; font-weight: bold; border: 1px solid red; padding: 10px; margin-bottom: 15px; background-color: #ffecec;}
        .no-data { color: #666; font-style: italic; text-align: center; margin-top: 20px;}
    </style>
</head>
<body>

    <h1>Sensor Data for User: <?php echo isset($target_user_id) ? htmlspecialchars($target_user_id) : 'N/A'; ?></h1>

    <?php if ($error_message): ?>
        <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>

    <div class="chart-container">
        <canvas id="sensorChart"></canvas>
    </div>

    <script>
        // Pass the PHP data to JavaScript
        // Use json_encode with JSON_NUMERIC_CHECK to ensure numbers are treated as numbers
        const rawData = <?php echo json_encode($chartData, JSON_NUMERIC_CHECK); ?>;
        const phpError = <?php echo json_encode($error_message); ?>; // Pass PHP error status to JS

        const ctx = document.getElementById('sensorChart').getContext('2d');
        const chartContainer = document.querySelector('.chart-container');

        // Check if we have data AND there was no PHP error before creating the chart
        if (!phpError && rawData && rawData.labels && rawData.labels.length > 0) {
            const sensorChart = new Chart(ctx, {
                type: 'line', // Type of chart (line, bar, pie, etc.)
                data: {
                    labels: rawData.labels, // X-axis labels (timestamps)
                    datasets: [
                        {
                            label: 'BPM (Beats Per Minute)',
                            data: rawData.bpm, // Y-axis data for BPM
                            borderColor: 'rgb(255, 99, 132)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            tension: 0.1
                        },
                        {
                            label: 'dB Level',
                            data: rawData.db,
                            borderColor: 'rgb(54, 162, 235)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            tension: 0.1
                        },
                        {
                            label: 'Gas Level',
                            data: rawData.gas,
                            borderColor: 'rgb(75, 192, 192)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            tension: 0.1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Sensor Readings Over Time'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Timestamp'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Value'
                            },
                            // beginAtZero: true // Optional
                        }
                    },
                    interaction: {
                      mode: 'nearest',
                      axis: 'x',
                      intersect: false
                    }
                }
            });
        } else if (!phpError) {
             // Display a message if there's no data and no PHP error
             chartContainer.innerHTML = '<p class="no-data">No sensor data found for this user.</p>';
        } else {
            // If there was a PHP error, the canvas might remain empty or show the PHP error message above.
            // You could optionally hide the canvas container entirely.
            // chartContainer.style.display = 'none';
        }
    </script>

</body>
</html>