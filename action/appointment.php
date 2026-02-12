<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Guidance Appointment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="../design/css/sidebar-student.css">

</head>
<body>
<div class="layout">
    <?php include 'sidebarST.php'; ?>
    <!-- SIDEBAR (Keep your existing sidebar here) -->

    <!-- MAIN CONTENT -->
    <main class="main">

        <div class="form-container">

            <h2 class="form-title">
                <i class="fa-solid fa-calendar-check"></i>
                Guidance Appointment
            </h2>

            <!-- STUDENT INFORMATION -->
            <div class="form-box">
                <h3>Student Information</h3>

                <table class="form-table">
                    <tr>
                        <th>Full Name</th>
                        <td><input type="text" id="studentName" required></td>
                    </tr>
                    <tr>
                        <th>Grade & Section</th>
                        <td><input type="text" id="studentSection" required></td>
                    </tr>
                    <tr>
                        <th>Student ID</th>
                        <td><input type="text" id="studentId"></td>
                    </tr>
                </table>
            </div>

            <!-- APPOINTMENT DETAILS -->
            <div class="form-box">
                <h3>Appointment Details</h3>

                <table class="form-table">
                    <tr>
                        <th>Preferred Date</th>
                        <td><input type="date" id="appointmentDate" required></td>
                    </tr>
                    <tr>
                        <th>Preferred Time</th>
                        <td>
                            <select id="appointmentTime" required>
                                <option value="">Select Time</option>
                                <option>8:00 AM</option>
                                <option>9:00 AM</option>
                                <option>10:00 AM</option>
                                <option>11:00 AM</option>
                                <option>1:00 PM</option>
                                <option>2:00 PM</option>
                                <option>3:00 PM</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Reason for Appointment</th>
                        <td>
                            <textarea id="appointmentReason" rows="4" required></textarea>
                        </td>
                    </tr>
                </table>
                <!-- ACTION BUTTON -->
                <div class="form-actions">
                    <button type="button" class="submit-btn" onclick="bookAppointment()">
                        <i class="fa-solid fa-paper-plane"></i>
                        Submit Appointment
                    </button>
                </div>
            </div>
        </div>  
    </main>
</div>

<script>
const form = document.getElementById("appointmentForm");
const list = document.getElementById("appointmentList");

let appointments = JSON.parse(localStorage.getItem("appointments")) || [];

function displayAppointments(){
    list.innerHTML = "";
    appointments.forEach(app => {
        list.innerHTML += `
        <tr>
            <td>${app.name}</td>
            <td>${app.section}</td>
            <td>${app.date}</td>
            <td>${app.time}</td>
            <td>${app.reason}</td>
        </tr>`;
    });
}

form.addEventListener("submit", function(e){
    e.preventDefault();

    const appointment = {
        name: document.getElementById("name").value,
        section: document.getElementById("section").value,
        date: document.getElementById("date").value,
        time: document.getElementById("time").value,
        reason: document.getElementById("reason").value
    };

    appointments.push(appointment);
    localStorage.setItem("appointments", JSON.stringify(appointments));

    form.reset();
    displayAppointments();
});

displayAppointments();
</script>
<script src="../design/script/sidebar-student.js"></script>
</body>
</html>