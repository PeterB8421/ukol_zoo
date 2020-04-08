<?php

declare(strict_types=1);

namespace App\Model;

use Nette;


/**
 * Zoo management.
 */
final class ZooManager
{
	private const
		TABLE_NAME = 'event',
		COLUMN_ID = 'id',
		COLUMN_DATE = 'date',
		COLUMN_TIME = 'time',
		COLUMN_SUMMARY = 'summary',
		COLUMN_DESCRIPTION = 'description',
		COLUMN_VISITORS = 'visitors',
		COLUMN_TYPE = 'type';


	/** @var Nette\Database\Context */
	private $database;

	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
	}

	public function getAll($order){
		return $this->database->table(self::TABLE_NAME)->order($order)->fetchAll();
	}

	public function getByID($id){
		return $this->database->table(self::TABLE_NAME)->get($id);
	}
}