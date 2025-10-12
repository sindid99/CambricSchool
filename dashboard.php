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
$school_background_image = "1c0c9582-e847-47fa-ade3-44abc1183ebc.jpg";
$image1 = "Classroom.jpg";
$image2 = "student.jpg";
$image3 = "assembly.jpg";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Cambric School and College</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #64748b;
            --dark: #1e293b;
            --light: #f8fafc;
            --accent: #f59e0b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white;
            line-height: 1.6;
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            z-index: 1000;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
        }

        .logo span {
            color: var(--accent);
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
        }

        .nav-links a:hover {
            color: var(--accent);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: width 0.3s;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 80px 2rem 2rem;
            background: radial-gradient(circle at 20% 50%, rgba(37, 99, 235, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(245, 158, 11, 0.1) 0%, transparent 50%);
        }

        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #fff 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-content p {
            font-size: 1.1rem;
            color: #cbd5e1;
            margin-bottom: 2rem;
        }

        /* Cards Section */
        .section {
            padding: 100px 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 3rem;
            background: linear-gradient(135deg, #fff 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }

        .card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 2rem;
            transition: all 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--accent);
        }

        .card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--accent);
        }

        .card p {
            color: #cbd5e1;
            margin-bottom: 1.5rem;
        }

        /* Buttons */
        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--accent);
            color: #1e293b;
        }

        .btn-primary:hover {
            background: #d97706;
            transform: translateY(-2px);
        }

        .btn-outline {
            border: 2px solid var(--accent);
            color: var(--accent);
            background: transparent;
        }

        .btn-outline:hover {
            background: var(--accent);
            color: #1e293b;
            transform: translateY(-2px);
        }

        /* Image Gallery */
        .image-gallery {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin: 2rem 0;
        }

        .gallery-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            transition: transform 0.3s;
        }

        .gallery-image:hover {
            transform: scale(1.05);
        }

        /* Teacher List */
        .teacher-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
        }

        .teacher-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 1rem;
            border-radius: 10px;
            border-left: 3px solid var(--accent);
        }

        /* Footer */
        .footer {
            background: rgba(15, 23, 42, 0.95);
            padding: 3rem 2rem;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-container {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-content h1 {
                font-size: 2.5rem;
            }

            .nav-links {
                display: none;
            }

            .image-gallery {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="logo">Cambric<span>School</span></a>
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#teachers">Teachers</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="logout.php" class="btn btn-outline">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <h1>Welcome to Cambric School and College</h1>
                
                <!-- Personalized Welcome Message -->
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <p class="text-2xl text-gray-300 mb-4">Hello, <span class="font-semibold text-accent"><?php echo htmlspecialchars($_SESSION['username']); ?></span>!</p>
                    <p class="text-xl text-gray-400 mb-8">Your role: <span class="font-medium text-accent"><?php echo htmlspecialchars($_SESSION['role']); ?></span></p>
                <?php else: ?>
                    <p class="text-2xl text-gray-300 mb-4">Hello, <span class="font-semibold text-accent">Guest</span>!</p>
                    <p class="text-xl text-gray-400 mb-8">You are viewing public information.</p>
                <?php endif; ?>
                            <!-- Teacher Portal Section -->
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && $_SESSION['role'] === 'teacher'): ?>
                <div class="card mt-8 text-center">
                    <h3 class="text-2xl font-bold text-accent mb-4">Teacher Portal</h3>
                    <p class="text-gray-400 mb-4">Access your personal information and teaching resources</p>
                    <div class="flex justify-center gap-4">
                        <a href="teacher_info.php" class="btn btn-primary">
                            <i class="fas fa-user-circle"></i> My Information
                        </a>
                    </div>
                </div>
            <?php endif; ?>

                <p class="text-lg text-gray-400">Empowering students through quality education and holistic development since our inception.</p>

                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <!-- User specific content -->
                <?php else: ?>
                    <div class="bg-blue-900/50 border border-blue-400 text-blue-200 px-4 py-3 rounded-lg mb-6 mt-4">
                        <span class="block sm:inline">You are in Guest Mode. Register to access personalized information!</span>
                    </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-4 mt-8">
                    <a href="admission.php" class="btn btn-primary">
                        <i class="fas fa-user-graduate"></i>Admission Info
                    </a>
                    <a href="academic.php" class="btn btn-outline">
                        <i class="fas fa-book"></i>Academic Info
                    </a>
                    <a href="cocurricular.php" class="btn btn-outline">
                        <i class="fas fa-futbol"></i>Co-curricular
                    </a>
                </div>
            </div>
            
            <div class="hero-images">
                <div class="image-gallery">
                    <img src="<?php echo htmlspecialchars($image1); ?>" alt="School Classroom" class="gallery-image floating">
                    <img src="<?php echo htmlspecialchars($image2); ?>" alt="Students" class="gallery-image floating" style="animation-delay: 0.5s;">
                    <img src="<?php echo htmlspecialchars($image3); ?>" alt="School Assembly" class="gallery-image floating" style="animation-delay: 1s;">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="section">
        <h2 class="section-title">School Features</h2>
        <div class="cards-grid">
            <div class="card">
                <h3>📚 Academic Excellence</h3>
                <p>Comprehensive curriculum with both Bangla Medium and English Version programs. Morning and Day shifts available for flexible learning.</p>
                <a href="academic.php" class="btn btn-outline">Learn More</a>
            </div>
            
            <div class="card">
                <h3>🎓 Modern Education</h3>
                <p>Well-equipped classrooms with modern teaching aids and technology integration to enhance learning experience.</p>
                <a href="academic.php" class="btn btn-outline">View Facilities</a>
            </div>
            
            <div class="card">
                <h3>🏆 Co-curricular Activities</h3>
                <p>Diverse sports, cultural events, and clubs to develop students' talents beyond academics.</p>
                <a href="cocurricular.php" class="btn btn-outline">Explore Activities</a>
            </div>
        </div>
    </section>

    <!-- Teachers Section -->
    <section id="teachers" class="section">
        <h2 class="section-title">Our Esteemed Teachers</h2>
        <div class="teacher-grid">
            <?php foreach ($teachers as $teacher): ?>
                <div class="teacher-item">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-accent rounded-full mr-3"></div>
                        <span class="text-gray-300"><?php echo htmlspecialchars($teacher); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section">
        <h2 class="section-title">Contact Us</h2>
        <div class="cards-grid">
            <div class="card text-center">
                <h3>📍 Location</h3>
                <p class="text-gray-300"><?php echo htmlspecialchars($school_location); ?></p>
            </div>
            
            <div class="card text-center">
                <h3>📞 Contact</h3>
                <p class="text-gray-300"><?php echo htmlspecialchars($contact_number); ?></p>
            </div>
            
            <div class="card text-center">
                <h3>🕒 Office Hours</h3>
                <p class="text-gray-300">Sunday - Thursday<br>8:00 AM - 5:00 PM</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="max-w-6xl mx-auto">
            <h3 class="text-2xl font-bold text-accent mb-4">Cambric School and College</h3>
            <p class="text-gray-400 mb-4">Committed to excellence in education and character building</p>
            <div class="flex justify-center gap-6 mb-4">
                <a href="admission.php" class="text-gray-400 hover:text-accent transition-colors">Admission</a>
                <a href="academic.php" class="text-gray-400 hover:text-accent transition-colors">Academics</a>
                <a href="cocurricular.php" class="text-gray-400 hover:text-accent transition-colors">Activities</a>
            </div>
            <p class="text-gray-500 text-sm">&copy; 2024 Cambric School and College. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 100) {
                navbar.style.background = 'rgba(15, 23, 42, 0.98)';
            } else {
                navbar.style.background = 'rgba(15, 23, 42, 0.95)';
            }
        });
    </script>
</body>
</html>