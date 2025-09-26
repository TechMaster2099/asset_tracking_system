<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == 'POST'){
 $name=$_POST['name'];
 $quantity=$_POST['quantity'];
 $note=$_POST['note'];

 $stmt= $conn->prepare("SELECT * FROM ITEMS WHERE name=?");

 if ($stmt === false) {
    die("Preparation failed: " . $conn->error);
}
 $stmt->bind_param("s", $name);
 
 $stmt->execute();

 $result2 = $stmt->get_result();

 if ($result2->num_rows > 0) {
    die("Item already exists. Process terminated.");
    }

 $stmt2=$conn->prepare("INSERT INTO items(name, total_quantity, notes) VALUES (?, ?, ?)");
  
 if ($stmt2 === false) {
        die("Preparation failed: " . $conn->error);
    }

    $stmt2->bind_param("sis", $name, $quantity, $note);
    
    if ($stmt2->execute() ) {
        header("Location: add_items.php");
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
    <title>add items</title>
</head>
<body>
    <h2>Add Items</h2>
<form action="add_items.php" method="post">
    <label>Name:</label>
    <input type="text" name="name">
    <br><br>
    <label>Quantity:</label>
    <input type="number" name="quantity">
    <br><br>
    <label>Note:</label>
    <textarea name="note"></textarea>
    <br><br>
    <button type="submit">Add</button>
</form>

</body>
</html>