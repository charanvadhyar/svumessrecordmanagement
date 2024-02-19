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
        
    <div class="form-group">
                    <form method="post" action="studentdetails.php"> <!-- Corrected action attribute -->
                        <div class="calendar">
                            <label for="month">Select the Month</label>
                            <input type="month" name="month" id="month" required>
                            <input type="submit" name="Login" value="Submit" class="btn btn-primary"> <!-- Added submit button -->
                        </div>
                    </form>
                </div>
                
               

        <section class="table__body">
            <table>
                <thead>
                    <tr>
                    <th>Student id</th>
                    <th>Student Name</th>
                    <th>Present</th>
                    <th>Absent</th>
                    <th>Non Veg</th>
                    <th> Veg</th>
                    <th>food charges</th>
                    <th>veg charges</th>
                    <th>Non Veg Charges</th>
                    <th>Room Charges</th>
                    <th>Total</th>
                        
                    </tr>
                </thead>
                <tbody>
                <?php
                if (isset($_POST["Login"])){
                    $month = $_POST["month"];
                    $timelineDate = $month . '-01';
                   
                
                
                   
                    require_once "database.php";
                  $sql = "SELECT * FROM messdetailsinsertion1 WHERE timeline = '$timelineDate'";
                  $result = $connect->query($sql);
                  
                
                  if ($result && $result->num_rows > 0) {
                      $studentinfo = mysqli_fetch_array($result);
                      while($studentinfo = mysqli_fetch_assoc($result)) {
                           
                        echo  "<tr>";
                         /* The above code is printing the value of the 'student_id' key from the
                          array inside a table cell. The value is first passed
                         through the htmlspecialchars function to ensure that any special
                         characters are properly encoded. */
                         echo"<td>" . htmlspecialchars($studentinfo['student_id']) . "</td>";
                         echo"<td>" . htmlspecialchars($studentinfo['full_name']) . "</td>";
                         echo"<td>" . htmlspecialchars($studentinfo['days_present']) . "</td>";
                         echo  "<td>" . htmlspecialchars($studentinfo['days_absent']) . "</td>";
                         echo  "<td>" . htmlspecialchars($studentinfo['non_veg']) . "</td>";
                         echo  "<td>" . htmlspecialchars($studentinfo['veg']) . "</td>";
                         echo  "<td>" . htmlspecialchars($studentinfo['food_charges']) . "</td>";
                         echo  "<td>" . htmlspecialchars($studentinfo['veg_charges']) . "</td>";
                         echo  "<td>" . htmlspecialchars($studentinfo['non_veg_charges']) . "</td>";
                         echo  "<td>" . htmlspecialchars($studentinfo['room_charges']) . "</td>";
                         echo  "<td>" . htmlspecialchars($studentinfo['total']) . "</td>";
                         
                         echo "</tr>";
                        // Make sure you close the <tr> tag inside the loop
                     }
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