<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<aside class="sidebar" id="counselorSidebar">

    <!-- Logo Section -->
    <div class="sidebar-header">
        <div class="logo">
            <i class="fa-solid fa-heart-hands"></i>
            <span>Division Office</span>
        </div>
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
    </div>

    <!-- User Profile Section -->
    <div class="user-profile-wrapper">
        <a href="profile.php" class="user-profile">
            <div class="profile-avatar">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <div class="profile-info">
                <p class="profile-name">👋 Good Morning</p>
                <p class="profile-role">Sdo Handler</p>
            </div>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">
        <ul class="nav-list">

            <li class="nav-item">
                <a href="" class="nav-link">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Profile Submenu -->
            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link" data-submenu="#profileMenu">
                    <i class="fa-solid fa-user"></i>
                    <span>Profile</span>
                    <i class="fa-solid fa-chevron-right dropdown-icon"></i>
                </a>
                <ul class="submenu" id="profileMenu">
                    <li><a href="student-profile.php">Student</a></li>
                    <li><a href="counselor-profile.php">Counselor</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="analytics.php" class="nav-link">
                    <i class="fa-solid fa-chart-area"></i>
                    <span>Analytics</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="pending-forms.php" class="nav-link">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span>Pending Forms</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="schedule.php" class="nav-link">
                    <i class="fa-solid fa-calendar"></i>
                    <span>Schedule</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="feedbacks.php" class="nav-link">
                    <i class="fa-solid fa-envelope"></i>
                    <span>Feedbacks</span>
                </a>
            </li>

            <!-- Reports Submenu -->
            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link" data-submenu="#reportsMenu">
                    <i class="fa-solid fa-file"></i>
                    <span>Reports</span>
                    <i class="fa-solid fa-chevron-right dropdown-icon"></i>
                </a>
                <ul class="submenu" id="reportsMenu">
                    <li><a href="case-reports.php">Case Reports</a></li>
                    <li><a href="appointment-reports.php">Appointment Reports</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="referral-flow.php" class="nav-link">
                    <i class="fa-solid fa-handshake"></i>
                    <span>Referral & Counseling Flow</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="follow-upForm.php" class="nav-link">
                    <i class="fa-solid fa-clipboard-check"></i>
                    <span>Follow-up Form</span>
                </a>
            </li>

            <li class="nav-divider"></li>

            <li class="nav-item">
                <a href="login.php" class="nav-link logout-link">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span>Log Out</span>
                </a>
            </li>

        </ul>
    </nav>

    <div class="sidebar-footer">
        <p>Counselor Portal 2025-2026</p>
    </div>

</aside>