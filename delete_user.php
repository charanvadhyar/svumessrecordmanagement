<?php
require_once "database.php"; // Make sure to use the correct path to your database connection file

if (isset($_POST['delete'])) {
    $student_id = $_POST['student_id'];

    // Prepare SQL statement to prevent SQL injection
    $stmt = $connect->prepare("DELETE FROM users WHERE student_id = ?");
    $stmt->bind_param("i", $student_id); // 'i' specifies the variable type => 'integer'

    if ($stmt->execute()) {
        // If successful, redirect back to the table page
        header("Location: detailsentry.php"); // Replace 'your_table_page.php' with the actual name of your table page
        exit();
    } else {
        echo "Error deleting record: " . $connect->error;
    }
}
?>
