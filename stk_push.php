<?php
date_default_timezone_set('Africa/Nairobi');

// === Step 1: Credentials ===
$consumerKey    = 'LulBPqgQg9QtIysA1cX1AcH69hI4gvyAB4KkqLpqxY4GWGzR';
$consumerSecret = 'R5w0aThWqzpRjZdujjmDUBJEd6AeF4egMSrehDr0E5m2CZBhGQG69njNNhVkaJEl';

// === Step 2: Get Access Token ===
$credentials = base64_encode($consumerKey . ':' . $consumerSecret);
$url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $credentials]);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$token_response = curl_exec($curl);
curl_close($curl);

$token = json_decode($token_response);
if (!isset($token->access_token)) {
    die("❌ Failed to get access token: " . $token_response);
}
$access_token = $token->access_token;

// === Step 3: STK Push ===
$stkUrl = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

$BusinessShortCode = '6048146'; // Your Till Number
$Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
$Timestamp = date('YmdHis');
$Password = base64_encode($BusinessShortCode . $Passkey . $Timestamp);

// Your phone number
$PartyA = '254743830419'; // CHANGE this to your real Safaricom number

$stkPushData = [
    'BusinessShortCode' => $BusinessShortCode,
    'Password' => $Password,
    'Timestamp' => $Timestamp,
    'TransactionType' => 'CustomerBuyGoodsOnline',
    'Amount' => 10,
    'PartyA' => $PartyA,
    'PartyB' => $BusinessShortCode,
    'PhoneNumber' => $PartyA,
    'CallBackURL' => 'https://mydomain.com/callback',
    'AccountReference' => 'VillageWiFi',
    'TransactionDesc' => 'WiFi Access'
];

$ch = curl_init($stkUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $access_token,
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($stkPushData));
$response = curl_exec($ch);
curl_close($ch);

// === Show response ===
echo "<pre>";
print_r(json_decode($response));
echo "</pre>";

// Optional: Save to log file
file_put_contents("stk_response_log.txt", $response . "\n", FILE_APPEND);
