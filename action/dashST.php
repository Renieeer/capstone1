<?php 
require_once '../connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information Form</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    

    <!-- Combined CSS (Sidebar + Forms) -->
    <link rel="stylesheet" href="../design/css/sidebar-student.css">

</head>
<body>

<div class="layout">
    <?php include 'sidebarST.php'; ?>

   <main class="main">
        <div class="form-container">
            <h2 class="form-title">
                <i class="fa-solid fa-user-graduate"></i> Student Information Form
            </h2>

            <form id="studentForm" action="crud/save_student.php" method="POST">
                
                <!-- STUDENT INFORMATION -->
                <div class="form-box">
                    <h3>STUDENT INFORMATION</h3>
                    <table class="form-table">
                        <tr>
                            <th>Student ID <span class="required">*</span></th>
                            <td><input type="text" name="StudentId" required></td>
                            <th>LRN <span class="required">*</span></th>
                            <td><input type="text" name="LRN" required></td>
                        </tr>
                        <tr>
                            <th>First Name <span class="required">*</span></th>
                            <td><input type="text" name="FirstName" required></td>
                            <th>Middle Name</th>
                            <td><input type="text" name="MiddleName"></td>
                        </tr>
                        <tr>
                            <th>Last Name <span class="required">*</span></th>
                            <td><input type="text" name="LastName" required></td>
                            <th>Nickname</th>
                            <td><input type="text" name="NickName"></td>
                        </tr>
                        <tr>
                            <th>Sex <span class="required">*</span></th>
                            <td>
                                <select name="Sex" required>
                                    <option value="">Select</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </td>
                            <th>Age <span class="required">*</span></th>
                            <td><input type="number" name="Age" required></td>
                        </tr>
                        <tr>
                            <th>Date of Birth <span class="required">*</span></th>
                            <td><input type="date" name="DateOfBirth" required></td>
                            <th>Place of Birth</th>
                            <td><input type="text" name="PlaceOfBirth"></td>
                        </tr>
                        <tr>
                            <th>Religion from Birth</th>
                            <td><input type="text" name="ReligionFromBirth"></td>
                            <th>Current Religion</th>
                            <td><input type="text" name="CurrentReligion"></td>
                        </tr>
                        <tr>
                            <th>Current Address</th>
                            <td><input type="text" name="CurrentAddress"></td>
                            <th>Permanent Address</th>
                            <td><input type="text" name="PermanentAddress"></td>
                        </tr>
                        <tr>
                            <th>Cellphone Number</th>
                            <td colspan="3"><input type="text" name="CellphoneNumber"></td>
                        </tr>
                    </table>
                </div>

                <!-- EDUCATIONAL BACKGROUND (Multiple Schools) -->
                <div class="form-box">
                    <h3>EDUCATIONAL BACKGROUND</h3>
                    <div id="educationContainer">
                        <div class="dynamic-section">
                            <table class="form-table">
                                <tr>
                                    <th>Grade Level</th>
                                    <td><input type="text" name="education[0][GradeLevel]" placeholder="e.g., Grade 7"></td>
                                    <th>School Attended</th>
                                    <td><input type="text" name="education[0][SchoolAttended]"></td>
                                </tr>
                                <tr>
                                    <th>Inclusive Years</th>
                                    <td><input type="text" name="education[0][InclusiveYes]" placeholder="e.g., 2020-2024"></td>
                                    <th>Plan After High School</th>
                                    <td><textarea rows="2" name="education[0][PlaceAndSchool]"></textarea></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <button type="button" class="add-more-btn" onclick="addEducation()">
                        <i class="fa-solid fa-plus"></i> Add More School
                    </button>
                </div>

                <!-- ORGANIZATION BACKGROUND (Multiple) -->
                <div class="form-box">
                    <h3>ORGANIZATION BACKGROUND</h3>
                    <div id="organizationContainer">
                        <div class="dynamic-section">
                            <table class="form-table">
                                <tr>
                                    <th>Organization Name</th>
                                    <td><input type="text" name="organization[0][OrganizationName]"></td>
                                    <th>Position Title</th>
                                    <td><input type="text" name="organization[0][PositionTitle]"></td>
                                </tr>
                                <tr>
                                    <th>In Campus?</th>
                                    <td colspan="3">
                                        <select name="organization[0][inCampus]">
                                            <option value="">Select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <button type="button" class="add-more-btn" onclick="addOrganization()">
                        <i class="fa-solid fa-plus"></i> Add More Organization
                    </button>
                </div>

                <!-- PARENTS BACKGROUND -->
                <div class="form-box">
                    <h3>PARENTS BACKGROUND</h3>
                    <div class="parents-grid">
                        <!-- FATHER -->
                        <div class="parent-card">
                            <h4><i class="fa-solid fa-person"></i> Father's Information</h4>
                            <table class="form-table">
                                <tr>
                                    <th>First Name</th>
                                    <td><input type="text" name="father_FirstName"></td>
                                </tr>
                                <tr>
                                    <th>Middle Name</th>
                                    <td><input type="text" name="father_MiddleName"></td>
                                </tr>
                                <tr>
                                    <th>Last Name</th>
                                    <td><input type="text" name="father_LastName"></td>
                                </tr>
                                <tr>
                                    <th>Nickname</th>
                                    <td><input type="text" name="father_NickName"></td>
                                </tr>
                                <tr>
                                    <th>Birth Date</th>
                                    <td><input type="date" name="father_BirthDate"></td>
                                </tr>
                                <tr>
                                    <th>Place of Birth</th>
                                    <td><input type="text" name="father_PlaceOfBirth"></td>
                                </tr>
                                <tr>
                                    <th>Occupation</th>
                                    <td><input type="text" name="father_Occupation"></td>
                                </tr>
                                <tr>
                                    <th>Contact Number</th>
                                    <td><input type="text" name="father_ContactNumber"></td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td><input type="text" name="father_Address"></td>
                                </tr>
                                <tr>
                                    <th>Highest Educational Attainment</th>
                                    <td><input type="text" name="father_HighestEducationalAttainment"></td>
                                </tr>
                                <tr>
                                    <th>Deceased</th>
                                    <td>
                                        <select name="father_isDeceased">
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- MOTHER -->
                        <div class="parent-card">
                            <h4><i class="fa-solid fa-person-dress"></i> Mother's Information</h4>
                            <table class="form-table">
                                <tr>
                                    <th>First Name</th>
                                    <td><input type="text" name="mother_FirstName"></td>
                                </tr>
                                <tr>
                                    <th>Middle Name</th>
                                    <td><input type="text" name="mother_MiddleName"></td>
                                </tr>
                                <tr>
                                    <th>Last Name</th>
                                    <td><input type="text" name="mother_LastName"></td>
                                </tr>
                                <tr>
                                    <th>Nickname</th>
                                    <td><input type="text" name="mother_NickName"></td>
                                </tr>
                                <tr>
                                    <th>Birth Date</th>
                                    <td><input type="date" name="mother_BirthDate"></td>
                                </tr>
                                <tr>
                                    <th>Place of Birth</th>
                                    <td><input type="text" name="mother_PlaceOfBirth"></td>
                                </tr>
                                <tr>
                                    <th>Occupation</th>
                                    <td><input type="text" name="mother_Occupation"></td>
                                </tr>
                                <tr>
                                    <th>Contact Number</th>
                                    <td><input type="text" name="mother_ContactNumber"></td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td><input type="text" name="mother_Address"></td>
                                </tr>
                                <tr>
                                    <th>Highest Educational Attainment</th>
                                    <td><input type="text" name="mother_HighestEducationalAttainment"></td>
                                </tr>
                                <tr>
                                    <th>Deceased</th>
                                    <td>
                                        <select name="mother_isDeceased">
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- FAMILY STATUS -->
                <div class="form-box">
                    <h3>FAMILY STATUS</h3>
                    <table class="form-table">
                        <tr>
                            <th>Parents Living Together</th>
                            <td>
                                <select name="LivingTogether">
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>
                            <th>Married</th>
                            <td>
                                <select name="MarriedYet">
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Married in Church</th>
                            <td>
                                <select name="MarriedChurch">
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>
                            <th>Temporarily Separated</th>
                            <td>
                                <select name="TemporarilySepered">
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Permanently Separated</th>
                            <td>
                                <select name="PermanentlySepered">
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>
                            <th>Father Deceased</th>
                            <td>
                                <select name="FatherDie">
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Mother Deceased</th>
                            <td>
                                <select name="MotherDie">
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>
                            <th>Father with Partner</th>
                            <td>
                                <select name="FatherWithPartner">
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Mother with Partner</th>
                            <td colspan="3">
                                <select name="MotherWithPartner">
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- SIBLINGS -->
                <div class="form-box">
                    <h3>SIBLINGS INFORMATION</h3>
                    <div id="siblingsContainer">
                        <div class="dynamic-section">
                            <table class="form-table">
                                <tr>
                                    <th>First Name</th>
                                    <td><input type="text" name="sibling[0][FirstName]"></td>
                                    <th>Middle Name</th>
                                    <td><input type="text" name="sibling[0][MiddleName]"></td>
                                </tr>
                                <tr>
                                    <th>Last Name</th>
                                    <td><input type="text" name="sibling[0][LastName]"></td>
                                    <th>Nickname</th>
                                    <td><input type="text" name="sibling[0][NickName]"></td>
                                </tr>
                                <tr>
                                    <th>Age</th>
                                    <td><input type="number" name="sibling[0][Age]"></td>
                                    <th>Birth Order</th>
                                    <td><input type="text" name="sibling[0][BirthOrder]" placeholder="e.g., 1st, 2nd"></td>
                                </tr>
                                <tr>
                                    <th>School ID</th>
                                    <td colspan="3"><input type="text" name="sibling[0][SchoolId]"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <button type="button" class="add-more-btn" onclick="addSibling()">
                        <i class="fa-solid fa-plus"></i> Add Sibling
                    </button>
                </div>

                <!-- GUARDIAN (if applicable) -->
                <div class="form-box">
                    <h3>GUARDIAN INFORMATION (If Applicable)</h3>
                    <table class="form-table">
                        <tr>
                            <th>First Name</th>
                            <td><input type="text" name="guardian_FirstName"></td>
                            <th>Middle Name</th>
                            <td><input type="text" name="guardian_MiddleName"></td>
                        </tr>
                        <tr>
                            <th>Last Name</th>
                            <td><input type="text" name="guardian_LastName"></td>
                            <th>Relationship</th>
                            <td><input type="text" name="guardian_Relationship"></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td><input type="text" name="guardian_Address"></td>
                            <th>Landline</th>
                            <td><input type="text" name="guardian_Landline"></td>
                        </tr>
                        <tr>
                            <th>Mobile Number</th>
                            <td colspan="3"><input type="text" name="guardian_MobileNumber"></td>
                        </tr>
                    </table>
                </div>

                <!-- FRIENDS -->
                <div class="form-box">
                    <h3>FRIENDS INFORMATION</h3>
                    <div id="friendsContainer">
                        <div class="dynamic-section">
                            <table class="form-table">
                                <tr>
                                    <th>In School?</th>
                                    <td>
                                        <select name="friend[0][In_school]">
                                            <option value="">Select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </td>
                                    <th>First Name</th>
                                    <td><input type="text" name="friend[0][FirstName]"></td>
                                </tr>
                                <tr>
                                    <th>Middle Name</th>
                                    <td><input type="text" name="friend[0][MiddleName]"></td>
                                    <th>Last Name</th>
                                    <td><input type="text" name="friend[0][LastName]"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <button type="button" class="add-more-btn" onclick="addFriend()">
                        <i class="fa-solid fa-plus"></i> Add Friend
                    </button>
                        <!-- SUBMIT BUTTON -->
                     <div class="form-actions">
                    <button type="submit" class="submit-btn">
                        <i class="fa-solid fa-save"></i> Save Student Information
                    </button>
                </div>
                </div>
            </form>
        </div>
    </main>
