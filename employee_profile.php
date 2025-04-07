<?php
$conn = new mysqli("localhost", "root", "", "DB_HRMS");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid Employee ID.");
}

$employee_id = $conn->real_escape_string($_GET['id']);
$sql = "SELECT * FROM employees WHERE id = '$employee_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Employee not found.");
}

$employee = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Employee Profile</h2>
    <p><strong>ID:</strong> <?= htmlspecialchars($employee['id']) ?></p>
    <p><strong>Name:</strong> <?= htmlspecialchars($employee['first_name'] . " " . $employee['last_name']) ?></p>
    <p><strong>Department:</strong> <?= htmlspecialchars($employee['department']) ?></p>
    <p><strong>Position:</strong> <?= htmlspecialchars($employee['position']) ?></p>
    <p><strong>Employment Type:</strong> <?= htmlspecialchars($employee['employment_type']) ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars($employee['status']) ?></p>

    <a href="employee_edit.php?id=<?= htmlspecialchars($employee['id']) ?>">Edit Employee</a>
    <a href="employee_list.php">Back to Employee List</a>
</div>
</body>
</html>
