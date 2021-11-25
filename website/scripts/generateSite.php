<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$container = \App\Bootstrap::boot()->createContainer();
$container->callMethod(function (
	\Nette\Application\IPresenterFactory $presenterFactory,
	\Nette\Routing\Router $router,
	\Nette\Database\Connection $db,
) {
	$db->query('set search_path to stage_live');
	$baseUri = new \Nette\Http\UrlScript('http://ssg.localhost/');
	$outDir = __DIR__ . '/../dist/';

	$presenter = $presenterFactory->createPresenter('Homepage');
	$appRequest = new \Nette\Application\Request('Homepage', 'GET', []);
	$response = $presenter->run($appRequest);
	assert($response instanceof \Nette\Application\Responses\TextResponse);
	$html = (string) $response->getSource();
	$url = $router->constructUrl([
		'presenter' => $appRequest->getPresenterName(),
	] + $appRequest->getParameters(), $baseUri);
	assert($url !== null);
	$pagePath = substr($url, strlen($baseUri->getBaseUrl()));
	echo "$pagePath\n";
	file_put_contents($outDir . $pagePath . '/index.html', $html);
});
