<?php
include 'db.php';

$class_streams = $conn->query("SELECT * FROM class_streams");

// Handle form submissions for adding new students
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_student'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $class_stream_id = $_POST['class_stream_id'];
    $sql = "INSERT INTO students (first_name, last_name, class_stream_id) VALUES ('$first_name', '$last_name', '$class_stream_id')";
    if ($conn->query($sql) === TRUE) {
        echo "New student added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle student deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM students WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Student deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// View single student details
if (isset($_GET['view'])) {
    $id = $_GET['view'];
    header("Location: view_student.php?id=$id");
    exit();
}

// Fetch all students
$students = $conn->query("SELECT students.*, class_streams.name as class_name FROM students JOIN class_streams ON students.class_stream_id = class_streams.id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Students</title>
</head>
<body>
    <h1>Students</h1>
    
    <!-- Add New Student Form -->
    <form method="POST">
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <select name="class_stream_id" required>
            <option value="">Select Class Stream</option>
            <?php while ($row = $class_streams->fetch_assoc()) { ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            <?php } ?>
        </select>
        <button type="submit" name="add_student">Add Student</button>
    </form>

    <!-- Display All Students -->
    <h2>All Students</h2>
    <ul>
        <?php while ($row = $students->fetch_assoc()) { ?>
            <li>
                <?php echo $row['first_name'] . ' ' . $row['last_name'] . ' (' . $row['class_name'] . ')'; ?>
                <a href="?view=<?php echo $row['id']; ?>">View</a> | 
                <a href="edit_student.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                <a href="?delete=<?php echo $row['id']; ?>">Delete</a>
            </li>
        <?php } ?>
    </ul>

    <a href="index.php">Back to Home</a>
</body>
</html>
