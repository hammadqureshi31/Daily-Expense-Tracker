<?php
session_start();

include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    // Insert expense into database
    $stmt = $conn->prepare("INSERT INTO expenses (user_id, amount, description, date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("idss", $user['id'], $amount, $description, $date);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Expense added successfully!";
    } else {
        $_SESSION['error'] = "Error adding expense!";
    }

    $stmt->close();
    header('Location: ../index.php'); // Redirect to dashboard after adding expense
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Expense</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Add Expense</h1>
    </header>
    <nav>
        <ul>
            <li><a href="../index.php">Dashboard</a></li>
            <li><a href="expenses.php">Add Expense</a></li>
            <li><a href="expense_report.php">View Expenses</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="change_password.php">Change Password</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <div id="content">
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="error">
                <?php 
                    echo $_SESSION['error']; 
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif ?>
        <form method="post" action="add_expense.php">
            <div class="input-group">
                <label for="amount">Amount</label>
                <input type="number" name="amount" required>
            </div>
            <div class="input-group">
                <label for="description">Description</label>
                <input type="text" name="description" required>
            </div>
            <div class="input-group">
                <label for="date">Date</label>
                <input type="date" name="date" required>
            </div>
            <div class="input-group">
                <button type="submit" class="btn">Add Expense</button>
            </div>
        </form>
    </div>
    <script src="../js/script.js"></script>
</body>
</html>
