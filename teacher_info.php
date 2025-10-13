<?php
session_start();

// Redirect if not logged in or not a teacher
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'teacher') {
    header("Location: login.php");
    exit;
}

require_once 'db_config.php';

// Fetch teacher information from database
$user_id = $_SESSION['id'];
$username = $_SESSION['username'];
$teacher_info = null;

// Try multiple methods to find teacher info
$stmt = $conn->prepare("SELECT * FROM teachers WHERE user_id = ? OR email = ?");
$stmt->bind_param("is", $user_id, $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $teacher_info = $result->fetch_assoc();
} else {
    // If still not found, try just by email
    $stmt2 = $conn->prepare("SELECT * FROM teachers WHERE email = ?");
    $stmt2->bind_param("s", $username);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    
    if ($result2->num_rows > 0) {
        $teacher_info = $result2->fetch_assoc();
    }
    $stmt2->close();
}

$stmt->close();
$conn->close();

// Rest of your my_information.php code remains the same...
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Information - Cambric School</title>
    
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
            min-height: 100vh;
        }

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
        }

        .nav-links a:hover {
            color: var(--accent);
        }

        .main-content {
            margin-top: 80px;
            padding: 2rem;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
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

        .profile-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            margin-bottom: 2rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .info-item {
            display: flex;
            justify-content: between;
            align-items: center;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            border-left: 4px solid var(--accent);
        }

        .info-label {
            font-weight: 600;
            color: var(--accent);
            min-width: 150px;
        }

        .info-value {
            color: #cbd5e1;
            flex: 1;
        }

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

        .profile-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #1e293b;
            margin: 0 auto 1rem;
            border: 4px solid rgba(255, 255, 255, 0.2);
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .info-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            
            .info-label {
                min-width: auto;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="dashboard.php" class="logo">Cambric<span>School</span></a>
            <ul class="nav-links">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="teacher_info.php" style="color: var(--accent);">My Information</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <h1 class="section-title">My Information</h1>
        
        <?php if (!empty($teacher_info)): ?>
            <!-- Profile Header -->
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-accent"><?php echo htmlspecialchars($teacher_info['full_name']); ?></h2>
                    <p class="text-gray-400"><?php echo htmlspecialchars($teacher_info['subject'] ?? 'Teacher'); ?></p>
                </div>

                <!-- Personal Information -->
                <h3 class="text-2xl font-semibold text-accent mb-4">Personal Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Full Name:</span>
                        <span class="info-value"><?php echo htmlspecialchars($teacher_info['full_name']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value"><?php echo htmlspecialchars($teacher_info['email']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Phone:</span>
                        <span class="info-value"><?php echo htmlspecialchars($teacher_info['phone'] ?? 'Not provided'); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Subject:</span>
                        <span class="info-value"><?php echo htmlspecialchars($teacher_info['subject'] ?? 'Not specified'); ?></span>
                    </div>
                </div>

                <!-- Professional Information -->
                <h3 class="text-2xl font-semibold text-accent mb-4 mt-8">Professional Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Qualification:</span>
                        <span class="info-value"><?php echo htmlspecialchars($teacher_info['qualification'] ?? 'Not provided'); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Joining Date:</span>
                        <span class="info-value">
                            <?php 
                            if (!empty($teacher_info['joining_date']) && $teacher_info['joining_date'] !== '0000-00-00') {
                                echo date('F j, Y', strtotime($teacher_info['joining_date']));
                            } else {
                                echo 'Not provided';
                            }
                            ?>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Teacher ID:</span>
                        <span class="info-value">TCH-<?php echo str_pad($teacher_info['id'], 4, '0', STR_PAD_LEFT); ?></span>
                    </div>
                </div>

                <!-- Additional Information -->
                <h3 class="text-2xl font-semibold text-accent mb-4 mt-8">Additional Information</h3>
                <div class="info-grid">
                    <?php if (!empty($teacher_info['date_of_birth']) && $teacher_info['date_of_birth'] !== '0000-00-00'): ?>
                    <div class="info-item">
                        <span class="info-label">Date of Birth:</span>
                        <span class="info-value"><?php echo date('F j, Y', strtotime($teacher_info['date_of_birth'])); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($teacher_info['blood_group'])): ?>
                    <div class="info-item">
                        <span class="info-label">Blood Group:</span>
                        <span class="info-value"><?php echo htmlspecialchars($teacher_info['blood_group']); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($teacher_info['emergency_contact'])): ?>
                    <div class="info-item">
                        <span class="info-label">Emergency Contact:</span>
                        <span class="info-value"><?php echo htmlspecialchars($teacher_info['emergency_contact']); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($teacher_info['address'])): ?>
                    <div class="info-item" style="grid-column: 1 / -1;">
                        <span class="info-label">Address:</span>
                        <span class="info-value"><?php echo htmlspecialchars($teacher_info['address']); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="profile-card text-center">
                <div class="profile-avatar">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h2 class="text-2xl font-bold text-accent mb-4">Profile Not Found</h2>
                <p class="text-gray-400 mb-4">Your teacher profile information is not available in the system.</p>
                <p class="text-gray-400">Please contact the administration to set up your teacher profile.</p>
            </div>
        <?php endif; ?>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-4 justify-center mt-8">
            <a href="dashboard.php" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i>Back to Dashboard
            </a>
            <button class="btn btn-outline" onclick="window.print()">
                <i class="fas fa-print"></i>Print Information
            </button>
        </div>
    </div>

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