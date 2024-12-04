<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (name, address, email, username, password, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $address, $email, $username, $password, $role]);

    echo "Registration successful!";
}
?>

<form method="POST">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="text" name="address" placeholder="Address" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <select name="role">
        <option value="user">User</option>
        <option value="hotel-owner">Hotel Owner</option>
    </select>
    <button type="submit">Register</button>
</form>
