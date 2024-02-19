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


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SVU MESS RECORDS MANAGEMENT</title>
  <link rel="stylesheet" href="index.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script src="validationscript.js"></script>
</head>
<body>
  <h1 id = "title">SVU STUDENT MESS RECORD MANEGEMENT SYSTEM</h1>
  <div class="container">
  <div class="wrapper">
    <div class="form1">
      <form action="update.php" method="post">
        <h1> Student</h1>
        <div class="input-box">
        <input type="text" class="form-control" placeholder="Full Name" name ="Name">
          <i class='bx bxs-user'></i>
        </div>
        <div class="input-box">
          
          <input type="text" placeholder="Student Id" name = "StudentID" required>
          <i class='bx bxs-user'></i>
        </div>
        <div class="input-box">
        <input type="text" placeholder="mess" name = "mess" required>
          <i class='bx bxs-user'></i>
        </div>
        <div class="input-box">
        <input type="text" placeholder="course" name = "course" required>
          <i class='bx bxs-user'></i>
        </div>
     


        
        
        <button type="submit"  class="btn" id = "myBtn4" name = "submit" >Update</button>
        
        </form>
      </div>
      
      
    
  </div>
</body>
</html>