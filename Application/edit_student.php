<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch student details
    $student_sql = "SELECT * FROM students WHERE id=$id";
    $student_result = $conn->query($student_sql);

    if ($student_result->num_rows > 0) {
        $student = $student_result->fetch_assoc();
    } else {
        echo "No student found with this ID.";
        exit();
    }

    // Handle student updates
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_student'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $class_stream_id = $_POST['class_stream_id'];
        $sql = "UPDATE students SET first_name='$first_name', last_name='$last_name', class_stream_id='$class_stream_id' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Student updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    // Fetch class streams for the dropdown
    $class_streams = $conn->query("SELECT * FROM class_streams");
} else {
    echo "No student ID specified.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body>
    <h1>Edit Student</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
        <input type="text" name="first_name" value="<?php echo $student['first_name']; ?>" required>
        <input type="text" name="last_name" value="<?php echo $student['last_name']; ?>" required>
        <select name="class_stream_id" required>
            <option value="">Select Class Stream</option>
            <?php while ($row = $class_streams->fetch_assoc()) { ?>
                <option value="<?php echo $row['id']; ?>" <?php echo ($row['id'] == $student['class_stream_id']) ? 'selected' : ''; ?>>
                    <?php echo $row['name']; ?>
                </option>
            <?php } ?>
        </select>
        <button type="submit" name="update_student">Update Student</button>
    </form>
    <a href="students.php">Back to Student List</a>
</body>
</html>
