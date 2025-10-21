<?php

header("Cache-Control: no-cache, must-revalidate, no-store, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

 include 'connect.php';

 $sql="SELECT * FROM items";
 $result=$conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Delete Items</title>
</head>
<body>
    <h2>Delete Item</h2>
    <table>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Original Quantity</th>
            <th>Current Quantity</th>
            <th>Lent Quantity</th>
            <th>Notes</th>
            <th>Date added</th>
            <th>Action</th>
        </tr>
        <?php
          $counter = 1; 
         while ($row = $result->fetch_assoc()):
        ?>

        <tr>
            <td><?php echo $counter++; ?></td>
            <td><?php echo $row['name'];?></td>
            <td><?php echo $row['original'];?></td>
            <td><?php echo $row['total_quantity'];?></td>
            <td><?php echo $row['original']-$row['total_quantity'];?></td>
            <td><?php echo $row['notes'];?></td>
            <td><?php echo $row['created_at'];?></td>


            <td>
                <a id="delete-button" href="delete_I.php?id=<?php echo $row['id']; ?>">Delete</a>
            </td>
        </tr>     
   
        <?php endwhile; ?>
    </table>
</body>
</html>