<?php
/**
 * Allocate a VA.QP with the PI return URL to the qrcode
 * as well as uniqueid.  Payment information is stored
 * in database.
 */
require_once "common.php";

$sSelf = $aConfig["self"] . "continue.php?reference=~uniqueid~";

// Build PI request
$sAmount = sprintf("%.02f", $aConfig["pi"]["amount"]);
$sXml = <<<"PI"
<?xml version="1.0" encoding="UTF-8"?>
<Request version="1.0">
    <Transaction mode="{$aConfig["pi"]["mode"]}" response="ASYNC">
        <Login>
            <User>{$aConfig["pi"]["user"]}</User>
            <Password>{$aConfig["pi"]["password"]}</Password>
            <ProjectID>{$aConfig["pi"]["projectid"]}</ProjectID>
        </Login>
        <Payment code="VA.QP">
            <Presentation>
                <Amount>{$sAmount}</Amount>
                <Currency>EUR</Currency>
                <Usage>freelotto payment</Usage>
            </Presentation>
        </Payment>
		<Frontend>
			<ResponseUrl>{$sSelf}</ResponseUrl>
			<ResponseErrorUrl>{$sSelf}</ResponseErrorUrl>
		</Frontend>
    </Transaction>
</Request>
PI;

// Perform request
$rCurl = curl_init($aConfig["pi"]["api"] . "/payment/xml");
curl_setopt_array(
	$rCurl,
	array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FAILONERROR => true,
		CURLOPT_SSL_VERIFYHOST => false,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_POSTFIELDS => "xml=" . $sXml,
	)
);

$sResponseXml = curl_exec($rCurl);
curl_close($rCurl);

// Populate view data
if ($sResponseXml === false) {
	$aViewData["error"] = "PaymentInterface request failed";
}
else {
	$oResponseXml = new SimpleXMLElement($sResponseXml);
	$oX = new Xpath($oResponseXml);
	$sResult = $oX->e("//Processing/Result");
	$sReturnMessage = $oX->e("//Processing/Return");
	
	putlog("Payment result: " . $sResult);
	
	if ($sResult !== "ACK") {
		$aViewData["error"] = $sReturnMessage;
	}
	else {
		$sUniqueId = $oX->e("//UniqueID");
		$sShortId = $oX->e("//ShortID");
		$sDescriptor = $oX->e("//Descriptor");
		$sQrCodeUrl = $oX->e("//QrCodeUrl");
		$sAppUrl = $oX->e("//MobileAppUrl");
		
		if (!$sUniqueId || !$sShortId || !$sDescriptor || !$sQrCodeUrl || !$sAppUrl) {
			$aViewData["error"] = "Unexpected response from payment gateway";
		}
		else {
			// hackmode: replace qrcode size! :)
			$sQrCodeUrl = preg_replace("|/colour/(\d+)|", "/colour/100", $sQrCodeUrl);
			$sQrCodeUrl = preg_replace("|/size/(\d+)|", "/size/1", $sQrCodeUrl);
			
			// insert into database
			$oDb = newDbHandle();  // see common.php
			$oInsert = $oDb->prepare(
				"INSERT INTO payment (uniquenumber, shortnumber, descriptor, ip, created, modified) "
			  . "VALUES (?, ?, ?, ?, NOW(), NOW())"
			);
			
			$oInsert->bind_param("ssss", $sUniqueId, $sShortId, $sDescriptor, $_SERVER["REMOTE_ADDR"]);
			$oInsert->execute();
			
			if ($oInsert->error) {
				putlog("Could not store payment in database: " . $oInsert->error);
			}

			$oInsert->close();
			
			$iPaymentId = $oDb->insert_id;
			
			$oInsert = $oDb->prepare(
				"INSERT INTO paymentcustomer (payment_id) VALUES (?)"
			);
			
			$oInsert->bind_param("d", $iPaymentId);
			$oInsert->execute();
			
			if ($oInsert->error) {
				putlog("Could not store payment customer data in database: " . $oInsert->error);
			}
			
			$oInsert->close();
			
			$oInsert = $oDb->prepare(
				"INSERT INTO lotto (payment_id, created, modified) "
              . "VALUES (?, NOW(), NOW())"				
			);
			
			$oInsert->bind_param("d", $iPaymentId);
			$oInsert->execute();
			
			if ($oInsert->error) {
				putlog("Could not store lottery in database: " . $oInsert->error);
			}
			
			$oInsert->close();
			
			$aViewData["return"] = $sReturnMessage;
			$aViewData["uniqueid"] = $sUniqueId;
			$aViewData["shortid"] = $sShortId;
			$aViewData["descriptor"] = $sDescriptor;
			$aViewData["qrcode"] = $sQrCodeUrl;
			$aViewData["appurl"] = $sAppUrl;
		}
	}
}

// Render JSON
header("Content-type: application/json");
echo json_encode($aViewData);
