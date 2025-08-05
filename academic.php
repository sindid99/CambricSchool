<?php
session_start(); // Start the session at the beginning

// Image path
$academic_background_image = "background.avif";

// Academic information data
$academic_info = [
    "program_types" => [
        "Bangla Medium",
        "English Version"
    ],
    "class_hours" => [
        "Morning Shift: 8:00 AM - 12:00 PM",
        "Day Shift: 1:00 PM - 5:00 PM"
    ],
    "weekly_routine" => [
        "Sunday: English, Math, Science",
        "Monday: Bangla, Social Science, Art",
        "Tuesday: Math, English, Religion",
        "Wednesday: Science, Bangla, Computer",
        "Thursday: Social Science, Math, Physical Education",
        "Friday: Off",
        "Saturday: Off"
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Information - Cambric School and College</title>
    <!-- Tailwind CSS CDN for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts for 'Inter' font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Custom CSS for body styling */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #e6e9edff;
            background-image: url('<?php echo $academic_background_image; ?>'); /* Set the background image */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        /* Overlay to make text readable over the background image */
        .overlay {
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white overlay */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            width: 100%;
        }
        /* Styling for the main content card */
        .card {
            background-color: #ffffff; /* White background for the card */
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            width: 100%;
            max-width: 4xl;
            text-align: center;
            margin-bottom: 2rem;
        }
        /* Button styling with animation */
        .button-animated {
            transition: all 0.2s ease-in-out;
            background-image: linear-gradient(to right, #1d4ed8, #2563eb); /* Gradient for buttons */
        }
        .button-animated:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1-px rgba(0, 0, 0, 0.06);
            background-image: linear-gradient(to right, #2563eb, #1d4ed8); /* Reverse gradient on hover */
        }
        .button-animated:active {
            transform: translateY(1px);
            box-shadow: none;
        }
    </style>
</head>
<body class="text-gray-900">
    <div class="overlay">
        <div class="card">
            <h1 class="text-5xl font-extrabold text-blue-800 mb-6">Academic Information</h1>
            
            <!-- Personalized Welcome Message -->
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <p class="text-2xl text-gray-700 mb-4">Hello, <span class="font-semibold text-blue-600"><?php echo htmlspecialchars($_SESSION['username']); ?></span>!</p>
                <p class="text-xl text-gray-600 mb-8">You are viewing academic details.</p>
            <?php else: ?>
                <p class="text-2xl text-gray-700 mb-4">Hello, <span class="font-semibold text-blue-600">Guest</span>!</p>
                <p class="text-xl text-gray-600 mb-8">Feel free to explore our academic programs.</p>
            <?php endif; ?>

            <!-- Academic Details Section -->
            <div class="text-left mt-8 mb-8">
                <div class="mb-6">
                    <h2 class="text-3xl font-bold text-gray-800 mb-3">Programs and Class Hours</h2>
                    <p class="text-lg text-gray-700 mb-2"><strong>Available Programs:</strong></p>
                    <ul class="list-disc list-inside text-lg text-gray-700 mb-4">
                        <?php foreach ($academic_info['program_types'] as $program): ?>
                            <li><?php echo htmlspecialchars($program); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <p class="text-lg text-gray-700 mb-2"><strong>Daily Class Shifts:</strong></p>
                    <ul class="list-disc list-inside text-lg text-gray-700">
                        <?php foreach ($academic_info['class_hours'] as $shift): ?>
                            <li><?php echo htmlspecialchars($shift); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="mb-6">
                    <h2 class="text-3xl font-bold text-gray-800 mb-3">Weekly Class Routine (Sample)</h2>
                    <ul class="list-disc list-inside text-lg text-gray-700">
                        <?php foreach ($academic_info['weekly_routine'] as $day_routine): ?>
                            <li><?php echo htmlspecialchars($day_routine); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- Back to Dashboard Button -->
            <a href="dashboard.php" class="inline-block w-full md:w-auto px-8 py-3 rounded-md font-semibold text-white bg-gray-500 hover:bg-gray-600 shadow-lg transition-colors duration-200">
                Back to Dashboard
            </a>
        </div>
    </div>
</body>
</html>
