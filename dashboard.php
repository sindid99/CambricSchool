<?php
session_start(); // Start the session at the very beginning

// Teacher list data (public information)
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

// School contact information (public information)
$school_location = "Himbari, Joar Sahara Bazar Road, Vatara, Dhaka - 1229";
$contact_number = "01711459087";

// Image paths
// The main background image for the dashboard
$school_background_image = "1c0c9582-e847-47fa-ade3-44abc1183ebc.jpg";
// The three images to be displayed side-by-side
$image1 = "Classroom.jpg"; // Left image
$image2 = "student.jpg";      // Middle (larger) image
$image3 = "assembly.jpg";     // Right image
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Cambric School and College</title>
    <!-- Tailwind CSS CDN for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts for 'Inter' font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Custom CSS for body styling */
        body {
            font-family: 'Inter', sans-serif; /* Apply Inter font */
            background-color: #f0f2f5; /* Light gray background */
            min-height: 100vh; /* Minimum height of viewport */
            margin: 0; /* Remove default body margin */
            background-image: url('<?php echo $school_background_image; ?>'); /* Set the background image */
            background-size: cover; /* Cover the entire background */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Do not repeat the image */
            background-attachment: fixed; /* Keep the background fixed during scroll */
        }
        /* Overlay to make text readable over the background image */
        .overlay {
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white overlay */
            min-height: 100vh; /* Ensure overlay covers full height */
            display: flex; /* Use flexbox for layout */
            flex-direction: column; /* Stack items vertically */
            align-items: center; /* Center items horizontally */
            justify-content: center; /* Center items vertically */
            padding: 2rem; /* Add padding around the content */
        }
        /* Styling for the main content card */
        .card {
            background-color: #ffffff; /* White background for the card */
            border-radius: 0.75rem; /* Rounded corners */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* Shadow effect */
            padding: 2rem; /* Padding inside the card */
            width: 100%; /* Full width on small screens */
            max-width: 4xl; /* Maximum width for larger screens */
            text-align: center; /* Center text within the card */
            margin-bottom: 2rem; /* Margin below the card */
        }
        /* Styling for the teacher list */
        .teacher-list {
            list-style: none; /* Remove default list bullets */
            padding: 0; /* Remove default list padding */
            text-align: left; /* Align text to the left within the list */
            columns: 2; /* Display in two columns on larger screens */
            column-gap: 2rem; /* Gap between columns */
        }
        .teacher-list li {
            margin-bottom: 0.5rem; /* Margin between list items */
            font-size: 1rem; /* Font size for list items */
            color: #4a5568; /* Gray text color */
        }
        /* Responsive adjustment for teacher list on smaller screens */
        @media (max-width: 768px) {
            .teacher-list {
                columns: 1; /* Display in a single column on small screens */
            }
        }
        /* Animation for images on hover */
        .animated-image {
            transition: transform 0.3s ease-in-out; /* Smooth transition for transform property */
        }
        .animated-image:hover {
            transform: scale(1.05); /* Slightly enlarge image on hover */
        }

        /* Dashboard specific animation for the main card */
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

        /* Button styling with animation */
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
<body class="bg-gray-100">
    <div class="overlay">
        <div class="card animated-card">
            <h2 class="text-5xl font-extrabold text-center text-blue-800 mb-6">Welcome to Cambric School and College!</h2>

            <!-- Images Section - Side by Side with specific widths and Animation -->
            <div class="flex flex-col md:flex-row justify-center items-center gap-4 mb-8 mt-4">
                <!-- Left Image (45% width) -->
                <img src="<?php echo htmlspecialchars($image1); ?>" alt="School Classroom Photo" class="animated-image rounded-lg shadow-md w-[30%] h-auto object-cover">
                <!-- Middle Image (60% width) -->
                <img src="<?php echo htmlspecialchars($image2); ?>" alt="School Group Photo" class="animated-image rounded-lg shadow-md w-[40%] h-auto object-cover">
                <!-- Right Image (45% width) -->
                <img src="<?php echo htmlspecialchars($image3); ?>" alt="School Assembly Photo" class="animated-image rounded-lg shadow-md w-[30%] h-auto object-cover">
            </div>

            <!-- Display personalized welcome message based on login status -->
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <p class="text-2xl text-gray-700 mb-4">Hello, <span class="font-semibold text-blue-600"><?php echo htmlspecialchars($_SESSION['username']); ?></span>!</p>
                <p class="text-xl text-gray-600 mb-8">Your role: <span class="font-medium text-purple-600"><?php echo htmlspecialchars($_SESSION['role']); ?></span></p>
            <?php else: ?>
                <p class="text-2xl text-gray-700 mb-4">Hello, <span class="font-semibold text-blue-600">Guest</span>!</p>
                <p class="text-xl text-gray-600 mb-8">You are viewing public information.</p>
            <?php endif; ?>

            <p class="text-lg text-gray-500 mb-10">This is your dashboard. Explore the information below.</p>

            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
               
            <?php else: ?>
                <!-- Message for guest users -->
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">You are in Guest Mode. Register to access personalized information like fee dues and exam schedules!</span>
                </div>
            <?php endif; ?>

            <!-- The section with the two buttons, now side by side on medium screens and up -->
            <div class="flex flex-col md:flex-row justify-center items-center gap-4 mt-8 mb-8">
                <!-- Admission Information Button -->
                <a href="admission.php" class="inline-block w-full md:w-auto px-8 py-3 rounded-md font-semibold text-white shadow-lg button-animated">
                    Admission Information
                </a>
                <!-- Academic Information Button -->
                <a href="academic.php" class="inline-block w-full md:w-auto px-8 py-3 rounded-md font-semibold text-white shadow-lg button-animated">
                    Academic Information
                </a>
                <a href="cocurricular.php" class="inline-block w-full md:w-auto px-8 py-3 rounded-md font-semibold text-white shadow-lg button-animated">
                   Co-Curricular Activities
                </a>
            </div>

            <!-- Teachers Section (public information) -->
            <div class="mt-12 mb-12">
                <h3 class="text-3xl font-bold text-gray-800 mb-6">Our Esteemed Teachers</h3>
                <ul class="teacher-list mx-auto max-w-lg">
                    <?php foreach ($teachers as $teacher): ?>
                        <li class="flex items-center text-gray-700">
                            <!-- SVG icon for list items -->
                            <svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <?php echo htmlspecialchars($teacher); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Logout Button -->
            <a href="logout.php" class="inline-block bg-red-600 text-white py-3 px-8 rounded-md font-semibold hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-200 ease-in-out shadow-lg transform hover:scale-105 mt-8">
                Logout
            </a>
        </div>

        <!-- Footer Contact Information (public information) -->
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