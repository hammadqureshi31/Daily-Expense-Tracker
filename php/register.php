<?php
session_start();

include 'db.php';

// Initialize variables
$username = $email = '';
$errors = array();

// If the register button is clicked
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receive all input values from the form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Validate form inputs
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password)) { array_push($errors, "Password is required"); }

    // Check if username or email already exists
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = $conn->query($user_check_query);
    $user = $result->fetch_assoc();
    
    if ($user) { // If user exists
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }

        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    // If no errors, register user
    if (count($errors) == 0) {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT); // Encrypt the password
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password_hashed')";
        $conn->query($query);

        // Get the ID of the registered user
        $logged_in_user_id = $conn->insert_id;
        $_SESSION['user'] = getUserById($logged_in_user_id); // Put user into session

        // Redirect to dashboard
        header('location: ../index.php');
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="header">
        <h2>Register</h2>
    </div>
    
    <form method="post" action="register.php">
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
            <label>Password</label>
            <input type="password" name="password">
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="register_btn">Register</button>
        </div>
        <p>
            Already a member? <a href="login.php">Sign in</a>
        </p>
    </form>
</body>
</html>
