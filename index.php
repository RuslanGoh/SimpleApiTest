<?php
$config = require __DIR__ . '/config.php';

$config['landingUrl'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . ($_SERVER['HTTP_HOST'] ?? 'localhost') . $_SERVER['REQUEST_URI'];
$config['ip'] = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

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
    (new \Controllers\MainController())->list($leadService);
} elseif ($method === 'POST' && $uri === '/lead') {
    (new \Controllers\LeadController())->store($leadService);
} else {
    http_response_code(404);
    echo "404 Not Found";
}


