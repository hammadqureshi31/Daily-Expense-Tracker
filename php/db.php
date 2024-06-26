<?php
// Database configuration
$host = 'localhost'; // MySQL server address
$dbname = 'expense_tracker'; // Database name
$username = 'hammad'; // Database username
$password = 'hammad'; // Database password

// Create database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to insert a new user into the database
function insertUser($username, $email, $password) {
    global $conn;
    
    // Prepare statement
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    // Execute statement
    $stmt->execute();
    
    // Return the newly inserted user id
    return $stmt->insert_id;
}

// Function to fetch user by username
function getUserByUsername($username) {
    global $conn;
    
    // Prepare statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    
    // Execute statement
    $stmt->execute();
    
    // Get result
    $result = $stmt->get_result();
    
    // Return user row or null if not found
    return $result->fetch_assoc();
}

// Function to fetch user by user id
function getUserById($id) {
    global $conn;
    
    // Prepare statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    // Execute statement
    $stmt->execute();
    
    // Get result
    $result = $stmt->get_result();
    
    // Return user row or null if not found
    return $result->fetch_assoc();
}

// Function to update user password
function updateUserPassword($user_id, $new_password) {
    global $conn;
    
    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    
    // Prepare statement
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashed_password, $user_id);
    
    // Execute statement
    $stmt->execute();
    
    // Check if update was successful
    return $stmt->affected_rows > 0;
}

// Close prepared statement and database connection
function closeConnection() {
    global $conn;
    $conn->close();
}
?>
