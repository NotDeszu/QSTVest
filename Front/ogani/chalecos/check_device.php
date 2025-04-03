<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
file_put_contents('debug.log', "Request received: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
file_put_contents('debug.log', file_get_contents('php://input') . "\n", FILE_APPEND);

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
        // Redirect to graficaChalecos.php instead of including it
        header("Location: graficaChalecos.php?device=" . $deviceRecord);
        exit;
    } else {
        // Redirect to notFound.html
        header("Location: notFound.html");
        exit;
    }
    
    $stmt->close();
}
?>

<form action="logsChalecos.php" method="post">
  <input type="hidden" name="test" value="1">
  <button type="submit">Test API</button>
</form>

