<?php
function send_sms($phone, $message) {
    $username = "sandbox"; // or your production username
    $apiKey = "YOUR_AT_API_KEY"; // replace with your Africa's Talking API key

    $data = array(
        "username" => $username,
        "to" => $phone,
        "message" => $message
    );

    $url = "https://api.africastalking.com/version1/messaging";

    $headers = array(
        "apiKey: $apiKey",
        "Content-Type: application/x-www-form-urlencoded"
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);
}
