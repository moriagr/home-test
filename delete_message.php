<?php
// delete_message.php

// Assume user authentication is done and you know $logged_in_username

define("a328763fe27bba", "TRUE");

// auth.php
require_once('config.php');

$message_id = $_POST['message_id'] ?? null;
if (!$message_id) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing message ID']);
    exit;
}


$result = mysql_update("messages", [ "msg_type"=>"revoked"], ["row_id"=>$message_id]);
if (!$result['success']) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete message']);
}
else echo json_encode(['status' => 'ok']);
exit;
