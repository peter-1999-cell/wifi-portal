<?php
date_default_timezone_set('Africa/Nairobi');

$phone = $_POST['phone'];
$amount = 10; // default — you can adjust this if needed

// Determine expiry time
if ($amount == 10) {
    $hours = 3;
} elseif ($amount == 20) {
    $hours = 7;
} else {
    $hours = 1; // fallback
}

// Generate password
$password = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 6);

// Calculate expiry time
$expiry = time() + ($hours * 3600); // now + N hours

// Save to passwords.txt
$entry = "$phone|$password|$amount|$expiry\n";
file_put_contents("passwords.txt", $entry, FILE_APPEND);

// Send SMS
include 'send_sms.php';
send_sms($phone, "Your WiFi password is: $password. Valid for $hours hours.");

// Confirm to browser
echo "✅ Payment verified. Password sent to your phone.";
?>
