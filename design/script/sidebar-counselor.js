/**
 * ============================================
 * COUNSELOR SIDEBAR - JavaScript Interactivity
 * ============================================
 * Handles navigation, submenu toggle, settings, and performance optimizations
 */

// ============================================
// CONFIGURATION & STATE
// ============================================

const SidebarConfig = {
    sidebarSelector: '#counselorSidebar',
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
    console.log('🚀 Counselor Sidebar initialized');
    
    // Add ARIA labels
    const sidebar = document.querySelector(SidebarConfig.sidebarSelector);
    if (sidebar) {
        sidebar.setAttribute('aria-label', 'Counselor Navigation');
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
            // Skip if it's a submenu toggle
            if (this.getAttribute('data-submenu')) {
                return;
            }
            
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
    submenus.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const submenuTarget = document.querySelector(this.getAttribute('data-submenu'));
            if (submenuTarget) {
                submenuTarget.classList.toggle('open');
                
                // Toggle aria-expanded attribute
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', !isExpanded);
            }
        });
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

console.log('✅ Counselor Sidebar Script Loaded');
//////////////////////////////////////////////////////////
// Auto-calculate totals on page load

document.addEventListener('DOMContentLoaded', function() {
    calculateAllTotals();
    
    // Auto-refresh every 30 seconds to detect database changes
    setInterval(refreshData, 30000);
});

// Refresh data from database
function refreshData() {
    location.reload();
}

// Calculate all totals based on displayed values
function calculateAllTotals() {
    // 1. Calculate category-grade totals (M + F for each category/grade combination)
    document.querySelectorAll('.category-grade-total').forEach(cell => {
        const categoryId = cell.dataset.category;
        const gradeId = cell.dataset.grade;
        const row = cell.closest('tr');
        
        const maleCell = row.querySelector(`.male-value[data-category="${categoryId}"][data-grade="${gradeId}"]`);
        const femaleCell = row.querySelector(`.female-value[data-category="${categoryId}"][data-grade="${gradeId}"]`);
        
        const male = parseInt(maleCell.textContent) || 0;
        const female = parseInt(femaleCell.textContent) || 0;
        
        cell.textContent = male + female;
    });
    
    // 2. Calculate category grand totals (sum of all grades for each category)
    document.querySelectorAll('.category-grand-total').forEach(cell => {
        const categoryId = cell.dataset.category;
        let total = 0;
        
        document.querySelectorAll(`.category-grade-total[data-category="${categoryId}"]`).forEach(gradeCell => {
            total += parseInt(gradeCell.textContent) || 0;
        });
        
        cell.textContent = total;
    });
    
    // 3. Calculate section totals (sum of all categories in a section for each grade)
    document.querySelectorAll('[data-section-id]').forEach(row => {
        const sectionId = row.dataset.sectionId;
        
        // For each grade
        document.querySelectorAll('.male-value').forEach(cell => {
            const gradeId = cell.dataset.grade;
            if (cell.dataset.section === sectionId) {
                // Male total
                let maleTotal = 0;
                document.querySelectorAll(`.male-value[data-section="${sectionId}"][data-grade="${gradeId}"]`).forEach(c => {
                    maleTotal += parseInt(c.textContent) || 0;
                });
                const maleTotalCell = row.querySelector(`.section-male-total[data-section="${sectionId}"][data-grade="${gradeId}"]`);
                if (maleTotalCell) maleTotalCell.textContent = maleTotal;
                
                // Female total
                let femaleTotal = 0;
                document.querySelectorAll(`.female-value[data-section="${sectionId}"][data-grade="${gradeId}"]`).forEach(c => {
                    femaleTotal += parseInt(c.textContent) || 0;
                });
                const femaleTotalCell = row.querySelector(`.section-female-total[data-section="${sectionId}"][data-grade="${gradeId}"]`);
                if (femaleTotalCell) femaleTotalCell.textContent = femaleTotal;
                
                // Combined total
                const totalCell = row.querySelector(`.section-total-total[data-section="${sectionId}"][data-grade="${gradeId}"]`);
                if (totalCell) totalCell.textContent = maleTotal + femaleTotal;
            }
        });
        
        // Section grand total
        let sectionGrandTotal = 0;
        row.querySelectorAll('.section-total-total').forEach(cell => {
            sectionGrandTotal += parseInt(cell.textContent) || 0;
        });
        const grandTotalCell = row.querySelector(`.section-grand-total[data-section="${sectionId}"]`);
        if (grandTotalCell) grandTotalCell.textContent = sectionGrandTotal;
    });
    
    // 4. Calculate overall totals (sum of all sections for each grade)
    document.querySelectorAll('.overall-male-total').forEach(cell => {
        const gradeId = cell.dataset.grade;
        let total = 0;
        
        document.querySelectorAll(`.section-male-total[data-grade="${gradeId}"]`).forEach(sectionCell => {
            total += parseInt(sectionCell.textContent) || 0;
        });
        
        cell.textContent = total;
    });
    
    document.querySelectorAll('.overall-female-total').forEach(cell => {
        const gradeId = cell.dataset.grade;
        let total = 0;
        
        document.querySelectorAll(`.section-female-total[data-grade="${gradeId}"]`).forEach(sectionCell => {
            total += parseInt(sectionCell.textContent) || 0;
        });
        
        cell.textContent = total;
    });
    
    document.querySelectorAll('.overall-total-total').forEach(cell => {
        const gradeId = cell.dataset.grade;
        let total = 0;
        
        document.querySelectorAll(`.section-total-total[data-grade="${gradeId}"]`).forEach(sectionCell => {
            total += parseInt(sectionCell.textContent) || 0;
        });
        
        cell.textContent = total;
    });
    
    // 5. Calculate overall grand total
    let overallGrandTotal = 0;
    document.querySelectorAll('.overall-total-total').forEach(cell => {
        overallGrandTotal += parseInt(cell.textContent) || 0;
    });
    document.getElementById('overallGrandTotal').textContent = overallGrandTotal;
}

