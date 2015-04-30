<?php
/**
 * Run a query on the given unique id exactly once, return current
 * payment state as well as interesting stuff from the customer
 * block.
 */
require_once "common.php";

// don't bother returning wellformed json here
if (!isset($_GET["reference"])) {
	die("reference parameter is required");
}

$sUniqueId = htmlspecialchars($_GET["reference"]);

// Build PI request
$sXml = <<<"PI"
<?xml version="1.0" encoding="UTF-8"?>
<Request version="1.0">
    <Query>
        <Login>
            <User>{$aConfig['pi']['user']}</User>
            <Password>{$aConfig['pi']['password']}</Password>
        </Login>
        <Scope entity="project">
			<EntityID>{$aConfig['pi']['projectid']}</EntityID>
		</Scope>
		<Identifications>
			<Identification>
				<UniqueID>$sUniqueId</UniqueID>
			</Identification>
		</Identifications>
    </Query>
</Request>
PI;

// Perform request
$rCurl = curl_init($aConfig['pi']["api"] . "/query/xml");
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
	$sResult = $oX->e("//Query/Processing/Result");
	$sReturnMessage = $oX->e("//Query/Processing/Return");

	if ($sResult !== "ACK") {
		$aViewData["error"] = $sReturnMessage;
	}
	else {
		// Get transaction status
		$sStatus = $oX->e("//Result/Transaction/Processing/Status[1]/.");
		$aViewData["status"] = $sStatus;

		// Update okforlottery if we have received payment
		if (in_array($sStatus, array("RECEIVED"))) {
			putlog("Permitting lottery for transaction " . $sUniqueId);
			$oDbHandle = newDbHandle();
			$oStmt = $oDbHandle->prepare(
				"UPDATE payment SET okforlottery=1, state=? WHERE uniquenumber=?"
			);
			$oStmt->bind_param("ss", $sStatus, $sUniqueId);
			$oStmt->execute();
			$oStmt->close();

			putlog("Updating customer information for transaction " . $sUniqueId);

			$sCustomerGiven = $oX->e("//Transaction/Customer/Name/Given");
			$sCustomerFamily = $oX->e("//Transaction/Customer/Name/Family");
			$iCustomerGender = $oX->e("//Transaction/Customer/Name/Sex") === "M";
            $sCustomerMail = $oX->e("//Transaction/Customer/Contact/Email");

			$oStmt = $oDbHandle->prepare(
				"UPDATE paymentcustomer pc "
			  . "INNER JOIN payment p ON p.id = pc.payment_id "
			  . "SET given = ?, family = ?, gender = ?, email = ? "
			  . "WHERE p.uniquenumber = ?"
			);

			$oStmt->bind_param("ssdss", $sCustomerGiven, $sCustomerFamily, $iCustomerGender, $sCustomerMail, $sUniqueId);
			$oStmt->execute();
			$oStmt->close();
		}
	}
}

// Render JSON
header("Content-type: application/json");
echo json_encode($aViewData);
