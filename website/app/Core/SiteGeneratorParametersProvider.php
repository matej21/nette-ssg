<?php declare(strict_types=1);

namespace App\Core;

interface SiteGeneratorParametersProvider
{
	public function getSSGParameters(): iterable;
}
