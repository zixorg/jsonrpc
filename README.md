# PHP JSON-RPC 2.0 Server Implementation

## Installation

If you're using [Composer](https://getcomposer.org/), you can include this library
([zixsihub/jsonrpc](https://packagist.org/packages/zixsihub/jsonrpc)) like this:
```
composer require "zixsihub/jsonrpc"
```

## Getting started

1. Create a server instance
2. Register classes
3. Start the server

```
$server = new Server();
$server->registerInstances([
	'one' => OneClass::class,
	'two' => new TwoClass(),
]);

$server->run();
```
## Register classes

Registration can take place in 2 ways

```
// array map
$server->registerInstances([
	'one' => OneClass::class,
	'two' => new TwoClass(),
]);

// single
$server->registerInstance('one', OneClass::class);

```
