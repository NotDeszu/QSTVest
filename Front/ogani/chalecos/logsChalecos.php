<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection from your existing file
require_once '../../../BD/conexion.php';

// Set headers to handle AJAX requests
header('Content-Type: application/json');

// Function to validate data
function validateData($data) {
    // Ensure all required fields are present and numeric
    if (!isset($data['bpm']) || !is_numeric($data['bpm']) ||
        !isset($data['db']) || !is_numeric($data['db']) ||
        !isset($data['gas']) || !is_numeric($data['gas'])) {
        return false;
    }
    return true;
}

// Check if it's a POST request with data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON data
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    
    // Log raw input for debugging
    file_put_contents('debug.log', date('Y-m-d H:i:s') . ": " . $jsonData . "\n", FILE_APPEND);
    
    // Validate the data
    if (!validateData($data)) {
        echo json_encode(['success' => false, 'message' => 'Invalid data format']);
        exit;
    }
    
    // Extract the data
    $bpm = $data['bpm'];
    $db = $data['db'];
    $gas = $data['gas'];
    $timestamp = isset($data['timestamp']) ? $data['timestamp'] : date('Y-m-d H:i:s');
    $userId = isset($data['userId']) ? $data['userId'] : 'default_user';
    
    try {
        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO chaleco_data (user_id, bpm, db_level, gas_level, timestamp) VALUES (?, ?, ?, ?, ?)");
        
        // Bind parameters and execute
        $stmt->bind_param("sidds", $userId, $bpm, $db, $gas, $timestamp);
        $result = $stmt->execute();
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Data saved successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save data: ' . $stmt->error]);
        }
        
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>