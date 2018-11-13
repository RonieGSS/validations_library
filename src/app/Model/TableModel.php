<?php declare(strict_types=1);

namespace App\Model;

/**
 * TableModel Class
 *
 * Parent class of all app model classes
 * Note: All App Model Classes must extend TableModel
 */
class TableModel
{
	/**
	 * Connects to the database
	 *
	 * @return PDO Class returns the PDO Instance
	 */
	protected function conn()
	{
		$database = new \Lib\Model\DatabaseModel();
		$database_config = require_once('app/Config/database.php');
		
		return $database->connect($database_config['database_config']);
	}
}