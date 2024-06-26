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
$username = $user['username'];
$email = $user['email'];
$errors = array();

// If the update profile button is clicked
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receive all input values from the form
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    
    // Validate form inputs
    if (empty($new_username)) { array_push($errors, "Username is required"); }
    if (empty($new_email)) { array_push($errors, "Email is required"); }

    // If no errors, update profile
    if (count($errors) == 0) {
        $user_id = $user['id'];
        $query = "UPDATE users SET username='$new_username', email='$new_email' WHERE id=$user_id";
        $conn->query($query);

        $_SESSION['success'] = "Profile updated successfully";
        $_SESSION['user']['username'] = $new_username; // Update session with new username
        $_SESSION['user']['email'] = $new_email; // Update session with new email
        header('location: profile.php'); // Redirect to profile page to refresh data
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
        <h2>Profile</h2>
    </div>
    
    <form method="post" action="profile.php">
        <!-- <?php include('php/errors.php'); ?> Display validation errors here -->
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" value="<?php echo $username; ?>">
        </div>
        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email" value="<?php echo $email; ?>">
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="update_profile_btn">Update Profile</button>
        </div>
        <p>
            <a href="../index.php">Back to Dashboard</a>
        </p>
    </form>
</body>
</html>
