<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordinator Dashboard</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Chart.js for Charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Counselor CSS - Sidebar & Dashboard Combined -->
    <link rel="stylesheet" href="../design/css/sidebarCoordinator.css">
</head>
<body>

<div class="layout">
    <?php include 'sidebarCoordinator.php'; ?>

    <main class="main">
        <div class="dashboard-container">

        <!-- TOP CARDS -->
        <div class="cards">
            <div class="card">
                <i class="fa-solid bi-people-fill"></i>
                178+
                <span>Grade 7</span>
            </div>

            <div class="card">
                <i class="fa-solid bi-people-fill"></i>
                20+
                <span>Grade 8</span>
            </div>

            <div class="card">
                <i class="fa-solid bi-people-fill"></i>
                190+
                <span>Grade 9</span>
            </div>

            <div class="card">
                <i class="fa-solid bi-people-fill"></i>
                12+
                <span>Grade 10</span>
            </div>
        </div>

        <!-- CHARTS -->
        <div class="charts">
            <div class="chart-box">
                <h3><i class="fa-solid fa-chart-area"></i> Reports</h3>
                <canvas id="lineChart"></canvas>
            </div>

            <div class="chart-box">
                <h3><i class="fa-solid fa-chart-pie"></i> Analytics</h3>
                <canvas id="donutChart"></canvas>
            </div>
        </div>

        <!-- BOTTOM SECTION -->
        <div class="bottom">
            <div class="table-box">
                <h3><i class="fa-solid fa-table"></i> Pending Form </h3>
                <table>
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Year</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#1001</td>
                            <td>Camera Lens</td>
                            <td>$178</td>
                            <td>1236</td>
                            <td>325</td>
                            
                        </tr>
                        <tr>
                            <td>#1002</td>
                            <td>Black Dress</td>
                            <td>$14</td>
                            <td>720</td>
                            <td>153</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<script src="../design/script/sidebar-counselor.js"></script>
<script src="../design/script/counsilor.js"></script>
</body>
</html>
