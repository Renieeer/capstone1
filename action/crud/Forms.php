<?php
header('Content-Type: application/json');
require_once 'config.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0);

function sendResponse($success, $message, $data = null) {
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 'Invalid request method');
}

try {
    $conn = getDBConnection();
    if (!$conn) {
        throw new Exception('Database connection failed');
    }

    // Get JSON input
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (!$data) {
        throw new Exception('Invalid JSON data');
    }

    // Validate required fields
    $requiredFields = ['lastName', 'grade', 'schoolYear'];
    foreach ($requiredFields as $field) {
        if (empty($data[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    // Start transaction
    $conn->begin_transaction();

    // Insert or update student record
    $stmt = $conn->prepare("
        INSERT INTO students (
            last_name, 
            given_name, 
            middle_initial, 
            grade_id, 
            section, 
            adviser,
            contact_number,
            school_year,
            quarter
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            given_name = VALUES(given_name),
            middle_initial = VALUES(middle_initial),
            grade_id = VALUES(grade_id),
            section = VALUES(section),
            adviser = VALUES(adviser),
            contact_number = VALUES(contact_number),
            school_year = VALUES(school_year),
            quarter = VALUES(quarter)
    ");

    $stmt->bind_param(
        "sssisssss",
        $data['lastName'],
        $data['givenName'],
        $data['middleInitial'],
        $data['grade'],
        $data['section'],
        $data['adviser'],
        $data['contactNumber'],
        $data['schoolYear'],
        $data['quarter']
    );

    if (!$stmt->execute()) {
        throw new Exception('Failed to save student record: ' . $stmt->error);
    }

    $studentId = $conn->insert_id ?: $stmt->insert_id;
    $stmt->close();

    // Process selected problems/categories
    if (!empty($data['problems']) && is_array($data['problems'])) {
        foreach ($data['problems'] as $problem) {
            // Extract category_id from the problem value
            $categoryId = extractCategoryId($problem);
            
            if ($categoryId) {
                // Insert case record
                $stmt = $conn->prepare("
                    INSERT INTO student_cases (
                        student_id,
                        category_id,
                        case_date,
                        intervention,
                        intervention_date,
                        action_taken,
                        agreement,
                        agreement_date,
                        signature
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");

                $stmt->bind_param(
                    "iissssss",
                    $studentId,
                    $categoryId,
                    $data['problemDate'],
                    $data['intervention'],
                    $data['interventionDate'],
                    $data['actionTaken'],
                    $data['agreement'],
                    $data['agreementDate'],
                    $data['signature']
                );

                if (!$stmt->execute()) {
                    throw new Exception('Failed to save case record: ' . $stmt->error);
                }
                $stmt->close();

                // Update reports table for statistics
                updateReportStatistics(
                    $conn, 
                    $categoryId, 
                    $data['grade'], 
                    $data['gender'] ?? 'M',
                    $data['schoolYear']
                );
            }
        }
    }

    // Commit transaction
    $conn->commit();
    closeDBConnection($conn);

    sendResponse(true, 'Form submitted successfully', ['student_id' => $studentId]);

} catch (Exception $e) {
    if (isset($conn)) {
        $conn->rollback();
        closeDBConnection($conn);
    }
    sendResponse(false, $e->getMessage());
}

// Helper function to extract category ID from problem string
function extractCategoryId($problemString) {
    global $conn;
    
    // Map problem strings to category names in database
    $categoryMap = [
        'Violation of City Ordinances' => 'Alcohol',
        'Membership of gang/group not recognized' => 'Membership of any Gang / Fraternity / Unsolicited Group',
        'Bringing deadly weapon' => 'Carrying Deadly Weapon',
        'Bringing illegal drugs' => 'Alcohol',
        'Quarreling' => 'Alcohol',
        'Living in high-risk environment' => 'Alcohol',
        'Gambling' => 'Gambling',
        'Bullying - Physical' => 'Physical',
        'Bullying - Verbal' => 'Verbal',
        'Bullying - Emotional' => 'Emotional',
        'Abuse - Sexual' => 'Sexual',
        'Abuse - Physical' => 'Physical',
        'Abuse - Verbal' => 'Verbal',
        'Abuse - Emotional' => 'Psychological',
        'Educational' => 'Underachievement',
        'Teenage Pregnancy/Impregnator' => 'Teenage Pregnancy',
        'Mental Health' => 'Depression',
        'Suicidal Ideation' => 'Suicide Attempt',
        'Suicidal Attempt' => 'Suicide Attempt'
    ];

    $categoryName = $categoryMap[$problemString] ?? null;
    
    if (!$categoryName) {
        return null;
    }

    $stmt = $conn->prepare("SELECT id FROM categories WHERE category_name = ? LIMIT 1");
    $stmt->bind_param("s", $categoryName);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    return $row ? $row['id'] : null;
}

// Helper function to update report statistics
function updateReportStatistics($conn, $categoryId, $gradeId, $gender, $schoolYear) {
    $maleCount = ($gender === 'M') ? 1 : 0;
    $femaleCount = ($gender === 'F') ? 1 : 0;

    $stmt = $conn->prepare("
        INSERT INTO reports (category_id, grade_id, male_count, female_count, school_year)
        VALUES (?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            male_count = male_count + VALUES(male_count),
            female_count = female_count + VALUES(female_count)
    ");

    $stmt->bind_param("iiiss", $categoryId, $gradeId, $maleCount, $femaleCount, $schoolYear);
    $stmt->execute();
    $stmt->close();
}
///////////////////////////////////////////////////////////////////////////
// RESPOSIBLE FOR FETCHING DATA FOR REPORTS AND ANALYTICS //
// //////////////////////////////////////////////////////////
<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
require_once 'config.php';

try {
    $conn = getDBConnection();
    if (!$conn) {
        throw new Exception('Database connection failed');
    }

    // Fetch all sections with their categories
    $query = "
        SELECT 
            s.id as section_id,
            s.section_code,
            s.section_name,
            c.id as category_id,
            c.category_name
        FROM sections s
        LEFT JOIN categories c ON s.id = c.section_id
        ORDER BY s.id, c.id
    ";

    $result = $conn->query($query);
    
    if (!$result) {
        throw new Exception('Query failed: ' . $conn->error);
    }

    $sections = [];
    while ($row = $result->fetch_assoc()) {
        $sectionId = $row['section_id'];
        
        if (!isset($sections[$sectionId])) {
            $sections[$sectionId] = [
                'id' => $row['section_id'],
                'code' => $row['section_code'],
                'name' => $row['section_name'],
                'categories' => []
            ];
        }
        
        if ($row['category_id']) {
            $sections[$sectionId]['categories'][] = [
                'id' => $row['category_id'],
                'name' => $row['category_name']
            ];
        }
    }

    closeDBConnection($conn);

    echo json_encode([
        'success' => true,
        'data' => array_values($sections)
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
?>