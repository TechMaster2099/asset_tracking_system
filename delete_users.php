<?php

header("Cache-Control: no-cache, must-revalidate, no-store, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

include 'connect.php';

$sql="SELECT * FROM users";
$result=$conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Delete users</title>
</head>
<body>
    <h2>Delete user</h2>
    <table>
        <tr>
            <th></th>
            <th>Username</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php
          $counter = 1; 
         while ($row = $result->fetch_assoc()):
        ?>

        <tr>
            <td data-label=""><?php echo $counter++; ?></td>
            <td data-label="Username"><?php echo $row['username'];?></td>
            <td data-label="Email"><?php echo $row['email'];?></td>
            <td data-label="Action">
                <a id="delete-button" href="delete.php?id=<?php echo $row['user_id']; ?>">Delete</a>
            </td>
        </tr>
      <?php endwhile; ?>

    </table>
</body>
</html>