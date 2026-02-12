/**
 * ============================================
 * COORDINATOR SIDEBAR - JavaScript Interactivity
 * ============================================
 * Handles navigation, submenu toggle, settings, and performance optimizations
 */

// ============================================
// CONFIGURATION & STATE
// ============================================

const SidebarConfig = {
    sidebarSelector: '#coordinatorSidebar',
    toggleSelector: '#sidebarToggle',
    submenuSelector: '[data-submenu]',
    settingsToggleSelector: '#settingsToggle',
    settingsModalSelector: '#settingsModal',
    settingsOverlaySelector: '#settingsOverlay',
    settingsCloseSelector: '#settingsClose',
    animationDuration: 300,
    storagePrefix: 'sidebar_'
};

// ============================================
// INITIALIZATION
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    initSidebar();
    setupEventListeners();
    restoreUserSettings();
    setActiveNavigationItem();
    requestAnimationFrame(() => {
        loadThemePreference();
    });
});

/**
 * Initialize Sidebar Components
 */
function initSidebar() {
    console.log('🚀 Coordinator Sidebar initialized');
    
    // Add ARIA labels
    const sidebar = document.querySelector(SidebarConfig.sidebarSelector);
    if (sidebar) {
        sidebar.setAttribute('aria-label', 'Coordinator Navigation');
    }

    // Setup submenu handlers
    setupSubmenus();
    
    // Enable smooth scroll behavior
    document.documentElement.style.scrollBehavior = 'smooth';
}

/**
 * Setup Event Listeners
 */
function setupEventListeners() {
    // Sidebar Toggle (Mobile)
    const sidebarToggle = document.querySelector(SidebarConfig.toggleSelector);
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }

    // Settings Modal
    const settingsToggle = document.querySelector(SidebarConfig.settingsToggleSelector);
    if (settingsToggle) {
        settingsToggle.addEventListener('click', openSettingsModal);
    }

    const settingsClose = document.querySelector(SidebarConfig.settingsCloseSelector);
    if (settingsClose) {
        settingsClose.addEventListener('click', closeSettingsModal);
    }

    const settingsOverlay = document.querySelector(SidebarConfig.settingsOverlaySelector);
    if (settingsOverlay) {
        settingsOverlay.addEventListener('click', closeSettingsModal);
    }

    // Navigation Links
    setupNavigationLinks();

    // Close sidebar when clicking outside (mobile)
    document.addEventListener('click', handleOutsideClick);

    // Handle Escape key
    document.addEventListener('keydown', handleEscapeKey);

    // Notification sound toggle
    setupNotificationSounds();
}

// ============================================
// NAVIGATION HANDLING
// ============================================

/**
 * Setup Navigation Links Click Handler
 */
function setupNavigationLinks() {
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        // Remove previous active class
        link.addEventListener('click', function(e) {
            // Don't prevent default for actual navigation
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            
            // Store active state
            localStorage.setItem(SidebarConfig.storagePrefix + 'active', this.href);
        });
    });
}

/**
 * Set Active Navigation Item on Page Load
 */
function setActiveNavigationItem() {
    const currentPage = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        if (link.href.includes(currentPage) || link.getAttribute('href') === currentPage) {
            link.classList.add('active');
        }
    });
}

// ============================================
// SIDEBAR TOGGLE (MOBILE)
// ============================================

/**
 * Toggle Sidebar Visibility
 */
function toggleSidebar() {
    const sidebar = document.querySelector(SidebarConfig.sidebarSelector);
    if (sidebar) {
        sidebar.classList.toggle('collapsed');
        localStorage.setItem(SidebarConfig.storagePrefix + 'collapsed', 
            sidebar.classList.contains('collapsed'));
    }
}

/**
 * Handle Outside Click to Close Sidebar (Mobile)
 */
function handleOutsideClick(e) {
    const sidebar = document.querySelector(SidebarConfig.sidebarSelector);
    const toggle = document.querySelector(SidebarConfig.toggleSelector);
    
    if (sidebar && sidebar.classList.contains('visible') && 
        !sidebar.contains(e.target) && !toggle?.contains(e.target)) {
        sidebar.classList.remove('visible');
    }
}

/**
 * Handle Escape Key
 */
