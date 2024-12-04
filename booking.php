<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "Please login first.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hotel_name = $_POST['hotel_name'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    $stmt = $conn->prepare("INSERT INTO bookings (user_id, hotel_name, check_in, check_out) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $hotel_name, $check_in, $check_out]);

    echo "Booking successful!";
}
?>

<form method="POST">
    <input type="text" name="hotel_name" placeholder="Hotel Name" required>
    <input type="date" name="check_in" required>
    <input type="date" name="check_out" required>
    <button type="submit">Book Now</button>
</form>
