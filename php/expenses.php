<?php
session_start();

include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('location: login.php');
    exit;
}

$user = $_SESSION['user']; // Get logged-in user

// Fetch expenses for the logged-in user
$user_id = $user['id'];
$query = "SELECT * FROM expenses WHERE user_id = $user_id";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Daily Expense Tracker</h1>
    </header>
    <nav>
        <ul>
        <li><a href="../index.php">Dashboard</a></li>
        <li><a href="expense_report.php">View Expenses</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="change_password.php">Change Password</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="sub-header">
        <h2>Expenses</h2>
    </div>
    
    <div id="content">
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Expense Name</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($row['amount']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No expenses found.</p>
        <?php endif; ?>
        
        <div class='buttons'>
            <a href="add_expense.php">Add Expense</a>
            <a href="../index.php">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
