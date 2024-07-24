<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT students.*, class_streams.name as class_name FROM students JOIN class_streams ON students.class_stream_id = class_streams.id WHERE students.id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "No student found with this ID.";
        exit();
    }
} else {
    echo "No student ID specified.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Student</title>
</head>
<body>
    <h1>View Student</h1>
    <p><strong>First Name:</strong> <?php echo $student['first_name']; ?></p>
    <p><strong>Last Name:</strong> <?php echo $student['last_name']; ?></p>
    <p><strong>Class Stream:</strong> <?php echo $student['class_name']; ?></p>
    <a href="students.php">Back to Student List</a>
</body>
</html>
