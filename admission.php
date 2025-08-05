<?php
session_start(); // Start the session at the beginning

// Image paths
$admission_poster = "poster.jpg";

// Admission information data
$admission_details = [
    "eligibility" => "Students must have passed their previous grade level to be eligible for admission. Specific requirements may vary by class.",
    "documents" => [
        "Photocopy of birth certificate",
        "Previous school's transfer certificate (if applicable)",
        "Passport-size photos of the student",
        "Photocopy of national ID card of the guardian"
    ],
    "important_dates" => [
        "Application Period: August 1 - September 30",
        "Admission Test: October 10",
        "Result Publication: October 15",
        "Admission Finalization: October 16 - October 31"
    ]
];

// Contact information
$contact_numbers = [
    "01711459087",
    "01885856866",
    "01913101186"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Information - Cambric School</title>
    <!-- Tailwind CSS CDN for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts for 'Inter' font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Custom CSS for body styling */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        /* Overlay to make text readable over the background image */
        .overlay {
            background-color: rgba(255, 255, 255, 0.95); /* Slightly transparent white card */
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
            text-align: center;
        }
        /* Button styling with animation */
        .button-animated {
            transition: all 0.2s ease-in-out;
            background-image: linear-gradient(to right, #167e0aff, #167e0aff); /* Gradient for buttons */
        }
        .button-animated:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            background-image: linear-gradient(to right, #a31bf7ff, #a31bf7ff); /* Reverse gradient on hover */
        }
        .button-animated:active {
            transform: translateY(1px);
            box-shadow: none;
        }
        /* Style for the container holding the card and image */
        .main-content-container {
            display: flex;
            flex-direction: column; /* Stack vertically on mobile */
            gap: 2rem;
            max-width: 6xl; /* Larger max width to accommodate both card and image */
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
        /* CSS animation for the poster image */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .poster-image {
            animation: float 0.8s ease-in-out infinite; /* Apply the float animation */
        }
    </style>
</head>
<body class="text-gray-900">
    <div class="overlay">
        <!-- Main Content Container with a flex layout -->
        <div class="main-content-container">
            <!-- Left side: The main information card -->
            <div class="card flex-grow lg:w-2/3">
                <h1 class="text-5xl font-extrabold text-blue-800 mb-6">Admission Information</h1>
                
                <!-- Personalized Welcome Message -->
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <p class="text-2xl text-gray-700 mb-4">Hello, <span class="font-semibold text-blue-600"><?php echo htmlspecialchars($_SESSION['username']); ?></span>!</p>
                    <p class="text-xl text-gray-600 mb-8">You are viewing admission details.</p>
                <?php else: ?>
                    <p class="text-2xl text-gray-700 mb-4">Hello, <span class="font-semibold text-blue-600">Guest</span>!</p>
                    <p class="text-xl text-gray-600 mb-8">Feel free to explore our admission process.</p>
                <?php endif; ?>

                <!-- Admission Details Section -->
                <div class="text-left mt-8 mb-8">
                    <div class="mb-6">
                        <h2 class="text-3xl font-bold text-gray-800 mb-3">Eligibility and Requirements</h2>
                        <p class="text-lg text-gray-700"><?php echo htmlspecialchars($admission_details['eligibility']); ?></p>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-3xl font-bold text-gray-800 mb-3">Required Documents</h2>
                        <ul class="list-disc list-inside text-lg text-gray-700">
                            <?php foreach ($admission_details['documents'] as $doc): ?>
                                <li><?php echo htmlspecialchars($doc); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-3xl font-bold text-gray-800 mb-3">Important Dates</h2>
                        <ul class="list-disc list-inside text-lg text-gray-700">
                            <?php foreach ($admission_details['important_dates'] as $date): ?>
                                <li><?php echo htmlspecialchars($date); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <!-- Call to Action Buttons -->
                <div class="flex flex-col md:flex-row justify-center items-center gap-4 mt-8">
                    <a href="#" class="inline-block w-full md:w-auto px-8 py-3 rounded-md font-semibold text-white shadow-lg button-animated">
                        Apply Now
                    </a>
                    <a href="dashboard.php" class="inline-block w-full md:w-auto px-8 py-3 rounded-md font-semibold text-white bg-gray-500 hover:bg-gray-600 shadow-lg transition-colors duration-200">
                        Back to Dashboard
                    </a>
                </div>
            </div>

            <!-- Right side: The poster image with animation -->
            <div class="lg:w-1/3 flex justify-center items-center">
                <img src="<?php echo htmlspecialchars($admission_poster); ?>" alt="Admission Poster" class="rounded-lg shadow-xl w-full h-auto object-cover md:max-w-md poster-image">
            </div>
        </div>

        <!-- Footer Contact Information -->
        <footer class="bg-blue-700 text-white p-6 rounded-lg shadow-xl w-full max-w-4xl text-center mt-8">
            <h4 class="text-2xl font-semibold mb-3">For More Information, Contact Us</h4>
            <p class="text-lg mb-2">
                <span class="font-medium">Location:</span> Himbari, Joar Sahara Bazar Road, Vatara, Dhaka-1229
            </p>
            <p class="text-lg">
                <span class="font-medium">Contact Numbers:</span>
                <?php echo implode(', ', array_map('htmlspecialchars', $contact_numbers)); ?>
            </p>
        </footer>
    </div>
</body>
</html>
