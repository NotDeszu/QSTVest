<?php
// Process form submission
require_once '../../../BD/conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the device record from the form
    $deviceRecord = $_POST["record"];
    
    // Prepare a statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM chalecos WHERE cha_record = ?");
    $stmt->bind_param("s", $deviceRecord);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if record exists
    if ($result->num_rows > 0) {
        include "graficaChalecos.php";
        // You can retrieve and display additional information if needed
        // $device = $result->fetch_assoc();
        // echo "Device details: " . $device["some_column"];
    } else {
        //echo "Device does not exist in our database.";
        include "notFound.html";
    }
    
    $stmt->close();
}
?>
