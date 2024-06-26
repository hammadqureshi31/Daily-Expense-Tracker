<?php
session_start();

include 'php/db.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('location: php/login.php');
    exit;
}

$user = $_SESSION['user']; // Get logged-in user
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Expense Tracker</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Daily Expense Tracker</h1>
    </header>
    <nav>
        <ul>
            <li><a href="php/expenses.php">Add Expense</a></li>
            <li><a href="php/expense_report.php">View Expenses</a></li>
            <li><a href="php/profile.php">Profile</a></li>
            <li><a href="php/change_password.php">Change Password</a></li>
            <li><a href="php/logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Here dashboard should come -->
    <div id="content">
        <h2>Welcome to your Dashboard</h2>
        <p>Here you can manage your expenses, view reports, and update your profile.</p>
        
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="error success">
                <h3>
                    <?php 
                        echo $_SESSION['success']; 
                        unset($_SESSION['success']);
                    ?>
                </h3>
            </div>
        <?php endif ?>

        <!-- Display user information -->
        <?php if (isset($user['username'])) : ?>
            <p>Welcome <strong><?php echo htmlspecialchars($user['username']); ?></strong></p>
        <?php endif ?>
    </div>
    
    <script src="js/script.js"></script>
</body>
</html>
