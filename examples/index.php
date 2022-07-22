<?php

use Tests\OneClass;
use Tests\TwoClass;
use Zixsihub\JsonRpc\Middleware\PrettyMiddleware;
use Zixsihub\JsonRpc\Server;

// php -S localhost:8000 -t examples/ 

// curl -X POST -d '{"jsonrpc": "2.0", "method":"one.methodTwo", "params":{}, "id": 1}' "http://localhost:8000/"
// curl -X POST -d '[{"jsonrpc": "2.0", "method":"one.methodTwo", "params":{}, "id": 1}, {"method":"one.methodTwo", "params":{}, "id": 1}, {"jsonrpc": "2.0", "method":"two.methodOne", "params":{}}]' "http://localhost:8000/"
//

require_once '../vendor/autoload.php';

$server = new Server();
$server->registerInstances([
	'one' => OneClass::class,
	'two' => new TwoClass(),
]);
$server->registerMiddlewares([
	new PrettyMiddleware()
]);

$server->run();