<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>School Portal | Login</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0f3c68, #1c6bb3);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .card {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }

        .form-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .form-header h1 {
            color: #0f3c68;
            margin-bottom: 5px;
        }

        .form-header p {
            color: #555;
            font-size: 14px;
        }

        .form {
            display: none;
        }

        .form.active {
            display: block;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 5px;
            color: #333;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            outline: none;
            font-size: 14px;
        }

        .input-group input:focus {
            border-color: #1c6bb3;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #1c6bb3;
            border: none;
            border-radius: 6px;
            color: white;
            font-weight: bold;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #0f3c68;
        }

        .switch {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .switch span {
            color: #1c6bb3;
            font-weight: bold;
            cursor: pointer;
        }

        /* TOAST NOTIFICATION */
        #toast {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0.9);

    min-width: 260px;
    max-width: 340px;
    padding: 16px 22px;

    background: #0f3c68;
    color: #fff;
    border-radius: 12px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.3);

    font-size: 15px;
    font-weight: 500;
    text-align: center;

    opacity: 0;
    pointer-events: none;
    transition: all 0.35s ease;
    z-index: 999;
}

#toast.show {
    opacity: 1;
    transform: translate(-50%, -50%) scale(1);
}

#toast.success { background: #2e8b57; }
#toast.error   { background: #c0392b; }
#toast.info    { background: #1c6bb3; }

    </style>
</head>

<body>

<div class="container">
    <div class="card">

        <div class="form-header">
            <h1 id="formTitle">School Portal</h1>
            <p id="formSubtitle">Login to your account</p>
        </div>

        <!-- LOGIN FORM -->
        <form id="loginForm" class="form active" action="counsilor.php">
            <div class="input-group">
                <label>Email</label>
                <input type="email" id="loginEmail" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" id="loginPassword" required>
            </div>

            <button type="submit">Login</button>

            <p class="switch">
                Don't have an account?
                <span onclick="showRegister()">Register</span>
            </p>
        </form>

        <!-- REGISTER FORM -->
        <form id="registerForm" class="form">
            <div class="input-group">
                <label>Full Name</label>
                <input type="text" id="regName" required>
            </div>

            <div class="input-group">
                <label>Email</label>
                <input type="email" id="regEmail" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" id="regPassword" required>
            </div>

            <div class="input-group">
                <label>Confirm Password</label>
                <input type="password" id="regConfirm" required>
            </div>

            <button type="submit">Create Account</button>

            <p class="switch">
                Already have an account?
                <span onclick="showLogin()">Login</span>
            </p>
        </form>

    </div>
</div>

<!-- TOAST -->
<div id="toast"></div>

<script>
    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");
    const title = document.getElementById("formTitle");
    const subtitle = document.getElementById("formSubtitle");

    function showRegister() {
        loginForm.classList.remove("active");
        registerForm.classList.add("active");
        title.textContent = "Student Registration";
        subtitle.textContent = "Create a new account";
    }

    function showLogin() {
        registerForm.classList.remove("active");
        loginForm.classList.add("active");
        title.textContent = "School Portal";
        subtitle.textContent = "Login to your account";
    }

    function showToast(message, type = "info") {
        const toast = document.getElementById("toast");
        toast.textContent = message;
        toast.className = "";
        toast.classList.add("show", type);

        setTimeout(() => {
            toast.classList.remove("show");
        }, 3000);
    }

    loginForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const email = loginEmail.value.trim();
        const password = loginPassword.value.trim();

        // if (!email || !password) {
        //     showToast("Please fill in all login fields", "error");
        //     return;
        // }
        redirect to counsilor.php //path way to other page
        showToast("Login successful!", "success");
    });

    registerForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const password = regPassword.value;
        const confirm = regConfirm.value;

        if (password !== confirm) {
            showToast("Passwords do not match", "error");
            return;
        }

        showToast("Registration successful!", "success");
        showLogin();
    });
</script>

</body>
</html>
