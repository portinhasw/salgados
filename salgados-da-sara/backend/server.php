<?php
// Servidor de desenvolvimento PHP simples
// Para usar: php -S localhost:8000 server.php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remover /api do início se presente
if (strpos($uri, '/api') === 0) {
    $uri = substr($uri, 4);
}

// Roteamento simples
$routes = [
    // Auth
    '/auth/login' => 'api/auth/login.php',
    '/auth/register' => 'api/auth/register.php',
    '/auth/forgot-password' => 'api/auth/forgot-password.php',
    '/auth/admin-login' => 'api/auth/admin-login.php',
    
    // Products
    '/products' => 'api/products/read.php',
    '/products/create' => 'api/products/create.php',
    '/products/update' => 'api/products/update.php',
    '/products/delete' => 'api/products/delete.php',
    
    // Orders
    '/orders' => 'api/orders/read.php',
    '/orders/create' => 'api/orders/create.php',
    '/orders/update-status' => 'api/orders/update-status.php',
    '/orders/delete' => 'api/orders/delete.php',
    
    // Admin
    '/admin/admins' => 'api/admin/admins.php',
    
    // Config
    '/config' => 'api/config/config.php',
    
    // Test
    '/test' => 'api/test.php',
    
    // Index
    '/' => 'api/index.php',
    '' => 'api/index.php'
];

// Verificar se a rota existe
if (isset($routes[$uri])) {
    $file = __DIR__ . '/' . $routes[$uri];
    if (file_exists($file)) {
        include $file;
        return true;
    }
}

// Se não encontrou a rota, retornar 404
http_response_code(404);
header('Content-Type: application/json');
echo json_encode([
    'sucesso' => false,
    'mensagem' => 'Endpoint não encontrado: ' . $uri,
    'uri_solicitada' => $_SERVER['REQUEST_URI'],
    'metodo' => $_SERVER['REQUEST_METHOD']
]);
return true;
?>