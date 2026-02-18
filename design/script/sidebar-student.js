/**
 * ============================================
 * STUDENT SIDEBAR - JavaScript Interactivity
 * ============================================
 * Handles navigation, submenu toggle, settings, and performance optimizations
 */

// ============================================
// CONFIGURATION & STATE
// ============================================

const SidebarConfig = {
    sidebarSelector: '#studentSidebar',
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
    console.log('🚀 Sidebar initialized');
    
    // Add ARIA labels
    const sidebar = document.querySelector(SidebarConfig.sidebarSelector);
    if (sidebar) {
        sidebar.setAttribute('aria-label', 'Student Navigation');
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
 * Setup Navigation Links
 */
function setupNavigationLinks() {
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Don't prevent default for actual links
            if (!this.getAttribute('data-submenu')) {
                handleNavigation(this);
            }
        });

        // Add keyboard support
        link.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                if (this.getAttribute('data-submenu')) {
                    toggleSubmenu(this);
                } else {
                    this.click();
                }
            }
        });
    });
}

/**
 * Handle Navigation Click
 */
function handleNavigation(element) {
    // Add animation feedback
    element.style.transform = 'scale(0.98)';
    setTimeout(() => {
        element.style.transform = 'scale(1)';
    }, 150);

    // Play click sound if enabled
    playClickSound();

    // Log analytics (optional)
    const linkText = element.querySelector('.nav-text')?.textContent || 'Unknown';
    logNavigation(linkText);
}

/**
 * Log Navigation for Analytics
 */
function logNavigation(linkName) {
    const timestamp = new Date().toLocaleTimeString();
    console.log(`📍 Navigated to: ${linkName} at ${timestamp}`);
}

// ============================================
// SUBMENU HANDLING
// ============================================

/**
 * Setup Submenus
 */
function setupSubmenus() {
    const submenuTriggers = document.querySelectorAll(SidebarConfig.submenuSelector);
    
    submenuTriggers.forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            toggleSubmenu(this);
        });
    });
}


// ============================================
// SETTINGS MODAL
// ============================================

/**
 * Open Settings Modal
 */
function openSettingsModal(e) {
    e?.preventDefault();
    const modal = document.querySelector(SidebarConfig.settingsModalSelector);
    const overlay = document.querySelector(SidebarConfig.settingsOverlaySelector);
    
    if (modal && overlay) {
        modal.classList.add('active');
        overlay.classList.add('active');
        modal.focus();
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
        
        // Play sound
        playOpenSound();
    }
}

/**
 * Close Settings Modal
 */
function closeSettingsModal(e) {
    e?.preventDefault();
    const modal = document.querySelector(SidebarConfig.settingsModalSelector);
    const overlay = document.querySelector(SidebarConfig.settingsOverlaySelector);
    
    if (modal && overlay) {
        modal.classList.remove('active');
        overlay.classList.remove('active');
        
        // Restore body scroll
        document.body.style.overflow = '';
    }
}

/**
 * Setup Settings Toggle Handlers
 */
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('themeToggle');
    const notifToggle = document.getElementById('notifToggle');
    const soundToggle = document.getElementById('soundToggle');

    if (themeToggle) {
        themeToggle.addEventListener('change', toggleTheme);
        themeToggle.checked = localStorage.getItem(SidebarConfig.storagePrefix + 'darkMode') === 'true';
    }

    if (notifToggle) {
        notifToggle.addEventListener('change', toggleNotifications);
        notifToggle.checked = localStorage.getItem(SidebarConfig.storagePrefix + 'notifications') !== 'false';
    }

    if (soundToggle) {
        soundToggle.addEventListener('change', toggleSound);
        soundToggle.checked = localStorage.getItem(SidebarConfig.storagePrefix + 'sound') !== 'false';
    }
});

/**
 * Toggle Dark Mode Theme
 */
function toggleTheme(e) {
    const isDarkMode = e.target.checked;
    document.body.classList.toggle('dark-mode', isDarkMode);
    localStorage.setItem(SidebarConfig.storagePrefix + 'darkMode', isDarkMode);
    console.log('🌙 Dark mode:', isDarkMode ? 'ON' : 'OFF');
}

/**
 * Toggle Notifications
 */
function toggleNotifications(e) {
    const enabled = e.target.checked;
    localStorage.setItem(SidebarConfig.storagePrefix + 'notifications', enabled);
    console.log('🔔 Notifications:', enabled ? 'Enabled' : 'Disabled');
    
    // You can add notification permission request here
    if (enabled && 'Notification' in window) {
        if (Notification.permission === 'default') {
            Notification.requestPermission();
        }
    }
}

/**
 * Toggle Sound Effects
 */
