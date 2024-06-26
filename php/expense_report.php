<?php
session_start();

include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('location: login.php');
    exit;
}

$user = $_SESSION['user']; // Get logged in user

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_expense'])) {
    $expense_id = $_POST['expense_id'];
    $stmt = $conn->prepare("DELETE FROM expenses WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $expense_id, $user['id']);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Expense deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting expense!";
    }

    $stmt->close();
    header('Location: expense_report.php'); // Redirect to the same page after deletion
    exit;
}

// Fetch expenses for the logged-in user
$user_id = $user['id'];
$query = "SELECT * FROM expenses WHERE user_id = $user_id";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Report</title>
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
    <div class='sub-header'>
        <h1>Expense Report</h1>
    </div>
    
    <div class="content">
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Expense Name</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo $row['amount']; ?></td>
                            <td>
                                <form method="post" action="expense_report.php" onsubmit="return confirm('Are you sure you want to delete this expense?');">
                                    <input type="hidden" name="expense_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="delete_expense" class="btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No expenses found.</p>
        <?php endif; ?>
        
        <p>
            <a href="../index.php" class="btn-back">Back to Dashboard</a>
        </p>
    </div>
</body>
</html>
