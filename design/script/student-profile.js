// Student Profile Application - Vanilla JavaScript

class StudentProfileApp {
    constructor() {
        this.students = [];
        this.selectedStudent = null;
        this.followUpHistory = [];
        this.searchQuery = '';
        this.currentGradient = 0;
        this.gradients = ['gradient-1', 'gradient-2'];
        
        this.initializeElements();
        this.attachEventListeners();
        this.loadStudents();
    }

    // Initialize DOM elements
    initializeElements() {
        console.log('=== initializeElements() called ===');
        this.elements = {
            searchInput: document.getElementById('searchInput'),
            searchBtn: document.getElementById('searchBtn'),
            studentGrid: document.getElementById('studentGrid'),
            loadingSpinner: document.getElementById('loadingSpinner'),
            emptyState: document.getElementById('emptyState'),
            modalOverlay: document.getElementById('studentModal'),
            modalCloseBtn: document.getElementById('modalCloseBtn'),
            tabButtons: document.querySelectorAll('.tab-button'),
            detailsTab: document.getElementById('detailsTab'),
            historyTab: document.getElementById('historyTab'),
            historyContent: document.getElementById('historyContent'),
            historyCount: document.getElementById('historyCount'),
            modalStudentName: document.getElementById('modalStudentName'),
            modalStudentId: document.getElementById('modalStudentId')
        };
        
        console.log('Elements found:');
        console.log('- searchInput:', this.elements.searchInput);
        console.log('- searchBtn:', this.elements.searchBtn);
        console.log('- studentGrid:', this.elements.studentGrid);
        console.log('- modalOverlay:', this.elements.modalOverlay);
        console.log('- modalCloseBtn:', this.elements.modalCloseBtn);
        console.log('- modalStudentName:', this.elements.modalStudentName);
        console.log('- modalStudentId:', this.elements.modalStudentId);
        console.log('- detailsTab:', this.elements.detailsTab);
        console.log('- historyTab:', this.elements.historyTab);
        
        // Verify critical elements exist
        if (!this.elements.studentGrid || !this.elements.searchBtn) {
            console.error('Critical HTML elements not found');
        }
        
        // Initialize follow-up form
        this.followupForm = document.getElementById('followupForm');
        this.followupFormTab = document.getElementById('followupFormTab');
        console.log('- followupForm:', this.followupForm);
        console.log('- followupFormTab:', this.followupFormTab);
        
        // Check for details grid
        const detailsGrid = document.querySelector('.details-grid');
        console.log('- details-grid:', detailsGrid);
    }

