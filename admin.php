<?php
// Database connection
$host = 'localhost';
$dbname = 'hotel_booking';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle user management actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_user'])) {
        $name = $_POST['user_name'];
        $email = $_POST['user_email'];
        $role = $_POST['user_role'];

        $stmt = $conn->prepare("INSERT INTO users (name, email, role) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $role]);
    } elseif (isset($_POST['delete_user'])) {
        $id = $_POST['user_id'];
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    } elseif (isset($_POST['add_hotel'])) {
        $name = $_POST['hotel_name'];
        $price = $_POST['hotel_price'];
        $image = '';

        if ($_FILES['hotel_image']['name']) {
            $image = 'uploads/' . basename($_FILES['hotel_image']['name']);
            move_uploaded_file($_FILES['hotel_image']['tmp_name'], $image);
        }

        $stmt = $conn->prepare("INSERT INTO hotels (name, price, image) VALUES (?, ?, ?)");
        $stmt->execute([$name, $price, $image]);
    } elseif (isset($_POST['delete_hotel'])) {
        $id = $_POST['hotel_id'];
        $stmt = $conn->prepare("DELETE FROM hotels WHERE id = ?");
        $stmt->execute([$id]);
    }
}

// Fetch users and hotels
$users = $conn->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
$hotels = $conn->query("SELECT * FROM hotels")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            width: 90%;
            margin: auto;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        form {
            margin-bottom: 20px;
        }

        input, select, button {
            padding: 10px;
            margin: 5px 0;
            width: 100%;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>

        <!-- Manage Users -->
        <h2>Manage Users</h2>
        <form method="POST">
            <input type="text" name="user_name" placeholder="User Name" required>
            <input type="email" name="user_email" placeholder="User Email" required>
            <select name="user_role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit" name="add_user" class="btn">Add User</button>
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['name'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['role'] ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <button type="submit" name="delete_user" class="btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <!-- Manage Hotels -->
        <h2>Manage Hotels</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="hotel_name" placeholder="Hotel Name" required>
            <input type="number" step="0.01" name="hotel_price" placeholder="Hotel Price" required>
            <input type="file" name="hotel_image" required>
            <button type="submit" name="add_hotel" class="btn">Add Hotel</button>
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            <?php foreach ($hotels as $hotel): ?>
                <tr>
                    <td><?= $hotel['id'] ?></td>
                    <td><?= $hotel['name'] ?></td>
                    <td><?= $hotel['price'] ?></td>
                    <td>
                        <img src="<?= $hotel['image'] ?>" alt="Hotel Image" style="width:100px;">
                    </td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="hotel_id" value="<?= $hotel['id'] ?>">
                            <button type="submit" name="delete_hotel" class="btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
