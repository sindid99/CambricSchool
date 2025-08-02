<?php
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Teacher list data
$teachers = [
    "Co-founder and principal - Mr Anisur Rahman",
    "Founder - Mrs Sabina Rahman",
    "Vice principal - Shohel Rana",
    "Rainy Akter",
    "Rekha Begum",
    "Rifat Hasan",
    "Nazmul Hossain",
    "Pushpita Chowdhury",
    "Muslima Akter Chomky",
    "Nahida Sultana",
    "Sahana Akter",
    "Shamima Akter",
    "Jasmine Akter Dolna",
    "Sindid Rahman Srestho",
    "Sadia Ritu",
    "Mazidur Rahman",
    "Aslam Alom",
    "Roksana Afrin",
    "Sadia Islam"
];

// School contact information
$school_location = "Himbari, Joar Sahara Bazar Road, Vatara, Dhaka - 1229";
$contact_number = "01711459087";
$school_image = "1c0c9582-e847-47fa-ade3-44abc1183ebc.jpg"; // Updated to the new image
$logo_image = "classroom.jpg"; // Updated to the new image
$additional_image = "student.jpg"; // Updated to the new image
$assembly_image = "assembly.jpg"; // New image for assembly
$new_image = "image_0b6d84.jpg"; // New image to be added
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Cambric School and College</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            min-height: 100vh;
            margin: 0;
            background-image: url('<?php echo $school_image; ?>'); /* Set the background image */
            background-size: cover; /* Cover the entire background */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Do not repeat the image */
            background-attachment: fixed; /* Keep the background fixed during scroll */
        }
        .overlay {
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white overlay */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .card {
            background-color: #ffffff;
            border-radius: 0.75rem; /* rounded-lg */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* shadow-xl */
            padding: 2rem;
            width: 100%;
            max-width: 4xl; /* Adjust as needed */
            text-align: center;
            margin-bottom: 2rem;
        }
        .teacher-list {
            list-style: none; /* Remove default list style */
            padding: 0;
            text-align: left;
            columns: 2; /* Two columns for teachers on larger screens */
            column-gap: 2rem;
        }
        .teacher-list li {
            margin-bottom: 0.5rem;
            font-size: 1rem;
            color: #4a5568; /* gray-700 */
        }
        @media (max-width: 768px) {
            .teacher-list {
                columns: 1; /* Single column on small screens */
            }
        }
        /* Animation for images */
        .animated-image {
            transition: transform 0.3s ease-in-out;
        }
        .animated-image:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="overlay">
        <div class="card">
            <h2 class="text-5xl font-extrabold text-center text-blue-800 mb-6">Welcome to Cambric School and College!</h2>

            <!-- Images Section - Side by Side with Animation -->
            <div class="flex flex-col md:flex-row justify-center items-center gap-4 mb-8 mt-4">
                <img src="<?php echo htmlspecialchars($logo_image); ?>" alt="Cambric School and College Logo" class="animated-image rounded-lg shadow-md w-[25%] h-auto object-cover">
                <img src="<?php echo htmlspecialchars($additional_image); ?>" alt="School Group Photo" class="animated-image rounded-lg shadow-md w-[35%] h-auto object-cover">
                <img src="<?php echo htmlspecialchars($assembly_image); ?>" alt="School Assembly Photo" class="animated-image rounded-lg shadow-md w-[25%] h-auto object-cover">
            </div>

            <p class="text-2xl text-gray-700 mb-4">Hello, <span class="font-semibold text-blue-600"><?php echo htmlspecialchars($_SESSION['username']); ?></span>!</p>
            <p class="text-xl text-gray-600 mb-8">Your role: <span class="font-medium text-purple-600"><?php echo htmlspecialchars($_SESSION['role']); ?></span></p>

            <p class="text-lg text-gray-500 mb-10">This is your secure dashboard. Explore the information below.</p>

            <!-- Teachers Section -->
            <div class="mt-12 mb-12">
                <h3 class="text-3xl font-bold text-gray-800 mb-6">Our Esteemed Teachers</h3>
                <ul class="teacher-list mx-auto max-w-lg">
                    <?php foreach ($teachers as $teacher): ?>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <?php echo htmlspecialchars($teacher); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <a href="logout.php" class="inline-block bg-red-600 text-white py-3 px-8 rounded-md font-semibold hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-200 ease-in-out shadow-lg transform hover:scale-105 mt-8">
                Logout
            </a>
        </div>

        <!-- Footer Contact Information -->
        <footer class="bg-blue-700 text-white p-6 rounded-lg shadow-xl w-full max-w-4xl text-center mt-8">
            <h4 class="text-2xl font-semibold mb-3">Contact Us</h4>
            <p class="text-lg mb-2">
                <span class="font-medium">Location:</span> <?php echo htmlspecialchars($school_location); ?>
            </p>
            <p class="text-lg">
                <span class="font-medium">Contact Number:</span> <?php echo htmlspecialchars($contact_number); ?>
            </p>
        </footer>
    </div>
</body>
</html>