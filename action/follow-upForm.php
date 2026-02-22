<?php

// Follow-Up Form Handler
include '../connection.php';

$submitSuccess = false;
$submitError = null;
$students = [];
$sections = [];
$categories = [];

// Fetch all students for selection
try {
    $stmt = $connection->prepare("
        SELECT StudentId, FirstName, LastName, MiddleName
        FROM student_table
        ORDER BY LastName, FirstName
    ");
    $stmt->execute();
    $students = $stmt->fetchAll();
} catch (PDOException $e) {
    $submitError = "Error fetching students: " . $e->getMessage();
}

// Fetch all categories with their section IDs
try {
    $stmt = $connection->prepare("
        SELECT id, section_id, category_name
        FROM categories
        ORDER BY section_id, category_name
    ");
    $stmt->execute();
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    // Categories table might not exist or be empty
    $categories = [];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $connection->prepare("
            INSERT INTO follow_up (StudentID, Title, Counselor, CategoryID, Status, TimeCreated, TimeUpdated)
            VALUES (?, ?, ?, ?, ?, NOW(), NOW())
        ");
        
        $stmt->execute([
            $_POST['studentId'],
            $_POST['title'],
            $_POST['counselor'],
            $_POST['categoryId'] ?? null,
            $_POST['status']
        ]);
        
        $submitSuccess = true;
    } catch (PDOException $e) {
        $submitError = "Error saving follow-up form: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Follow-Up Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@400;600;700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../design/css/sidebarCounsilor.css">
</head>
<body>
    <div class="layout">
        <?php include 'sidebarCounsilor.php'; ?>
        
        <main class="main-content">
            <div class="container">
                <div class="header">
                    <h1>Follow-Up Form</h1>
                    <p>Centro De Child Promotional And Advance Infant School | Academic Year: 2025-2026</p>
                </div>

                <div class="form-content">
                    <?php if ($submitSuccess): ?>
                        <div style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
                            <i class="fas fa-check-circle"></i> Follow-up form submitted successfully!
                        </div>
                    <?php elseif ($submitError): ?>
                        <div style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
                            <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($submitError); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" id="followUpForm">
                        <!-- Student Selection -->
                        <div class="section-title">Student Information</div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="studentId">Select Student <span class="required">*</span></label>
                                <select id="studentId" name="studentId" required style="padding: 0.75rem; border: 2px solid var(--border); border-radius: 8px; font-family: 'DM Sans', sans-serif; font-size: 1rem; cursor: pointer;">
                                    <option value="">-- Choose a Student --</option>
                                    <?php foreach ($students as $student): ?>
                                        <option value="<?php echo htmlspecialchars($student['StudentId']); ?>">
                                            <?php echo htmlspecialchars($student['FirstName'] . ' ' . $student['LastName']); ?> (ID: <?php echo htmlspecialchars($student['StudentId']); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Follow-Up Details -->
                        <div class="section-title">Follow-Up Details</div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="sectionId">Section <span class="required">*</span></label>
                                <select id="sectionId" name="sectionId" required onchange="updateCategories()" style="padding: 0.75rem; border: 2px solid var(--border); border-radius: 8px; font-family: 'DM Sans', sans-serif; font-size: 1rem; cursor: pointer;">
                                    <option value="">-- Select Section --</option>
                                    <option value="1">CAR (Children at Risk)</option>
                                    <option value="2">Mental Health</option>
                                    <option value="3">Bullying</option>
                                    <option value="4">Academic</option>
                                    <option value="5">Family Issues</option>
                                    <option value="6">Abuse and Neglect</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="categoryId">Category <span class="required">*</span></label>
                                <select id="categoryId" name="categoryId" required onchange="updateTitle()" style="padding: 0.75rem; border: 2px solid var(--border); border-radius: 8px; font-family: 'DM Sans', sans-serif; font-size: 1rem; cursor: pointer;">
                                    <option value="">-- Select Category --</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-group" style="grid-column: span 2;">
                                <label for="title">Title <span class="required">*</span></label>
                                <input type="text" id="title" name="title" required placeholder="Auto-generated based on category">
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="counselor">Counselor Name <span class="required">*</span></label>
                                <input type="text" id="counselor" name="counselor" required placeholder="Your full name">
                            </div>
                            <div class="form-group">
                                <label for="status">Status <span class="required">*</span></label>
                                <select id="status" name="status" required style="padding: 0.75rem; border: 2px solid var(--border); border-radius: 8px; font-family: 'DM Sans', sans-serif; font-size: 1rem; cursor: pointer;">
                                    <option value="">-- Select Status --</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="submit-section">
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i> Submit Follow-Up
                            </button>
                            <button type="reset" class="btn-secondary">
                                <i class="fas fa-redo"></i> Clear Form
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Pass categories data to JavaScript
        window.categoriesData = <?php echo json_encode($categories); ?>;
    </script>
    <script src="../design/script/sidebar-counselor.js"></script>
</body>
</html>