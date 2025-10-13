<?php
session_start();
require_once 'db_config.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if (empty($username) || empty($password)) {
            $error_message = "Please enter both username and password.";
        } else {
            // Prepare SQL statement to prevent SQL injection
            $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                
                // Verify password (plain text comparison for demo)
                // In production, use: if (password_verify($password, $user['password']))
                if ($password === $user['password']) {
                    // Set session variables
                    $_SESSION['loggedin'] = true;
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];

                    // Update last login in database
                    $update_stmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                    $update_stmt->bind_param("i", $user['id']);
                    $update_stmt->execute();
                    $update_stmt->close();

                    // Redirect to dashboard
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $error_message = "Invalid username or password.";
                }
            } else {
                $error_message = "Invalid username or password.";
            }
            $stmt->close();
        }
    } elseif (isset($_POST['guest_mode'])) {
        // Handle guest mode
        $_SESSION['loggedin'] = false;
        $_SESSION['username'] = 'Guest';
        $_SESSION['role'] = 'guest';
        
        header("Location: dashboard.php");
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cambric School and College</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        :root {
            --primary: #1a4b8c;
            --secondary: #f0a500;
            --light: #f8f9fa;
            --dark: #343a40;
        }

        body {
            background: linear-gradient(135deg, #1a4b8c 0%, #0d2b52 100%);
            color: var(--dark);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 1rem;
        }

        .logo {
            width: 60px;
            height: 60px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: var(--primary);
            font-size: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .school-name {
            font-size: 2.2rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1;
        }

        .form-container {
            display: flex;
            max-width: 1000px;
            width: 100%;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .form-left {
            flex: 1;
            background: linear-gradient(135deg, var(--primary) 0%, #0d2b52 100%);
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-right {
            flex: 1;
            padding: 3rem;
        }

        .form-title {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: var(--primary);
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
        }

        .input-group {
            position: relative;
        }

        input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26, 75, 140, 0.2);
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #6c757d;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: #153a6e;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary {
            background-color: #e9ecef;
            color: var(--dark);
            margin-top: 1rem;
        }

        .btn-secondary:hover {
            background-color: #dee2e6;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .divider {
            text-align: center;
            margin: 1.5rem 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background-color: #dee2e6;
        }

        .divider span {
            background-color: white;
            padding: 0 1rem;
            color: #6c757d;
        }

        .register-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .features-list {
            list-style: none;
            margin-top: 2rem;
        }

        .features-list li {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .features-list i {
            margin-right: 10px;
            color: var(--secondary);
            font-size: 1.2rem;
        }

        .welcome-text {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .info-text {
            margin-bottom: 2rem;
            opacity: 0.9;
            line-height: 1.6;
        }

        .footer {
            text-align: center;
            margin-top: 2rem;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 768px) {
            .form-container {
                flex-direction: column;
            }
            
            .form-left {
                padding: 2rem;
            }
            
            .school-name {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo-container">
            <div class="logo">CSC</div>
            <h1 class="school-name">Cambric School and College</h1>
        </div>
        <p class="subtitle">Welcome Back to Our Educational Community</p>
    </header>

    <main class="main-content">
        <div class="form-container">
            <div class="form-left">
                <div class="welcome-text">Welcome Back!</div>
                <p class="info-text">Login to your account to access all the features and resources available to students, teachers, and staff at Cambric School and College.</p>
                
                <ul class="features-list">
                    <li><i class="fas fa-check-circle"></i> Access your personalized dashboard</li>
                    <li><i class="fas fa-check-circle"></i> View academic progress and grades</li>
                    <li><i class="fas fa-check-circle"></i> Connect with teachers and classmates</li>
                    <li><i class="fas fa-check-circle"></i> Stay updated with school announcements</li>
                </ul>
            </div>
            
            <div class="form-right">
                <h2 class="form-title">Login</h2>
                
                <?php if (!empty($error_message)): ?>
                    <div class="error-message">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="POST" id="loginForm">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-group">
                            <input type="text" id="username" name="username" placeholder="Enter your username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" name="login" class="btn btn-primary">Login</button>

                    <div class="divider">
                        <span>OR</span>
                    </div>

                    <button type="submit" name="guest_mode" class="btn btn-secondary">Continue as Guest</button>

                    <div class="register-link">
                        <p>Don't have an account? <a href="register.php">Register Here</a></p>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2023 Cambric School and College. All rights reserved.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            // Toggle password visibility
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                togglePassword.innerHTML = type === 'password' ? '<i class="far fa-eye"></i>' : '<i class="far fa-eye-slash"></i>';
            });
        });
    </script>
</body>
</html>