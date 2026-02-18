<?php
require_once '../../connection.php';

function getPost($key, $default = null) {
    return isset($_POST[$key]) && $_POST[$key] !== '' ? $_POST[$key] : $default;
}

/* ================= VALIDATION ================= */

$required_fields = ['StudentId', 'LRN', 'FirstName', 'LastName', 'Sex', 'Age', 'DateOfBirth'];
$missing_fields = [];

foreach ($required_fields as $field) {
    if (empty($_POST[$field])) $missing_fields[] = $field;
}

if (!empty($missing_fields)) {
    die("Missing required fields: " . implode(", ", $missing_fields));
}

/* ================= START TRANSACTION ================= */
$conn->beginTransaction();

try {

$studentId = getPost('StudentId');

/* ================= STUDENT ================= */

$stmt = $conn->prepare("
INSERT INTO student_table
(StudentId, LRN, FirstName, LastName, MiddleName, NickName, Sex, Age, DateOfBirth,
PlaceOfBirth, ReligionFromBirth, CurrentReligion, CurrentAddress, PermanentAddress, CellphoneNumber)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->execute([
    $studentId,
    getPost('LRN'),
    getPost('FirstName'),
    getPost('LastName'),
    getPost('MiddleName'),
    getPost('NickName'),
    getPost('Sex'),
    getPost('Age'),
    getPost('DateOfBirth'),
    getPost('PlaceOfBirth'),
    getPost('ReligionFromBirth'),
    getPost('CurrentReligion'),
    getPost('CurrentAddress'),
    getPost('PermanentAddress'),
    getPost('CellphoneNumber')
]);

/* ================= EDUCATION ================= */

if (!empty($_POST['education'])) {
    $eduStmt = $conn->prepare("
    INSERT INTO educational_background
    (StudentId, GradeLevel, SchoolAttended, InclusiveYes, PlaceAndSchool)
    VALUES (?, ?, ?, ?, ?)
    ");

    foreach ($_POST['education'] as $edu) {
        if (empty($edu['SchoolAttended']) && empty($edu['GradeLevel'])) continue;

        $eduStmt->execute([
            $studentId,
            $edu['GradeLevel'] ?? null,
            $edu['SchoolAttended'] ?? null,
            $edu['InclusiveYes'] ?? null,
            $edu['PlaceAndSchool'] ?? null
        ]);
    }
}

/* ================= ORGANIZATION ================= */

if (!empty($_POST['organization'])) {
    $orgStmt = $conn->prepare("
    INSERT INTO oraganization
    (OrganizationId, OrganizationName, PositionTitle, inCampus, StudentId)
    VALUES (?, ?, ?, ?, ?)
    ");

    $i=1;
    foreach ($_POST['organization'] as $org) {
        if (empty($org['OrganizationName'])) continue;

        $orgStmt->execute([
            $studentId.'-ORG-'.$i++,
            $org['OrganizationName'] ?? null,
            $org['PositionTitle'] ?? null,
            $org['inCampus'] ?? null,
            $studentId
        ]);
    }
}

/* ================= PARENTS ================= */

$parentStmt = $conn->prepare("
INSERT INTO parent_table
(ParentId, StudentId, FirstName, LastName, MiddleName, NickName, BirthDate, PlaceOfBirth,
Address, ContactNumber, HighestEducationalAttainment, Occupation, isDeceased)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

if (getPost('father_FirstName') || getPost('father_LastName')) {
    $parentStmt->execute([
        $studentId.'-FATHER',$studentId,
        getPost('father_FirstName'),getPost('father_LastName'),
        getPost('father_MiddleName'),getPost('father_NickName'),
        getPost('father_BirthDate'),getPost('father_PlaceOfBirth'),
        getPost('father_Address'),getPost('father_ContactNumber'),
        getPost('father_HighestEducationalAttainment'),
        getPost('father_Occupation'),
        getPost('father_isDeceased','No')
    ]);
}

if (getPost('mother_FirstName') || getPost('mother_LastName')) {
    $parentStmt->execute([
        $studentId.'-MOTHER',$studentId,
        getPost('mother_FirstName'),getPost('mother_LastName'),
        getPost('mother_MiddleName'),getPost('mother_NickName'),
        getPost('mother_BirthDate'),getPost('mother_PlaceOfBirth'),
        getPost('mother_Address'),getPost('mother_ContactNumber'),
        getPost('mother_HighestEducationalAttainment'),
        getPost('mother_Occupation'),
        getPost('mother_isDeceased','No')
    ]);
}

/* ================= FAMILY STATUS ================= */

$familyStmt = $conn->prepare("
INSERT INTO family_status
(StudentId, LivingTogether, MarriedYet, MarriedChurch, TemporarilySepered,
PermanentlySepered, FatherDie, MotherDie, FatherWithPartner, MotherWithPartner)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$familyStmt->execute([
    $studentId,
    getPost('LivingTogether'),
    getPost('MarriedYet'),
    getPost('MarriedChurch'),
    getPost('TemporarilySepered'),
    getPost('PermanentlySepered'),
    getPost('FatherDie'),
    getPost('MotherDie'),
    getPost('FatherWithPartner'),
    getPost('MotherWithPartner')
]);

/* ================= SIBLINGS ================= */

if (!empty($_POST['sibling'])) {
    $sibStmt = $conn->prepare("
    INSERT INTO sibling
    (FirstName, LastName, MiddleName, NickName, Age, SchoolId, BirthOrder, StudentId)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    foreach ($_POST['sibling'] as $s) {
        if (empty($s['FirstName']) && empty($s['LastName'])) continue;

        $sibStmt->execute([
            $s['FirstName'] ?? null,
            $s['LastName'] ?? null,
            $s['MiddleName'] ?? null,
            $s['NickName'] ?? null,
            $s['Age'] ?? null,
            $s['SchoolId'] ?? null,
            $s['BirthOrder'] ?? null,
            $studentId
        ]);
    }
}

/* ================= GUARDIAN ================= */

if (getPost('guardian_FirstName') || getPost('guardian_LastName')) {
    $guardStmt=$conn->prepare("
    INSERT INTO guardian
    (StudentId, FirstName, MiddleName, LastName, Address, Landline, MobileNumber, Relationship)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $guardStmt->execute([
        $studentId,
        getPost('guardian_FirstName'),
        getPost('guardian_MiddleName'),
        getPost('guardian_LastName'),
        getPost('guardian_Address'),
        getPost('guardian_Landline'),
        getPost('guardian_MobileNumber'),
        getPost('guardian_Relationship')
    ]);
}

/* ================= FRIENDS ================= */

if (!empty($_POST['friend'])) {
    $friendStmt=$conn->prepare("
    INSERT INTO friends_table
    (StudentId, In_school, FirstName, MiddleName, LastName)
    VALUES (?, ?, ?, ?, ?)
    ");

    foreach ($_POST['friend'] as $f) {
        if (empty($f['FirstName']) && empty($f['LastName'])) continue;

        $friendStmt->execute([
            $studentId,
            $f['In_school'] ?? null,
            $f['FirstName'] ?? null,
            $f['MiddleName'] ?? null,
            $f['LastName'] ?? null
        ]);
    }
}

/* ================= COMMIT ================= */

$conn->commit();
header("Location: ../dashST.php?success=1");

} catch (Exception $e) {
    $conn->rollBack();
    echo "ERROR: ".$e->getMessage();
}
?>