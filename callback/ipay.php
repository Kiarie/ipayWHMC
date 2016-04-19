<?php
/**
 * WHMCS Sample Payment Callback File
 *
 * This sample file demonstrates how a payment gateway callback should be
 * handled within WHMCS.
 *
 * It demonstrates verifying that the payment gateway module is active,
 * validating an Invoice ID, checking for the existence of a Transaction ID,
 * Logging the Transaction for debugging and Adding Payment to an Invoice.
 *
 * For more information, please refer to the online documentation.
 *
 * @see http://docs.whmcs.com/Gateway_Module_Developer_Docs
 *
 * @copyright Copyright (c) WHMCS Limited 2015
 * @license http://www.whmcs.com/license/ WHMCS Eula
 */

// Require libraries needed for gateway module functions.
require_once __DIR__ . '/../../../init.php';
require_once __DIR__ . '/../../../includes/gatewayfunctions.php';
// require_once __DIR__ . '/../../../includes/invoicefunctions.php';
include '../../../includes/invoicefunctions.php';

// Detect module name from filename.
$gatewayModuleName = basename(__FILE__, '.php');

// Fetch gateway configuration parameters.
$gatewayParams = getGatewayVariables($gatewayModuleName);

// Die if module is not active.
if (!$gatewayParams['type']) {
    die("Module Not Activated");
}

// Retrieve data returned in payment gateway callback
// Varies per payment gateway
$success = '';
$invoiceId = $_GET['ivm'];//ivm the invoice number is returned as an MD5 hash for you to process if you need to.
$transactionId = $_GET["ivm"]; //id for you to authenticate the order id again and map it to the order transaction again.

$paymentFee = floatval('0.00');
// $hash = $_GET["x_hash"];
 
$val3 = $_GET['qwh'];
$val4 = $_GET['afd'];
$val5 = $_GET['poi'];
$val6 = $_GET['uyt'];
$val7 = $_GET['ifd'];

$paymentAmount = floatval($_GET['mc']);

// echo ($success);
// echo ($invoiceId);
// echo ($transactionId);
// echo ($paymentAmount);
/**
 * Validate callback authenticity.
 *
 * Most payment gateways provide a method of verifying that a callback
 * originated from them. In the case of our example here, this is achieved by
 * way of a shared secret which is used to build and compare a hash.
 */
$ipnurl = "https://www.ipayafrica.com/ipn/?vendor=".$val."&id=".$data->id."&ivm=".$data->inv."&qwh=".$val3."&afd=".$val4."&poi=".$val5."&uyt=".$val6."&ifd=".$val7;

$fp = fopen($ipnurl, "rb");
$status = $_GET["status"];//stream_get_contents($fp, -1, -1);
fclose($fp);

if($status == 'bdi6p2yy76etrs')
{
    //pending
    $success = false;
}
if ($status == 'fe2707etr5s4wq') {
    //failed
    $success = false;
}
if($status == 'aei7p7yrx4ae34'){
    //success
    $success = true;
}
if ($status =='cr5i3pgy9867e1') {
    //used
    $success = false;
}
if ($status =='dtfi4p7yty45wq'){
    // less
    $success= false;
}
if ($status == 'eq3i7p5yt7645e') {
    //more
    $success= true;
}
$transactionStatus = $success ? 'Success' : 'Failure';
/*$secretKey = $gatewayParams['secretKey'];
if ($hash != md5($invoiceId . $transactionId . $paymentAmount . $secretKey)) {
    $transactionStatus = 'Hash Verification Failure';
    $success = false;
}
*/

/**
 * Validate Callback Invoice ID.
 *
 * Checks invoice ID is a valid invoice number. Note it will count an
 * invoice in any status as valid.
 *
 * Performs a die upon encountering an invalid Invoice ID.
 *
 * Returns a normalised invoice ID.
 */
$invoiceId = checkCbInvoiceID($invoiceId, $gatewayParams['name']);

/**
 * Check Callback Transaction ID.
 *
 * Performs a check for any existing transactions with the same given
 * transaction number.
 *
 * Performs a die upon encountering a duplicate.
 */
checkCbTransID($transactionId);

/**
 * Log Transaction.
 *
 * Add an entry to the Gateway Log for debugging purposes.
 *
 * The debug data can be a string or an array. In the case of an
 * array it will be
 *
 * @param string $gatewayName        Display label
 * @param string|array $debugData    Data to log
 * @param string $transactionStatus  Status
 */
logTransaction($gatewayParams['name'], $_GET, $transactionStatus);

if($success === true) {

    $invoiceId = intval($invoiceId);
    /**
     * Add Invoice Payment.
     *
     * Applies a payment transaction entry to the given invoice ID.
     *
     * @param int $invoiceId         Invoice ID
     * @param string $transactionId  Transaction ID
     * @param float $paymentAmount   Amount paid (defaults to full balance)
     * @param float $paymentFee      Payment fee (optional)
     * @param string $gatewayModule  Gateway module name
     */

    AddInvoicePayment(
        $invoiceId,
        $transactionId,
        $paymentAmount,
        $paymentFee,
        $gatewayModuleName
    );
    // use WHMCS\User\Alert;
    // header('Location: http://cheapdomain.co.ke/cart.php?a=complete');
        redirSystemURL("a=complete", "cart.php");
// echo '<meta http-equiv="refresh" content="3;url=http://cheapdomain.co.ke/cart.php?a=complete>';

}
if($success !== true)
{
    header('Location: http://cheapdomain.co.ke/clientarea.php?action=invoices');
    //&paymentfailed=true
}