</div>

<script src="../design/script/sidebar-student.js"></script>
<script>
// Global counters
let educationCount = 1;
let organizationCount = 1;
let siblingCount = 1;
let friendCount = 1;

// Add Education
function addEducation() {
    const container = document.getElementById('educationContainer');
    const div = document.createElement('div');
    div.className = 'dynamic-section';
    div.innerHTML = `
        <button type="button" class="remove-btn" onclick="this.parentElement.remove()">
            <i class="fa-solid fa-times"></i> Remove
        </button>
        <table class="form-table">
            <tr>
                <th>Grade Level</th>
                <td><input type="text" name="education[${educationCount}][GradeLevel]" placeholder="e.g., Grade 7"></td>
                <th>School Attended</th>
                <td><input type="text" name="education[${educationCount}][SchoolAttended]"></td>
            </tr>
            <tr>
                <th>Inclusive Years</th>
                <td><input type="text" name="education[${educationCount}][InclusiveYes]" placeholder="e.g., 2020-2024"></td>
                <th>Plan After High School</th>
                <td><textarea rows="2" name="education[${educationCount}][PlaceAndSchool]"></textarea></td>
            </tr>
        </table>
    `;
    container.appendChild(div);
    educationCount++;
}

// Add Organization
function addOrganization() {
    const container = document.getElementById('organizationContainer');
    const div = document.createElement('div');
    div.className = 'dynamic-section';
    div.innerHTML = `
        <button type="button" class="remove-btn" onclick="this.parentElement.remove()">
            <i class="fa-solid fa-times"></i> Remove
        </button>
        <table class="form-table">
            <tr>
                <th>Organization Name</th>
                <td><input type="text" name="organization[${organizationCount}][OrganizationName]"></td>
                <th>Position Title</th>
                <td><input type="text" name="organization[${organizationCount}][PositionTitle]"></td>
            </tr>
            <tr>
                <th>In Campus?</th>
                <td colspan="3">
                    <select name="organization[${organizationCount}][inCampus]">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </td>
            </tr>
        </table>
    `;
    container.appendChild(div);
    organizationCount++;
}

