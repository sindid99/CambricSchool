<?php
session_start();
require_once 'db_config.php';

$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    if (empty($username) || empty($password) || empty($role)) {
        $error_message = "Please fill in all fields.";
    } else {
        // Check if username already exists
        $stmt_check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt_check->bind_param("s", $username);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $error_message = "Username already exists. Please choose a different one.";
        } else {
            // Insert new user
            $stmt_insert = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt_insert->bind_param("sss", $username, $password, $role);

            if ($stmt_insert->execute()) {
                $success_message = "Registration successful! You can now log in.";
                // Clear form
                $username = '';
                $password = '';
                $role = '';
            } else {
                $error_message = "Error: " . $stmt_insert->error;
            }
            $stmt_insert->close();
        }
        $stmt_check->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Cambric School and College</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Same styles as login.php - use the same design system */
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
            --success: #28a745;
            --danger: #dc3545;
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

        input, select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        input:focus, select:focus {
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

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
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

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            border: 1px solid #c3e6cb;
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
        <p class="subtitle">Create Your Account</p>
    </header>

    <main class="main-content">
        <div class="form-container">
            <div class="form-left">
                <div class="welcome-text">Join Our Educational Community</div>
                <p class="info-text">Create an account to access all the features and resources available to students, teachers, and staff at Cambric School and College.</p>
                
                <ul class="features-list">
                    <li><i class="fas fa-check-circle"></i> Access to educational resources</li>
                    <li><i class="fas fa-check-circle"></i> Track academic progress</li>
                    <li><i class="fas fa-check-circle"></i> Connect with teachers and peers</li>
                    <li><i class="fas fa-check-circle"></i> Stay updated with school events</li>
                </ul>
            </div>
            
            <div class="form-right">
                <h2 class="form-title">Register</h2>
                
                <?php if (!empty($error_message)): ?>
                    <div class="error-message">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($success_message)): ?>
                    <div class="success-message">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <form action="register.php" method="POST" id="registerForm">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-group">
                            <input type="text" id="username" name="username" placeholder="Choose a username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password" placeholder="Create a strong password" value="<?php echo isset($password) ? htmlspecialchars($password) : ''; ?>" required>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" id="confirmPassword" placeholder="Re-enter your password" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="role">Role</label>
                        <select id="role" name="role" required>
                            <option value="" disabled selected>Select Your Role</option>
                            <option value="student" <?php echo (isset($role) && $role == 'student') ? 'selected' : ''; ?>>Student</option>
                            <option value="teacher" <?php echo (isset($role) && $role == 'teacher') ? 'selected' : ''; ?>>Teacher</option>
                            <option value="parent" <?php echo (isset($role) && $role == 'parent') ? 'selected' : ''; ?>>Parent</option>
                            <option value="admin" <?php echo (isset($role) && $role == 'admin') ? 'selected' : ''; ?>>Administrator</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Register</button>

                    <div class="login-link">
                        <p>Already have an account? <a href="login.php">Login Here</a></p>
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
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const registerForm = document.getElementById('registerForm');

            // Toggle password visibility
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                togglePassword.innerHTML = type === 'password' ? '<i class="far fa-eye"></i>' : '<i class="far fa-eye-slash"></i>';
            });

            // Password confirmation validation
            registerForm.addEventListener('submit', function(e) {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;
                
                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert('Passwords do not match. Please try again.');
                    return;
                }
            });

            // Real-time password confirmation check
            confirmPasswordInput.addEventListener('input', function() {
                const password = passwordInput.value;
                const confirmPassword = this.value;
                
                if (confirmPassword && password !== confirmPassword) {
                    this.style.borderColor = 'var(--danger)';
                    this.style.boxShadow = '0 0 0 3px rgba(220, 53, 69, 0.2)';
                } else if (confirmPassword) {
                    this.style.borderColor = 'var(--success)';
                    this.style.boxShadow = '0 0 0 3px rgba(40, 167, 69, 0.2)';
                } else {
                    this.style.borderColor = '#ced4da';
                    this.style.boxShadow = 'none';
                }
            });
        });
    </script>
</body>
</html>