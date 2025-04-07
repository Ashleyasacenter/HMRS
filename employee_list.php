<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Employee List</h2>

    <!-- Search and Filter Form -->
    <form action="employee_list.php" method="GET">
        <input type="text" name="search" placeholder="Search by Employee ID or Name" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
        <select name="department">
            <option value="">Select Department</option>
            <option value="IT">IT</option>
            <option value="HR">HR</option>
            <option value="Finance">Finance</option>
            <option value="Sales">Sales</option>
        </select>
        <select name="position">
            <option value="">Select Position</option>
            <option value="Manager">Manager</option>
            <option value="Staff">Staff</option>
        </select>
        <select name="employment_type">
            <option value="">Select Employment Type</option>
            <option value="Full-Time">Full-Time</option>
            <option value="Part-Time">Part-Time</option>
        </select>
        <select name="status">
            <option value="">Select Status</option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select>
        <button type="submit">Filter</button>
    </form>

    <!-- Employee List Table -->
    <table>
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Position</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        
        $conn = new mysqli("localhost", "root", "", "DB_HRMS");
        if ($conn->connect_error) {
            die("<script>alert('Connection failed: " . $conn->connect_error . "');</script>");
        }

        $whereClauses = [];
        if (!empty($_GET['search'])) {
            $search = $conn->real_escape_string($_GET['search']);
            $whereClauses[] = "(CONCAT(first_name, ' ', last_name) LIKE '%$search%' OR id LIKE '%$search%')";
        }
        if (!empty($_GET['department'])) {
            $department = $conn->real_escape_string($_GET['department']);
            $whereClauses[] = "department = '$department'";
        }
        if (!empty($_GET['position'])) {
            $position = $conn->real_escape_string($_GET['position']);
            $whereClauses[] = "position = '$position'";
        }
        if (!empty($_GET['employment_type'])) {
            $employment_type = $conn->real_escape_string($_GET['employment_type']);
            $whereClauses[] = "employment_type = '$employment_type'";
        }
        if (!empty($_GET['status'])) {
            $status = $conn->real_escape_string($_GET['status']);
            $whereClauses[] = "status = '$status'";
        }

        $whereSql = count($whereClauses) > 0 ? "WHERE " . implode(" AND ", $whereClauses) : "";

        $sql = "SELECT id, first_name, last_name, department, position FROM employees $whereSql";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $employee_id = htmlspecialchars($row['id']);
                $first_name = htmlspecialchars($row['first_name']);
                $last_name = htmlspecialchars($row['last_name']);
                $department = htmlspecialchars($row['department']);
                $position = htmlspecialchars($row['position']);

                echo "<tr>";
                echo "<td>$employee_id</td>";
                echo "<td>$first_name $last_name</td>";
                echo "<td>$department</td>";
                echo "<td>$position</td>";

                // Ensure ID exists before displaying actions
                if (!empty($employee_id)) {
                    echo "<td>
                            <a href='employee_profile.php?id=$employee_id'>View Profile</a> | 
                            <a href='employee_edit.php?id=$employee_id'>Edit</a>
                          </td>";
                } else {
                    echo "<td>No ID Available</td>";
                }

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No employees found.</td></tr>";
        }

        $conn->close();
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
