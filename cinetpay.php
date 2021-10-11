<?php
//Credentials apiKey & siteId
$apikey = '';
$cpm_site_id ='';

//Post Parameters
$cpm_version = 'V1';
$cpm_language = 'fr';
$cpm_currency = 'CFA';
$cpm_page_action = 'PAYMENT';
$cpm_payment_config = 'SINGLE';
$cpSecure = "https://secure.cinetpay.com";
$signatureUrl = "https://api.cinetpay.com/v1/?method=getSignatureByPost";
/////////////////////////////

$cpm_amount = 100; //TransactionAmount
$cpm_custom = '';// This field exist soanything can be inserted in it;it will be send back after payment

$cpm_designation = 'Payement'; //this field exist to identify the article being paid


$cpm_trans_date = date("Y-m-d H:i:s");
$cpm_trans_id = 'payement-' . (string)date("YmdHis"); //Transaction id that will be send to identify the transaction
$return_url = ""; //The customer will be redirect on this page after successful payment
$cancel_url = "";//The customer will be redirect on this page if the payment get cancel
$notify_url = "";//This page must be a webhook (webservice).
//it will be called weither or nor the payment is success or failed
//you must only listen to this to update transactions status


//Data that will be send in the form
$getSignatureData = array(
    'apikey' => $apikey,
    'cpm_amount' => $cpm_amount,
    'cpm_custom' => $cpm_custom,
    'cpm_site_id' => $cpm_site_id,
    'cpm_version' => $cpm_version,
    'cpm_currency' => $cpm_currency,
    'cpm_trans_id' => $cpm_trans_id,
    'cpm_language' => $cpm_language,
    'cpm_trans_date' => $cpm_trans_date,
    'cpm_page_action' => $cpm_page_action,
    'cpm_designation' => $cpm_designation,
    'cpm_payment_config' => $cpm_payment_config
);
// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'method' => "POST",
        'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
        'content' => http_build_query($getSignatureData)
        )
);

$context = stream_context_create($options);
$result = file_get_contents($signatureUrl, false, $context);
if ($result === false) {
    /* Handle error */
    \header($return_url);
    exit();
}
// var_dump($getSignatureData);
// echo("\n");
$signature = json_decode($result);
// var_dump($signature);

?>

<!DOCTYPE html>
<html>
<head>  
           <title>slydesign test</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
           <script charset="utf-8" src="https://www.cinetpay.com/cdn/seamless_sdk/latest/cinetpay.prod.min.js" type="text/javascript"></script> 
           <script src="payment.js" type="text/javascript"></script>
      </head>  
<body>
    <form action="<?php echo $cpSecure; ?>" method="post">
        <input type="hidden" value="<?php echo $apikey; ?>" name="apikey">
        <p><input type="text" value="<?php echo $cpm_amount; ?>" name="cpm_amount"></p>
        <input type="hidden" value="<?php echo $cpm_custom; ?>" name="cpm_custom">
        <input type="hidden" value="<?php echo $cpm_site_id; ?>" name="cpm_site_id">
        <input type="hidden" value="<?php echo $cpm_version; ?>" name="cpm_version">
        <p><input type="text" value="<?php echo $cpm_currency; ?>" name="cpm_currency"></p>
        <input type="hidden" value="<?php echo $cpm_trans_id; ?>" name="cpm_trans_id">
        <input type="hidden" value="<?php echo $cpm_language; ?>" name="cpm_language">
        <input type="hidden" value="<?php echo $getSignatureData['cpm_trans_date']; ?>" name="cpm_trans_date">
        <input type="hidden" value="<?php echo $cpm_page_action; ?>" name="cpm_page_action">
        <p><input type="text" value="<?php echo $cpm_designation; ?>" name="cpm_designation"> </p>
        <input type="hidden" value="<?php echo $cpm_payment_config; ?>" name="cpm_payment_config">
        <input type="hidden" value="<?php echo $signature; ?>" name="signature">
        <input type="hidden" value="<?php echo $return_url; ?>" name="return_url">
        <input type="hidden" value="<?php echo $cancel_url; ?>" name="cancel_url">
        <input type="hidden" value="<?php echo $notify_url; ?>" name="notify_url">
        <button type="submit" class="btn btn-primary"  id="bt_get_signature">Procéder au payement</button>	
        <input type="hidden" value="1" name="debug">
        
    </form>
</body>

</html>
