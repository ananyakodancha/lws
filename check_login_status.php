<?php
session_start();

$response = array(
    "loggedIn" => false
);

if (isset($_SESSION['email'])) {
    $response["loggedIn"] = true;
}

echo json_encode($response);
?>
