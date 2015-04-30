<?php
/**
* do the lottery stuff for a given transaction
*/
require_once "common.php";
require_once "Fortunor.php";

// let's not allow strange stuff
if (!isset($_GET["reference"])) {
	die("invalid parameters");
}

// get lottery information
$oDbHandle = newDbHandle();
$oSelect = $oDbHandle->prepare(
	"SELECT lotto.id,shortnumber,digit1,digit2,digit3,digit4,digit5,digit6,additionaldigit,lotto.created,fortunoruniqueid IS NULL,pc.given,pc.family,pc.gender,pc.email,pc.emailsent,pc.id AS pcid FROM lotto "
  . "JOIN payment ON payment.id = payment_id "
  . "JOIN paymentcustomer pc ON pc.payment_id = payment.id "
  . "WHERE payment.okforlottery = 1 AND payment.uniquenumber = ?"
);
$oSelect->bind_param("s", $_GET["reference"]);
$oSelect->execute();
$oSelect->bind_result($iLottoId,
					  $sShortId,
					  $iDigit1,
					  $iDigit2,
					  $iDigit3,
					  $iDigit4,
					  $iDigit5,
					  $iDigit6,
					  $iAdditionalDigit,
					  $sCreatedDate,
					  $bNeedsSubmit,
					  $sGiven,
					  $sFamily,
					  $bGender,
                      $sEmail,
                      $bSent,
                      $iPcId);

$oSelect->fetch();
$oSelect->close();

// Digits are not nullable, so if we have one of them, we have them all!
if ($iDigit1 === null) {
	die("invalid reference");
}

// Perform lottery magic unless this has already happened
$aDigits = array($iDigit1, $iDigit2, $iDigit3, $iDigit4, $iDigit5, $iDigit6);
$oCreatedDate = DateTime::createFromFormat("Y-m-d H:i:s", $sCreatedDate);
$oLotteryDate = $oCreatedDate->modify("+2 days");

if ($bNeedsSubmit) {
	$sFortunorTxId = str_pad($sShortId, 16, "X");

	$oFortunor = new Fortunor($aConfig["fortunor"]);
	$aFortunorData = $oFortunor->submit(
		$sFortunorTxId,
		$aDigits,
		$iAdditionalDigit,
		$oLotteryDate,
		$oLotteryDate
	);

	$aViewData["result"] = $aFortunorData[1];

	// Update database record for this
	if ($aFortunorData[1] === "SUCC") {
		putlog("Updating lottery record " . $iLottoId);
		$oUpdate = $oDbHandle->prepare(
			"UPDATE lotto SET uniqueid = ?, fortunoruniqueid = ?, startdate = ?, enddate = ?, modified = NOW() WHERE id = ?"
		);
		$oUpdate->bind_param("ssssd", $sFortunorTxId, $aFortunorData[2], $oLotteryDate->format("Y-m-d"), $oLotteryDate->format("Y-m-d"), $iLottoId);
		$oUpdate->execute();

		if ($oUpdate->error) {
			putlog("Could not update lottery record: " . $oUpdate->error);
		}

		$oUpdate->close();
	}
}

// Send email
if(!$bSent && !empty($sEmail)) {
    $subject = $aConfig["mailsubject"];
    $header = "From: " . $aConfig["mailfrom"];

    $sDigits = implode(", ", $aDigits) . " + ". $iAdditionalDigit;
    $bMailSent = mail($sEmail, $aConfig["mailsubject"], sprintf(
            $aConfig["mailmsg"],
            $bGender ? "Mr" : "Mrs",
            $sGiven,
            $sFamily,
            $oLotteryDate->format("d.m.Y"),
            $sDigits
        ),
        $header
    );

    if($bMailSent) {
        $oUpdate = $oDbHandle->prepare("UPDATE paymentcustomer SET emailsent=1 WHERE id = ?");
        $oUpdate->bind_param("s", $iPcId);
        $oUpdate->execute();

        if ($oUpdate->error) {
            putlog("Could not update paymentcustomer record: " . $oUpdate->error);
        }

        $oUpdate->close();
    }
    else {
        putlog("Could not send mail to " . $sEmail);
    }
}

// Mirror the digits back to the caller
$aViewData["digits"] = $aDigits;
$aViewData["additionaldigit"] = $iAdditionalDigit;
$aViewData["date"] = $oLotteryDate->format("Y-m-d");
$aViewData["customer"]["given"] = $sGiven;
$aViewData["customer"]["name"] = $sFamily;
$aViewData["customer"]["gender"] = $bGender;

// Give json result
header("Content-type: application/json");
echo json_encode($aViewData);


