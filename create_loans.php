<?php
include "connect.php";
$item_result = null; // initialize

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['item'])) {
    $item = $_POST['item'];

    $stmt = $conn->prepare('SELECT * FROM items WHERE name = ?');
    $stmt->bind_param("s", $item);
    $stmt->execute();
    $result = $stmt->get_result();

    $item_result = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['borrower'])) {
    $borrower  = trim($_POST['borrower'] ?? '');
    $phone     = trim($_POST['phone'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $id_number = intval($_POST['id_number'] ?? 0);
    $item_name = trim($_POST['item_name'] ?? '');
    $quantity  = intval($_POST['quantity'] ?? 0);


    $sql_1="SELECT * FROM borrower  
            WHERE name = ?
            AND phone = ?
            AND email = ? 
            AND id_number = ? 
            AND item = ? 
            AND quantity = ?  ";
    
    $stmt_1 = $conn->prepare($sql_1);
    if ($stmt_1 === false) { die("Preparation failed: " . $conn->error); }
    $stmt_1->bind_param("sssisi", $borrower, $phone, $email, $id_number, $item_name, $quantity);
    
    $stmt_1->execute();

    $result_1 = $stmt_1->get_result();

    if ($result_1->num_rows > 0) {
    die("Loan already exists. Process terminated.");
    }



    // insert borrower: use correct types (name, phone, email = strings; id_number = int)
    $stmt = $conn->prepare("INSERT INTO borrower(name, phone, email, id_number, item, quantity) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) { die("Preparation failed: " . $conn->error); }
    $stmt->bind_param("sssisi", $borrower, $phone, $email, $id_number, $item_name, $quantity );

    if (! $stmt->execute()) {
        die("Insert failed: " . $stmt->error);
    }
    $stmt->close();

    // get item row
    $sql = "SELECT total_quantity FROM items WHERE name = ?";
    $stmt2 = $conn->prepare($sql);
    if ($stmt2 === false) { die("Preparation failed: " . $conn->error); }
    $stmt2->bind_param("s", $item_name);
    $stmt2->execute();
    $result = $stmt2->get_result();
    $result_arr = $result ? $result->fetch_assoc() : null;
    $stmt2->close();

    if (!$result_arr) {
        die("Item not found.");
    }

    $original_quantity = intval($result_arr['total_quantity']);
    if ($quantity <= 0) {
        die("Invalid quantity.");
    }
    if ($quantity > $original_quantity) {
        die("Not enough stock. Available: $original_quantity");
    }

    $current_quantity = $original_quantity - $quantity;

    // update only the matched item
    $update_sql = "UPDATE items SET total_quantity = ? WHERE name = ?";
    $stmt3 = $conn->prepare($update_sql);
    if ($stmt3 === false) { die("Preparation failed: " . $conn->error); }
    $stmt3->bind_param("is", $current_quantity, $item_name);

    if ($stmt3->execute()) {
        header("Location: create_loans.php");
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
    <title>Create loan</title>
</head>
<body>
    <h2>Create loan </h2>
    <h3>Check Availability</h3>
    <form action="create_loans.php" method="post">
        <input type="text" name="item">
        <br><br>
        <button type="submit">Search</button>
    </form>

    <?php if ($item_result !== null): ?>
        <p id="chairs_availabe">Chairs available are <?php echo htmlspecialchars($item_result['total_quantity']); ?></p>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == 'POST'): ?>
        <p id="chairs_availabe">No item found with that name.</p>
    <?php endif; ?>

    <h3>Loan Item</h3>

    <form action="create_loans.php" method="post">
        <label>Borrower:</label>
        <input type="text" name="borrower">
        <br><br>
        <label>Phone number:</label>
        <input type="number" name="phone">
        <br><br>
        <label>Email:</label>
        <input type="email" name="email">
        <br><br>
        <label>Id number</label>
        <input type="number" name="id_number">
        <br><br>
        <label>Item</label>
        <input type="text" name="item_name">
        <br><br>
        <label>Quantity</label>
        <input type="number" name="quantity">
        <br><br>
        <button type="submit">Create Loan</button>
    </form>

    
</body>
</html>
