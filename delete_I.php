<?php
   include 'connect.php';

  $id = $_GET['id'];

   $stmt = $conn->prepare("DELETE FROM items WHERE id = ?");
    if ($stmt === false) {
        die("Preparation failed: " . $conn->error);
    }
    
    
    $stmt->bind_param("i", $id);
    
   
    if ($stmt->execute()) {
        header("Location: delete_items.php");
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    
    
    $stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
</head>
<body>
    
</body>
</html>