// Download report function
function downloadReport() {
    window.print();
}

// ============================================
// FOLLOW-UP FORM FUNCTIONS
// ============================================

// Store categories data from PHP
const categoriesData = typeof window.categoriesData !== 'undefined' ? window.categoriesData : [];
const sectionNames = {
    1: 'CAR (Children at Risk)',
    2: 'Mental Health',
    3: 'Bullying',
    4: 'Academic',
    5: 'Family Issues',
    6: 'Abuse and Neglect'
};

// Update categories dropdown based on selected section
function updateCategories() {
    const sectionId = document.getElementById('sectionId')?.value;
    const categorySelect = document.getElementById('categoryId');
    const titleInput = document.getElementById('title');
    
    if (!categorySelect || !titleInput) return;
    
    // Clear existing options
    categorySelect.innerHTML = '<option value="">-- Select Category --</option>';
    titleInput.value = '';
    
    if (!sectionId) return;
    
    // Filter categories by section
    const filteredCategories = categoriesData.filter(cat => cat.section_id == sectionId);
    
    // Populate category dropdown
    filteredCategories.forEach(category => {
        const option = document.createElement('option');
        option.value = category.id;
        option.textContent = category.category_name;
        categorySelect.appendChild(option);
    });
}

// Auto-generate title based on selected category
function updateTitle() {
    const categoryId = document.getElementById('categoryId')?.value;
    const sectionId = document.getElementById('sectionId')?.value;
    const titleInput = document.getElementById('title');
    
    if (!titleInput) return;
    
    if (!categoryId || !sectionId) {
        titleInput.value = '';
        return;
    }
    
    // Find selected category
    const category = categoriesData.find(cat => cat.id == categoryId);
    const section = sectionNames[sectionId];
    
    if (category) {
        titleInput.value = `${section} - ${category.category_name}`;
    }
}

// Initialize follow-up form
document.addEventListener('DOMContentLoaded', function() {
    // Form submission
    const followUpForm = document.getElementById('followUpForm');
    if (followUpForm) {
        followUpForm.addEventListener('submit', function(e) {
            // Validate required fields
            const studentId = document.getElementById('studentId')?.value;
            const sectionId = document.getElementById('sectionId')?.value;
            const categoryId = document.getElementById('categoryId')?.value;
            const title = document.getElementById('title')?.value;
            const counselor = document.getElementById('counselor')?.value;
            const status = document.getElementById('status')?.value;
            
            if (!studentId || !sectionId || !categoryId || !title || !counselor || !status) {
                e.preventDefault();
                alert('Please fill in all required fields');
                return false;
            }
        });
    }

    // Add smooth focus effects
    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            if (this.parentElement && this.parentElement.classList.contains('form-group')) {
                this.parentElement.style.transform = 'translateX(4px)';
                this.parentElement.style.transition = 'transform 0.3s ease';
            }
        });
        
        input.addEventListener('blur', function() {
            if (this.parentElement && this.parentElement.classList.contains('form-group')) {
                this.parentElement.style.transform = 'translateX(0)';
            }
        });
    });
});