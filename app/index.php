<?php
    header("Content-Type: application/json");

    $request = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];

    $request = parse_url($request, PHP_URL_PATH);

    switch ($request) {
        case '/':
            echo json_encode(['message' => 'Hello, World!']);
            break;
        case '/items':
            require __DIR__ . '/data/items.php';
            break;
        default:
            http_response_code(404);
            echo json_encode(['message' => 'Page not found']);
            break;
    }
?>