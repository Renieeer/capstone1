<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro De Child Promotional And Advance Infant School - Enrollment Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@400;600;700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #2c5f2d;
            --secondary: #97bf0d;
            --accent: #ffd166;
            --text: #1a1a1a;
            --text-light: #666;
            --bg: #fafaf9;
            --white: #ffffff;
            --border: #e0e0db;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: linear-gradient(135deg, #f5f7f3 0%, #e8ebe4 100%);
            color: var(--text);
            line-height: 1.6;
            min-height: 100vh;
            padding: 2rem 1rem;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(44, 95, 45, 0.08);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            background: linear-gradient(135deg, var(--primary) 0%, #1e4620 100%);
            color: var(--white);
            padding: 3rem 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(151, 191, 13, 0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        .header h1 {
            font-family: 'Crimson Pro', serif;
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
            position: relative;
            z-index: 1;
        }

        .header p {
            font-size: 1rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .form-content {
            padding: 2.5rem;
        }

        .section-title {
            font-family: 'Crimson Pro', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary);
            margin: 2rem 0 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--secondary);
            display: inline-block;
        }

        .section-title:first-child {
            margin-top: 0;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        label {
            font-weight: 500;
            color: var(--text);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        input[type="text"],
        input[type="date"],
        input[type="tel"],
        input[type="email"],
        select,
        textarea {
            padding: 0.875rem 1rem;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--bg);
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        input[type="tel"]:focus,
        input[type="email"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--secondary);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(151, 191, 13, 0.1);
        }

        select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%232c5f2d' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1.25rem;
            padding-right: 2.5rem;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        .signature-section {
            margin-top: 2rem;
            padding: 1.5rem;
            background: var(--bg);
            border-radius: 12px;
            border: 2px dashed var(--border);
        }

        .signature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 1rem;
        }

        .submit-section {
            margin-top: 2.5rem;
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        button {
            padding: 1rem 2.5rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--secondary) 0%, #82a50c 100%);
            color: var(--white);
            box-shadow: 0 4px 15px rgba(151, 191, 13, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(151, 191, 13, 0.4);
        }

        .btn-secondary {
            background: var(--white);
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-secondary:hover {
            background: var(--primary);
            color: var(--white);
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 1.75rem;
            }

            .form-content {
                padding: 1.5rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .submit-section {
                flex-direction: column;
            }

            button {
                width: 100%;
            }
        }

        .required {
            color: #e74c3c;
        }

        .helper-text {
            font-size: 0.85rem;
            color: var(--text-light);
            margin-top: 0.25rem;
        }

        .checkbox-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .checkbox-category {
            background: var(--bg);
            padding: 1.25rem;
            border-radius: 12px;
            border: 2px solid var(--border);
            transition: all 0.3s ease;
        }

        .checkbox-category:hover {
            border-color: var(--secondary);
            box-shadow: 0 4px 12px rgba(151, 191, 13, 0.1);
        }

        .category-title {
            font-family: 'Crimson Pro', serif;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--secondary);
        }

        .checkbox-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 6px;
            transition: background 0.2s ease;
        }

        .checkbox-item:hover {
            background: rgba(151, 191, 13, 0.05);
        }

        .checkbox-item input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: var(--secondary);
            flex-shrink: 0;
        }

        .checkbox-item span {
            font-size: 0.95rem;
            color: var(--text);
        }

        .specify-input {
            flex: 1;
            padding: 0.4rem 0.75rem;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 0.9rem;
            background: var(--white);
            min-width: 150px;
        }

        .specify-input:focus {
            outline: none;
            border-color: var(--secondary);
            box-shadow: 0 0 0 2px rgba(151, 191, 13, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Centro De Child Promotional And Advance Infant School</h1>
            <p>Follow-Up Form | Academic Year: ____</p>
        </div>

        <div class="form-content">
            <form id="enrollmentForm">
                <!-- Student Information -->
                <div class="section-title">Name of Patient</div>
                <div class="form-grid">
                    <div form="lastName" class="form-group">
                        <label for="lastName">Last Name <span class="required">*</span></label>
                        <input type="text" id="lastName" name="lastName" required>
                    </div>
                    <div class="form-group">
                        <label for="firtsName">First Name<span class="required">*</span></label>
                        <input type="text" name="fisrstName" id="firstName" required>
                    </div>
                    <div form="middleName" class="form-group">
                        <label for="middleName">Middle Name</label>
                        <input type="text" id="middleName" name="middleName" maxlength="2">   
                    </div>

                    <div class="form-group">
                        <label for="givenName">Given</label>
                        <input type="text" id="givenName" name="givenName">
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="section-title">Contact Number</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="contactNumber">Contact Number</label>
                        <input type="tel" id="contactNumber" name="contactNumber" placeholder="09XX-XXX-XXXX">
                    </div>
                    <div class="form-group">
                        <label for="clientName">Name of Client</label>
                        <input type="text" id="clientName" name="clientName">
                    </div>
                </div>

                <!-- Problem Details -->
                <div class="section-title">Nature of Problem</div>
                
                <div class="checkbox-grid">
                    <!-- CAR Section -->
                    <div class="checkbox-category">
                        <h3 class="category-title">CAR (Children at Risk)</h3>
                        <div class="checkbox-list">
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="Violation of City Ordinances">
                                <span>Violation of City Ordinances</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="Membership of gang/group not recognized">
                                <span>Membership of any gang/group not recognized by the school</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="Bringing deadly weapon">
                                <span>Bringing deadly weapon</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="Bringing illegal drugs">
                                <span>Bringing illegal drugs/and the like</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="Quarreling">
                                <span>Quarreling</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="Living in high-risk environment">
                                <span>Living in high-risk environment</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="Gambling">
                                <span>Gambling</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="CICL" id="ciclCheck">
                                <span>CICL, Specify:</span>
                                <input type="text" name="ciclSpecify" id="ciclSpecify" class="specify-input" placeholder="Specify...">
                            </label>
                        </div>
                    </div>

                    <!-- Bullying Section -->
                    <div class="checkbox-category">
                        <h3 class="category-title">BULLYING</h3>
                        <div class="checkbox-list">
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="Bullying - Physical">
                                <span>Physical</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="Bullying - Verbal">
                                <span>Verbal</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="Bullying - Emotional">
                                <span>Emotional</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="Bullying - Cyber">
                                <span>Cyber</span>
                            </label>
                        </div>
                    </div>

                    <!-- Abuse and Neglect Section -->
                    <div class="checkbox-category">
                        <h3 class="category-title">ABUSE AND NEGLECT</h3>
                        <div class="checkbox-list">
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="Abuse - Sexual">
                                <span>Sexual</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="Abuse - Physical">
                                <span>Physical</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="Abuse - Verbal">
                                <span>Verbal</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="Abuse - Emotional">
                                <span>Emotional</span>
                            </label>
                        </div>
                    </div>

                    <!-- Others Section -->
                    <div class="checkbox-category">
                        <h3 class="category-title">OTHERS</h3>
                        <div class="checkbox-list">
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="Personal" id="personalCheck">
                                <span>Personal (Specify:</span>
                                <input type="text" name="personalSpecify" id="personalSpecify" class="specify-input" placeholder="Specify...">
                                <span>)</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="Educational">
                                <span>Educational</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="Teenage Pregnancy/Impregnator">
                                <span>Teenage Pregnancy/Impregnator</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="Authority" id="authorityCheck">
                                <span>Authority (Specify:</span>
                                <input type="text" name="authoritySpecify" id="authoritySpecify" class="specify-input" placeholder="Specify...">
                                <span>)</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="Behavioral" id="behavioralCheck">
                                <span>Behavioral (Specify:</span>
                                <input type="text" name="behavioralSpecify" id="behavioralSpecify" class="specify-input" placeholder="Specify...">
                                <span>)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Additional Issues -->
                    <div class="checkbox-category">
                        <h3 class="category-title">ADDITIONAL CONCERNS</h3>
                        <div class="checkbox-list">
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="OSAEC">
                                <span>OSAEC</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="CSAEM">
                                <span>CSAEM</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="Mental Health" id="mentalHealthCheck">
                                <span>Mental Health (Specify:</span>
                                <input type="text" name="mentalHealthSpecify" id="mentalHealthSpecify" class="specify-input" placeholder="Specify...">
                                <span>)</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="Suicidal Ideation">
                                <span>Suicidal Ideation</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="problem[]" value="Suicidal Attempt">
                                <span>Suicidal Attempt</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-grid" style="margin-top: 1.5rem;">
                    <div class="form-group">
                        <label for="problemDate">Date</label>
                        <input type="date" id="problemDate" name="problemDate">
                    </div>
                </div>

                <!-- Intervention Details -->
                <div class="section-title">Intervention</div>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="intervention">Intervention</label>
                        <textarea id="intervention" name="intervention" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="interventionDate">Date</label>
                        <input type="date" id="interventionDate" name="interventionDate">
                    </div>
                </div>

                <!-- Action Taken -->
                <div class="section-title">Action Taken</div>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="actionTaken">Action Taken</label>
                        <textarea id="actionTaken" name="actionTaken" rows="3"></textarea>
                    </div>
                </div>

                <!-- Agreement -->
                <div class="section-title">Agreement</div>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="agreement">Agreement</label>
                        <textarea id="agreement" name="agreement" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="agreementDate">Date</label>
                        <input type="date" id="agreementDate" name="agreementDate">
                    </div>
                </div>

                <!-- Signature Section -->
                <div class="signature-section">
                    <div class="section-title" style="margin-top: 0;">Signature</div>
                    <div class="signature-grid">
                        <div class="form-group">
                            <label for="signature">Signature</label>
                            <input type="text" id="signature" name="signature" placeholder="Type your full name">
                            <p class="helper-text">Type your full name as signature</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="submit-section">
                    <button type="submit" class="btn-primary">Submit Form</button>
                    <button type="reset" class="btn-secondary">Clear Form</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('enrollmentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Collect form data
            const formData = new FormData(this);
            const data = {};
            
            // Collect all checked problems
            const problems = [];
            const checkboxes = document.querySelectorAll('input[name="problem[]"]:checked');
            checkboxes.forEach(cb => {
                problems.push(cb.value);
            });
            data.problems = problems;
            
            // Collect other form data
            for (let [key, value] of formData.entries()) {
                if (key !== 'problem[]') {
                    data[key] = value;
                }
            }
            
            // Display success message
            alert('Form submitted successfully!\n\nThank you for completing the guidance form.');
            
            // In a real application, you would send this data to a server
            console.log('Form Data:', data);
            
            // Optionally reset the form
            // this.reset();
        });

        // Enable/disable specify inputs based on checkbox state
        const specifyCheckboxes = {
            'ciclCheck': 'ciclSpecify',
            'personalCheck': 'personalSpecify',
            'authorityCheck': 'authoritySpecify',
            'behavioralCheck': 'behavioralSpecify',
            'mentalHealthCheck': 'mentalHealthSpecify'
        };

        Object.keys(specifyCheckboxes).forEach(checkboxId => {
            const checkbox = document.getElementById(checkboxId);
            const input = document.getElementById(specifyCheckboxes[checkboxId]);
            
            if (checkbox && input) {
                // Initial state
                input.disabled = !checkbox.checked;
                input.style.opacity = checkbox.checked ? '1' : '0.5';
                
                // Toggle on change
                checkbox.addEventListener('change', function() {
                    input.disabled = !this.checked;
                    input.style.opacity = this.checked ? '1' : '0.5';
                    if (!this.checked) {
                        input.value = '';
                    }
                });
            }
        });

        // Add smooth focus effects
        const inputs = document.querySelectorAll('input:not([type="checkbox"]), select, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateX(4px)';
                this.parentElement.style.transition = 'transform 0.3s ease';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateX(0)';
            });
        });
    </script>
</body>
</html>