<?php
session_start();

include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('location: login.php');
    exit;
}

$user = $_SESSION['user']; // Get logged in user

// Initialize variables
$current_password = $new_password = '';
$errors = array();

// If the change password button is clicked
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receive all input values from the form
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    
    // Validate form inputs
    if (empty($current_password)) { array_push($errors, "Current Password is required"); }
    if (empty($new_password)) { array_push($errors, "New Password is required"); }

    // Verify current password and update password if no errors
    if (count($errors) == 0) {
        // Check if current password matches
        if (password_verify($current_password, $user['password'])) {
            $user_id = $user['id'];
            $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT); // Encrypt the new password

            // Update user's password in the database
            $query = "UPDATE users SET password='$new_password_hashed' WHERE id=$user_id";
            $conn->query($query);

            $_SESSION['success'] = "Password changed successfully";
            header('location: change_password.php'); // Redirect to refresh page
        } else {
            array_push($errors, "Incorrect current password");
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Daily Expense Tracker</h1>
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
    <div class="sub-header">
        <h2>Change Password</h2>
    </div>
    
    <form method="post" action="change_password.php">
        <!-- <?php include('php/errors.php'); ?> Display validation errors here -->
        <div class="input-group">
            <label>Current Password</label>
            <input type="password" name="current_password">
        </div>
        <div class="input-group">
            <label>New Password</label>
            <input type="password" name="new_password">
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="change_password_btn">Change Password</button>
        </div>
        <p>
            <a href="../index.php">Back to Dashboard</a>
        </p>
    </form>
</body>
</html>
