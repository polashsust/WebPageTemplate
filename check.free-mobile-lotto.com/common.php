<?php
/**
* le configuration
*/
$sMailMessage = <<<MSG
Dear %s %s %s,

Thank you for playing free mobile lotto.
Your lottery ticket played at %s has the following numbers:
%s

Best Regards,
Free Mobile Lotto
MSG;

$aConfig = array(
	// le paymentinterface
	"pi" => array(
		"api" => "https://ywlpg.net/api",
		"user" => "adminqooqoKrc01Rktk6Qp36y0Ce0sxNFNM17A51nMdqp",
		"password" => "bMBTGKuAjPpjlMYbPYQDh4eRwVjYwvbXOdnNoB5LSkM4RrLi5YXpJKqjMdubnFo0",
		"projectid" => 1049,
		"amount" => .0,
		"mode" => "LIVE",
	),
	
	// le fortunor
	"fortunor" => array(
		"api" => "https://lotto-request.fortunor.de/service/submit_lottery.php",
		"user" => "freemobilelotto",
		"password" => "EqhgIv2UhVQu9qwZIbPzn9Ny2Bot4ysp",
		"projectid" => "freeml01",
	),
	/*
	// le database
	"database" => array(
		"host" => "81.169.171.91",
		"user" => "eworks",
		"password" => "12345",
		"dbname" => "free_lotto",
		"port" => 3306,
	),
	*/

	// le database
	"database" => array(
		"host" => "localhost",
		"user" => "root",
		"password" => "p4sql",
		"dbname" => "freelotto",
		"port" => 3306,
	),

	// le log
	"log" => "messages.log",
	
	// le webserver
	"self" => "http://www.free-mobile-lotto.com/",

    // le mail message
    "mailmsg" => $sMailMessage,
    "mailfrom" => "webmaster@free-mobile-lotto.com",
    "mailsubject" => "Your lottery ticket with Free Mobile Lotto",
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
	* access ? la $oX->e()
	* @see query()
	* @return string
	*/
	public function e($sExpr) {
		return $this->query($sExpr);
	}
}