function toggleSound(e) {
    const enabled = e.target.checked;
    localStorage.setItem(SidebarConfig.storagePrefix + 'sound', enabled);
    console.log('🔊 Sound effects:', enabled ? 'ON' : 'OFF');
    if (enabled) playSuccessSound();
}

// ============================================
// SOUND EFFECTS (Optional)
// ============================================

/**
 * Setup Notification Sounds
 */
function setupNotificationSounds() {
    // Create audio context for sound effects
    if (!window.audioContext) {
        try {
            window.audioContext = new (window.AudioContext || window.webkitAudioContext)();
        } catch (e) {
            console.log('Web Audio API not supported');
        }
    }
}

/**
 * Play Click Sound
 */
function playClickSound() {
    if (!shouldPlaySound()) return;
    playTone(800, 0.05);
}

/**
 * Play Toggle Sound
 */
function playToggleSound() {
    if (!shouldPlaySound()) return;
    playTone(600, 0.1);
}

/**
 * Play Open Sound
 */
function playOpenSound() {
    if (!shouldPlaySound()) return;
    playTone(1000, 0.08);
}

/**
 * Play Success Sound
 */
function playSuccessSound() {
    if (!shouldPlaySound()) return;
    playTone(700, 0.1);
    setTimeout(() => playTone(900, 0.1), 50);
}

/**
 * Play Tone using Web Audio API
 */
function playTone(frequency, duration) {
    const audioContext = window.audioContext;
    if (!audioContext) return;

    try {
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();
        
        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);
        
        oscillator.frequency.value = frequency;
        oscillator.type = 'sine';
        
        gainNode.gain.setValueAtTime(0.1, audioContext.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + duration);
        
        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + duration);
    } catch (e) {
        // Silently fail if audio not available
    }
}

/**
 * Check if sound should play
 */
function shouldPlaySound() {
    return localStorage.getItem(SidebarConfig.storagePrefix + 'sound') !== 'false';
}

// ============================================
// SIDEBAR TOGGLE (Mobile)
// ============================================

/**
 * Toggle Sidebar Visibility
 */
function toggleSidebar() {
    const sidebar = document.querySelector(SidebarConfig.sidebarSelector);
    if (sidebar) {
        sidebar.classList.toggle('open');
        const isOpen = sidebar.classList.contains('open');
        const toggle = document.querySelector(SidebarConfig.toggleSelector);
        if (toggle) {
            toggle.setAttribute('aria-expanded', isOpen);
        }
    }
}

/**
 * Handle Outside Click to Close Sidebar
 */
function handleOutsideClick(e) {
    const sidebar = document.querySelector(SidebarConfig.sidebarSelector);
    const toggle = document.querySelector(SidebarConfig.toggleSelector);
    
    if (sidebar && toggle && window.innerWidth <= 768) {
        if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
            if (sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
            }
        }
    }
}

/**
 * Handle Escape Key to Close Modal/Sidebar
 */
function handleEscapeKey(e) {
    if (e.key === 'Escape') {
        // Close modal
        const modal = document.querySelector(SidebarConfig.settingsModalSelector);
        if (modal?.classList.contains('active')) {
            closeSettingsModal();
        }
        
        // Close sidebar (mobile)
        const sidebar = document.querySelector(SidebarConfig.sidebarSelector);
        if (sidebar?.classList.contains('open')) {
            sidebar.classList.remove('open');
        }
    }
}

// ============================================
// ACTIVE NAVIGATION STATE
// ============================================

/**
 * Set Active Navigation Item
 */
function setActiveNavigationItem() {
    const currentUrl = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href && currentUrl.includes(href)) {
            link.classList.add('active');
            link.setAttribute('aria-current', 'page');
            
            // Scroll to active item
            link.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } else {
            link.classList.remove('active');
            link.removeAttribute('aria-current');
        }
    });
}

// ============================================
// LOCAL STORAGE UTILITIES
// ============================================

/**
 * Save State to Local Storage
 */
function saveState(key, value) {
    try {
        localStorage.setItem(SidebarConfig.storagePrefix + key, JSON.stringify(value));
    } catch (e) {
        console.warn('Could not save to localStorage:', e);
    }
}

/**
 * Get State from Local Storage
 */
function getState(key, defaultValue = null) {
    try {
        const value = localStorage.getItem(SidebarConfig.storagePrefix + key);
        return value ? JSON.parse(value) : defaultValue;
    } catch (e) {
        return defaultValue;
    }
}

/**
 * Restore User Settings
 */
