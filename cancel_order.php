<?php
session_start();
include("connection.php");
include("function.php");

$user_data = check_login($conn);
$user_id = $user_data['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Verify that this order belongs to this user and is cancellable
    $stmt = $conn->prepare("SELECT order_status FROM orders WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    if (!$order) {
        die("Order not found or you do not have permission.");
    }

    // Only allow cancel if status is pending or processing
    if (in_array($order['order_status'], array('pending', 'processing'))) {
        $stmt = $conn->prepare("UPDATE orders SET order_status = 'cancelled' WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "<script>alert('Order cancelled successfully.'); window.location.href='my_orders.php';</script>";
            exit;
        } else {
            die("Failed to cancel order: " . $stmt->error);
        }
    } else {
        die("Order cannot be cancelled at this stage.");
    }
} else {
    die("Invalid request.");
}
?>
