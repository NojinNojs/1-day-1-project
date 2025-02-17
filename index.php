<?php
include 'list-projects.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nojin 1 Day 1 Project</title>

    <!-- Primary Meta Tags -->
    <meta name="title" content="Nojin 1 Day 1 Project">
    <meta name="description"
        content="Enhance nojin programming skills with daily coding projects. Learn web development through hands-on experience with HTML, CSS, JavaScript, PHP and more.">
    <meta name="keywords"
        content="1 day 1 project, Nojin, my projects, coding practice, web development, daily coding, learn programming, HTML, CSS, JavaScript, PHP, Nojin 1 Day 1 Project">
    <meta name="author" content="NojinNojs">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://github.com/NojinNojs/1-day-1-project">
    <meta property="og:title" content="Nojin 1 Day 1 Project">
    <meta property="og:description"
        content="Enhance Nojin programming skills with daily coding projects. Learn web development through hands-on experience with HTML, CSS, JavaScript, PHP and more.">
    <meta property="og:image" content="https://raw.githubusercontent.com/NojinNojs/1-day-1-project/main/preview.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://github.com/NojinNojs/1-day-1-project">
    <meta property="twitter:title" content="My Daily Programming Projects">
    <meta property="twitter:description"
        content="Enhance my programming skills with daily coding projects. Learn web development through hands-on experience with HTML, CSS, JavaScript, PHP and more.">
    <meta property="twitter:image"
        content="https://raw.githubusercontent.com/NojinNojs/1-day-1-project/main/preview.png">

    <!-- Discord -->
    <meta name="theme-color" content="#4F46E5">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.13/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'custom-bg': '#f9f9f9',
                        'custom-text': '#111111',
                        'custom-button': '#2e2e2e',
                    },
                },
            },
        }
    </script>
    <style>
        html {
            scroll-behavior: smooth;
            overscroll-behavior: none;
        }

        body {
            font-family: 'Poppins', sans-serif;
            overscroll-behavior: none;
        }

        .carousel-container {
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            /* For Firefox */
        }

        .carousel-container::-webkit-scrollbar {
            display: none;
            /* For Chrome, Safari, and Opera */
        }

        .carousel-item {
            scroll-snap-align: start;
        }

        .stat {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-custom-bg text-custom-text">
    <div class="container mx-auto px-4 py-16 max-w-7xl">
        <h1 class="text-5xl font-bold mb-8 text-center" data-aos="fade-down">1 Day 1 Project</h1>

        <div data-aos="fade-up"
            class="mb-8 p-6 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg shadow-lg text-white">
            <h2 class="text-4xl font-bold mb-4"><i class="fas fa-star"></i> 1 Day 1 Project</h2>
            <p class="mb-4 text-lg">Welcome to my <strong>1 Day 1 Project</strong>, an exciting initiative designed to
                supercharge my programming skills! <i class="fas fa-rocket"></i> By engaging in small, daily projects,
                I'll not only learn but
                also apply various concepts and technologies that are essential in the world of software development.
            </p>
            <p class="mb-4 text-lg">Join me in this journey of creativity and innovation, where each day brings a new
                challenge and opportunity to grow!</p>
        </div>

        <div data-aos="fade-up" class="mb-8">
            <h3 class="text-3xl font-bold mt-8 mb-4"><i class="fas fa-bullseye"></i> My Ambitious Objectives</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow-lg p-4 transition-transform transform hover:scale-105">
                    <h4 class="text-xl font-semibold mb-2"><i class="fas fa-tools"></i> Enhance My Skills</h4>
                    <p>Improve my programming and software development skills through hands-on experience.</p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-4 transition-transform transform hover:scale-105">
                    <h4 class="text-xl font-semibold mb-2"><i class="fas fa-globe"></i> Explore New Technologies</h4>
                    <p>Dive into a diverse array of technologies and frameworks to broaden my expertise.</p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-4 transition-transform transform hover:scale-105">
                    <h4 class="text-xl font-semibold mb-2"><i class="fas fa-folder"></i> Build My Portfolio</h4>
                    <p>Create a compelling project portfolio that highlights my technical prowess and creativity.</p>
                </div>
            </div>
        </div>

        <h2 class="text-3xl font-bold mb-8" id="projects" data-aos="fade-up">My Completed Projects</h2>

        <div class="flex flex-col space-y-4 pb-4" data-aos="fade-up">
            <?php
            $maxProjects = 3; // Limit to 3 projects
            $displayedProjects = array_slice($projects, -$maxProjects, 3, true); // Get the last 3 projects (latest)
            $displayedProjects = array_reverse($displayedProjects); // Reverse the order to show the latest first
            foreach ($displayedProjects as $project) { ?>
                <div class="card bg-white w-full shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title"><?= $project["title"] ?></h2>
                        <div class="badge text-white bg-black">Day <?= $project["day"] ?></div>
                        <p><?= $project["description"] ?></p>
                        <div class="mt-2">
                            <i class="fas fa-code"></i> <?= $project["technologies"] ?>
                        </div>
                        <div class="card-actions justify-end">
                            <a href="<?= $project["link"] ?>"
                                class="btn text-white bg-black transition-transform transform hover:scale-105">View
                                Project</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="text-center mt-4">
                <a href="projects.php"
                    class="btn bg-black text-white transition-transform transform hover:scale-105">View All
                    My Projects</a>
            </div>


            <footer class="footer footer-center p-4 text-base-content mt-16">
                <p>Copyright &copy; <?= date("Y") ?> NojinNojs. All rights reserved.</p>
            </footer>

            <script>
                AOS.init();
            </script>
</body>

</html>