<?php

namespace vendor;

use config\DatabaseConfig;
use mysqli;

final class Database
{
	/** var string */
	private $host;
	
	/** var string */
	private $database;
	
	/** var string */
	private $username;
	
	/** var string */
	private $password;
	
	public function __construct()
	{
		$this->host = DatabaseConfig::HOST;
		$this->database = DatabaseConfig::DATABASE;
		$this->username = DatabaseConfig::USER_NAME;
		$this->password = DatabaseConfig::PASSWORD;
	}
	
	/**
	* return mysqli
	*/
	public function getConnection(): mysqli
	{
		return new mysqli($this->host, $this->username, $this->password, $this->database);
	}
}