<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	#[Nette\DI\Attributes\Inject]
	public Nette\Database\Explorer $db;

	protected function startup()
	{
		parent::startup();
		$this->db->query('set search_path to stage_live');
	}

	protected function beforeRender()
	{
		parent::beforeRender();
		$this->template->categories = $this->db->table('category');
	}
}
