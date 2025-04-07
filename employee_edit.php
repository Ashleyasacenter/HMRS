<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "DB_HRMS");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if employee ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid Employee ID.");
}

$employee_id = $conn->real_escape_string($_GET['id']);

// Fetch employee details
$sql = "SELECT * FROM employees WHERE id = '$employee_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Employee not found.");
}

$employee = $result->fetch_assoc();

// Update employee details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $department = $conn->real_escape_string($_POST['department']);
    $position = $conn->real_escape_string($_POST['position']);
    $employment_type = $conn->real_escape_string($_POST['employment_type']);
    $status = $conn->real_escape_string($_POST['status']);

    $update_sql = "UPDATE employees SET 
                   first_name = '$first_name', 
                   last_name = '$last_name', 
                   department = '$department', 
                   position = '$position', 
                   employment_type = '$employment_type', 
                   status = '$status' 
                   WHERE id = '$employee_id'";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Employee updated successfully!'); window.location.href='employee_profile.php?id=$employee_id';</script>";
    } else {
        echo "<script>alert('Error updating employee: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Employee</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Edit Employee</h2>
    <form action="employee_edit.php?id=<?= htmlspecialchars($employee['id']) ?>" method="POST">
        <label>First Name:</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($employee['first_name']) ?>" required>

        <label>Last Name:</label>
        <input type="text" name="last_name" value="<?= htmlspecialchars($employee['last_name']) ?>" required>

        <label>Department:</label>
        <select name="department">
            <option value="IT" <?= $employee['department'] == 'IT' ? 'selected' : '' ?>>IT</option>
            <option value="HR" <?= $employee['department'] == 'HR' ? 'selected' : '' ?>>HR</option>
            <option value="Finance" <?= $employee['department'] == 'Finance' ? 'selected' : '' ?>>Finance</option>
            <option value="Sales" <?= $employee['department'] == 'Sales' ? 'selected' : '' ?>>Sales</option>
        </select>

        <label>Position:</label>
        <select name="position">
            <option value="Manager" <?= $employee['position'] == 'Manager' ? 'selected' : '' ?>>Manager</option>
            <option value="Staff" <?= $employee['position'] == 'Staff' ? 'selected' : '' ?>>Staff</option>
        </select>

        <label>Employment Type:</label>
        <select name="employment_type">
            <option value="Full-Time" <?= $employee['employment_type'] == 'Full-Time' ? 'selected' : '' ?>>Full-Time</option>
            <option value="Part-Time" <?= $employee['employment_type'] == 'Part-Time' ? 'selected' : '' ?>>Part-Time</option>
        </select>

        <label>Status:</label>
        <select name="status">
            <option value="Active" <?= $employee['status'] == 'Active' ? 'selected' : '' ?>>Active</option>
            <option value="Inactive" <?= $employee['status'] == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
        </select>

        <button type="submit">Update Employee</button>
    </form>
    <a href="employee_profile.php?id=<?= htmlspecialchars($employee['id']) ?>">Cancel</a>
</div>
</body>
</html>
