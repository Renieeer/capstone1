<?php
// Include database connection
require_once '../connection.php';
include 'crud/analytic.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Report Case</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../design/css/sidebarCoordinator.css">
</head>
<body>

<div class="layout">
    <?php include 'sidebarCoordinator.php'; ?>
    <main class="main">
        <div class="dashboard-container">
            <div class="top">
                <h1><i class="fa-solid fa-file-lines"></i> Report Case</h1>
                <div>
                    <button class="refresh-btn" onclick="refreshData()">
                        <i class="fa-solid fa-sync"></i> Refresh Data
                    </button>
                    <span id="lastUpdated" class="last-updated">
                        Last updated: <?php echo date('M d, Y h:i A'); ?>
                    </span>
                    <button class="btn btn-primary" onclick="downloadReport()">
                        <i class="fa-solid fa-download"></i> Download Report
                    </button>
                </div>
            </div>
            
<table id="reportTable">

<!-- HEADER -->
<tr>
    <th rowspan="2">Category of Cases</th>
    <?php foreach($grades as $grade): ?>
        <th colspan="3"><?php echo htmlspecialchars($grade['grade_name']); ?></th>
    <?php endforeach; ?>
    <th rowspan="2">GRAND TOTAL</th>
</tr>

<tr>
    <?php foreach($grades as $grade): ?>
        <th>M</th>
        <th>F</th>
        <th>Total</th>
    <?php endforeach; ?>
</tr>

<!-- BODY -->
<?php foreach($sections as $section): ?>
    <?php $sectionCategories = $categories[$section['id']] ?? []; ?>
    
    <!-- Section Title -->
    <tr>
        <td class="category"><?php echo htmlspecialchars($section['section_code'] . '. ' . $section['section_name']); ?></td>
        <td colspan="<?php echo (count($grades)*3)+1; ?>"></td>
    </tr>

    <!-- Section Items -->
    <?php foreach($sectionCategories as $category): ?>
        <tr data-category-id="<?php echo $category['id']; ?>">
            <td class="left"><?php echo htmlspecialchars($category['category_name']); ?></td>

            <?php foreach($grades as $grade): 
                $key = $category['id'] . '_' . $grade['id'];
                $maleCount = isset($reports[$key]) ? $reports[$key]['male_count'] : 0;
                $femaleCount = isset($reports[$key]) ? $reports[$key]['female_count'] : 0;
            ?>
                <!-- READ-ONLY MALE COUNT -->
                <td class="data-cell male-value" 
                    data-category="<?php echo $category['id']; ?>" 
                    data-grade="<?php echo $grade['id']; ?>"
                    data-section="<?php echo $section['id']; ?>">
                    <?php echo $maleCount; ?>
                </td>
                
                <!-- READ-ONLY FEMALE COUNT -->
                <td class="data-cell female-value" 
                    data-category="<?php echo $category['id']; ?>" 
                    data-grade="<?php echo $grade['id']; ?>"
                    data-section="<?php echo $section['id']; ?>">
                    <?php echo $femaleCount; ?>
                </td>
                
                <!-- AUTO-CALCULATED TOTAL -->
                <td class="auto-total category-grade-total" 
                    data-category="<?php echo $category['id']; ?>" 
                    data-grade="<?php echo $grade['id']; ?>">
                    <?php echo $maleCount + $femaleCount; ?>
                </td>
            <?php endforeach; ?>

            <!-- CATEGORY GRAND TOTAL -->
            <td class="auto-total category-grand-total" 
                data-category="<?php echo $category['id']; ?>">0</td>
        </tr>
    <?php endforeach; ?>

    <!-- Section Total -->
    <tr class="total-row" data-section-id="<?php echo $section['id']; ?>">
        <td>Total <?php echo htmlspecialchars($section['section_code'] . '. ' . $section['section_name']); ?></td>
        <?php foreach($grades as $grade): ?>
            <td class="section-male-total" data-section="<?php echo $section['id']; ?>" data-grade="<?php echo $grade['id']; ?>">0</td>
            <td class="section-female-total" data-section="<?php echo $section['id']; ?>" data-grade="<?php echo $grade['id']; ?>">0</td>
            <td class="section-total-total" data-section="<?php echo $section['id']; ?>" data-grade="<?php echo $grade['id']; ?>">0</td>
        <?php endforeach; ?>
        <td class="section-grand-total" data-section="<?php echo $section['id']; ?>">0</td>
    </tr>

<?php endforeach; ?>

<!-- OVERALL TOTAL -->
<tr class="grand-total">
    <td>OVERALL TOTAL</td>
    <?php foreach($grades as $grade): ?>
        <td class="overall-male-total" data-grade="<?php echo $grade['id']; ?>">0</td>
        <td class="overall-female-total" data-grade="<?php echo $grade['id']; ?>">0</td>
        <td class="overall-total-total" data-grade="<?php echo $grade['id']; ?>">0</td>
    <?php endforeach; ?>
    <td id="overallGrandTotal">0</td>
</tr>

</table>
        </div>
    </main>
</div>

<script src="../design/script/sidebar-counselor.js"></script>
<!-- <script src="../design/script/counsilor.js"></script> -->
   <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->

</body>
</html>