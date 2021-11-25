<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Core\SiteGeneratorParametersProvider;
use Nette;


final class CategoryPresenter extends BasePresenter implements SiteGeneratorParametersProvider
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

	public function getSSGParameters(): iterable
	{
		return array_map(
			fn(Nette\Database\Table\ActiveRow $row) => $row->toArray(),
			$this->db->table('category')->select('slug')->fetchAll(),
		);
	}
}
