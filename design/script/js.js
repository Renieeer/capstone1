function myFunction() {
  window.location.href = "action/login.php";
}

function openLogin() {
    document.getElementById("overlay").style.display = "block";
    document.getElementById("loginModal").style.display = "block";
}

function closeLogin() {
    document.getElementById("overlay").style.display = "none";
    document.getElementById("loginModal").style.display = "none";
}
