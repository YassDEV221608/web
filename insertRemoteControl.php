<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Check if level parameter is received in the GET request
if (!isset($_GET['level'])) {
    $response = array('status' => 'error', 'message' => 'level parameter is missing');
    echo json_encode($response);
    exit();
}

$level = floatval($_GET['level']);

$db_host = 'localhost';
$db_user = 'root';
$db_password = 'gtahyjump';
$db_db = 'automate';

$mysqli = @new mysqli($db_host, $db_user, $db_password, $db_db);

if ($mysqli->connect_error) {
    $response = array('status' => 'error', 'message' => $mysqli->connect_error);
    echo json_encode($response);
    exit();
}

// Prepare SQL statement
$sql = "INSERT INTO remote_control (time, remote_checked, level_remote) VALUES (NOW(), 1, ?)";

$stmt = $mysqli->prepare($sql);

if ($stmt === false) {
    $response = array('status' => 'error', 'message' => 'Prepare failed: ' . $mysqli->error);
    echo json_encode($response);
    exit();
}

// Bind the level parameter to the SQL statement
$stmt->bind_param("d", $level);

if ($stmt->execute()) {
    $response = array('status' => 'success', 'message' => 'Record inserted successfully');
} else {
    $response = array('status' => 'error', 'message' => 'Execute failed: ' . $mysqli->error);
    error_log('Execute failed: ' . $mysqli->error); // Log the error
}

$stmt->close();
$mysqli->close();

header('Content-Type: application/json');

// Print the response as a JSON string
echo json_encode($response);
?>