// Add Sibling
function addSibling() {
    const container = document.getElementById('siblingsContainer');
    const div = document.createElement('div');
    div.className = 'dynamic-section';
    div.innerHTML = `
        <button type="button" class="remove-btn" onclick="this.parentElement.remove()">
            <i class="fa-solid fa-times"></i> Remove
        </button>
        <table class="form-table">
            <tr>
                <th>First Name</th>
                <td><input type="text" name="sibling[${siblingCount}][FirstName]"></td>
                <th>Middle Name</th>
                <td><input type="text" name="sibling[${siblingCount}][MiddleName]"></td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td><input type="text" name="sibling[${siblingCount}][LastName]"></td>
                <th>Nickname</th>
                <td><input type="text" name="sibling[${siblingCount}][NickName]"></td>
            </tr>
            <tr>
                <th>Age</th>
                <td><input type="number" name="sibling[${siblingCount}][Age]"></td>
                <th>Birth Order</th>
                <td><input type="text" name="sibling[${siblingCount}][BirthOrder]" placeholder="e.g., 1st, 2nd"></td>
            </tr>
            <tr>
                <th>School ID</th>
                <td colspan="3"><input type="text" name="sibling[${siblingCount}][SchoolId]"></td>
            </tr>
        </table>
    `;
    container.appendChild(div);
    siblingCount++;
}

// Add Friend
function addFriend() {
    const container = document.getElementById('friendsContainer');
    const div = document.createElement('div');
    div.className = 'dynamic-section';
    div.innerHTML = `
        <button type="button" class="remove-btn" onclick="this.parentElement.remove()">
            <i class="fa-solid fa-times"></i> Remove
        </button>
        <table class="form-table">
            <tr>
                <th>In School?</th>
                <td>
                    <select name="friend[${friendCount}][In_school]">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </td>
                <th>First Name</th>
                <td><input type="text" name="friend[${friendCount}][FirstName]"></td>
            </tr>
            <tr>
                <th>Middle Name</th>
                <td><input type="text" name="friend[${friendCount}][MiddleName]"></td>
                <th>Last Name</th>
                <td><input type="text" name="friend[${friendCount}][LastName]"></td>
            </tr>
        </table>
    `;
    container.appendChild(div);
    friendCount++;
}

console.log('✅ Student form functions loaded');
</script>
</body>
</html>
