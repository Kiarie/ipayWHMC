<?php
/**
 * WHMCS Sample Payment Gateway Module
 *
 * Payment Gateway modules allow you to integrate payment solutions with the
 * WHMCS platform.
 *
 * This sample file demonstrates how a payment gateway module for WHMCS should
 * be structured and all supported functionality it can contain.
 *
 * Within the module itself, all functions must be prefixed with the module
 * filename, followed by an underscore, and then the function name. For this
 * example file, the filename is "ipay" and therefore all functions
 * begin "ipay_".
 *
 * If your module or third party API does not support a given function, you
 * should not define that function within your module. Only the _config
 * function is required.
 *
 * For more information, please refer to the online documentation.
 *
 * @see http://docs.whmcs.com/Gateway_Module_Developer_Docs
 *
 * @copyright Copyright (c) WHMCS Limited 2015
 * @license http://www.whmcs.com/license/ WHMCS Eula
 */

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

/**
 * Define module related meta data.
 *
 * Values returned here are used to determine module related capabilities and
 * settings.
 *
 * @see http://docs.whmcs.com/Gateway_Module_Meta_Data_Parameters
 *
 * @return array
 */
function ipay_MetaData()
{
    return array(
        'DisplayName' => 'iPay',
        'APIVersion' => '1.1', // Use API Version 1.1
        'DisableLocalCredtCardInput' => true,
        'TokenisedStorage' => false,
    );
}

/**
 * Define gateway configuration options.
 *
 * The fields you define here determine the configuration options that are
 * presented to administrator users when activating and configuring your
 * payment gateway module for use.
 *
 * Supported field types include:
 * * text
 * * password
 * * yesno
 * * dropdown
 * * radio
 * * textarea
 *
 * Examples of each field type and their possible configuration parameters are
 * provided in the sample function below.
 *
 * @return array
 */
function ipay_config()
{
    return array(
        // the friendly display name for a payment gateway should be
        // defined here for backwards compatibility
        'FriendlyName' => array(
            'Type' => 'System',
            'Value' => 'iPay Africa',
        ),
        // a text field type allows for single line text input
        'accountID' => array(
            'FriendlyName' => 'Account ID',
            'Type' => 'text',
            'Size' => '25',
            'Default' => 'demo',
            'Description' => 'Enter your vendor ID here',
        ),
        // a password field type allows for masked text input
        'hashkey' => array(
            'FriendlyName' => 'Secret Key',
            'Type' => 'password',
            'Size' => '25',
            'Default' => '',
            'Description' => 'Enter secret key here',
        ),
        // the yesno field type displays a single checkbox option
        'testMode' => array(
            'FriendlyName' => 'Test Mode',
            'Type' => 'dropdown',
            'Options'=> array(
                '0'=> '0',
                '1' => '1'
                ),
            'Description' => 'Tick to enable test mode 1 for Live and 0 for demo',
        ),
        // the dropdown field type renders a select menu of options
        'currency' => array(
            'FriendlyName' => 'Currency',
            'Type' => 'dropdown',
            'Options' => array(
                'KES' => 'KES',
                'USD' => 'USD'

            ),
            'Description' => 'Choose one',
        ),
        // the radio field type displays a series of radio button options
        'radioField' => array(
            'FriendlyName' => 'iPay Version ',
            'Type' => 'radio',
            'Options' => ' 2.0 , 3.0',
            'Description' => 'Choose your option!',
        ),
        // the textarea field type allows for multi-line text input
        'Comments' => array(
            'FriendlyName' => 'Comments',
            'Type' => 'textarea',
            'Rows' => '3',
            'Cols' => '60',
            'Description' => 'Freeform multi-line text input field',
        ),
    );
}

/**
 * Payment link.
 *
 * Required by third party payment gateway modules only.
 *
 * Defines the HTML output displayed on an invoice. Typically consists of an
 * HTML form that will take the user to the payment gateway endpoint.
 *
 * @param array $params Payment Gateway Module Parameters
 *
 * @see http://docs.whmcs.com/Payment_Gateway_Module_Parameters
 *
 * @return string
 */
