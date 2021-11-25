<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


final class HomepagePresenter extends BasePresenter
{
	public function renderDefault()
	{
		$this->template->articles = $this->db->table('article')
			->where('published_at <= ?', new \DateTimeImmutable())
			->order('published_at DESC')
			->fetchAll();
	}
}
