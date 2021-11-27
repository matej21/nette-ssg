<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
		$router->addRoute('article/<slug>', 'Article:default');
		$router->addRoute('category/<slug>', 'Category:default');
		$router->addRoute('[page/<page>][/<ajax>]', [
			'presenter' => 'Homepage',
			'action' => 'default',
			'ajax' => [
				Nette\Routing\Route::PATTERN => 'index.json',
				Nette\Routing\Route::FILTER_IN => fn ($val) => !!$val,
				Nette\Application\Routers\Route::FILTER_OUT => fn ($val) => $val ? 'index.json' : null,
			]
		]);
		$router->addRoute('<presenter>/<action>[/<id>]', 'Homepage:default');
		return $router;
	}
}
