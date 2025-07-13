<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gamer's Profile Manager</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .video-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 2.5rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            z-index: 1;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            color:rgb(40, 40, 44);
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: #666;
        }

        .form-group input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color:rgb(40, 41, 44);
            box-shadow: 0 0 5px rgba(26,35,126,0.2);
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .remember-me input {
            margin-right: 0.5rem;
        }

        .error-message {
            color: #d32f2f;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            text-align: center;
            padding: 0.5rem;
            background-color: #ffebee;
            border-radius: 5px;
        }

        .login-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg,rgb(31, 31, 34),rgb(26, 26, 26));
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .login-btn:hover {
            transform: translateY(-2px);
        }

        .signup-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .signup-link a {
            color: #1a237e;
            text-decoration: none;
            font-weight: 600;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 1.5rem;
        }

        .forgot-password a {
            color: #666;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .forgot-password a:hover {
            color: #1a237e;
        }
    </style>
</head>
<body>
    <?php
    session_start();

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gamers_profile";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $error_message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if (empty($username) || empty($password)) {
            $error_message = "Please enter both username and password";
        } else {
            try {
                $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE username = ?");
                $stmt->execute([$username]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    // Start session and store user data
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];

                    // If "Remember Me" is checked, set cookie
                    if (isset($_POST['remember_me'])) {
                        setcookie('user_login', $username, time() + (86400 * 30), "/"); // 30 days
                    }

                    // Redirect to dashboard
                    header("Location: ../index.php");
                    exit();
                } else {
                    $error_message = "Invalid username or password";
                }
            } catch(PDOException $e) {
                $error_message = "Login error: " . $e->getMessage();
            }
        }
    }
    ?>

    <div class="login-container">
        <div class="login-header">
            <h1>Welcome Back!</h1>
            <p>Login to access your gaming profile</p>
        </div>

        <?php if ($error_message): ?>
            <div class="error-message">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="remember-me">
                <input type="checkbox" id="remember_me" name="remember_me">
                <label for="remember_me">Remember me</label>
            </div>

            <div class="forgot-password">
                <a href="forgot-password.php">Forgot Password?</a>
            </div>

            <button type="submit" class="login-btn">Login</button>
        </form>

        <div class="signup-link">
            Don't have an account? <a href="signup.php">Sign up here</a>
        </div>
    </div>
</body>
</html>