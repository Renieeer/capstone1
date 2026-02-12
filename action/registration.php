<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- OVERLAY -->
    <div id="overlay" onclick="closeLogin()"></div>

    <!-- LOGIN MODAL -->
    <div id="loginModal">
        <h2 class="modal-title">Register</h2>
        <p class="modal-subtitle">Welcome Please Register Account</p>
                                                                                   
        <form id="loginForm" class="login-form" method="post" action="dashST.php">     <!-- change filepath  -->
            <div class="form-row">
                <label for="username">Email</label>
                <input id="username" name="username" type="text" placeholder="your@email.com" required>
            </div>

            <div class="form-row">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" placeholder="Password" required>
            </div>

            <div class="actions">
                <div>
                    <label style="font-size:13px;"><input type="checkbox" name="remember"> Remember me</label>
                </div>
                <div>
                    <button type="button" class="secondary" onclick="closeLogin()">Forgot password?</button>
                </div>
            </div>

            <div style="margin-top:12px;">
                <button type="submit" class="btn-primary">Sign In</button>
            </div>

            <div class="divider">Or continue with</div>

            <div class="socials">
                <button type="button"><img src="" alt=""> Google</button>
                <button type="button"><img src="" alt=""> GitHub</button>
            </div>

            <p style="text-align:center; color:#6b7280; margin-top:14px;">Don't have an account? <a href="Login.php">Sign up</a></p>
        </form>

    </div>



    <script src="design/js.js"></script>
</body>
</html>