<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Report</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Combined CSS (Sidebar + Forms) -->
    <link rel="stylesheet" href="../design/css/sidebar-student.css">
</head>
<body>

<div class="layout">
    <?php include 'sidebarST.php'; ?>

    <main class="main">
        <!-- <div class="form-container"> -->
            <h2 class="form-title">
                <i class="fa-solid fa-history"></i> History Report
            </h2>
            <div class="form-box">
                <h3>HISTORY REPORT</h3>
                <table class="form-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Report Type</th>
                                    <th>Status</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>2024-01-15</td>
                                    <td>Academic Performance</td>
                                    <td>Reviewed</td>
                                    <td><a href="#">View Details</a></td>
                                </tr>
                                <tr>
                                    <td>2024-02-10</td>
                                    <td>Behavioral Report</td>
                                    <td>Pending</td>
                                    <td><a href="#">View Details</a></td>
                                </tr>
                            </tbody>
                </table>
            </div>
        <!-- </div> -->
    </main>
</div>

<script src="../design/script/sidebar-student.js"></script>
</body>
</html>