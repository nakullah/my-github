<?php
class Config 
{
	public $domain;
	public $baseUrl;
	public $dbHost;
	public $dbUser;
	public $dbPass;
	public $dbName;
	public function __construct()
	{
		$this->domain  = "www.xyz.com";
		$this->baseUrl = "http://xyz.com";		
		$this->dbHost  = "localhost";
		$this->dbUser  = "root";
		$this->dbPass  = ""; //
		$this->dbName  = "db";
	}
}
?>