<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $username=$_POST['username'];
    $email=$_POST['email'];
    $role=$_POST['role'];
    $password=$_POST['password'];

    $hash=password_hash($password,PASSWORD_DEFAULT);
     
   $stmt2 = $conn->prepare("SELECT * FROM users WHERE username = ? AND email=? AND role=?");

   if ($stmt2 === false) {
    die("Preparation failed: " . $conn->error);
}

   $stmt2->bind_param("sss", $username, $email, $role);

   $stmt2->execute();

   $result2 = $stmt2->get_result();




    if ($result2->num_rows > 0) {
    die("User already exists. Process terminated.");
    }

    

    $stmt=$conn->prepare("INSERT INTO users(username, password_hash, email, role) VALUES (?, ?, ?, ?)");

    if ($stmt === false) {
        die("Preparation failed: " . $conn->error);
    }

    $stmt->bind_param("ssss", $username, $hash, $email, $role);

    if ($stmt->execute() ) {
        header("Location: add_users.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    
    $stmt->close();



}

$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Add user</title>
</head>
<body>
    <h2>Add user</h2>
    <form action="add_users.php" method="post">
        <label>username:</label>
        <input type='text' name='username'>
        <br><br>
        <label>Email:</label>
        <input type='email' name='email'>
        <br><br>
        <label>Role:</label>
        <input type='text' name='role'>
        <br><br>
        <label>Password:</label>
        <input type='password' name='password'>
        <br><br>
        <button type="submit">Add user</button>

    </form>
</body>
</html>