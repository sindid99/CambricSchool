<?php
session_start(); // Start the session at the beginning

// Image paths
$award_image = "Award.jpg";
$teacher_image = "Allteacher.jpg";

// Co-curricular information data
$cocurricular_info = [
    "sports_clubs" => [
        "Football Club: Weekly practice sessions and inter-school tournaments.",
        "Cricket Team: Regular coaching and league matches.",
        "Badminton Club: Open to all students with a passion for the sport.",
        "Chess Club: For students interested in strategic board games."
    ],
    "cultural_events" => [
        "Annual Science Fair: Showcasing student innovation and projects.",
        "School Drama Club: Performing plays and skits throughout the year.",
        "Debate Club: Fostering public speaking and critical thinking.",
        "Annual Cultural Program: Featuring music, dance, and poetry performances."
    ],
    "other_activities" => [
        "Gardening Club: Promoting environmental awareness and practical skills.",
        "Community Service Program: Engaging students in local community projects."
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Co-curricular Information - Cambric School and College</title>
    <!-- Tailwind CSS CDN for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts for 'Inter' font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Custom CSS for body styling */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        /* Styling for the main content card */
        .card {
            background-color: #ffffff;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            width: 100%;
            text-align: center;
        }
        /* Button styling with animation */
        .button-animated {
            transition: all 0.2s ease-in-out;
            background-image: linear-gradient(to right, #01050eff, #2563eb);
        }
        .button-animated:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            background-image: linear-gradient(to right, #2563eb, #1d4ed8);
        }
        .button-animated:active {
            transform: translateY(1px);
            box-shadow: none;
        }
        /* Style for the container holding the card and images */
        .main-content-container {
            display: flex;
            flex-direction: column; /* Stack vertically on mobile */
            gap: 2rem;
            max-width: 6xl; /* Larger max width to accommodate both card and images */
            width: 100%;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        /* Responsive styles for larger screens */
        @media (min-width: 1024px) {
            .main-content-container {
                flex-direction: row; /* Arrange horizontally on large screens */
            }
        }
        /* CSS animation for the images */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .animated-image {
            animation: float 5s ease-in-out infinite; /* Apply the float animation, changed to 5s */
        }
        /* Stylish comment box for the pictures */
        .comment-box {
            background-color: #f7d4e7ff; /* Light blue background */
            padding: 0.75rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
    </style>
</head>
<body class="text-gray-900">
    <!-- Ensure the main wrapper is full screen -->
    <div class="flex flex-col items-center justify-center min-h-screen p-4">
        <!-- Main Content Container with a flex layout -->
        <div class="main-content-container">
            <!-- Left side: The main information card -->
            <div class="card flex-grow lg:w-2/3">
                <h1 class="text-5xl font-extrabold text-blue-800 mb-6">Co-curricular Activities</h1>
                
                <!-- Personalized Welcome Message -->
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <p class="text-2xl text-gray-700 mb-4">Hello, <span class="font-semibold text-blue-600"><?php echo htmlspecialchars($_SESSION['username']); ?></span>!</p>
                    <p class="text-xl text-gray-600 mb-8">Here you can find information about our co-curricular activities.</p>
                <?php else: ?>
                    <p class="text-2xl text-gray-700 mb-4">Hello, <span class="font-semibold text-blue-600">Guest</span>!</p>
                    <p class="text-xl text-gray-600 mb-8">Feel free to explore the activities available at our school.</p>
                <?php endif; ?>

                <!-- Co-curricular Details Section -->
                <div class="text-left mt-8 mb-8">
                    <div class="mb-6">
                        <h2 class="text-3xl font-bold text-gray-800 mb-3">Sports and Clubs</h2>
                        <ul class="list-disc list-inside text-lg text-gray-700">
                            <?php foreach ($cocurricular_info['sports_clubs'] as $activity): ?>
                                <li><?php echo htmlspecialchars($activity); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-3xl font-bold text-gray-800 mb-3">Cultural and Creative Events</h2>
                        <ul class="list-disc list-inside text-lg text-gray-700">
                            <?php foreach ($cocurricular_info['cultural_events'] as $event): ?>
                                <li><?php echo htmlspecialchars($event); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <div class="mb-6">
                        <h2 class="text-3xl font-bold text-gray-800 mb-3">Other Opportunities</h2>
                        <ul class="list-disc list-inside text-lg text-gray-700">
                            <?php foreach ($cocurricular_info['other_activities'] as $activity): ?>
                                <li><?php echo htmlspecialchars($activity); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <!-- Back to Dashboard Button -->
                <a href="dashboard.php" class="inline-block w-full md:w-auto px-8 py-3 rounded-md font-semibold text-white bg-gray-500 hover:bg-gray-600 shadow-lg transition-colors duration-200">
                    Back to Dashboard
                </a>
            </div>

            <!-- Right side: The image gallery -->
            <div class="lg:w-1/3 flex flex-col items-center justify-center gap-8">
                <!-- First Image -->
                <div class="flex flex-col items-center w-full">
                    <img src="<?php echo htmlspecialchars($award_image); ?>" alt="Award Giving Ceremony" class="rounded-lg shadow-xl w-full h-auto object-cover md:max-w-md animated-image">
                    <!-- Stylish, bold comment for the first picture -->
                    <div class="comment-box mt-2 w-full md:max-w-md">
                        <p class="text-lg font-bold text-blue-800">A moment from our annual award-giving ceremony.</p>
                    </div>
                </div>

                <!-- Second Image -->
                <div class="flex flex-col items-center w-full">
                    <img src="<?php echo htmlspecialchars($teacher_image); ?>" alt="All Teacher's Picture" class="rounded-lg shadow-xl w-full h-auto object-cover md:max-w-md animated-image">
                    <!-- Stylish, bold comment for the second picture -->
                    <div class="comment-box mt-2 w-full md:max-w-md">
                        <p class="text-lg font-bold text-blue-800">Our dedicated teachers posing for a group photo.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