    // Attach event listeners
    attachEventListeners() {
        if (!this.elements.searchBtn || !this.elements.searchInput) {
            console.error('Search elements not found');
            return;
        }
        
        // Search functionality
        this.elements.searchBtn.addEventListener('click', () => this.handleSearch());
        this.elements.searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') this.handleSearch();
        });

        // Modal controls
        if (this.elements.modalCloseBtn) {
            this.elements.modalCloseBtn.addEventListener('click', () => this.closeModal());
        }
        if (this.elements.modalOverlay) {
            this.elements.modalOverlay.addEventListener('click', (e) => {
                if (e.target === this.elements.modalOverlay) this.closeModal();
            });
        }

        // Tab buttons
        this.elements.tabButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const tab = e.target.closest('.tab-button')?._dataset?.tab || e.target.dataset.tab;
                if (tab) this.switchTab(tab);
            });
        });

        // Follow-up form submission
        if (this.followupForm) {
            this.followupForm.addEventListener('submit', (e) => this.handleFollowUpSubmit(e));
            console.log('Follow-up form submit listener attached');
        }
    }

    // Fetch students from backend
    async loadStudents(searchQuery = '') {
        console.log('=== loadStudents() START ===');
        this.showLoading(true);
        try {
            console.log('Fetching students with query:', searchQuery);
            const response = await fetch('fetch-students.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ search: searchQuery })
            });

            console.log('Fetch response received, status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Fetch response:', data);
            console.log('Data.success:', data.success);
            console.log('Data.students:', data.students);
            console.log('Data.students.length:', data.students?.length);
            
            if (data.success && data.students && data.students.length > 0) {
                console.log('Students found, setting this.students and calling renderStudents()');
                this.students = data.students;
                console.log('this.students is now:', this.students);
                this.renderStudents();
            } else {
                console.warn('No students found or error in response');
                this.showEmptyState(true);
                this.students = [];
            }
        } catch (error) {
            console.error('Fetch error:', error);
            console.error('Error details:', error.message);
            this.showEmptyState(true);
            this.students = [];
        } finally {
            this.showLoading(false);
            console.log('=== loadStudents() END ===');
        }
    }



    // Render students grid
    renderStudents() {
        const grid = this.elements.studentGrid;
        console.log('=== renderStudents() START ===');
        console.log('renderStudents called with students:', this.students.length);
        console.log('studentGrid element:', grid);
        console.log('studentGrid element HTML before clear:', grid?.innerHTML.substring(0, 100));
        console.log('studentGrid visibility:', grid ? window.getComputedStyle(grid).visibility : 'not found');
        console.log('studentGrid display:', grid ? window.getComputedStyle(grid).display : 'not found');
        
        // Check parent container
        const contentArea = document.querySelector('.content-area');
        console.log('content-area element:', contentArea);
        console.log('content-area display:', contentArea ? window.getComputedStyle(contentArea).display : 'not found');
        console.log('content-area visibility:', contentArea ? window.getComputedStyle(contentArea).visibility : 'not found');
        
        // Force grid visibility
        if (grid) {
            grid.style.display = 'grid';
            grid.style.visibility = 'visible';
            console.log('Grid forced to display: grid and visibility: visible');
        } else {
            console.error('GRID NOT FOUND! Cannot render students');
            return;
        }
        
        grid.innerHTML = '';
        console.log('Grid cleared, innerHTML length:', grid?.innerHTML.length);

        if (this.students.length === 0) {
            console.log('No students, showing empty state');
            this.showEmptyState(true);
            console.log('=== renderStudents() END (empty) ===');
            return;
        }

        console.log('Showing students grid, hiding empty state');
        this.showEmptyState(false);

        this.students.forEach((student, index) => {
            try {
                const card = this.createStudentCard(student, index);
                console.log('Card created:', card);
                console.log('Card HTML:', card.outerHTML.substring(0, 200));
                grid.appendChild(card);
                console.log('Added card for student:', student.FirstName, student.LastName);
                console.log('Grid current HTML length:', grid.innerHTML.length);
                console.log('Grid current child count:', grid.children.length);
            } catch (error) {
                console.error('Error creating card for student:', student, error);
            }
        });
        
        console.log('Rendered', this.students.length, 'student cards');
        console.log('Final grid innerHTML length:', grid.innerHTML.length);
        console.log('Final grid child count:', grid.children.length);
        console.log('Grid computed display:', window.getComputedStyle(grid).display);
        console.log('Grid computed visibility:', window.getComputedStyle(grid).visibility);
        console.log('Grid offsetParent:', grid.offsetParent);
        console.log('Grid offsetHeight:', grid.offsetHeight);
        console.log('Grid offsetWidth:', grid.offsetWidth);
        console.log('=== renderStudents() END ===');
    }

    // Create student card element
    createStudentCard(student, index) {
        console.log('createStudentCard called for student:', student);
        const card = document.createElement('div');
        const gradientClass = this.gradients[index % this.gradients.length];
        console.log('Gradient class assigned:', gradientClass);
        
        card.className = `student-card ${gradientClass}`;
        console.log('Card className:', card.className);
        
        const fullName = `${student.FirstName} ${student.LastName}`;
        const initials = `${student.FirstName[0]}${student.LastName[0]}`;

        card.innerHTML = `
            <div class="card-content">
                <div class="card-avatar">${initials}</div>
                <div class="card-info">
                    <h3>${fullName}</h3>
                    <p>ID: ${student.StudentId}</p>
                    <p>${student.CurrentAddress}</p>
                </div>
            </div>
            <div class="card-action">🔍</div>
        `;

        // Force visibility with inline styles
        card.style.display = 'flex';
        card.style.visibility = 'visible';
        card.style.minHeight = '100px';

        console.log('Card innerHTML set');
        console.log('Card computed style display:', window.getComputedStyle(card).display);
        console.log('Card computed style background:', window.getComputedStyle(card).background.substring(0, 50));

        card.addEventListener('click', () => this.viewStudent(student));
        console.log('Click listener attached to card');
        return card;
    }

    // View student details
    async viewStudent(student) {
        console.log('viewStudent called for:', student.FirstName, student.LastName);
        this.selectedStudent = student;
        await this.loadFollowUpHistory(student.StudentId);
        console.log('Calling showModal');
        this.showModal();
        this.populateModalHeader(student);
        this.populateModalDetails(student);
        console.log('Student details populated and modal shown');
    }

    // Show modal
    showModal() {
        console.log('showModal called');
        console.log('modalOverlay element:', this.elements.modalOverlay);
        console.log('modalOverlay classes before:', this.elements.modalOverlay?.className);
        
        if (this.elements.modalOverlay) {
            // Remove the hidden class
            this.elements.modalOverlay.classList.remove('hidden');
            // Force display: flex directly on the element with !important
            this.elements.modalOverlay.style.setProperty('display', 'flex', 'important');
            console.log('Modal hidden class removed and display set to flex with !important');
            console.log('modalOverlay classes after:', this.elements.modalOverlay.className);
            console.log('modalOverlay style.display:', this.elements.modalOverlay.style.display);
            console.log('Computed display style:', window.getComputedStyle(this.elements.modalOverlay).display);
            console.log('Computed visibility:', window.getComputedStyle(this.elements.modalOverlay).visibility);
            console.log('Computed position:', window.getComputedStyle(this.elements.modalOverlay).position);
            console.log('Computed z-index:', window.getComputedStyle(this.elements.modalOverlay).zIndex);
            console.log('modalOverlay offsetParent:', this.elements.modalOverlay.offsetParent);
            console.log('modalOverlay offsetWidth:', this.elements.modalOverlay.offsetWidth);
            console.log('modalOverlay offsetHeight:', this.elements.modalOverlay.offsetHeight);
        } else {
            console.error('Modal overlay element not found!');
        }
        // Switch to details tab
        this.switchTab('details');
    }

    // Close modal
    closeModal() {
        console.log('closeModal called');
        this.elements.modalOverlay.classList.add('hidden');
        this.elements.modalOverlay.style.setProperty('display', 'none', 'important');
        console.log('Modal hidden class added and display set to none with !important');
        this.selectedStudent = null;
        this.followUpHistory = [];
    }

    // Populate modal header
    populateModalHeader(student) {
        console.log('populateModalHeader called with student:', student);
        const fullName = `${student.FirstName} ${student.LastName}`;
        const initials = `${student.FirstName[0]}${student.LastName[0]}`;
        
        console.log('Setting modal student name:', fullName);
        console.log('Modal name element:', this.elements.modalStudentName);
        if (this.elements.modalStudentName) {
            this.elements.modalStudentName.textContent = fullName;
        } else {
            console.warn('modalStudentName element not found');
        }
        
        console.log('Setting modal student ID:', student.StudentId);
        console.log('Modal ID element:', this.elements.modalStudentId);
        if (this.elements.modalStudentId) {
            this.elements.modalStudentId.textContent = `Student ID: ${student.StudentId}`;
        } else {
            console.warn('modalStudentId element not found');
        }
        
        // Update avatar
        const avatar = document.querySelector('.modal-avatar');
        console.log('Modal avatar element:', avatar);
        if (avatar) {
            avatar.textContent = initials;
            console.log('Avatar updated with initials:', initials);
        } else {
            console.warn('modal-avatar element not found');
        }
    }

    // Populate modal details
    populateModalDetails(student) {
        console.log('populateModalDetails called with student:', student);
        const detailsGrid = document.querySelector('.details-grid');
        console.log('Details grid element:', detailsGrid);
        console.log('Details grid parent:', detailsGrid?.parentElement);
        
        if (!detailsGrid) {
            console.error('Details grid (.details-grid) not found in DOM!');
            console.log('Searching for all divs with "grid" in class:');
            const allGrids = document.querySelectorAll('[class*="grid"]');
            console.log('Found grids:', allGrids);
            return;
        }
        
        detailsGrid.innerHTML = '';
        console.log('Details grid cleared, empty grid HTML:', detailsGrid.outerHTML);

        const details = [
            { label: 'Email', value: 'N/A', icon: '✉️' },
            { label: 'Phone', value: student.CellphoneNumber || 'N/A', icon: '📱' },
            { label: 'Address', value: student.CurrentAddress || 'N/A', icon: '📍' },
            { label: 'Date of Birth', value: student.DateOfBirth || 'N/A', icon: '📅' },
            { label: 'Age', value: student.Age || 'N/A', icon: '👤' },
            { label: 'Sex', value: student.Sex || 'N/A', icon: '⚧' },
            { label: 'Place of Birth', value: student.PlaceOfBirth || 'N/A', icon: '🌍' },
            { label: 'Religion', value: student.CurrentReligion || 'N/A', icon: '✝️' },
            { label: 'LRN', value: student.LRN || 'N/A', icon: '🔢' },
            { label: 'Middle Name', value: student.MiddleName || 'N/A', icon: '📝' }
        ];

        console.log('Adding', details.length, 'detail cards');
        details.forEach((detail, index) => {
            try {
                const card = document.createElement('div');
                card.className = 'info-card';
                card.innerHTML = `
                    <div class="info-card-icon">${detail.icon}</div>
                    <div class="info-card-label">${detail.label}</div>
                    <div class="info-card-value">${detail.value}</div>
                `;
                detailsGrid.appendChild(card);
                console.log(`Added detail card ${index + 1}: ${detail.label} = ${detail.value}`);
            } catch (error) {
                console.error(`Error adding detail card ${index}:`, error);
            }
        });
        
        console.log('All detail cards added to grid');
        console.log('Grid innerHTML length:', detailsGrid.innerHTML.length);
        console.log('Grid child count:', detailsGrid.children.length);
        console.log('Grid HTML sample:', detailsGrid.innerHTML.substring(0, 300));

        // Add status badge
        const statusCard = document.createElement('div');
        statusCard.className = 'info-card';
        statusCard.innerHTML = `
            <div class="status-badge">
                <span class="status-dot"></span>
                <span>Active</span>
            </div>
        `;
        detailsGrid.appendChild(statusCard);
        console.log('Status badge added');
        console.log('Final grid child count:', detailsGrid.children.length);
    }

    // Load follow-up history
    async loadFollowUpHistory(studentId) {
        console.log('loadFollowUpHistory called with studentId:', studentId);
        try {
            const response = await fetch('fetch-followup.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ studentId })
            });

            const data = await response.json();
            console.log('Follow-up history response:', data);
            
            if (data.success) {
                this.followUpHistory = data.history;
                console.log('Follow-up history loaded:', this.followUpHistory.length, 'records');
            } else {
                console.warn('Failed to load follow-up history:', data.message);
                this.followUpHistory = [];
            }
        } catch (error) {
            console.error('Error loading follow-up history:', error);
            this.followUpHistory = [];
        }

        this.updateHistoryCount();
    }

    // Update history count
    updateHistoryCount() {
        this.elements.historyCount.textContent = this.followUpHistory.length;
    }

    // Render follow-up history
    renderFollowUpHistory() {
        this.elements.historyContent.innerHTML = '';

        if (this.followUpHistory.length === 0) {
            this.elements.historyContent.innerHTML = `
                <div class="empty-history">
                    <div class="empty-history-icon">📄</div>
                    <p>No follow-up history available</p>
                </div>
            `;
            return;
        }

        this.followUpHistory.forEach(record => {
            const historyCard = document.createElement('div');
            historyCard.className = 'followup-card';
            
            const statusClass = record.status === 'Completed' ? 'completed' : 'pending';
            const nextFollowUpHTML = record.nextFollowUp ? 
                `<div class="followup-next">➜ Next Follow-up: ${new Date(record.nextFollowUp).toLocaleDateString()}</div>` : '';

            historyCard.innerHTML = `
                <div class="followup-header">
                    <div class="followup-left">
                        <span class="followup-status ${statusClass}">${record.status}</span>
                        <span class="followup-type">${record.type}</span>
                    </div>
                    <div class="followup-date">
                        📅 ${new Date(record.date).toLocaleDateString()}
                    </div>
                </div>
                <div class="followup-body">
                    <div class="followup-counselor">
                        👤 <span class="font-medium">Counselor:</span> ${record.counselor}
                    </div>
                    <div class="followup-notes">
                        <div class="followup-notes-label">Notes:</div>
                        <p>${record.notes}</p>
                    </div>
                    ${nextFollowUpHTML}
                </div>
            `;

            this.elements.historyContent.appendChild(historyCard);
        });
    }

    // Switch tab
    switchTab(tabName) {
        console.log('switchTab called with tabName:', tabName);
        // Update tab buttons
        this.elements.tabButtons.forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.tab === tabName) {
                btn.classList.add('active');
            }
        });

        // Update tab content
        if (tabName === 'details') {
            this.elements.detailsTab.classList.add('active');
            this.elements.historyTab.classList.remove('active');
            this.followupFormTab.classList.remove('active');
        } else if (tabName === 'history') {
            this.elements.detailsTab.classList.remove('active');
            this.elements.historyTab.classList.add('active');
            this.followupFormTab.classList.remove('active');
            this.renderFollowUpHistory();
        } else if (tabName === 'followup-form') {
            this.elements.detailsTab.classList.remove('active');
            this.elements.historyTab.classList.remove('active');
            this.followupFormTab.classList.add('active');
            this.prepareFollowUpForm();
        }
    }

    // Handle search
    handleSearch() {
        this.searchQuery = this.elements.searchInput?.value?.trim() || '';
        console.log('Search query:', this.searchQuery);
        this.loadStudents(this.searchQuery);
    }

    // Show/hide loading spinner
    showLoading(show) {
        this.elements.loadingSpinner.style.display = show ? 'flex' : 'none';
    }

    // Show/hide empty state
    showEmptyState(show) {
        this.elements.emptyState.style.display = show ? 'block' : 'none';
    }

    // Prepare follow-up form (set student info)
    prepareFollowUpForm() {
        if (!this.selectedStudent) return;
        console.log('prepareFollowUpForm called for student:', this.selectedStudent);
        // Set today's date as default
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('followupDate').value = today;
    }

    // Handle follow-up form submission
    async handleFollowUpSubmit(e) {
        e.preventDefault();
        if (!this.selectedStudent) {
            alert('No student selected');
            return;
        }

        console.log('handleFollowUpSubmit called');
        const formData = {
            studentId: this.selectedStudent.StudentId,
            type: document.getElementById('followupType').value,
            status: document.getElementById('followupStatus').value,
            date: document.getElementById('followupDate').value,
            notes: document.getElementById('followupNotes').value,
            nextFollowUp: document.getElementById('nextFollowupDate').value,
            counselor: 'Current Counselor' // You can get this from session/auth
        };

        console.log('Follow-up data to save:', formData);

        try {
            const response = await fetch('save-followup.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();
            console.log('Save response:', result);

            if (result.success) {
                // Show success message
                alert('Follow-up saved successfully!');
                // Reset form
                this.followupForm.reset();
                // Reload follow-up history
                await this.loadFollowUpHistory(this.selectedStudent.StudentId);
                // Switch to history tab to show new entry
                this.switchTab('history');
            } else {
                alert('Error saving follow-up: ' + result.message);
            }
        } catch (error) {
            console.error('Error saving follow-up:', error);
            alert('Error saving follow-up. Check console for details.');
        }
    }
}

// Initialize app when DOM is loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        console.log('=== StudentProfileApp: DOM Ready Event ===');
        window.studentProfileApp = new StudentProfileApp();
    });
} else {
    console.log('=== StudentProfileApp: DOM Already Ready ===');
    window.studentProfileApp = new StudentProfileApp();
}
