<?php
/**
 * Communicate with fortunor
 */
require_once "common.php";

class Fortunor {
	/**
	 * Config.
	 */
	private $_aConfig;
	
	/**
	* Construct with config.
	* @param array Config
	*/
	public function __construct($aConfig) {
		$this->_aConfig["user"] = $aConfig["user"];
		$this->_aConfig["password"] = $aConfig["password"];
		$this->_aConfig["projectid"] = $aConfig["projectid"];
		$this->_aConfig["api"] = $aConfig["api"];
	}

	/**
	* Submit.
	* @param string UniqueId
	* @param array Digits
	* @param integer AdditionalDigit
	* @param DateTime StartDate
	* @param DateTime EndDate
	*/
	public function submit($sUniqueId, $aDigits, $iAdditionalDigit, $oStartDate, $oEndDate) {
		$aConfig = &$this->_aConfig;
	
		// Normalize dates into YYYY-MM-DD
		$sNormStartDate = $oStartDate->format("Y-m-d");
		$sNormEndDate = $oEndDate->format("Y-m-d");
		
		// Build post data
		$aPostData = array(
			"login" => $aConfig["user"],
			"password" => $aConfig["password"],
			"projectid" => $aConfig["projectid"],
			"unique_id" => $sUniqueId,
			"startdate" => $sNormStartDate,
			"enddate" => $sNormEndDate,
			"additionaldigit" => $iAdditionalDigit,
		);
		
		// Merge digits into the array
		$aPostData += array_combine(
			array_map(function ($iDigit) { return "digit" . $iDigit; }, range(1, 6)),
			$aDigits
		);
		
		// Build hashed tip data
		$sHashedTip = md5(
			$sUniqueId 
		  . join("", $aDigits)
		  . $iAdditionalDigit 
		  . $sNormStartDate
		  . $sNormEndDate
		);
		
		$aPostData["hashedtip"] = $sHashedTip;
		
		// Send request
		$rCurl = curl_init($aConfig["api"]);
		curl_setopt_array($rCurl, array(
			CURLOPT_POST => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_POSTFIELDS => http_build_query($aPostData),
			CURLOPT_HTTPHEADER => array("Content-type: application/x-www-form-urlencoded"),
		));
		
		$sResult = curl_exec($rCurl);
		curl_close($rCurl);
		
		return str_getcsv($sResult, ";");
	}
}