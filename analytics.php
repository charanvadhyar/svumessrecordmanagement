<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

if (!isset($_SESSION['studentID'])) {
    echo "Student ID not retrieved";
    exit;
}

require_once "database.php";
$studentID = $_SESSION['studentID'];

$monthlyTotals = $chargesData = [];
$monthNames = [];

// Handling Year Submission for Bar Chart
if (isset($_POST["submitYear"])) {
    $year = $_POST['year'];
    $sql = "SELECT DATE_FORMAT(timeline, '%Y-%m') AS month, SUM(total) AS total 
            FROM messdetailsinsertion1 
            WHERE student_id = ? AND YEAR(timeline) = ?
            GROUP BY DATE_FORMAT(timeline, '%Y-%m')";
    
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "si", $studentID, $year);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $month, $total);
    
    while (mysqli_stmt_fetch($stmt)) {
        $monthlyTotals[$month] = $total;
    }
    mysqli_stmt_close($stmt);

    // Convert 'YYYY-MM' format to full month name for the bar chart
    function convertToMonthName($monthKey) {
        $date = DateTime::createFromFormat('Y-m', $monthKey);
        return $date->format('F'); // 'F' format returns the full month name
    }
    $monthNames = array_map('convertToMonthName', array_keys($monthlyTotals));
}

// Handling Month Submission for Pie Chart
if (isset($_POST["submitMonth"])) {
    $selectedMonth = date('Y-m', strtotime($_POST['month']));
    $sql = "SELECT 
                SUM(veg_charges) AS veg_charges_total, 
                SUM(food_charges) AS food_charges_total, 
                SUM(non_veg_charges) AS non_veg_charges_total, 
                SUM(room_charges) AS room_charges_total
            FROM messdetailsinsertion1
            WHERE student_id = ? AND DATE_FORMAT(timeline, '%Y-%m') = ?";
    
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $studentID, $selectedMonth);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $vegChargesTotal, $foodChargesTotal, $nonVegChargesTotal, $roomChargesTotal);
    
    if (mysqli_stmt_fetch($stmt)) {
        $chargesData = [
            'Veg Charges' => $vegChargesTotal,
            'Food Charges' => $foodChargesTotal,
            'Non-Veg Charges' => $nonVegChargesTotal,
            'Room Charges' => $roomChargesTotal,
        ];
    }
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  </head>
  <body>
    <div class="grid-container">

 
     

      <!-- Sidebar -->
      <aside id="sidebar">
        <div class="sidebar-title">
          <div class="sidebar-brand">
            <span class="material-icons-outlined"></span> Analytics
          </div>
          <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
        </div>

        <ul class="sidebar-list">
          <li class="sidebar-list-item">
            <a href="studentdashboard.php" target="_blank">
              Monthly details
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="#" target="_blank">
              Bill
            </a>
          </li>
          </li>
          <li class="sidebar-list-item">
            <a href="index.php" target="_blank">
              Logout
            </a>
          </li>
        </ul>
      </aside>
      <!-- End Sidebar -->

      <!-- Main -->
      <main class="main-container">
        

        <div class="charts">

          <div class="charts-card">
            <p class="chart-title">Yearly Analytics</p>
            <form action="" method="post">
                <label for="year">Select the Year:</label>
                <input type="number" name="year" id="year" min="2000" max="<?php echo date('Y'); ?>" >
                <input type="submit" name="submitYear" value="Fetch Yearly Totals">
            <div id="bar-chart">
            <?php if (!empty($monthlyTotals)): ?>
            <div class="chart-container" style="height:40vh; width:80vw">
                <canvas id="yearlyChart"></canvas>
            </div>
            <?php endif; ?>
            </div>
          </div>

          <div class="charts-card">
            <p class="chart-title">Monthly Analytics</p>
            <form action="" method="post">
                <label for="month">Select the Month:</label>
                <input type="month" name="month" id="month" >
                <input type="submit" name="submitMonth" value="Fetch Monthly Charges">
            </form>
            <div id="area-chart">
            <?php if (!empty($chargesData)): ?>
            <div class="chart-container" style="height:40vh; width:80vw">
                <canvas id="monthlyChart"></canvas>
            </div>
            <?php endif; ?>
            
            </div>
          </div>

        </div>
      </main>
      <!-- End Main -->

    </div>


    
    <script>
        <?php if (!empty($monthlyTotals)): ?>
        var barChartCtx = document.getElementById('yearlyChart').getContext('2d');
        new Chart(barChartCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($monthNames); ?>,
                datasets: [{
                    label: 'Monthly Totals',
                    data: <?php echo json_encode(array_values($monthlyTotals)); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        <?php endif; ?>

        <?php if (!empty($chargesData)): ?>
        var pieChartCtx = document.getElementById('monthlyChart').getContext('2d');
        new Chart(pieChartCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_keys($chargesData)); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_values($chargesData)); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
        <?php endif; ?>
    </script>
       

    
 
  </body>
</html>