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
	$presenters = [
		'Homepage',
		'Category',
		'Article' ,
	];
	foreach ($presenters as $presenterName) {
		$presenter = $presenterFactory->createPresenter($presenterName);
		$requestParams = $presenter instanceof \App\Core\SiteGeneratorParametersProvider ? $presenter->getSSGParameters() : [[]];
		foreach ($requestParams as $params) {
			$appRequest = new \Nette\Application\Request($presenterName, 'GET', $params);
			$presenter = $presenterFactory->createPresenter($appRequest->getPresenterName());
			$presenter->autoCanonicalize = false; // it returns a redirect otherwise
			$response = $presenter->run($appRequest);
			assert($response instanceof \Nette\Application\Responses\TextResponse);
			$html = (string) $response->getSource();
			$url = $router->constructUrl([
				'presenter' => $appRequest->getPresenterName(),
			] + $appRequest->getParameters(), $baseUri);
			assert($url !== null);
			$pagePath = substr($url, strlen($baseUri->getBaseUrl()));
			echo "$pagePath\n";
			\Nette\Utils\FileSystem::createDir($outDir . $pagePath);
			file_put_contents($outDir . $pagePath . '/index.html', $html);
		}
	}
});
