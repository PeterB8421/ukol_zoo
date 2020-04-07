<?php

declare(strict_types=1);

namespace App\Presenters;


final class ZooPresenter extends BasePresenter
{
	public function renderDefault(): void
	{
		$this->template->anyVariable = 'any value';
	}
}
