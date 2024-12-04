<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking App</title>
    <style>
        /* Same CSS as in your provided code */
        body {
            background-color: black;
            color: white;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #333;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            width: 320px;
        }

        .container h2 {
            margin-bottom: 20px;
            color: #2ecc71;
        }

        .input-box {
            margin-bottom: 15px;
        }

        .input-box input, .input-box select {
            padding: 12px;
            width: 100%;
            border: 2px solid #2ecc71;
            background-color: #444;
            color: white;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn {
            padding: 12px 20px;
            background-color: #2ecc71;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #27ae60;
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Hotel Booking Nepal</h2>
    <?php
    session_start();

    // Dummy admin credentials
    $admin_username = "admin";
    $admin_password = "admin123";

    $error = "";
    $success = "";

    // Handle form submissions
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['register'])) {
            $name = htmlspecialchars($_POST['name']);
            $address = htmlspecialchars($_POST['address']);
            $email = htmlspecialchars($_POST['email']);
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            $role = htmlspecialchars($_POST['role']);

            if (empty($name) || empty($address) || empty($email) || empty($username) || empty($password) || empty($role)) {
                $error = "All fields are required for registration!";
            } else {
                $_SESSION['users'][] = [
                    'name' => $name,
                    'address' => $address,
                    'email' => $email,
                    'username' => $username,
                    'password' => $password,
                    'role' => $role
                ];
                $success = "Registration successful!";
            }
        }

        if (isset($_POST['login'])) {
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            $role = htmlspecialchars($_POST['role']);

            if ($role === "admin" && $username === $admin_username && $password === $admin_password) {
                $success = "Welcome Admin!";
            } else {
                $found = false;
                if (isset($_SESSION['users'])) {
                    foreach ($_SESSION['users'] as $user) {
                        if ($user['username'] === $username && $user['password'] === $password && $user['role'] === $role) {
                            $success = "Welcome " . ucfirst($role) . "!";
                            $found = true;
                            break;
                        }
                    }
                }
                if (!$found) {
                    $error = "Invalid credentials or role.";
                }
            }
        }
    }
    ?>

    <!-- Login Form -->
    <form method="post">
        <h3>Login</h3>
        <div class="input-box">
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="input-box">
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <div class="input-box">
            <select name="role" required>
                <option value="user">User</option>
                <option value="hotel-owner">Hotel Owner</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <button class="btn" type="submit" name="login">Login</button>
    </form>

    <p style="margin-top: 20px;">Don't have an account? Register below:</p>

    <!-- Registration Form -->
    <form method="post">
        <h3>Register</h3>
        <div class="input-box">
            <input type="text" name="name" placeholder="Full Name" required>
        </div>
        <div class="input-box">
            <input type="text" name="address" placeholder="Address" required>
        </div>
        <div class="input-box">
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="input-box">
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="input-box">
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <div class="input-box">
            <select name="role" required>
                <option value="user">User</option>
                <option value="hotel-owner">Hotel Owner</option>
            </select>
        </div>
        <button class="btn" type="submit" name="register">Register</button>
    </form>

    <?php
    if (!empty($error)) {
        echo "<p class='error-message'>$error</p>";
    }
    if (!empty($success)) {
        echo "<p style='color: #2ecc71;'>$success</p>";
    }
    ?>
</div>

</body>
</html>
