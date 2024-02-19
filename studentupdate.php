<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>MESS RECORDS Management</title>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside id="sidebar">
            <div class="h-100">
                <div class="sidebar-logo">
                    <a href="#" style="color: black;">Mess Records Management system</a>
                </div>
                <!-- Sidebar Navigation -->
                <ul class="sidebar-nav">
                    <li class="sidebar-header" style="color: black; ">
                        Mess details entry
                    </li>
                  <li class="sidebar-item">
                        <a href="detailsentry.php" class="sidebar-link" style="color: black; font-weight : bold">
                            <i class="fa-regular fa-file-lines pe-2"></i>
                            Mess Details Entry
                        </a>
                    </li>
                    <!--<li class="sidebar-item">
                        <a href="salesupdate.html" class="sidebar-link collapsed" style="color: black; font-weight : bold ">
                            <i class="fa-regular fa-file-lines pe-2"></i>
                            Sales Details Update
                        </a>
                       
                    </li>
                    <li class="sidebar-item">
                        <a href="purchaseupdate.html" class="sidebar-link collapsed" style="color: black; font-weight : bold">
                            <i class="fa-regular fa-file-lines pe-2"></i>
                            Purchase details update
                        </a>
                        
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" style="color: black;  font-weight : bold">
                            <i class="fa-regular fa-file-lines pe-2"></i>
                            Contact
                        </a>
                        
                    </li>-->
                    <li class="sidebar-item">
                        <a href="index.html" class="sidebar-link collapsed" style="color: black;  font-weight : bold">
                            <i class="fa-regular fa-file-lines pe-2"></i>
                            Logout
                        </a>
                        
                    </li>
                   
                    
            </div>
        </aside>
        <!-- Main Component -->
        
        <div class="main">
       
	
    <main class="table" id="customers_table">
        
          
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                    <th>Student id</th>
                    <th>Student Name</th>
                    <th>Mess</th>
                    <th>Course</th>
                    <th>Actions</th>
                     
                        
                    </tr>
                </thead>
                <tbody>
                <?php
                 /* The above code is including the "database.php" file in the PHP script. */
                    
                    require_once "database.php";
                    $sql = "SELECT student_id,full_name, mess, cousre FROM users";
                    /* The above code is executing a query on a database using the PHP mysqli
                    extension. The result of the query is stored in the variable . */
                    
                    $result = $connect->query($sql);
                    
                    
                    
                    if ($result && $result->num_rows > 0) {
                        // Fetch each row one by one
                        while($studentinfo = mysqli_fetch_assoc($result)) {
                           
                           echo  "<tr>";
                            /* The above code is printing the value of the 'student_id' key from the
                             array inside a table cell. The value is first passed
                            through the htmlspecialchars function to ensure that any special
                            characters are properly encoded. */
                            echo"<td>" . htmlspecialchars($studentinfo['student_id']) . "</td>";
                            echo"<td>" . htmlspecialchars($studentinfo['full_name']) . "</td>";
                            echo"<td>" . htmlspecialchars($studentinfo['mess']) . "</td>";
                            echo  "<td>" . htmlspecialchars($studentinfo['cousre']) . "</td>";
                            echo "<td><form action='delete_user.php' method='post'><input type='hidden' name='student_id' value='" . $studentinfo['student_id'] . "'/><input type='submit' name='delete' value='Delete' class='btn btn-danger'/></form></td>";
                            echo "</tr>";
                           // Make sure you close the <tr> tag inside the loop
                        }
                    }
                ?>
                </tbody>
            </table>
        </section>
    </main>
    </div>

	</body>
    </html>