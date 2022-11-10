# PHP JSON-RPC 2.0 Server Implementation

## Installation

If you're using [Composer](https://getcomposer.org/), you can include this library
([zixsihub/jsonrpc](https://packagist.org/packages/zixsihub/jsonrpc)) like this:
```
composer require "zixsihub/jsonrpc"
```

## Getting started

```
$server = new Server([
	'one' => OneClass::class,
	'two' => new TwoClass(),
]);

$server->run();
```
