<?php
// Counselor Sidebar Component
// This file contains the sidebar for counselor dashboard with all navigation items

// Get current page for active state
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<aside class="sidebar" id="counselorSidebar">
    <!-- Logo Section -->
    <div class="sidebar-header">
        <div class="logo">
            <i class="fa-solid fa-heart-hands"></i>
            <span>Counselor</span>
        </div>
        <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle Sidebar">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
    </div>

    <!-- User Profile Section -->
    <div class="user-profile">
        <div class="profile-avatar">
            <i class="fa-solid fa-user-tie"></i>
        </div>
        <div class="profile-info">
            <p class="profile-name">👋 Good Morning</p>
            <p class="profile-role">Counselor</p>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="sidebar-nav">
        <ul class="nav-list">
            <!-- Dashboard Link -->
            <li class="nav-item">
                <a href="counsilor.php" class="nav-link <?php echo ($currentPage == 'counsilor.php') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-chart-line"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <!-- Analytics Link -->
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-chart-area"></i>
                    <span class="nav-text">Analytics</span>
                </a>
            </li>

             <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link" data-submenu="#appointmentMenu" aria-expanded="false">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span class="nav-text">Referral Form Status</span>
                    <i class="fa-solid fa-chevron-right dropdown-icon"></i>
                </a>
                <ul class="submenu" id="appointmentMenu">
                    <li><a href="counsilor.php"><i class="fa-solid fa-envelope"></i> Counseling Schedule</a></li>
                    <li><a href="#"><i class="fa-solid fa-user-tie"></i> Appointment Report</a></li>
                </ul>
            </li>


           
            <!-- Schedule Link -->
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-clock"></i>
                    <span class="nav-text">Schedule</span>
                </a>
            </li>

            <!-- Report Case Link -->
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-calendar-days"></i>
                    <span class="nav-text">Report Case</span>
                </a>
            </li>

            <!-- Messages Link -->
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-envelope"></i>
                    <span class="nav-text">Messages</span>
                    <span class="nav-badge notification-badge">5</span>
                </a>
            </li>

            <!-- Student Accounts Link -->
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-users"></i>
                    <span class="nav-text">Students</span>
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

            <!-- Help Link -->
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-circle-question"></i>
                    <span class="nav-text">Help</span>
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
        <p class="footer-text">Counselor Portal 2025-2026</p>
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
