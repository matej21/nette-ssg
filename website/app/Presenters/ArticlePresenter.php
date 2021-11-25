<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


final class ArticlePresenter extends BasePresenter
{
	public function renderDefault(string $slug)
	{
		$this->template->article = $this->db->table('article')->where('slug', $slug)->where('published_at <=', new \DateTimeImmutable())->fetch();
		if (!$this->template->article) {
			$this->error();
		}
	}
}
