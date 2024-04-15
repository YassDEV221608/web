<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST,PUT');

header("Access-Control-Allow-Headers: X-Requested-With");


$host = 'localhost';
$db   = 'automate';
$user = 'root';
$pass = 'gtahyjump';
$charset = 'utf8mb4';

// Set up the database connection
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Fetch the latest Level and Flow values
    $stmt = $pdo->query("SELECT Level, Flow FROM sensors ORDER BY time DESC LIMIT 1");
    $data = $stmt->fetch();

    // Prepare the response
    $response = [
        'level' => $data['Level'],
        'flow' => $data['Flow']
    ];

    // Set the content type header to JSON
    header('Content-Type: application/json');

    // Output the JSON data
    echo json_encode($response);

} catch (\PDOException $e) {
    // Handle database connection error
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
}
?>
