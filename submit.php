<?php

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $errors = [];

    // Validate name using regular expression
    if (!preg_match("/^[a-zA-Z ]{2,100}$/", $name)) {
        $errors[] = "Invalid name. Use letters and spaces only.";
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }

    // Validate mobile number using regular expression
    if (!preg_match("/^[6-9][0-9]{9}$/", $mobile)) {
        $errors[] = "Enter a valid 10-digit Indian mobile number.";
    }

    // Validate username
    if (!preg_match("/^[a-zA-Z0-9_]{4,50}$/", $username)) {
        $errors[] = "Username must contain 4-50 letters, numbers or underscores.";
    }

    // Validate password
    if (strlen($password) < 8) {
        $errors[] = "Password must have at least 8 characters.";
    }

    if (!preg_match("/[0-9]/", $password)) {
        $errors[] = "Password must contain at least one number.";
    }

    if (!preg_match("/[A-Z]/", $password)) {
        $errors[] = "Password must contain at least one uppercase letter.";
    }

    if (!preg_match("/[a-z]/", $password)) {
        $errors[] = "Password must contain at least one lowercase letter.";
    }

    // Display errors or insert the record
    if (!empty($errors)) {
    session_start();
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = [
        'name' => $name,
        'email' => $email,
        'mobile' => $mobile,
        'username' => $username
    ];

    header("Location: index.php");
    exit();
} else {

        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement
        $stmt = $conn->prepare(
            "INSERT INTO applicants
            (name, email, mobile, username, password)
            VALUES (?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssss",
            $name,
            $email,
            $mobile,
            $username,
            $hashed_password
        );

    try {
    if ($stmt->execute()) {
        echo "<h2>Application Submitted Successfully!</h2>";
        echo "<p>Your details have been stored in the database.</p>";
        echo '<a href="index.php">Apply Again</a>';
        echo '<br><br><a href="applicants.php">View Applications</a>';
    }
} catch (mysqli_sql_exception $e) {

    if ($e->getCode() == 1062) {
        echo "<h2>Application Error</h2>";
        echo "<p>This username is already taken. Please choose another.</p>";
        echo '<a href="index.php">Go Back</a>';
    } else {
        echo "<p>Database insertion failed. Please try again.</p>";
    }
}

    $stmt->close();
    }
}

$conn->close();

?>