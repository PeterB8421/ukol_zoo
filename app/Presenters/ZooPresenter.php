<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\ZooManager;
use Nette\Application\UI;

final class ZooPresenter extends BasePresenter
{
	const REQUIRED_CAPTION = "Nejsou vyplněna všechna vyžadovaná pole.";
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

	public function renderEdit($id): void{
		$event = $this->manager->getByID($id)->toArray();
		$event["time"] = $event["time"]->format("%h:%I");
		$event["date"] = $event["date"]->format("Y-m-d");
		$this["zooForm"]->setDefaults($event);
	}

	public function handleDelete($id){
		$this->manager->delete($id);
		$this->flashMessage("Akce smazána", "warning");
	}

	protected function createComponentZooForm(){
		$form = new UI\Form();
		$form->addText("summary", "Název akce")->addRule(UI\Form::MAX_LENGTH, "Název může mít maximálně 100 znaků.", 100)->setRequired(self::REQUIRED_CAPTION);
		$form->addTextArea("description", "Popis akce");
		$form->addText("date", "Datum konání")->setType("date")->setRequired(self::REQUIRED_CAPTION);
		$form->addText("time", "Čas konání")->setType("time")->setRequired(self::REQUIRED_CAPTION);
		$form->addInteger("visitors", "Počet návštěvníků")->addRule($form::RANGE, "Počet návštěvníků musí být v rozmezí 0 - 1000000", [0, 1000000]);
		$form->addSelect("type", "Typ eventu", array(
			"charitativní" => "Charitativní",
			"odborná" => "Odborná",
			"tradiční" => "Tradiční",
			"ostatní" => "Ostatní"
		))->setRequired(self::REQUIRED_CAPTION);
		$form->addSubmit("submit", (($this->getParameter("id") ? "Upravit" : "Vytvořit")))->setAttribute("class", "btn btn-primary");
		$form->onSuccess[] = array($this, "zooFormSucceeded");

		return $form;
	}

	public function zooFormSucceeded(UI\Form $form, $values){
		$id = $this->getParameter("id");
		if($id){
			$this->manager->update($id, $values);
			$this->flashMessage("Akce upravena", "success");
		}
		else{
			$this->manager->create($values);
			$this->flashMessage("Akce vytvořena", "success");
		}
		$this->redirect("Zoo:default");
	}
}
