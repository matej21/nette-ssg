<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Core\SiteGeneratorParametersProvider;
use Nette;


final class ArticlePresenter extends BasePresenter implements SiteGeneratorParametersProvider
{
	public function renderDefault(string $slug)
	{
		$this->template->article = $this->db->table('article')->where('slug', $slug)->where('published_at <=', new \DateTimeImmutable())->fetch();
		if (!$this->template->article) {
			$this->error();
		}
	}

	public function getSSGParameters(): iterable
	{
		return array_map(
			fn (Nette\Database\Table\ActiveRow $row) => $row->toArray(),
			$this->db->table('article')->select('slug')->fetchAll(),
		);
	}
}
