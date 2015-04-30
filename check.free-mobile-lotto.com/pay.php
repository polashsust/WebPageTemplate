<?php
/**
 * Allocate a VA.QP with the PI return URL to the qrcode
 * as well as uniqueid.  Payment information is stored
 * in database.
 */
require_once "common.php";

// Deny payment without dem digits
if (!isset($_GET["digits"]) || !is_array($_GET["digits"])) {
	die("Digits are mandatory");
}


// update database
$oDb = newDbHandle();  // see common.php
$oSelect = $oDb->prepare("SELECT id FROM payment WHERE uniquenumber=?");
$oSelect->bind_param("s", $_GET["reference"]);
$oSelect->execute();
$oSelect->bind_result($iPaymentId);
$oSelect->fetch();
$oSelect->close();

$oUpdate = $oDb->prepare(
    "UPDATE lotto SET digit1=?, digit2=?, digit3=?, digit4=?, digit5=?, " .
    "digit6=?, additionaldigit=? WHERE payment_id=? AND uniqueid IS NULL AND fortunoruniqueid IS NULL"
);
$aDigits = $_GET["digits"];
$oUpdate->bind_param("dddddddd", $aDigits[0], $aDigits[1], $aDigits[2], $aDigits[3], $aDigits[4], $aDigits[5], $aDigits[6], $iPaymentId);
$oUpdate->execute();

if ($oUpdate->error) {
    putlog("Could not store lottery in database: " . $oUpdate->error);
    $aViewData = array("return" => "NOK");
}
else {
    $aViewData = array("return" => "ACK");
}

$oUpdate->close();


// Render JSON
header("Content-type: application/json");
echo json_encode($aViewData);
