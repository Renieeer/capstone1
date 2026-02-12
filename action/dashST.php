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

            <!-- STUDENT -->
            <div class="form-box">
                <h3>STUDENT INFORMATION</h3>

                <table class="form-table">
                    <tr>
                        <th>Student ID</th>
                        <td><input type="text"></td>
                        <th>LRN</th>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <th>First Name</th>
                        <td><input type="text"></td>
                        <th>Middle Name</th>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <th>Last Name</th>
                        <td><input type="text"></td>
                        <th>Nickname</th>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <th>Sex</th>
                        <td>
                            <select>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </td>
                        <th>Age</th>
                        <td><input type="number"></td>
                    </tr>
                    <tr>
                        <th>Date of Birth</th>
                        <td><input type="date"></td>
                        <th>Place of Birth</th>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <th>Religion from Birth</th>
                        <td><input type="text"></td>
                        <th>Current Religion</th>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <th>Current Address</th>
                        <td><input type="text"></td>
                        <th>Permanent Address</th>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                        <th>Cellphone</th>
                        <td><input type="text"></td>
                        <th>Personal Email Account</th>
                        <td><input type="email"></td>
                    </tr>
                </table>
            </div>

            <!-- EDUCATIONAL BACKGROUND -->
            <div class="form-box">
                <h3>EDUCATIONAL BACKGROUND</h3>
                <table class="form-table">
                    <tr>
                        <th>Grade Level</th>
                        <td><input type="text"></td>
                        <th>School Attended</th>
                        <td><input type="text"></td>  <!-- this shoould be  multiple base on the school he she/attended-->
                    </tr>
                    <tr>
                        <th>Inclusive Years</th>
                        <td><input type="text"></td>
                        <th>Plan After High School</th>
                        <td><textarea rows="3"></textarea></td>
                    </tr>
                </table>
            </div>

            <div class="form-box">
                <h3> ORGANIZATION BACKGROUND</h3>
                <table class="form-table">
                    <tr>
                        <th>Organization Name</th>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                       <th>Position Title</th>
                        <td><input type="text"></td>
                    </tr>
                    <tr>
                         <th>Organization Type</th>
                        <td><input type="text"></td>
                    </tr>
                </table>
            </div>

            <div class="form-box">
                <h3>PARENTS BACKGROUND</h3>

                <div class="parents-grid">

                    <!-- FATHER -->
                    <div class="parent-card">
                        <h4>Father's Information</h4>
                        <table class="form-table">
                            <tr>
                                <th>Full Name</th>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <th>Occupation</th>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <th>Contact Number</th>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <th>Email Address</th>
                                <td><input type="email"></td>
                            </tr>
                            <tr>
                                <th>Highest Educational Attainment</th>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <th>Deceased</th>
                                <td>
                                    <select>
                                        <option>No</option>
                                        <option>Yes</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- MOTHER -->
                    <div class="parent-card">
                        <h4>Mother's Information</h4>
                        <table class="form-table">
                            <tr>
                                <th>Full Name</th>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <th>Occupation</th>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <th>Contact Number</th>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <th>Email Address</th>
                                <td><input type="email"></td>
                            </tr>
                            <tr>
                                <th>Highest Educational Attainment</th>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <th>Deceased</th>
                                <td>
                                    <select>
                                        <option>No</option>
                                        <option>Yes</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="form-actions">
                    <button class="submit-btn">
                        <i class="fa-solid fa-save"></i> Save Student
                    </button>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="../design/script/sidebar-student.js"></script>
</body>
</html>
