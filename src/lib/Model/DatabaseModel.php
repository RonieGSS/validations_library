<?php declare(strict_types=1);

namespace Lib\Model;

/**
 * DatabaseModel Class
 *
 * Manages database connection
 *
 */
class DatabaseModel
{
	/**
	 *
	 * @var string $servername
	 *
	 */
	private $servername;

	/**
	 *
	 * @var string $driver
	 *
	 */
	private $driver;

	/**
	 *
	 * @var string $username
	 *
	 */
	private $username;

	/**
	 *
	 * @var string $password
	 *
	 */
	private $password;

	/**
	 *
	 * @var string $database
	 *
	 */
	private $database;

	/**
	 * connect method
	 * connects the database
	 * 
	 * @param array $config holds database configuration
	 * @return PDO Class return PDO instance
	 */
	public function connect(array $config)
	{
		$this->setServerName($config['host']);
		$this->setDriver($config['driver']);
		$this->setUsername($config['username']);
		$this->setPassword($config['password']);
		$this->setDatabase($config['database']);

		return $this->getPDO();
	}

	/**
	 * setServerName method
	 * sets the database servername
	 *
	 * @param string $servername
	 */
	private function setServerName(string $servername)
	{
		$this->servername = htmlentities(trim($servername));
	}

	/**
	 * setDriver method
	 * sets the database driver
	 *
	 * @param string $driver
	 */
	private function setDriver(string $driver)
	{
		$this->driver = htmlentities(lcfirst(trim($driver)));
	}

	/**
	 * setUsername method
	 * sets the database username
	 *
	 * @param string $username
	 */
	private function setUsername(string $username)
	{
		$this->username = htmlentities(trim($username));
	}

	/**
	 * setPassword method
	 * sets the database password
	 *
	 * @param string $password
	 */
	private function setPassword(string $password)
	{
		$this->password = htmlentities(trim($password));
	}

	/**
	 * setDatabase method
	 * sets the database name
	 *
	 * @param string $database
	 */
	private function setDatabase(string $database)
	{
		$this->database = htmlentities(trim($database));
	}

	/**
	 * getPDO method
	 * gets PDO instance
	 *
	 * @return PDO class - returns the PDO instance
	 */
	private function getPDO()
	{
		try {
			$dsn = "{$this->driver}:host={$this->servername};dbname={$this->database}";
			$username = $this->username;
			$password = $this->password;

			return new \PDO($dsn, $username, $password);
		} catch(PDOException $e) {
			die("Connection failed: {$e->getMessage()}");
		}
	}

}