<?php
  include 'connect.php';

  $id = $_GET['id'];

   $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    if ($stmt === false) {
        die("Preparation failed: " . $conn->error);
    }
    
    
    $stmt->bind_param("i", $id);
    
   
    if ($stmt->execute()) {
        header("Location: delete_users.php");
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    
    
    $stmt->close();

?>