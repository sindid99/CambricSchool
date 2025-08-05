<?php
session_start(); // Start the session at the very beginning of the script

// Include the database configuration file
require_once 'db_config.php';

$error_message = ''; // Initialize error message variable

// Check if the form was submitted (either login or guest mode)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        // Handle regular login attempt
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Basic validation: Check if username or password fields are empty
        if (empty($username) || empty($password)) {
            $error_message = "Please enter both username and password.";
        } else {
            // Prepare a SQL statement to prevent SQL injection attacks.
            // This is crucial for security.
            $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
            $stmt->bind_param("s", $username); // 's' denotes a string parameter for username
            $stmt->execute();
            $result = $stmt->get_result(); // Get the result set from the executed statement

            // Check if a user with the given username was found
            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc(); // Fetch the user data as an associative array

                // Verify the password.
                // IMPORTANT: In a real application, you MUST use password_verify() with hashed passwords.
                // For this demo, we are comparing plain text passwords for simplicity.
                if ($password === $user['password']) {
                // Correct way for hashed passwords (uncomment and use this in production):
                // if (password_verify($password, $user['password'])) {

                    // Password is correct, set session variables to mark the user as logged in
                    $_SESSION['loggedin'] = true;
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];

                    // Redirect the user to the dashboard page
                    header("Location: dashboard.php");
                    exit(); // Stop further script execution
                } else {
                    // Password does not match
                    $error_message = "Invalid username or password.";
                }
            } else {
                // No user found with that username
                $error_message = "Invalid username or password.";
            }

            $stmt->close(); // Close the prepared statement
        }
    } elseif (isset($_POST['guest_mode'])) {
        // Handle guest mode entry
        // Set session variables to indicate guest access (not fully logged in)
        $_SESSION['loggedin'] = false; // User is not authenticated, but allowed to view public content
        $_SESSION['username'] = 'Guest';
        $_SESSION['role'] = 'guest';

        // Redirect to the dashboard page
        header("Location: dashboard.php");
        exit(); // Stop further script execution
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambric School and College - Login</title>
    <!-- Tailwind CSS CDN for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts for 'Inter' font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Custom CSS for body styling */
        body {
            font-family: 'Inter', sans-serif; /* Apply Inter font */
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); /* Vibrant gradient background */
            display: flex; /* Use flexbox for centering content */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            min-height: 100vh; /* Minimum height of viewport */
            margin: 0; /* Remove default body margin */
        }

        /* Animation for the main card entrance */
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animated-card {
            animation: fadeInScale 0.5s ease-out forwards;
        }

        /* Input field focus animation */
        .input-animated:focus {
            border-color: #4f46e5; /* indigo-600 */
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.5); /* indigo-600 with transparency */
        }

        /* Button hover and active animations */
        .button-animated {
            transition: all 0.2s ease-in-out;
            background-image: linear-gradient(to right, #4f46e5, #6366f1); /* Gradient for buttons */
        }
        .button-animated:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            background-image: linear-gradient(to right, #6366f1, #4f46e5); /* Reverse gradient on hover */
        }
        .button-animated:active {
            transform: translateY(1px);
            box-shadow: none;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md animated-card">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Cambric School and College</h2>
        <h3 class="text-2xl font-semibold text-center text-blue-600 mb-8">Login</h3>

        <?php if (!empty($error_message)): ?>
            <!-- Display error message if any -->
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $error_message; ?></span>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="login.php" method="POST" class="space-y-6">
            <div>
                <label for="username" class="block text-gray-700 text-sm font-medium mb-2">Username</label>
                <input type="text" id="username" name="username" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out input-animated">
            </div>
            <div>
                <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out input-animated">
            </div>
            <button type="submit" name="login"
                    class="w-full text-white py-3 rounded-md font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-lg transform button-animated">
                Login
            </button>
        </form>

        <div class="mt-6 text-center">
            <!-- Guest Mode Option -->
            <form action="login.php" method="POST">
                <button type="submit" name="guest_mode"
                        class="w-full bg-gray-500 text-white py-3 rounded-md font-semibold hover:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-gray-500 focus:ring-offset-2 transition duration-200 ease-in-out shadow-lg transform hover:scale-105 mt-4 button-animated">
                    Continue as Guest
                </button>
            </form>
            <!-- Registration Link -->
            <p class="mt-4 text-gray-600">Don't have an account? <a href="register.php" class="text-blue-600 hover:underline font-medium">Register Here</a></p>
        </div>
    </div>
</body>
</html>
