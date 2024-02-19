<?php   
require_once "database.php"; // No need to include it again later
if(isset($_POST["submit"])){
    $fullName = $_POST["Name"];
    $StudentId = $_POST["StudentID"];
    $mess = $_POST["mess"];
    $course = $_POST["course"];

    $errors = array();
    if(empty($fullName) || empty($StudentId)) {
        array_push($errors, "All fields are required");
    }
    if(!filter_var($StudentId, FILTER_VALIDATE_INT)) {
        array_push($errors, "Student Id Invalid, Please Provide a valid Student Id");
    }

    if(count($errors) > 0) {
        foreach($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    } else {
        // Corrected UPDATE statement
        $sql = "UPDATE users SET full_name=?, mess=?, cousre=? WHERE student_id=?";
        $stmt = mysqli_stmt_init($connect);
        if(mysqli_stmt_prepare($stmt, $sql)){
            // Binding the parameters correctly
            mysqli_stmt_bind_param($stmt, "sssi", $fullName, $mess, $course, $StudentId);
            if(mysqli_stmt_execute($stmt)){
                // If you want to show a JavaScript alert on success, you would typically handle this in the response portion of your code, not directly here.
                echo "<script>alert('Update successful');</script>";
            } else {
                echo "<script>alert('Something went wrong');</script>";
            }
        } else {
            die("Something went wrong");
        }
    }
}  
?>
