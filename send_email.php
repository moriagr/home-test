<?php


function sendEmailWithOTP($email, $otp_code) {
    error_log(json_encode(file_exists('.env')));
    if (!file_exists('.env')) return;

    $lines = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) continue; // skip comments
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        if (!array_key_exists($key, $_ENV)) {
            $_ENV[$key] = $value;
            putenv("$key=$value"); // optional: allows getenv() usage too
        }
    }

    
    $apiKey = $_ENV['API_KEY'];
    $data = [
        'sender' => ['name' => $_ENV['SENDER_NAME'], 'email' => $_ENV['SENDER_EMAIL']],
        'to' => [['email' => $email]],
        'subject' => 'Your OTP Code',
        'htmlContent' => "<html><body><h2>Your OTP is: $otp_code</h2><p>Valid for 5 minutes.</p></body></html>"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.brevo.com/v3/smtp/email');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'accept: application/json',
        'api-key: ' . $apiKey,
        'content-type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 201) {
        error_log("Email send failed: $response , HTTP Code: $httpCode");
    }
}
?>
