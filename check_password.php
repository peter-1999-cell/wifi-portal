<?php
$input_password = $_POST['password']; // from login form
$now = time();

$lines = file('passwords.txt');
$valid = false;

foreach ($lines as $line) {
    list($phone, $pass, $amount, $expiry) = explode('|', trim($line));
    
    if ($pass == $input_password) {
        if ($now <= (int)$expiry) {
            $valid = true;
            $remaining = $expiry - $now;
        }
        break;
    }
}

if ($valid) {
    echo "✅ Password is valid. Remaining time: " . gmdate("H:i:s", $remaining);
} else {
    echo "❌ Invalid or expired password.";
}
?>