function ipay_link($params)
{
    // Gateway Configuration Parameters
    $accountID = $params['accountID'];
    $hashkey = $params['hashkey'];
    $testMode = $params['testMode'];
    // $dropdownField = $params['dropdownField'];
     $radioField = $params['radioField'];
    $Comments = $params['Comments'];

    // Invoice Parameters
    $invoiceId = $params['invoiceid'];
    $orderId  = $invoiceId;

    $description = $params["description"];
    $amount = $params['amount'];
    $currencyCode = $params['currency'];

    // Client Parameters
    $firstname = $params['clientdetails']['firstname'];
    $lastname = $params['clientdetails']['lastname'];
    $email = $params['clientdetails']['email'];
    $address1 = $params['clientdetails']['address1'];
    $address2 = $params['clientdetails']['address2'];
    $city = $params['clientdetails']['city'];
    $state = $params['clientdetails']['state'];
    $postcode = $params['clientdetails']['postcode'];
    $country = $params['clientdetails']['country'];
    $phone = $params['clientdetails']['phonenumber'];

    // System Parameters
    $companyName = $params['companyname'];
    $systemUrl = $params['systemurl'];
    $returnUrl = $params['returnurl'];
    $langPayNow = $params['langpaynow'];
    $moduleDisplayName = $params['name'];
    $moduleName = $params['paymentmethod'];
    $whmcsVersion = $params['whmcsVersion'];
    $pst = array();

    if($radioField == '2.0')
    {
    $url = 'https://www.ipayafrica.com/payments/';


    $pst['live'] = $testMode;
    $pst['mm'] = 1;
    $pst['mb'] = 1;
    $pst['dc'] = 0;
    $pst['cc'] = 1;
    $pst['mer'] = $accountID;
    // $pst['last_name'] = $lastname;
    $pst['oid'] = $invoiceId;
    $pst['inv'] = $invoiceId;
    $pst['ttl'] = $amount;
    $pst['tel'] = $phone;


    $pst['eml'] = $email;
    $pst['vid'] = $accountID;
    $pst['cur'] = $currencyCode;
    $pst['p1'] = '';
    $pst['p2'] = '';
    $pst['p3'] = '';
    $pst['p4'] = '';
    $pst['cbk'] = $systemUrl . '/modules/gateways/callback/' . $moduleName . '.php';
    $pst['cst'] = 1;
    $pst['crl'] = 0;
    $datastring = '';
    foreach ($pst as $key => $value) {
        $datastring .= $value;
    }
    // $datastring = "01101demo20202000.000770221268kiarie@ipayafrica.comdemoKEShttp://cheapdomain.co.ke/modules/gateways/callback/ipay.phpkiarieipayafricacom0";
    // $datastring =  $pst['live'].$pst['mm'].$pst['mb'].$pst['dc'].$pst['cc'].$pst['mer'].$pst['oid'].$pst['inv'].$pst['ttl'].$pst['tel'].$pst['eml'].$pst['vid'].$pst['cur'].$pst['p1'].$pst['p2'].$pst['p3'].$pst['p4'].$pst['cbk'].$pst['cst'].$pst['crl'];
                                                            // $live.$mm.$mb.$dc.$cc.$mer.$oid.$inv.$ttl.$tel.$eml.$vid.$cur.$p1.$p2.$p3.$p4.$cbk.$cst.$crl;
    $hashid = hash_hmac('sha1', $datastring, $hashkey);
    $pst['hsh'] = $hashid;
    // $pst['cbk'] = urlencode($pst['cbk']);

    }
    if($radioField == '3.0')
    {
    $url = 'https://www.ipayafrica.com/payments/v3/ke';

    $pst['live'] = $testMode;
    $pst['inv'] = $invoiceId;
    $pst['oid'] = $orderId;
    $pst['ttl'] = $amount;
    $pst['tel'] = $phone;

    // $pst['currency'] = $currencyCode;
    // $pst['first_name'] = $firstname;
    // $pst['last_name'] = $lastname;
    $pst['eml'] = $email;
    $pst['vid'] = $accountID;
    $pst['curr'] = $currencyCode;
    $pst['p1'] = $orderId;
    $pst['p2'] = $companyName;
    $pst['p3'] = $returnUrl;
    $pst['p4'] = $country;
    $pst['cbk'] = $systemUrl . '/modules/gateways/callback/' . $moduleName . '.php';
    $pst['cst'] = 1;
    $pst['crl'] = 0;


    $datastring =  $pst['live'].$pst['oid'].$pst['inv'].$pst['ttl'].$pst['tel'].$pst['eml'].$pst['vid'].$pst['curr'].$pst['p1'].$pst['p2'].$pst['p3'].$pst['p4'].$pst['cbk'].$pst['cst'].$pst['crl'];
    $hashid = hash_hmac('sha1', $datastring, $hashkey);
    $pst['hsh'] = $hashid;
    }
    //$pst['return_url'] = $returnUrl;

    $htmlOutput = '<form method="post" action="' . $url . '">';
    foreach ($pst as $k => $v) {
        $htmlOutput .= '<input type="hidden" name="' . $k . '" value="' . $v . '" />';
    }
    $htmlOutput .= '<input type="submit" value="' . $langPayNow . '" />';
    $htmlOutput .= '</form>';

    return $htmlOutput;
}
