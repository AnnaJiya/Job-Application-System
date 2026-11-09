<?php

require 'db.php';

$sql = "SELECT id, name, email, mobile, username
        FROM applicants";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Applicant Records</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container" style="width:90%;">

    <h2>Submitted Job Applications</h2>

    <?php
    if ($result && $result->num_rows > 0) {
    ?>

        <table border="1" cellpadding="10" cellspacing="0"
               style="width:100%; border-collapse:collapse;">

            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Username</th>
            </tr>

            <?php
            while ($row = $result->fetch_assoc()) {
            ?>

                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                </tr>

            <?php
            }
            ?>

        </table>

    <?php
    } else {
        echo "<p>No applicant records found.</p>";
    }

    $conn->close();
    ?>

    <p><a href="index.php">Back to Application Form</a></p>

</div>

</body>
</html>