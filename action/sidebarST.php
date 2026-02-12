<?php
// Student Sidebar Component
// This file contains the sidebar for student dashboard with all navigation items

// Get current page for active state
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<aside class="sidebar" id="studentSidebar">
    <!-- Logo Section -->
    <div class="sidebar-header">
        <div class="logo">
            <i class="fa-solid fa-layer-group"></i>
            <span>Student Hub</span>
        </div>
        <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle Sidebar">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
    </div>

    <!-- User Profile Section -->
    <div class="user-profile">
        <div class="profile-avatar">
            <i class="fa-solid fa-user-circle"></i>
        </div>
        <div class="profile-info">
            <p class="profile-name">Welcome Back!</p>
            <p class="profile-role">Student</p>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="sidebar-nav">
        <ul class="nav-list">
            <!-- Student Form Link -->
            <li class="nav-item">
                <a href="dashST.php" class="nav-link <?php echo ($currentPage == 'dashST.php') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-file-invoice"></i>
                    <span class="nav-text">Student Form</span>
                </a>
            </li>

            <!-- History & Reports Link -->
            <li class="nav-item">
                <a href="HistoryReportST.php" class="nav-link <?php echo ($currentPage == 'HistoryReportST.php') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-history"></i>
                    <span class="nav-text">History Report</span>
                </a>
            </li>

            <!-- Appointments Submenu -->
            <li class="nav-item nav-item-submenu">
                <a href="appointment.php" class="nav-link">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span class="nav-text">Appointments</span>
                </a>
            </li>
    
            <!-- Referal & Counseling Link -->
            <li class="nav-item">
                <a href="#" class="nav-link" id="referalToggle">
                    <i class="bi bi-folder"></i>
                    <span class="nav-text">Referal/Counseling</span>
                </a>
            </li>
            <!-- Schedule Link -->
            <li class="nav-item">
                <a href="#" class="nav-link" id="sceduleToggle">
                    <i class="bi bi-calendar3"></i>
                    <span class="nav-text">Schedule</span>
                </a>
            </li>

            <!-- Feedback Link -->
            <li class="nav-item">
                <a href="#" class="nav-link" id="FeedbackToggle">
                    <i class="bi bi-chat-square-dots"></i>
                    <span class="nav-text">Feed-Back</span>
                </a>
            </li>

            <!-- Notification -->
            <li class="nav-item">
                <a href="#" class="nav-link" id="notificationToggle">
                    <i class="bi bi-bell-fill"></i>
                    <span class="nav-text">Notification</span>  
                </a>
            </li>

            <!-- Divider -->
            <li class="nav-divider"></li>

                <!-- Settings Link -->
                <li class="nav-item">
                    <a href="#" class="nav-link" id="settingsToggle">
                        <i class="fa-solid fa-gear"></i>
                        <span class="nav-text">Settings</span>
                    </a>
                </li>

                <!-- Logout Link -->
                <li class="nav-item">
                    <a href="login.php" class="nav-link logout-link">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span class="nav-text">Log Out</span>
                    </a>
                </li>
        </ul>
    </nav>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <p class="footer-text">Academic Year 2025-2026</p>
    </div>
</aside>

<!-- Settings Modal -->
<div class="settings-modal" id="settingsModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Settings</h3>
            <button class="modal-close" id="settingsClose">&times;</button>
        </div>
        <div class="modal-body">
            <div class="setting-item">
                <label for="themeToggle" class="setting-label">
                    <i class="fa-solid fa-moon"></i> Dark Mode
                </label>
                <input type="checkbox" id="themeToggle" class="setting-toggle">
            </div>
            <div class="setting-item">
                <label for="notifToggle" class="setting-label">
                    <i class="fa-solid fa-bell"></i> Enable Notifications
                </label>
                <input type="checkbox" id="notifToggle" class="setting-toggle" checked>
            </div>
            <div class="setting-item">
                <label for="soundToggle" class="setting-label">
                    <i class="fa-solid fa-volume-high"></i> Sound Effects
                </label>
                <input type="checkbox" id="soundToggle" class="setting-toggle" checked>
            </div>
        </div>
    </div>
</div>

<!-- Overlay for Modal -->
<div class="modal-overlay" id="settingsOverlay"></div>

