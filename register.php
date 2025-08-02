<?php
session_start(); // Start the session at the very beginning
require_once 'db_config.php'; // Include database configuration

$error_message = '';   // Initialize error message variable
$success_message = ''; // Initialize success message variable

// Check if the registration form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Get the role from the form (e.g., student, teacher, parent)

    // Basic validation: Check if any required field is empty
    if (empty($username) || empty($password) || empty($role)) {
        $error_message = "Please fill in all fields.";
    } else {
        // IMPORTANT: In a real application, you MUST hash the password for security.
        // Uncomment the line below and use password_verify() in login.php
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if the username already exists in the database
        $stmt_check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt_check->bind_param("s", $username); // 's' for string parameter
        $stmt_check->execute();
        $stmt_check->store_result(); // Store the result to check number of rows

        if ($stmt_check->num_rows > 0) {
            // Username already exists
            $error_message = "Username already exists. Please choose a different one.";
        } else {
            // Username is unique, proceed with insertion
            // Prepare an SQL statement to insert new user data
            $stmt_insert = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            // Bind parameters: 'sss' for three string parameters (username, password, role)
            $stmt_insert->bind_param("sss", $username, $password, $role);

            // Execute the insert statement
            if ($stmt_insert->execute()) {
                $success_message = "Registration successful! You can now log in.";
            } else {
                // Error during insertion
                $error_message = "Error: " . $stmt_insert->error;
            }
            $stmt_insert->close(); // Close the insert statement
        }
        $stmt_check->close(); // Close the check statement
    }
}
$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambric School and College - Register</title>
    <!-- Tailwind CSS CDN for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts for 'Inter' font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Custom CSS for body styling */
        body {
            font-family: 'Inter', sans-serif; /* Apply Inter font */
            background-color: #f0f2f5; /* Light gray background */
            display: flex; /* Use flexbox for centering content */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            min-height: 100vh; /* Minimum height of viewport */
            margin: 0; /* Remove default body margin */
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Cambric School and College</h2>
        <h3 class="text-2xl font-semibold text-center text-blue-600 mb-8">Register</h3>

        <?php if (!empty($error_message)): ?>
            <!-- Display error message if any -->
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $error_message; ?></span>
            </div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <!-- Display success message if registration was successful -->
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $success_message; ?></span>
            </div>
        <?php endif; ?>

        <!-- Registration Form -->
        <form action="register.php" method="POST" class="space-y-6">
            <div>
                <label for="username" class="block text-gray-700 text-sm font-medium mb-2">Username</label>
                <input type="text" id="username" name="username" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out">
            </div>
            <div>
                <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out">
            </div>
            <div>
                <label for="role" class="block text-gray-700 text-sm font-medium mb-2">Role</label>
                <select id="role" name="role" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out">
                    <option value="">Select Role</option>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                    <option value="parent">Parent</option>
                </select>
            </div>
            <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-md font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 ease-in-out shadow-lg transform hover:scale-105">
                Register
            </button>
        </form>

        <!-- Link back to login page -->
        <p class="mt-4 text-center text-gray-600">Already have an account? <a href="login.php" class="text-blue-600 hover:underline font-medium">Login Here</a></p>
    </div>
</body>
</html>