<?php
/**
* le configuration
*/
$aConfig = array(
	// le paymentinterface
	"pi" => array(
		"api" => "http://dev.paymentinterface/api",
		"user" => "myusername",
		"password" => "secret",
		"projectid" => 1,
		"amount" => .0,
		"mode" => "CONNECTOR_TEST",
	),
	
	// le fortunor
	"fortunor" => array(
		"api" => "https://lotto-request.fortunor.de/demoservice/submit_lottery.php",
		"user" => "qooqo",
		"password" => "JFdBK7X9ENbCqWYPJ8KIjhr4E",
		"projectid" => "qooqo001",
	),
	
	// le database
	"database" => array(
		"host" => "localhost",
		"user" => "root",
		"password" => "",
		"dbname" => "freelotto",
		"port" => 3306,
	),
	
	// le log
	"log" => "messages.log",
	
	// le webserver
	"self" => "http://www.free-mobile-lotto.com/",
);

/**
* le database helper
* @return mysqli
*/
function newDbHandle() {
	global $aConfig;
	
	$oDb = new mysqli(
		$aConfig["database"]["host"],
		$aConfig["database"]["user"],
		$aConfig["database"]["password"],
		$aConfig["database"]["dbname"],
		$aConfig["database"]["port"]
	);
	
	$oDb->autocommit(true);
	$oDb->set_charset("utf-8");
	
	return $oDb;
}

/**
* le log
* @param string Message
*/
function putlog($sMessage) {
	global $aConfig;
	$sLogMessage = date("c") . " " . sprintf("%x", crc32($sMessage)) . " " . $sMessage . PHP_EOL;
	file_put_contents($aConfig["log"], $sLogMessage, FILE_APPEND);
}


/**
* le xpath helper
*/
class Xpath {
	/**
	* @var SimpleXMLElement
	*/
	private $_oSubject;

	/**
	* ctor
	* @param SimpleXMLElement Subject
	*/
	public function __construct(SimpleXMLElement $oSubject) {
		$this->_oSubject = $oSubject;
	}
	
	/**
	* don't even ask
	* @param string Expr
	* @return string
	*/
	public function query($sExpr) {
		return (string)reset($this->_oSubject->xpath($sExpr));
	}
	
	/**
	* convenience alias to {@method query()}, for thuper fast
	* access á la $oX->e()
	* @see query()
	* @return string
	*/
	public function e($sExpr) { 
		return $this->query($sExpr);
	}
}
