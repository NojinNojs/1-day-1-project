<?php
include 'list-projects.php';

// Initialize search and sort variables
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$filteredProjects = [];

// Filter projects based on search term
if ($searchTerm) {
    foreach ($projects as $project) {
        if (stripos($project["title"], $searchTerm) !== false || stripos($project["description"], $searchTerm) !== false || stripos("day " . $project["day"], $searchTerm) !== false) {
            $filteredProjects[] = $project;
        }
    }
} else {
    $filteredProjects = $projects; // If no search term, show all projects
}

// Sort projects based on sort order
if ($sortOrder === 'newest') {
    usort($filteredProjects, function ($a, $b) {
        return $b['day'] - $a['day'];
    });
} elseif ($sortOrder === 'oldest') {
    usort($filteredProjects, function ($a, $b) {
        return $a['day'] - $b['day'];
    });
}

// Pagination logic
$perPage = 5;
$totalProjects = count($filteredProjects);
$totalPages = ceil($totalProjects / $perPage);
$currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$currentPage = max(1, min($currentPage, $totalPages)); // Ensure current page is within bounds
$offset = ($currentPage - 1) * $perPage;
$projectsToDisplay = array_slice($filteredProjects, $offset, $perPage);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Projects</title>
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
    <div class="container mx-auto px-4 py-16">
        <h1 class="text-3xl font-bold mb-8 text-center">All Projects</h1>

        <div class="mb-4">
            <form method="GET" action="">
                <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-2">
                    <input name="search" class="input input-bordered bg-white w-full sm:w-auto" placeholder="Search"
                        value="<?= htmlspecialchars($searchTerm) ?>" />
                    <select name="sort" class="select select-bordered bg-white w-full sm:w-auto" onchange="this.form.submit()">
                        <option value="newest" <?= $sortOrder === 'newest' ? 'selected' : '' ?>>Sort by Newest</option>
                        <option value="oldest" <?= $sortOrder === 'oldest' ? 'selected' : '' ?>>Sort by Oldest</option>
                    </select>
                    <button type="submit" class="btn text-white bg-black w-full sm:w-auto">Search</button>
                    <a href="projects.php" class="btn text-white bg-black w-full sm:w-auto">Clear</a>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php if (empty($projectsToDisplay)) { ?>
                <div class="text-center text-gray-500 col-span-full">No projects found.</div>
            <?php } else { ?>
                <?php foreach ($projectsToDisplay as $project) { ?>
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
            <?php } ?>
        </div>

        <div class="mt-4 text-center">
            <a href="index.php" class="btn bg-black text-white">Back to Home</a>
        </div>

        <div class="mt-4">
            <nav>
                <div class="flex justify-center space-x-2">
                    <?php if ($currentPage > 1): ?>
                        <button class="btn btn-outline text-black border-black hover:text-white hover:bg-black" onclick="window.location.href='?page=<?= $currentPage - 1 ?>&search=<?= urlencode($searchTerm) ?>&sort=<?= urlencode($sortOrder) ?>'">Previous</button>
                    <?php endif; ?>
                    <button class="btn btn-outline text-black border-black hover:text-white hover:bg-black" onclick="jump_modal.showModal()">...</button>
                    <?php if ($currentPage < $totalPages): ?>
                        <button class="btn btn-outline text-black border-black hover:text-white hover:bg-black" onclick="window.location.href='?page=<?= $currentPage + 1 ?>&search=<?= urlencode($searchTerm) ?>&sort=<?= urlencode($sortOrder) ?>'">Next</button>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </div>

    <dialog id="jump_modal" class="modal">
        <div class="modal-box bg-white">
            <h3 class="text-lg font-bold">Jump to Page</h3>
            <form method="GET" action="">
                <input type="hidden" name="search" value="<?= htmlspecialchars($searchTerm) ?>">
                <input type="hidden" name="sort" value="<?= htmlspecialchars($sortOrder) ?>">
                <div class="py-4">
                    <input type="number" name="page" class="input input-bordered w-full bg-white" min="1" max="<?= $totalPages ?>" placeholder="Enter page number">
                </div>
                <div class="modal-action flex justify-between">
                    <button type="button" class="btn text-black bg-white hover:text-white" onclick="jump_modal.close()">Cancel</button>
                    <button type="submit" class="btn text-white bg-black">Go</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
</body>

</html>