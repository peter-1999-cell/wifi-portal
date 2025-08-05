<?php
$consumerKey = "jDDdEelQ6Bk9P1dGnlzvSYuwGnseDyYrkkOkhNSLG6uEd6Pd";
$consumerSecret = "zJlG97V5krToDwAd1NlITKTFAHsFAEZYpb9W1Gjs00sgWweiWHSa9FCd7NOccmtu";

$credentials = base64_encode($consumerKey . ':' . $consumerSecret);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $credentials]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

if ($response === false) {
    echo "❌ cURL Error: " . curl_error($ch);
} else {
    echo "✅ Response from Daraja:<br><pre>$response</pre>";
}

curl_close($ch);
?>
