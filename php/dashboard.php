<?php
session_start();

include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('location: login.php');
}

$user = $_SESSION['user']; // Get logged in user

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href=".//css/style.css">
</head>
<body>
    <div class="header">
        <h2>Dashboard</h2>
    </div>
    
    <div class="content">
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="error success" >
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
            <p>Welcome <strong><?php echo $user['username']; ?></strong></p>
            
            <h1>Daily Expense Tracker</h1>
            <div id="content">
                <h2>Welcome to your Dashboard</h2>
                <p>Here you can manage your expenses, view reports, and update your profile.</p>
            </div>
            <p> <a href="logout.php" style="color: red;">logout</a> </p>
        <?php endif ?>
    </div>
</body>
</html>
