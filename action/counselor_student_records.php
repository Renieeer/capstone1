<?php
// Counselor Student Records and Follow-Up Forms Viewer
// This page allows counselors to view their students' information and follow-up form records

include '../connection.php';

// If no students are found, handle the query
$studentsData = [];
$selectedStudentId = null;
$followUpRecords = [];

// Fetch all students (in a real app, you'd filter by counselor ID)
try {
    $stmt = $connection->prepare("
        SELECT s.StudentId, s.LRN, s.FirstName, s.LastName, s.MiddleName, 
               s.DateOfBirth, s.Sex, s.Age, s.CurrentAddress, s.CellphoneNumber
        FROM student_table s
        ORDER BY s.LastName, s.FirstName
    ");
    $stmt->execute();
    $studentsData = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error fetching students: " . $e->getMessage();
}

// If a student is selected, fetch their follow-up form records
if (isset($_GET['student_id'])) {
    $selectedStudentId = $_GET['student_id'];
    
    try {
        $stmt = $connection->prepare("
            SELECT * FROM follow_up 
            WHERE StudentID = ?
            ORDER BY TimeCreated DESC
        ");
        $stmt->execute([$selectedStudentId]);
        $followUpRecords = $stmt->fetchAll();
    } catch (PDOException $e) {
        // Table might not exist yet
        $followUpRecords = [];
    }
}

// Get selected student details
$selectedStudent = null;
if ($selectedStudentId) {
    foreach ($studentsData as $student) {
        if ($student['StudentId'] == $selectedStudentId) {
            $selectedStudent = $student;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records & Follow-Up Forms</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@400;600;700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../design/css/sidebarCounsilor.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #2c5f2d;
            --secondary: #97bf0d;
            --accent: #ffd166;
            --text: #1a1a1a;
            --text-light: #666;
            --bg: #fafaf9;
            --white: #ffffff;
            --border: #e0e0db;
            --danger: #e74c3c;
            --success: #27ae60;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f5f7fa;
            color: var(--text);
            line-height: 1.6;
            height: 100vh;
            overflow: hidden;
        }

        .layout {
            display: grid;
            grid-template-columns: 260px 1fr;
            min-height: 100vh;
            height: 100vh;
            width: 100%;
        }

        .main-content {
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow-y: auto;
            background-color: #f5f7fa;
        }

        .container {
            flex: 1;
            display: grid;
            grid-template-columns: 350px 1fr;
            height: 100%;
            gap: 1rem;
            padding: 1rem;
            background: #f5f7fa;
        }

        /* Left Panel - Student List */
        .students-panel {
            background: var(--white);
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .students-header {
            background: linear-gradient(135deg, var(--primary) 0%, #1e4620 100%);
            color: var(--white);
            padding: 1.5rem;
            flex-shrink: 0;
        }

        .students-header h2 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }

        .search-box {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .search-box input {
            flex: 1;
            padding: 0.6rem 0.75rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.1);
            color: var(--white);
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .search-box input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--secondary);
            background: rgba(255, 255, 255, 0.15);
        }

        .students-list {
            flex: 1;
            overflow-y: auto;
            padding: 0;
        }

        .student-item {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border);
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
            color: var(--text);
        }

        .student-item:hover {
            background: #f0f0ed;
            padding-left: 1.25rem;
        }

        .student-item.active {
            background: linear-gradient(135deg, var(--secondary) 0%, #82a50c 100%);
            color: var(--white);
            border-left: 4px solid var(--primary);
            padding-left: 1.25rem;
        }

        .student-item-name {
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
        }

        .student-item-id {
            font-size: 0.8rem;
            opacity: 0.7;
        }

        /* Right Panel - Student Details */
        .details-panel {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            overflow-y: auto;
        }

        .card {
            background: var(--white);
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 1.5rem;
            flex-shrink: 0;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--secondary);
        }

        .card-header i {
            font-size: 1.5rem;
            color: var(--secondary);
        }

        .card-header h3 {
            font-size: 1.1rem;
            color: var(--text);
        }

        .student-info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .info-group {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 0.85rem;
            color: var(--text-light);
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 0.35rem;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 1rem;
            color: var(--text);
            font-weight: 500;
        }

        .no-selection {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            text-align: center;
            color: var(--text-light);
        }

        .no-selection i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        /* Follow-Up Records Table */
        .followup-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .followup-table thead {
            background: #f0f0ed;
        }

        .followup-table th {
            padding: 0.75rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--primary);
            border-bottom: 2px solid var(--border);
        }

        .followup-table td {
            padding: 0.75rem;
            border-bottom: 1px solid var(--border);
            font-size: 0.9rem;
        }

        .followup-table tbody tr:hover {
            background: #fafaf9;
        }

        .status-badge {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #ffeaa7;
            color: #d63031;
        }

        .status-completed {
            background: #a9dfbf;
            color: #27ae60;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-small {
            padding: 0.5rem 1rem;
            background: var(--secondary);
            color: var(--white);
            border: none;
            border-radius: 6px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-small:hover {
            background: #82a50c;
            transform: translateY(-2px);
        }

        .btn-small.view {
            background: var(--primary);
        }

        .btn-small.view:hover {
            background: #1e4620;
        }

        .empty-message {
            text-align: center;
            padding: 2rem 1rem;
            color: var(--text-light);
        }

        .empty-message i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: var(--white);
            border-radius: 12px;
            max-width: 700px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            padding: 2rem;
            position: relative;
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--secondary);
        }

        .modal-header h2 {
            font-size: 1.3rem;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-light);
        }

        .modal-close:hover {
            color: var(--text);
        }

        .form-section {
            margin-bottom: 1.5rem;
        }

        .form-section-title {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.75rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text);
            margin-bottom: 0.35rem;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            padding: 0.6rem 0.75rem;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        @media (max-width: 1024px) {
            .container {
                grid-template-columns: 1fr;
            }

            .students-panel {
                max-height: 40vh;
            }
        }

        @media (max-width: 768px) {
            .layout {
                grid-template-columns: 1fr;
            }

            .student-info-grid {
                grid-template-columns: 1fr;
            }

            .students-list {
                max-height: 300px;
            }
        }

        /* Scrollbar Styling */
        .students-list::-webkit-scrollbar,
        .details-panel::-webkit-scrollbar {
            width: 6px;
        }

        .students-list::-webkit-scrollbar-track,
        .details-panel::-webkit-scrollbar-track {
            background: transparent;
        }

        .students-list::-webkit-scrollbar-thumb,
        .details-panel::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 3px;
        }

        .students-list::-webkit-scrollbar-thumb:hover,
        .details-panel::-webkit-scrollbar-thumb:hover {
            background: var(--secondary);
        }
    </style>
