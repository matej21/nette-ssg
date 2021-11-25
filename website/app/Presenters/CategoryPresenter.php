<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


final class CategoryPresenter extends BasePresenter
{
	public function renderDefault(string $slug)
	{
		$category = $this->db->table('category')->where('slug', $slug)->fetch();
		if (!$category) {
			$this->error();
		}
		$this->template->category = $category;
		$this->template->articles = $this->db->table('article')
			->where('published_at <= ?', new \DateTimeImmutable())
			->where('category_id', $category->id)
			->order('published_at DESC');
	}
}
