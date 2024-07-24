<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $sql = "INSERT INTO class_streams (name) VALUES ('$name')";
    if ($conn->query($sql) === TRUE) {
        echo "New class stream created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM class_streams WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Class stream deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$class_streams = $conn->query("SELECT * FROM class_streams");

// View a single class stream
if (isset($_GET['view'])) {
    $id = $_GET['view'];
    $sql = "SELECT * FROM class_streams WHERE id=$id";
    $class_stream_result = $conn->query($sql);
    
    if ($class_stream_result->num_rows > 0) {
        $class_stream = $class_stream_result->fetch_assoc();
        $class_stream_name = $class_stream['name'];
        
        // Fetch students for the class stream
        $student_sql = "SELECT * FROM students WHERE class_stream_id=$id";
        $students = $conn->query($student_sql);
    } else {
        $class_stream_name = "No class stream found with this ID";
        $students = [];
    }
} else {
    $class_stream_name = "";
    $students = [];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Class Streams</title>
</head>
<body>
    <h1>Class Streams</h1>
    <form method="POST">
        <input type="text" name="name" placeholder="Class Stream Name" required>
        <button type="submit">Add Class Stream</button>
    </form>
    <h2>All Class Streams</h2>
    <ul>
        <?php while ($row = $class_streams->fetch_assoc()) { ?>
            <li>
                <?php echo $row['name']; ?> 
                <a href="?view=<?php echo $row['id']; ?>">View</a> | 
                <a href="?delete=<?php echo $row['id']; ?>">Delete</a>
            </li>
        <?php } ?>
    </ul>

    <?php if ($class_stream_name) { ?>
        <h2>View Class Stream</h2>
        <p><strong>Class Stream Name:</strong> <?php echo $class_stream_name; ?></p>
        <h3>Students in this Class Stream</h3>
        <ul>
            <?php if ($students->num_rows > 0) {
                while ($student = $students->fetch_assoc()) { ?>
                    <li><?php echo $student['first_name'] . ' ' . $student['last_name']; ?></li>
                <?php } 
            } else {
                echo "<li>No students found</li>";
            } ?>
        </ul>
    <?php } ?>

    <a href="index.php">Back to Home</a>
</body>
</html>
