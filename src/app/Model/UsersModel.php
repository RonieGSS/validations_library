<?php declare(strict_types=1);

namespace App\Model;

class UsersModel extends TableModel
{
	// Start Coding!

	/**
	 * Contains database connection
	 * @var db_conn PDO Object
	 */
	private $db_conn;

	public function __construct()
	{
		$this->db_conn = $this->conn();
	}

	public function getConn()
	{
		return $this->db_conn;
	}
}