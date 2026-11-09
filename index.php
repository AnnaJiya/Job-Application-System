<?php
session_start();

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];

unset($_SESSION['errors'], $_SESSION['old']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Job Application Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<?php if (!empty($errors)) { ?>
    <div class="error-box">
        <strong>Please correct the following errors:</strong>
        <ul>
            <?php foreach ($errors as $error) { ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
    <h2>Job Application Form</h2>
    <p>Please enter your details to apply.</p>

    <form action="submit.php" method="POST">

        <label>Name</label>
<input type="text" name="name"
       placeholder="Enter your full name"
       value="<?php echo htmlspecialchars($old['name'] ?? ''); ?>"
       required>
        <label>Email</label>
<input type="text" name="email"
       placeholder="Enter your email address"
       value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>"
       required>
        <label>Mobile Number</label>
<input type="text" name="mobile"
       placeholder="Enter your mobile number"
       value="<?php echo htmlspecialchars($old['mobile'] ?? ''); ?>"
       required>
        <label>Username</label><input type="text" name="username"
       placeholder="Enter your full name"
       value="<?php echo htmlspecialchars($old['username'] ?? ''); ?>"
       required>
        <label>Password</label>
        <input type="password" name="password" placeholder="Choose a password" required>

        <button type="submit" name="submit">Submit Application</button>

    </form>

    <p><a href="applicants.php">View Submitted Applications</a></p>
</div>

</body>
</html>