</head>
<body>
    <div class="layout">
        <?php include 'sidebarCounsilor.php'; ?>
        
        <main class="main-content">
            <div class="container">
                <!-- Left Panel: Student List -->
                <div class="students-panel">
                    <div class="students-header">
                        <h2>Students</h2>
                        <div class="search-box">
                            <input type="text" id="studentSearch" placeholder="Search name or LRN...">
                        </div>
                    </div>
                    <div class="students-list" id="studentsList">
                        <?php if (count($studentsData) > 0): ?>
                            <?php foreach ($studentsData as $student): ?>
                                <a href="?student_id=<?php echo htmlspecialchars($student['StudentId']); ?>" 
                                   class="student-item <?php echo ($selectedStudentId == $student['StudentId']) ? 'active' : ''; ?>">
                                    <div class="student-item-name">
                                        <?php echo htmlspecialchars($student['FirstName'] . ' ' . $student['LastName']); ?>
                                    </div>
                                    <div class="student-item-id">
                                        ID: <?php echo htmlspecialchars($student['StudentId']); ?>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div style="padding: 2rem 1rem; text-align: center; color: var(--text-light);">
                                No students found
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right Panel: Student Details -->
                <div class="details-panel">
                    <?php if ($selectedStudent): ?>
                        <!-- Student Information Card -->
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-user-circle"></i>
                                <h3>Student Information</h3>
                            </div>
                            
                            <div class="student-info-grid">
                                <div class="info-group">
                                    <span class="info-label">First Name</span>
                                    <span class="info-value"><?php echo htmlspecialchars($selectedStudent['FirstName']); ?></span>
                                </div>
                                <div class="info-group">
                                    <span class="info-label">Last Name</span>
                                    <span class="info-value"><?php echo htmlspecialchars($selectedStudent['LastName']); ?></span>
                                </div>
                                <div class="info-group">
                                    <span class="info-label">Middle Name</span>
                                    <span class="info-value"><?php echo htmlspecialchars($selectedStudent['MiddleName'] ?? 'N/A'); ?></span>
                                </div>
                                <div class="info-group">
                                    <span class="info-label">Student ID</span>
                                    <span class="info-value"><?php echo htmlspecialchars($selectedStudent['StudentId']); ?></span>
                                </div>
                                <div class="info-group">
                                    <span class="info-label">LRN</span>
                                    <span class="info-value"><?php echo htmlspecialchars($selectedStudent['LRN']); ?></span>
                                </div>
                                <div class="info-group">
                                    <span class="info-label">Age</span>
                                    <span class="info-value"><?php echo htmlspecialchars($selectedStudent['Age']); ?></span>
                                </div>
                                <div class="info-group">
                                    <span class="info-label">Sex</span>
                                    <span class="info-value"><?php echo htmlspecialchars($selectedStudent['Sex']); ?></span>
                                </div>
                                <div class="info-group">
                                    <span class="info-label">Date of Birth</span>
                                    <span class="info-value"><?php echo htmlspecialchars($selectedStudent['DateOfBirth']); ?></span>
                                </div>
                                <div class="info-group" style="grid-column: span 2;">
                                    <span class="info-label">Current Address</span>
                                    <span class="info-value"><?php echo htmlspecialchars($selectedStudent['CurrentAddress'] ?? 'N/A'); ?></span>
                                </div>
                                <div class="info-group">
                                    <span class="info-label">Phone Number</span>
                                    <span class="info-value"><?php echo htmlspecialchars($selectedStudent['CellphoneNumber'] ?? 'N/A'); ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Follow-Up Forms Card -->
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-file-alt"></i>
                                <h3>Follow-Up Forms</h3>
                            </div>
                            
                            <?php if (count($followUpRecords) > 0): ?>
                                <div style="overflow-x: auto;">
                                    <table class="followup-table">
                                        <thead>
                                            <tr>
                                                <th>Date Created</th>
                                                <th>Title</th>
                                                <th>Counselor</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($followUpRecords as $record): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($record['TimeCreated'] ?? 'N/A'); ?></td>
                                                    <td><?php echo htmlspecialchars(substr($record['Title'] ?? '', 0, 30) . (strlen($record['Title'] ?? '') > 30 ? '...' : '')); ?></td>
                                                    <td><?php echo htmlspecialchars($record['Counselor'] ?? 'N/A'); ?></td>
                                                    <td>
                                                        <span class="status-badge <?php echo ($record['Status'] == 'Completed') ? 'status-completed' : 'status-pending'; ?>">
                                                            <?php echo htmlspecialchars($record['Status']); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="action-buttons">
                                                            <button class="btn-small view" onclick="viewFollowUp(<?php echo htmlspecialchars(json_encode($record)); ?>)">
                                                                <i class="fas fa-eye"></i> View
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="empty-message">
                                    <i class="fas fa-inbox"></i>
                                    <p>No follow-up forms yet</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="card" style="display: flex; align-items: center; justify-content: center; height: 100%; min-height: 500px;">
                            <div class="no-selection">
                                <div>
                                    <i class="fas fa-clipboard-list"></i>
                                    <h3>Select a Student</h3>
                                    <p>Choose a student from the list to view their information and follow-up forms</p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <!-- Follow-Up Details Modal -->
    <div class="modal" id="followUpModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Follow-Up Form Details</h2>
                <button class="modal-close" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="form-section">
                <div class="form-section-title">Basic Information</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Follow-Up ID</label>
                        <input type="text" id="modalFollowUpId" readonly>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" id="modalTitle" readonly>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Counselor</label>
                        <input type="text" id="modalCounselor" readonly>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" id="modalStatus" readonly>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-title">Category & Dates</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Category ID</label>
                        <input type="text" id="modalCategoryId" readonly>
                    </div>
                    <div class="form-group">
                        <label>Date Created</label>
                        <input type="text" id="modalTimeCreated" readonly>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Last Updated</label>
                        <input type="text" id="modalTimeUpdated" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('studentSearch').addEventListener('keyup', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const students = document.querySelectorAll('.student-item');
            
            students.forEach(student => {
                const text = student.textContent.toLowerCase();
                student.style.display = text.includes(searchTerm) ? 'block' : 'none';
            });
        });

        // View follow-up form details
        function viewFollowUp(record) {
            document.getElementById('modalFollowUpId').value = record.Follow_id || 'N/A';
            document.getElementById('modalTitle').value = record.Title || 'N/A';
            document.getElementById('modalCounselor').value = record.Counselor || 'N/A';
            document.getElementById('modalStatus').value = record.Status || 'N/A';
            document.getElementById('modalCategoryId').value = record.CategoryID || 'N/A';
            document.getElementById('modalTimeCreated').value = record.TimeCreated || 'N/A';
            document.getElementById('modalTimeUpdated').value = record.TimeUpdated || 'N/A';
            
            document.getElementById('followUpModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('followUpModal').classList.remove('active');
        }

        // Close modal when clicking outside
        document.getElementById('followUpModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>
