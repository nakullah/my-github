<?php	include_once("config.php"); ?>
<?php
$config = new Config;
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
/*--------------------- NOTICE ------------------------*\
| 	Name		:	database							|
| 	Type		:	Class								|
| 	Author		:	Usman								|
| 	Created		:	02-02-2013							|
| 	Updated		:	02-02-2013							|
| 	Doctype		:	PHP/HTML/CSS/JS/XML					|
| 	Revision	:	0									|
| 	Copyright	:	Orbit360(R)							|
|-------------------------------------------------------|
| Serves as a major class to Manipulate database tables |
| querying them, inserting data in a convinient way		|
\*-----------------------------------------------------*/
class Database
{
	// Need to set these constant variables:
	protected $database ;
	protected $dbUser ;
	protected $dbPassword ;
	protected $dbHost ;
	protected $dbConnection ;
	// ////////////////////////////////////////////////////
	//	***************************************************
	//	PHP and MySQL Connection and Error Specific methods
	//	***************************************************
	// Constructor
	public function __construct()
	{
		global $config;

		$conn = mysql_connect($config->dbHost,$config->dbUser,$config->dbPass);
		//mysql_query("SET AUTOCOMMIT=0");
		if(!$conn) {
			$this->error("Connection attempt failed");
		}
		if(!mysql_select_db($config->dbName,$conn)) {
			$this->error("Dbase Select failed");
		}
		$this->database = $config->dbName;
		$this->dbUser = $config->dbUser;
		$this->dbPassword = $config->dbPass;
		$this->dbHost =$config->dbHost;
		$this->dbConnection = $conn;
		return true;
	}
	
	// In case we need inDev Active mysql Connection for troubleshooting purposes
	public function getConnection()
	{
		return $this->dbConnection;	}
	
	// Get current mysql Host
	public function getHost()
	{
		return $this->dbHost;
	}
	
	// Get selected Database Name
	public function getDatabase()
	{
		return $this->database;
	}
	// Close current active connection used by this object
	public function close()
	{
		$conn = $this->dbConnection ;
		$close = mysql_close($conn);
		if(!$close) {
			$this->error("Connection close failed");
		}
		return true;
	}
	//Set Error Messages
	public function error($text)
	{
		$no = mysql_errno();
		$msg = mysql_error();
		exit;
	}
	// SQL SELECT : Returns Array
	public function select ($sql="",$rt=MYSQL_BOTH)
	{
		if(empty($sql)) { return false; }
		if(!@eregi("(^select)|(^\(select)",$sql))
		{
			//echo "wrong query<br>$sql";
			echo "<H2>Wrong public function silly!</H2>\n";
			return false;
		}
		if(empty($this->dbConnection)) { return false; }
		$conn = $this->dbConnection;
		$results = mysql_query($sql,$conn);

		if( (!$results) or (empty($results)) ) { 
			return false;
		}
		$count = 0;
		$data = array();
		while ( $row = mysql_fetch_array($results,$rt))
		{
			$data[$count] = $row;
			$count++;
		}
		mysql_free_result($results);
		return $data;
	}

	public function affected($sql="")
	{
		if(empty($sql)) { return false; }
		if(!eregi("^select",$sql))
		{
			//echo "wrong query<br>$sql";
			echo "<H2>Wrong public function silly!</H2>\n";
			return false;
		}
		if(empty($this->dbConnection)) { return false; }
		$conn = $this->dbConnection;
		$results = @mysql_query($sql,$conn);
		if( (!$results) or (empty($results)) ) {
			return false;
		}
		$tot=0;
		$tot=mysql_affected_rows();
		return $tot;
	}

	public function insert ($sql="")
	{
		//echo $sql;
		if(empty($sql)) { return false; }
		if(!@eregi("^insert",$sql))
		{
			return false;
		}
		if(empty($this->dbConnection))
		{
			return false;
		}
		$conn = $this->dbConnection;
		$results = @mysql_query($sql,$conn);
		if(!$results)
		{
			return false;
		}
		$id = mysql_insert_id();
		return $id;
	}

	public function update($sql="")
	{
		//echo $sql;
		if(empty($sql)) { return false; }
		if(!@eregi("^update",$sql))
		{
			return false;
		}
		if(empty($this->dbConnection))
		{
			return false;
		}
		$conn = $this->dbConnection;
		$results =@mysql_query($sql,$conn);
		if(!$results)
		{
//			$this->error("<H2>No results!</H2>\n");
			return 0;
		}
		$rows = 0;
		$rows = mysql_affected_rows();
		return $rows;
	}

	public function adminSql($sqld="") //Warning
	{	
		if(empty($sqld)) { return false; }
		if(empty($this->dbConnection)) { return false; }
		$conn = $this->dbConnection;
		//echo $sqld;
		$results = @mysql_query($sqld,$conn) or die("query fail");
		//$results = @mysql_query($sqld,$conn);
		return $results;
	}
	public function debug()
	{
		var_dump($this);
	}
} $db = new Database();
?>