<?php 
require_once '../connection.php';
// Get current school year (you can modify this logic as needed)
$current_school_year = date('Y') . '-' . (date('Y') + 1);

// Fetch all data from database
$grades = [];
$stmt = $connection->query("SELECT * FROM grades ORDER BY id");
while ($row = $stmt->fetch()) {
    $grades[] = $row;
}

$sections = [];
$stmt = $connection->query("SELECT * FROM sections ORDER BY id");
while ($row = $stmt->fetch()) {
    $sections[] = $row;
}

$categories = [];
$stmt = $connection->query("SELECT c.*, s.section_code, s.section_name 
                           FROM categories c 
                           JOIN sections s ON c.section_id = s.id 
                           ORDER BY s.id, c.id");
while ($row = $stmt->fetch()) {
    $categories[$row['section_id']][] = $row;
}

// Fetch existing report data
$reports = [];
$stmt = $connection->query("SELECT * FROM reports WHERE school_year = '$current_school_year'");
while ($row = $stmt->fetch()) {
    $key = $row['category_id'] . '_' . $row['grade_id'];
    $reports[$key] = $row;
}


?>