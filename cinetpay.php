<?php
require_once __DIR__ . '/src/new-guichet.php';
//Credentials apiKey & siteId
try {
    if(1 !=0)
    {
$customer_name ="gg";
$customer_surname = "lll";
$description ="dgfegtgrth";
$amount ="100";
$currency = "XOF";
}
else{
    echo "Veuillez passer par le formulaire";
}
//transaction id
$id_transaction = date("YmdHis"); // or $id_transaction = Cinetpay::generateTransId()

//Veuillez entrer votre apiKey
$apikey = "xxxxxxx";
//Veuillez entrer votre siteId
$site_id = "xxxxxxx";

//notify url
$notify_url = "http://mondomaine.com/notify/";
//return url
$return_url = "http://mondomaine.com/notify/";
$channels = "ALL";


$formData = array(
    "transaction_id"=> $id_transaction,
    "amount"=> $amount,
    "currency"=> $currency,
    "customer_surname"=> $customer_name,
    "customer_name"=> $customer_surname,
    "description"=> $description,
    "notify_url" => $notify_url,
    "return_url" => $return_url,
    "channels" => $channels,
    "metadata" => "Joe", // utiliser cette variable pour recevoir des informations personnalisés.
    "alternative_currency" => "XOF",//Valeur de la transaction dans une devise alternative
    //pour afficher le paiement par carte de credit
    "customer_email" => "down@test.com", //l'email du client
    "customer_phone_number" => "0708876711", //Le numéro de téléphone du client
    "customer_address" => "BP 0024", //l'adresse du client
    "customer_city" => "abidjan", // ville du client
    "customer_country" => "CI",//Le pays du client, la valeur à envoyer est le code ISO du pays (code à deux chiffre) ex : CI, BF, US, CA, FR
    "customer_state" => "CI", //L’état dans de la quel se trouve le client. Cette valeur est obligatoire si le client se trouve au États Unis d’Amérique (US) ou au Canada (CA)
    "customer_zip_code" => "225" //Le code postal du client
);
// enregistrer la transaction dans votre base de donnée
/*  $commande->create(); */

$CinetPay = new CinetPay($site_id, $apikey);
$result = $CinetPay->generatePaymentLink($formData);

if ($result["code"] == '201')
{
    $url = $result["data"]["payment_url"];

    // ajouter le token à la transaction enregistré
    /* $commande->update(); */
    //redirection vers l'url de paiement
    header('Location:'.$url);

}
} catch (Exception $e) {
echo $e->getMessage();
}

?>

<!DOCTYPE html>
<html>
<head>  
           <title>sylvain test</title>  
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
