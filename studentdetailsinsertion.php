<?php   
         require_once "database.php";
        if(isset($_POST["submit"])){
            $fullName = $_POST["Name"];
            $StudentId = $_POST["StudentID"];
            $password = $_POST["password"];
            $mess = $_POST["mess"];
            $course = $_POST["course"];
            $repeatpassword = $_POST["repeat_password"];
            
            $passwordhash = password_hash($password, PASSWORD_DEFAULT);

            $errors = array();
            if(empty($fullName) || empty($StudentId) || empty($password) || empty($repeatpassword)) {
                array_push($errors, "All fields are required");
            }
            if(!filter_var($StudentId, FILTER_VALIDATE_INT))
            {
                array_push($errors,"Student Id  Invalid , Please Provide a valid Student Id");
            }
            if(strlen($password) < 8)
            {
                array_push($errors,"Password must be at least 8 characters");
            }
            if($password != $repeatpassword)
            {
                array_push($errors,"Passwords do not match");
            }
           
            $sql = "SELECT * FROM users WHERE student_id = $StudentId";
            $result = $connect->query($sql);
            $rowcount = mysqli_num_rows($result);

            if($rowcount > 0)
            {
                array_push($errors,"The Student Id exists already in the database");
            }


            if(count($errors) > 0)
            {
                foreach($errors as $error)
                {
                    echo "<div class='alert alert-danger'>$error</div>";
                
                }
            }
            else
            
                require "database.php";
                $sql = "INSERT INTO  users (full_name,student_id,mess,cousre,Password) VALUES (?,?,?,?,?)";
                $init = mysqli_stmt_init($connect);
                if(mysqli_stmt_prepare($init, $sql)) {
                    mysqli_stmt_bind_param($init,"sssss", $fullName, $StudentId, $mess, $course, $passwordhash);
                    if(mysqli_stmt_execute($init)) {
                        // JavaScript alert for successful registration
                        echo "<script>alert('You have successfully registered!'); window.location.href='index.php';</script>";
                    } else {
                        echo "<div class='alert alert-danger'>Something went wrong during registration.</div>";
                    }
                } else {
                    die("Something went wrong with preparing the statement.");
                }
            
            
            }  
        
    ?>

