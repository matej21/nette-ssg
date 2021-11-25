<?php

declare(strict_types=1);

if (PHP_SAPI === 'cli-server') {
	$_SERVER['SCRIPT_NAME'] = '/index.php';
	if ($_SERVER['REQUEST_URI'] !== '/' && is_file($_SERVER['DOCUMENT_ROOT'] . urldecode($_SERVER['REQUEST_URI']))) {
		return false;
	}
}

require __DIR__ . '/../vendor/autoload.php';

$configurator = App\Bootstrap::boot();
$container = $configurator->createContainer();
$application = $container->getByType(Nette\Application\Application::class);
$application->run();