function handleEscapeKey(e) {
    if (e.key === 'Escape') {
        const sidebar = document.querySelector(SidebarConfig.sidebarSelector);
        if (sidebar) {
            sidebar.classList.remove('visible');
        }
    }
}

// ============================================
// SUBMENUS
// ============================================

/**
 * Setup Submenu Toggles
 */
function setupSubmenus() {
    const submenus = document.querySelectorAll('[data-submenu]');
    submenus.forEach(submenu => {
        const toggle = submenu.querySelector('.submenu-toggle');
        if (toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                submenu.classList.toggle('open');
                const icon = toggle.querySelector('i');
                if (icon) {
                    icon.style.transform = submenu.classList.contains('open') ? 'rotate(180deg)' : '';
                }
            });
        }
    });
}

// ============================================
// SETTINGS MODAL
// ============================================

/**
 * Open Settings Modal
 */
function openSettingsModal() {
    const modal = document.querySelector(SidebarConfig.settingsModalSelector);
    const overlay = document.querySelector(SidebarConfig.settingsOverlaySelector);
    
    if (modal && overlay) {
        modal.classList.add('active');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

/**
 * Close Settings Modal
 */
function closeSettingsModal() {
    const modal = document.querySelector(SidebarConfig.settingsModalSelector);
    const overlay = document.querySelector(SidebarConfig.settingsOverlaySelector);
    
    if (modal && overlay) {
        modal.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }
}

// ============================================
// USER SETTINGS & PREFERENCES
// ============================================

/**
 * Restore User Settings from LocalStorage
 */
function restoreUserSettings() {
    const isCollapsed = localStorage.getItem(SidebarConfig.storagePrefix + 'collapsed') === 'true';
    const theme = localStorage.getItem(SidebarConfig.storagePrefix + 'theme') || 'light';
    
    if (isCollapsed) {
        const sidebar = document.querySelector(SidebarConfig.sidebarSelector);
        if (sidebar) {
            sidebar.classList.add('collapsed');
        }
    }
    
    applyTheme(theme);
}

/**
 * Load Theme Preference
 */
function loadThemePreference() {
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const theme = localStorage.getItem(SidebarConfig.storagePrefix + 'theme') || 
                  (prefersDark ? 'dark' : 'light');
    applyTheme(theme);
}

/**
 * Apply Theme
 */
function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem(SidebarConfig.storagePrefix + 'theme', theme);
}

// ============================================
// NOTIFICATION SOUNDS
// ============================================

/**
 * Setup Notification Sound Toggle
 */
function setupNotificationSounds() {
    const soundToggle = document.querySelector('[data-sound-toggle]');
    if (soundToggle) {
        const enabled = localStorage.getItem(SidebarConfig.storagePrefix + 'sound') !== 'false';
        soundToggle.checked = enabled;
        
        soundToggle.addEventListener('change', function() {
            localStorage.setItem(SidebarConfig.storagePrefix + 'sound', this.checked);
        });
    }
}

/**
 * Play Notification Sound
 */
function playNotificationSound() {
    const enabled = localStorage.getItem(SidebarConfig.storagePrefix + 'sound') !== 'false';
    if (enabled) {
        const audio = new Audio('data:audio/wav;base64,UklGRiYAAABXQVZFZm10IBAAAAABAAEAQB8AAAB9AAACABAAZGF0YQIAAAAAAA==');
        audio.play().catch(() => {});
    }
}

// ============================================
// ANIMATIONS & TRANSITIONS
// ============================================

/**
 * Smooth Scroll to Element
 */
function smoothScroll(selector) {
    const element = document.querySelector(selector);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

/**
 * Add Animation to Element
 */
function addAnimation(element, animationName) {
    element.style.animation = `${animationName} ${SidebarConfig.animationDuration}ms ease-out`;
    setTimeout(() => {
        element.style.animation = '';
    }, SidebarConfig.animationDuration);
}

// ============================================
// PERFORMANCE OPTIMIZATIONS
// ============================================

// Debounce function for resize events
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Handle window resize
const handleResize = debounce(() => {
    const sidebar = document.querySelector(SidebarConfig.sidebarSelector);
    if (window.innerWidth > 768 && sidebar) {
        sidebar.classList.remove('visible');
    }
}, 250);

window.addEventListener('resize', handleResize);

console.log('✅ Coordinator Sidebar Script Loaded');
