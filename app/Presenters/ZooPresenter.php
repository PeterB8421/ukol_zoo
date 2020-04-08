<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\ZooManager;


final class ZooPresenter extends BasePresenter
{
	private $manager;

	public function __construct(ZooManager $manager){
		$this->manager = $manager;
	}

	public function renderDefault($order = 'id'): void{
		$this->template->events = $this->manager->getAll($order);
	}

	public function renderDetail($id): void{
		$this->template->event = $this->manager->getByID($id);
	}
}
