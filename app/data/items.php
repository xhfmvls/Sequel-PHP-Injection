<?php
require_once 'config.php';

// Set up DSN (Data Source Name) for PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo json_encode(['message' => 'Database connection successful']);
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Database connection failed', 'error' => $e->getMessage()]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        handleGetItems($pdo);
        break;
    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}

function handleGetItems($pdo) {
    try {
        // Get the 'name' parameter from the query string
        $name = isset($_GET['name']) ? $_GET['name'] : null;

        // Check if the 'name' parameter is empty
        if (empty($name)) {
            http_response_code(400);
            echo json_encode(['message' => 'Name parameter is required']);
            return;
        }
        
        $sql = "SELECT * FROM items WHERE name = '$name'";
        $stmt = $pdo->query($sql);
        $items = $stmt->fetchAll();

        
        // Check if any items are found
        if (empty($items)) {
            http_response_code(404);
            echo json_encode(['message' => 'No item found with the provided name']);
            return;
        }
        
        // Output the items as JSON
        header('Content-Type: application/json');
        echo json_encode($items);
    } catch (\PDOException $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Query failed', 'error' => $e->getMessage()]);
    }
}