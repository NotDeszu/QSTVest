<?php
// Include database connection
require_once '../../../BD/conexion.php';

// Firebase configuration
$firebaseConfig = [
    'apiKey' => "AIzaSyDZh7xPxQQvn3QpIvB8R7jFjgXIZZQYYAk",
    'authDomain' => "qstvest.firebaseapp.com",
    'databaseURL' => "https://qstvest-default-rtdb.firebaseio.com",
    'projectId' => "qstvest",
    'storageBucket' => "qstvest.firebasestorage.app",
    'messagingSenderId' => "581299055269",
    'appId' => "1:581299055269:web:5f9b082b0a8b95b497fb4c",
    'measurementId' => "G-2JD2XZP620"
];

// Function to fetch data from Firebase using cURL
function fetchFirebaseData($databaseURL, $path) {
    $url = $databaseURL . '/' . $path . '.json';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        $error = 'Error fetching data from Firebase: ' . curl_error($ch);
        logError($error);
        return false;
    }
    
    curl_close($ch);
    
    return json_decode($response, true);
}

// Function to save data to MariaDB
function saveToDatabase($conn, $data) {
    // Create firebasedb table if it doesn't exist
    $createTableSQL = "CREATE TABLE IF NOT EXISTS firebasedb (
        id INT AUTO_INCREMENT PRIMARY KEY,
        sensor_value FLOAT NOT NULL,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if (!mysqli_query($conn, $createTableSQL)) {
        $error = "Error creating table: " . mysqli_error($conn);
        logError($error);
        return false;
    }
    
    // Process the data
    if (is_array($data)) {
        // If data is an object with multiple entries
        if (isset($data) && !empty($data)) {
            foreach ($data as $key => $value) {
                // Handle both value-only data and object data
                $sensorValue = is_array($value) ? (isset($value['value']) ? $value['value'] : reset($value)) : $value;
                
                // Insert data into the database
                $sql = "INSERT INTO firebasedb (fire_data) VALUES (?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "d", $sensorValue);
                
                if (!mysqli_stmt_execute($stmt)) {
                    $error = "Error inserting data: " . mysqli_stmt_error($stmt);
                    logError($error);
                }
                
                mysqli_stmt_close($stmt);
            }
            return true;
        }
    } else {
        // If it's a single data point
        $sql = "INSERT INTO firebasedb (fire_data) VALUES (?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "d", $data);
        
        if (!mysqli_stmt_execute($stmt)) {
            $error = "Error inserting data: " . mysqli_stmt_error($stmt);
            logError($error);
            return false;
        }
        
        mysqli_stmt_close($stmt);
        return true;
    }
    
    return false;
}

// Function to log errors
function logError($message) {
    $logFile = __DIR__ . '/firebase_log.txt';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message\n";
    
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

// Check if this is a cron job or manual request
$isCron = isset($_GET['cron']) && $_GET['cron'] == 1;
$isJson = !$isCron || (isset($_GET['format']) && $_GET['format'] == 'json');

// Main execution
try {
    // Fetch data from Firebase
    $firebasePath = isset($_GET['path']) ? $_GET['path'] : 'gas'; // Allow custom path via GET parameter
    $firebaseData = fetchFirebaseData($firebaseConfig['databaseURL'], $firebasePath);
    
    if ($firebaseData !== false) {
        // Save data to MariaDB
        if (saveToDatabase($conn, $firebaseData)) {
            $response = ['success' => true, 'message' => 'Data saved to database successfully'];
        } else {
            $response = ['success' => false, 'message' => 'Failed to save data to database'];
        }
    } else {
        $response = ['success' => false, 'message' => 'Failed to fetch data from Firebase'];
    }
} catch (Exception $e) {
    $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    logError($e->getMessage());
}

// Close the database connection
mysqli_close($conn);

// Output response based on request type
if ($isJson) {
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    echo $response['success'] ? "SUCCESS: " . $response['message'] : "ERROR: " . $response['message'];
}
?>
