<?php
 if ($_SERVER["REQUEST_METHOD"]=='POST') {
    $username=$_POST['username'];
    $role=$_POST['role'];
    $password=$_POST['password'];

     $stmt = $conn->prepare('SELECT * FROM users WHERE username = ?');
     $stmt->bind_param("s", $username);
     $stmt->execute();
     $result = $stmt->get_result();

     if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password_hash'];

        if (password_verify($password, $hashedPassword)) {
            if ($row['role'] === 'admin') {
                header("Location: admin_dashboard.php");
                exit;
        }elseif ($row['role'] === 'staff') {
                header("Location: staff_dashboard.php");
                exit;
        }else {
            echo 'unknown role.';
        }
        }else {
            echo 'invalid password';
        }
     }else {
        echo 'invalid username';
     }
     }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <h2>Log In</h2>
    <form action="login.php" method="post">
        <label>username:</label>
        <br>
        <input type="text" name="username">
        <br><br>
        <label>role:</label>
        <br>
        <select name='role'>
            <option value="admin">admin</option>
            <option value="staff">staff</option>
        </select>
        <br><br>
        <label>password:</label>
        <br>
        <input type="password" name="password">
        <br><br>
        <button type='submit'>log in</button>
    </form>
</body>
</html>