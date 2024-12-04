<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'hotel-owner') {
    echo "You must be a hotel owner to view this page.";
    exit;
}

echo "Welcome to the Hotel Owner Dashboard!";
?>

<!-- Hotel owner can manage bookings here -->
