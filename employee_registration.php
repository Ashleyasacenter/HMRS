<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Employee Registration</h2>
    <form action="" method="POST">
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="middle_name" placeholder="Middle Name">
        <input type="date" name="date_of_birth" required>

        <!-- Gender -->
     <div class="gender-container" required>
       <label>Gender:</label><br>
       <label><input type="radio" name="gender" value="Male"> Male</label>
       <label><input type="radio" name="gender" value="Female"> Female</label>
      </div>

        <input type="text" name="home_address" placeholder="Home Address" required>
        <input type="text" name="contact_number" placeholder="Contact Number" required>
        <input type="email" name="email" placeholder="Email" required>

        <select name="employment_type" required>
            <option value="">Department</option>
            <option value="IT">IT</option>
            <option value="HR">HR</option>
            <option value="Finance">Finace</option>
            <option value="Sales">Sales</option>
        </select>

         <select name="employment_type" required>
            <option value="">Position</option>
            <option value="Manager">Manager</option>
            <option value="Staff">Staff</option>
        </select>

        <select name="employment_type" required>
            <option value="">Employment Type</option>
            <option value="Full-Time">Full-Time</option>
            <option value="Part-Time">Part-Time</option>
        </select>

        <select name="status" required>
            <option value="">Status</option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select>

        <input type="date" name="date_hired" required>
        <button type="submit" name="submit">Add Employee</button>
    </form>
    <br>
    <a href="employee_list.php">View Employee List</a>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    
    $conn = new mysqli("localhost", "root", "", "DB_HRMS");
    if ($conn->connect_error) {
        die("<script>alert('Connection failed: " . $conn->connect_error . "');</script>");
    }

    // Collect data
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $home_address = $_POST['home_address'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $position = $_POST['position'];
    $employment_type = $_POST['employment_type'];
    $status = $_POST['status'];
    $date_hired = $_POST['date_hired'];

    // Prepare insert
    $stmt = $conn->prepare("INSERT INTO employees 
        (last_name, first_name, middle_name, date_of_birth, gender, home_address, contact_number, email, department, position, employment_type, status, date_hired)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssssssssss", $last_name, $first_name, $middle_name, $date_of_birth, $gender, $home_address, $contact_number, $email, $department, $position, $employment_type, $status, $date_hired);

    if ($stmt->execute()) {
        echo "<script>alert('Employee added successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
</body>
</html>
