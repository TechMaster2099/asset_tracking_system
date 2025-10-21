<?php
include 'connect.php';

$sql="SELECT * FROM items";
$result=$conn->query($sql);

 $sql2="SELECT * FROM borrower";
 $result2=$conn->query($sql2);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>View assets</title>
    <style>
    /* hide both tables when the page loads */
    #items_table, #borrowers_table { display: none; }
  </style>
    <script>
        function showTable(tableId){
            const tables = ['items_table', 'borrowers_table'];

            tables.forEach(table => {
                document.getElementById(table).style.display = 'none';
            });

            document.getElementById(tableId).style.display = 'block';

            
        }
    </script>
</head>
<body>
    <div class="table-navigation">
       <button onclick="showTable('items_table')">Items</button>
       <button onclick="showTable('borrowers_table')">Borrowers</button>
    </div>
    <div id="items_table">
        <h2>Items</h2>
        <table>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Original Quantity</th>
                <th>Current Quantity</th>
                <th>Lent Quantity</th>
                <th>Notes</th>
                <th>Date added</th>
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
            </tr>

            <?php endwhile; ?>
        </table>


    </div>

    <div id="borrowers_table">
        <h2>borrowers</h2>
        <table>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Id number</th>
                <th>Item</th>
                <th>Quantity</th>
            </tr>

            <?php
            $counter = 1; 
            while ($row2 = $result2->fetch_assoc()):
            ?>

            <tr>
                <td><?php echo $counter++; ?></td>
                <td><?php echo $row2['name'];?></td>
                <td><?php echo $row2['phone'];?></td>
                <td><?php echo $row2['email'];?></td>
                <td><?php echo $row2['id_number'];?></td>
                <td><?php echo $row2['item'];?></td>
                <td><?php echo $row2['quantity'];?></td>
            </tr>

            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>