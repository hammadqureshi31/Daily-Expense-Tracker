Download XAMPP, Do setup into your system. Open XAMPP control panel start Apache and MySQL. Open browser Navigate to  "http://localhost/phpmyadmin"
Create Database:
Click on the "Databases" tab.
Enter expense_tracker as the database name.
Click "Create".
Create Tables:
Select the expense_tracker database from the left sidebar.
Go to the "SQL" tab.
Paste the below SQL commands into the textarea.

USE expense_tracker;

CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE expenses (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    date DATE NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

Click "Go".


And Navigate to " http://localhost/expense_tracker/index.php "
