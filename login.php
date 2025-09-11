<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user by username
    $stmt = $conn->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password_hash'];

        // Verify password
        if (password_verify($password, $hashedPassword)) {
            // Redirect based on stored role
            if ($row['role'] === 'admin') {
                header("Location: admin_dashboard.php");
                exit;
            } elseif ($row['role'] === 'staff') {
                header("Location: staff_dashboard.php");
                exit;
            } else {
                echo 'Unknown role.';
            }
        } else {
            echo 'Invalid password';
        }
    } else {
        echo 'Invalid username';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Log In</h2>
    <form action="login.php" method="post">
        <label>Username:</label><br>
        <input type="text" name="username" required>
        <br><br>
        <label>Password:</label><br>
        <input type="password" name="password" required>
        <br><br>
        <button type='submit'>Log in</button>
    </form>
</body>
</html>
