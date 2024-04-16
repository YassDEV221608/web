<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST,PUT');

header("Access-Control-Allow-Headers: X-Requested-With");


$host = 'localhost';
$db   = 'automate';
$user = 'root';
$pass = 'gtahyjump';
$charset = 'utf8mb4';
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get level_remote parameter from request
$level_remote = isset($_GET['level_remote']) ? floatval($_GET['level_remote']) : null;

// Prepare SQL statement
$sql = "INSERT INTO remote_control (remote_checked, level_remote) VALUES (1, ?)";

// Prepare and bind parameter
$stmt = $conn->prepare($sql);
$stmt->bind_param("d", $level_remote);  // "d" specifies a double-precision floating-point number

$response = [];

if ($stmt->execute()) {
    $response['status'] = 'success';
    $response['message'] = 'Record inserted successfully';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error: ' . $sql . '<br>' . $conn->error;
}

echo json_encode($response);

// Close statement and connection
$stmt->close();
$conn->close();
?>