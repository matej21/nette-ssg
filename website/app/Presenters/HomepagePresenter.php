<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Core\SiteGeneratorParametersProvider;
use Nette;


final class HomepagePresenter extends BasePresenter implements SiteGeneratorParametersProvider
{
	public function renderDefault(int $page = 1)
	{
		$paginator = $this->createPaginator();
		$paginator->setPage($page);
		$this->template->paginator = $paginator;
		$articles = $this->getArticles();
		$paginator->setItemCount($articles->count('*'));
		$this->template->articles = $articles
			->limit($paginator->length, $paginator->offset);
		$this->redrawControl();
	}

	protected function getArticles(): Nette\Database\Table\Selection
	{
		$articles = $this->db->table('article')
			->where('published_at <= ?', new \DateTimeImmutable())
			->order('published_at DESC');
		return $articles;
	}

	public function getSSGParameters(): iterable
	{
		$paginator = $this->createPaginator();
		$paginator->setItemCount($this->getArticles()->count('*'));
		for ($page = 1; $page <= $paginator->lastPage; $page++) {
			yield ['page' => $page === 1 ? null : $page];
			yield ['page' => $page === 1 ? null : $page, 'ajax' => true];
		}
	}

	/**
	 * @return Nette\Utils\Paginator
	 */
	protected function createPaginator(): Nette\Utils\Paginator
	{
		$paginator = new Nette\Utils\Paginator();
		$paginator->setItemsPerPage(20);
		return $paginator;
	}
}
