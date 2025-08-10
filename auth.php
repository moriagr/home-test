<?php
    define("a328763fe27bba", "TRUE");

    // auth.php
    require_once('config.php');
    
    header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Content-Type: application/json");
    require_once('send_email.php');
    function generateOTP($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $otp = '';
        for ($i = 0; $i < $length; $i++) {
            $otp .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $otp;
    }

    // $input = json_decode(file_get_contents("php://input"), true);
    $action = $_POST["action"] ?? null;
    $username = $_POST["username"] ?? null;
    $otp = $_POST['otp'] ?? '';
    $honeypot = $_POST['website'] ?? ''; // Honeypot field
    if (!empty($honeypot)) {
        // If the honeypot field is filled, it's likely a bot submission

        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Bot submission detected."]);
        exit;
    }


    if (!$action || !$username) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Missing action or username."]);
        exit;
    }


    $user_query = mysql_fetch_array("SELECT * FROM users WHERE username = ?", [$username]);


    if (!$user_query || count($user_query) === 0) {
        http_response_code(404);
        echo json_encode(["status" => "error", "message" => "User not found."]);
        exit;
    }

    $user = $user_query[0];
    // ->fetch_assoc();
    $user_id = $user['id'];

    if ($action === 'send_otp') {
        // check rate limits (4 per hour, 10 per day)
        $now = date('Y-m-d H:i:s');
        $hour_limit = 4;
        $one_hour_ago = date('Y-m-d H:i:s', strtotime('-1 hour'));
        $one_day_ago = date('Y-m-d H:i:s', strtotime('-1 day'));
        $day_limit = 10;

        $count_query = mysql_fetch_array(
            "SELECT COUNT(*) as count FROM user_otp_sessions WHERE user_id = ? AND created_at >= ?",
            [$user_id, $one_day_ago],
            // $connect
        );

        // $total_today = $count_query->fetch_assoc()['count'];

        $total_today = $count_query[0]["count"];

        if ($total_today >= $day_limit) {
            http_response_code(429);
            echo json_encode(["status" => "error", "message" => "OTP limit for this day exceeded."]);
            exit;
        }

        $count_hour_query = mysql_fetch_array(
            "SELECT COUNT(*) as count FROM user_otp_sessions WHERE user_id = ? AND created_at >= ?",
            [$user_id, $one_hour_ago],
            // $connect
        );

        // $total_hour = $count_query->fetch_assoc()['count'];
        $total_hour = $count_query[0]['count'];
        if ($total_hour >= $hour_limit) {
            http_response_code(response_code: 429);
            echo json_encode(["status" => "error", "message" => "OTP limit for this hour exceeded."]);
            exit;
        }


        $otp_code = generateOTP();

        $ten_minutes_after = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        $insert_query = mysql_insert(
            "user_otp_sessions",
            ["user_id" => $user_id, "otp_code" => $otp_code, "expires_at" => $ten_minutes_after]
        );
        // $connect


        sendEmailWithOTP($user['email'], $otp_code);
    }

    if ($action === 'validate_otp') {

        $count_query = mysql_fetch_array(
            "SELECT otp_code, expires_at FROM user_otp_sessions 
                WHERE user_id = ? 
                AND otp_code = ? 
                AND expires_at > NOW()
                ORDER BY id DESC LIMIT 1",
            [$user_id, $otp,],
            // $connect
        );
        if ($count_query && count($count_query) > 0) {
            // 2. OTP valid → generate token
            $token = bin2hex(random_bytes(32)); // 64-character secure token

            // 3. Store token (for example in users table)
            $count_query = mysql_fetch_array(
                "update users SET access_token = ? 
                WHERE id = ?",
                [$token, $user_id],
                // $connect
            );

            // 5. Send token to client
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'ok',
                'token' => $token
            ]);
        } else {
            // Invalid OTP
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid or expired OTP'
            ]);
        }
    }
exit;
?>
