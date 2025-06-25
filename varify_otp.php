<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$otp = $data['otp'];
$email = $data['email'];

$response = ['verified' => false];

if (isset($_SESSION['otp']) && $_SESSION['otp'] == $otp && $_SESSION['otp_email'] == $email) {
    $response['verified'] = true;
}

echo json_encode($response);
?>