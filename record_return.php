<?php

header("Cache-Control: no-cache, must-revalidate, no-store, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

include 'connect.php';
$result=null;

if ($_SERVER["REQUEST_METHOD"]=='POST') {
    $borrower = $_POST['borrower'];

    $stmt = $conn->prepare('SELECT * FROM borrower WHERE name = ?');
    $stmt->bind_param("s", $borrower);
    $stmt->execute();
    $result = $stmt->get_result();

    

}

if ($_SERVER["REQUEST_METHOD"]=='POST' && isset($_POST['item'])) {
    $item=$_POST['item'];
    $quantity=$_POST['quantity'];
    $borrower = $_POST['borrower'];

    $sql = "SELECT total_quantity FROM items WHERE name = ?";
    $stmt2 = $conn->prepare($sql);
    if ($stmt2 === false) { die("Preparation failed: " . $conn->error); }
    $stmt2->bind_param("s", $item);
    $stmt2->execute();
    $result = $stmt2->get_result();
    $result_arr = $result ? $result->fetch_assoc() : null;
    $stmt2->close();

    if (!$result_arr) {
        die("Item not found.");
    }

    $db_quantity = intval($result_arr['total_quantity']);


    $current_quantity = $db_quantity + $quantity;

    $update_sql = "UPDATE items SET total_quantity = ? WHERE name = ?";
    $stmt3 = $conn->prepare($update_sql);
    if ($stmt3 === false) { die("Preparation failed: " . $conn->error); }
    $stmt3->bind_param("is", $current_quantity, $item);

    if ($stmt3->execute()) {
        $delete_sql="DELETE FROM borrower WHERE name= ?;";
        $stmt4=$conn->prepare($delete_sql);
        if ($stmt4 === false) { die("Preparation failed: " . $conn->error); }
         $stmt4->bind_param("s", $borrower);
         $stmt4->execute();
        header("Location: record_return.php");
        exit();
    } else {
        echo "Error updating record: " . $stmt3->error;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
    
</head>
<body>
    <h2>Record return</h2>
<h3>Check borrower</h3>
<form action="record_return.php" method="post">
    <input type="text" name="borrower">
    <br><br>
    <button type="submit">Search</button>
</form>

    <?php if ($result !== null && $result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Id number</th>
                <th>Item</th>
                <th>Quantity</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>

            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['id_number']; ?></td>
                <td><?php echo $row['item']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
            </tr>

            <?php endwhile; ?>    
        </table>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == 'POST'): ?>
        <p id="borrower_availabe">No borrower found with that name.</p>
    <?php endif; ?>

    <h3>Return item</h3>
    <form action="record_return.php" method="post">
        <label>Item:</label>
        <input type="text" name='item'>
        <br><br>
        <label>Quantity:</label>
        <input type="text" name='quantity'>
        <br><br>
         <label>Borrower:</label>
        <input type="text" name="borrower">
        <br><br>
        <button type="submit">Return</button>
    </form>
</body>
</html>