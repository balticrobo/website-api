<?php declare(strict_types=1);

use BalticRobo\Api\Kernel;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

require __DIR__.'/../vendor/autoload.php';

if (!isset($_SERVER['APP_ENV'])) {
    (new Dotenv())->load(__DIR__.'/../.env');
}

if ($_SERVER['APP_ENV'] !== 'prod') {
    umask(0000);
    Debug::enable();
}

$kernel = new Kernel($_SERVER['APP_ENV'], $_SERVER['APP_ENV'] !== 'prod');
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
