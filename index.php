<?php
$config = require __DIR__ . '/config.php';

spl_autoload_register(function ($class) {
    $file = __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

$leadService = new \Services\CrmApiService($config);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = str_replace('/simple-api-test', '', $uri);

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET' && ($uri === '/form' || $uri === '/')) {
    (new \Controllers\MainController())->form();
} elseif ($method === 'GET' && $uri === '/list') {
    (new \Controllers\MainController())->list();
} elseif ($method === 'POST' && $uri === '/lead') {
    (new \Controllers\LeadController())->store();
} else {
    http_response_code(404);
    echo "404 Not Found";
}


