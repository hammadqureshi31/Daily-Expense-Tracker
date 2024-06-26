<?php
session_start();

include 'db.php';

// Initialize variables
$username = '';
$errors = array();

// If the login button is clicked
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receive all input values from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Validate form inputs
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($password)) { array_push($errors, "Password is required"); }

    // Attempt login if no errors
    if (count($errors) == 0) {
        $query = "SELECT * FROM users WHERE username='$username'";
        $result = $conn->query($query);
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) { // Verify password
            $_SESSION['user'] = $user;
            header('location: ../index.php'); // Redirect to dashboard
        } else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="header">
        <h2>Login</h2>
    </div>
    
    <form method="post" action="login.php">
        <!-- <?php include('php/errors.php'); ?> Display validation errors here -->
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" value="<?php echo $username; ?>">
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password">
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="login_btn">Login</button>
        </div>
        <p>
            Not yet a member? <a href="register.php">Sign up</a>
        </p>
    </form>
</body>
</html>
