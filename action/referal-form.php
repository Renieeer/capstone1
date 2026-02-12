<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Referral System</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    
 <link rel="stylesheet" href="../design/css/sidebar-student.css">
<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

body{
    background:#f4f6fb;
    display:flex;
}
/* STEPS */
.steps{
    position:relative;
    display:flex;
    justify-content:space-between;
    margin:40px 0;
}

.progress-line{
    position:absolute;
    top:35px;
    left:5%;
    right:5%;
    height:4px;
    background:#e5e7eb;
    z-index:0;
}

.progress-fill{
    position:absolute;
    top:35px;
    left:5%;
    height:4px;
    background:#d9534f;
    width:0%;
    z-index:1;
    transition:.4s;
}

.step{
    text-align:center;
    width:150px;
    cursor:pointer;
    z-index:2;
}

.circle{
    width:70px;
    height:70px;
    border-radius:50%;
    background:#e5e7eb;
    display:flex;
    justify-content:center;
    align-items:center;
    margin:0 auto;
    font-size:22px;
    color:#555;
    transition:.3s;
}

.step.active .circle{
    background:#d9534f;
    color:#fff;
}

.step p{
    font-size:13px;
    margin-top:10px;
}

/* CONTENT AREA */
.content{
    background:#fff;
    padding:30px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
    min-height:200px;
}

.section{
    display:none;
    animation:fade .3s ease-in-out;
}

.section.active{
    display:block;
}

@keyframes fade{
    from{opacity:0; transform:translateY(10px);}
    to{opacity:1; transform:translateY(0);}
}

/* BUTTONS */
.buttons{
    margin-top:25px;
    display:flex;
    justify-content:space-between;
}

button{
    padding:10px 25px;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

.prev{
    background:#e5e7eb;
}

.next{
    background:#d9534f;
    color:#fff;
}
</style>
</head>
<body>

<?php include 'sidebarST.php'; ?>

<!-- MAIN CONTENT -->
<div class="main">

    <div class="header">
        <h1>REFERRAL SYSTEM</h1>
        <p>Oriental Mindoro National High School Care Center</p>
    </div>

    <!-- STEP PROGRESS -->
    <div class="steps">
        <div class="progress-line"></div>
        <div class="progress-fill" id="progressFill"></div>

        <div class="step active" data-step="0">
            <div class="circle"><i class="fa fa-folder-open"></i></div>
            <p>Admission</p>
        </div>

        <div class="step" data-step="1">
            <div class="circle"><i class="fa fa-search"></i></div>
            <p>Screening</p>
        </div>

        <div class="step" data-step="2">
            <div class="circle"><i class="fa fa-file-signature"></i></div>
            <p>Consent</p>
        </div>

        <div class="step" data-step="3">
            <div class="circle"><i class="fa fa-clipboard-check"></i></div>
            <p>Assessment</p>
        </div>

        <div class="step" data-step="4">
            <div class="circle"><i class="fa fa-users"></i></div>
            <p>Conference</p>
        </div>

        <div class="step" data-step="5">
            <div class="circle"><i class="fa fa-hospital"></i></div>
            <p>External Referral</p>
        </div>
    </div>

    <!-- CONTENT AREA -->
    <div class="content">

        <div class="section active">
            <h3>Admission of Case for Referral</h3>
            <p>Walk-in or referred by Adviser, Subject Teacher, or Student.</p>
        </div>

        <div class="section">
            <h3>Initial Screening by Counselor</h3>
            <p>Interview, Observation, Risk Level Assessment.</p>
        </div>

        <div class="section">
            <h3>Parent Consent</h3>
            <p>Consent required for Assessment and Interventions.</p>
        </div>

        <div class="section">
            <h3>Assessment Proper</h3>
            <p>Tools: GAD-7, PHQ, Columbia Scale, HEADSSS.</p>
        </div>

        <div class="section">
            <h3>Parent Conference / Discussion</h3>
            <p>Presentation of Results and Initial Intervention Plan.</p>
        </div>

        <div class="section">
            <h3>External Referral</h3>
            <p>If necessary, student is referred to external specialists.</p>
        </div>

        <div class="buttons">
            <button class="prev">Prev</button>
            <button class="next">Next</button>
        </div>

    </div>

</div>

<script>
const steps = document.querySelectorAll(".step");
const sections = document.querySelectorAll(".section");
const progressFill = document.getElementById("progressFill");
const nextBtn = document.querySelector(".next");
const prevBtn = document.querySelector(".prev");

let current = 0;

function updateUI(){
    steps.forEach(step => step.classList.remove("active"));
    sections.forEach(sec => sec.classList.remove("active"));

    steps[current].classList.add("active");
    sections[current].classList.add("active");

    let percent = (current / (steps.length - 1)) * 90;
    progressFill.style.width = percent + "%";
}

steps.forEach(step=>{
    step.addEventListener("click", ()=>{
        current = parseInt(step.dataset.step);
        updateUI();
    });
});

nextBtn.onclick = ()=>{
    if(current < steps.length-1){
        current++;
        updateUI();
    }
}

prevBtn.onclick = ()=>{
    if(current > 0){
        current--;
        updateUI();
    }
}
</script>
<script src="../design/script/sidebar-student.js"></script>

</body>
</html>