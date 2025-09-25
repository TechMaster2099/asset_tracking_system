<?php
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
            <th>Delete</th>
        </tr>
        <?php
          $counter = 1; 
         while ($row = $result->fetch_assoc()):
        ?>

        <tr>
            <td><?php echo $counter++; ?></td>
            <td><?php echo $row['username'];?></td>
            <td><?php echo $row['email'];?></td>
            <td>
                <a id="delete-button" href="delete.php?id=<?php echo $row['user_id']; ?>">Delete</a>
            </td>
        </tr>
      <?php endwhile; ?>

    </table>
</body>
</html>