function restoreUserSettings() {
    // Restore theme preference
    if (localStorage.getItem(SidebarConfig.storagePrefix + 'darkMode') === 'true') {
        document.body.classList.add('dark-mode');
    }
    
    // Restore submenu states
    document.querySelectorAll('[data-submenu]').forEach(trigger => {
        const submenuId = trigger.getAttribute('data-submenu');
        const wasOpen = getState(`submenu_${submenuId}`, false);
        const submenu = document.querySelector(submenuId);
        if (wasOpen && submenu) {
            submenu.classList.add('open');
            trigger.setAttribute('aria-expanded', 'true');
        }
    });
}

/**
 * Load Theme Preference
 */
function loadThemePreference() {
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const savedTheme = localStorage.getItem(SidebarConfig.storagePrefix + 'darkMode');
    
    if (savedTheme === null && prefersDark) {
        document.body.classList.add('dark-mode');
        localStorage.setItem(SidebarConfig.storagePrefix + 'darkMode', 'true');
    }
}

// ============================================
// PERFORMANCE OPTIMIZATION
// ============================================

/**
 * Debounce Function
 */
function debounce(func, delay) {
    let timeoutId;
    return function(...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func.apply(this, args), delay);
    };
}

/**
 * Throttle Function
 */
function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Optimize resize events
window.addEventListener('resize', throttle(() => {
    console.log('📐 Window resized');
}, 250));

// ============================================
// UTILITY FUNCTIONS
// ============================================

/**
 * Log Message with Emoji
 */
function logMessage(emoji, message) {
    console.log(`${emoji} ${message}`);
}

/**
 * Get Current Hour Greeting
 */
function getGreeting() {
    const hour = new Date().getHours();
    if (hour < 12) return '👋 Good Morning';
    if (hour < 18) return '☀️ Good Afternoon';
    return '🌙 Good Evening';
}

/**
 * Update Greeting (Optional)
 */
function updateGreeting() {
    const profileName = document.querySelector('.profile-name');
    if (profileName) {
        profileName.textContent = getGreeting();
    }
}

// Update greeting on page load
setTimeout(updateGreeting, 500);

// ============================================
// EXPORT FOR USE
// ============================================

// Make functions available globally if needed
window.Sidebar = {
    toggle: toggleSidebar,
    openSettings: openSettingsModal,
    closeSettings: closeSettingsModal,

    // toggleSubmenu: toggleSubmenu,
    saveState: saveState,
    getState: getState
};

console.log('✅ Sidebar JavaScript loaded successfully');

/////////////////////////////////////////////////////////////
// Global counters for dynamic sections
let educationCount = 1;
let organizationCount = 1;
let siblingCount = 1;
let friendCount = 1;

// Add Education Function
function addEducation() {
    const container = document.getElementById('educationContainer');
    if (!container) {
        console.error('educationContainer not found');
        return;
    }
    
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
    console.log('Education section added successfully');
}

// Add Organization Function
function addOrganization() {
    const container = document.getElementById('organizationContainer');
    if (!container) {
        console.error('organizationContainer not found');
        return;
    }
    
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
    console.log('Organization section added successfully');
}

// Add Sibling Function
function addSibling() {
    const container = document.getElementById('siblingsContainer');
    if (!container) {
        console.error('siblingsContainer not found');
        return;
    }
    
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
    console.log('Sibling section added successfully');
}

// Add Friend Function
function addFriend() {
    const container = document.getElementById('friendsContainer');
    if (!container) {
        console.error('friendsContainer not found');
        return;
    }
    
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
    console.log('Friend section added successfully');
}

// Form validation before submit (optional)
function validateStudentForm() {
    const requiredFields = ['StudentId', 'LRN', 'FirstName', 'LastName', 'Sex', 'Age', 'DateOfBirth'];
    let isValid = true;
    let missingFields = [];

    requiredFields.forEach(field => {
        const input = document.querySelector(`[name="${field}"]`);
        if (!input || !input.value.trim()) {
            isValid = false;
            missingFields.push(field);
            if (input) {
                input.style.borderColor = 'red';
            }
        } else if (input) {
            input.style.borderColor = '';
        }
    });

    if (!isValid) {
        alert('Please fill in all required fields:\n' + missingFields.join('\n'));
        return false;
    }
    
    return true;
}

// Initialize form when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Student form functions loaded successfully');
    console.log('✅ Functions available: addEducation, addOrganization, addSibling, addFriend');
    
    // Attach form validation to submit event
    const studentForm = document.getElementById('studentForm');
    if (studentForm) {
        studentForm.addEventListener('submit', function(e) {
            if (!validateStudentForm()) {
                e.preventDefault();
                return false;
            }
        });
        console.log('✅ Form validation attached');
    }
});

// Export functions to global scope (in case they're called inline)
window.addEducation = addEducation;
window.addOrganization = addOrganization;
window.addSibling = addSibling;
window.addFriend = addFriend;
window.validateStudentForm = validateStudentForm;

console.log('✅ Student form JavaScript module loaded');