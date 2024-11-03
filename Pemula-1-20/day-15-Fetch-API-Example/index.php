<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meowgical Cat Gallery ✨</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="theme-color" content="#ff6b6b">
    <meta name="description" content="Discover and collect adorable cat photos in our magical cat gallery">
</head>

<body>
    <!-- Modern Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="fas fa-cat me-2 bounce"></i>
                <span class="brand-text">Meowgical</span>
            </a>
            <div class="nav-actions d-flex align-items-center">
                <button id="darkModeToggle" class="btn btn-icon" aria-label="Toggle dark mode">
                    <i class="fas fa-moon"></i>
                </button>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <!-- Modern Header -->
        <header class="text-center mb-5">
            <div class="floating-cats">
                <span class="floating-cat" role="img" aria-label="Happy cat">😺</span>
                <span class="floating-cat delayed-1" role="img" aria-label="Grinning cat">😸</span>
                <span class="floating-cat delayed-2" role="img" aria-label="Laughing cat">😹</span>
            </div>

            <h1 class="page-title">
                <i class="fas fa-paw me-2 bounce"></i>
                Meowgical Cat Gallery
                <i class="fas fa-paw ms-2 bounce-reverse"></i>
            </h1>
            <p class="lead text-muted mb-4">Discover and collect adorable cat photos</p>
            <div class="header-actions">
                <a href="favorites.php" class="btn btn-outline-primary btn-lg me-2 wobble-on-hover">
                    <i class="fas fa-heart me-2"></i>My Favorites
                </a>
            </div>
        </header>

        <!-- Modern Search Section -->
        <section class="search-container mb-5">
            <h3 class="search-title text-center mb-4">
                <i class="fas fa-search me-2"></i>Find Your Purr-fect Cat!
            </h3>
            <form method="GET" class="row g-4 align-items-end" id="searchForm">
                <div class="col-lg-3 col-md-6">
                    <label for="limit" class="form-label fw-bold">
                        <i class="fas fa-photo-film me-2"></i>Number of Photos
                    </label>
                    <input type="number" id="limit" name="limit" class="form-control form-control-lg" min="1" max="20"
                        placeholder="Max: 20" value="<?php echo isset($_GET['limit']) ? $_GET['limit'] : '5'; ?>">
                </div>
                <div class="col-lg-3 col-md-6">
                    <label for="page" class="form-label fw-bold">
                        <i class="fas fa-file-alt me-2"></i>Page
                    </label>
                    <input type="number" id="page" name="page" class="form-control form-control-lg" min="1" placeholder="1"
                        value="<?php echo isset($_GET['page']) ? $_GET['page'] : '1'; ?>">
                </div>
                <div class="col-lg-4 col-md-8">
                    <label for="category" class="form-label fw-bold">
                        <i class="fas fa-tags me-2"></i>Category
                    </label>
                    <select id="category" name="category" class="form-select form-select-lg">
                        <option value="">All Categories</option>
                        <option value="1" <?php echo isset($_GET['category']) && $_GET['category'] == '1' ? 'selected' : ''; ?>>Cats with Hats</option>
                        <option value="4" <?php echo isset($_GET['category']) && $_GET['category'] == '4' ? 'selected' : ''; ?>>Cool Cats with Sunglasses</option>
                        <option value="5" <?php echo isset($_GET['category']) && $_GET['category'] == '5' ? 'selected' : ''; ?>>Cats in Boxes</option>
                        <option value="15" <?php echo isset($_GET['category']) && $_GET['category'] == '15' ? 'selected' : ''; ?>>Fashionable Cats</option>
                        <option value="2" <?php echo isset($_GET['category']) && $_GET['category'] == '2' ? 'selected' : ''; ?>>Funny Cats</option>
                        <option value="cute" <?php echo isset($_GET['category']) && $_GET['category'] == 'cute' ? 'selected' : ''; ?>>Extra Cute Cats</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-4">
                    <button type="submit" class="btn btn-search btn-lg w-100 pulse-on-hover">
                        <i class="fas fa-search me-2"></i>Find Cats
                    </button>
                </div>
            </form>
        </section>

        <!-- Modern Gallery Grid with Masonry Layout -->
        <div class="row g-4 masonry-grid" id="cat-gallery">
            <?php
            // Pengaturan jumlah foto, halaman, dan kategori
            $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
            $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
            $category = isset($_GET['category']) ? $_GET['category'] : '';

            if ($limit > 20) $limit = 20;

            $catApiUrl = "https://api.thecatapi.com/v1/images/search?limit={$limit}&page={$page}";
            if ($category) {
                $catApiUrl .= "&category_ids={$category}";
            }

            $cacheFile = "cache/cats_{$limit}_{$category}_{$page}.json";
            $cacheTime = 3600;

            if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheTime)) {
                $catData = json_decode(file_get_contents($cacheFile));
            } else {
                $catData = @json_decode(file_get_contents($catApiUrl));
                if (!file_exists('cache')) {
                    mkdir('cache', 0777, true);
                }
                if ($catData) {
                    file_put_contents($cacheFile, json_encode($catData));
                }
            }

            // Cache cleanup
            $files = glob('cache/*.json');
            foreach ($files as $file) {
                if (time() - filemtime($file) > 86400) {
                    unlink($file);
                }
            }

            if ($catData) {
                foreach ($catData as $index => $cat) {
                    echo '<div class="col-lg-4 col-md-6 mb-4 fade-in" style="animation-delay: '.($index * 0.1).'s">';
                    echo '<article class="cat-card h-100">';
                    echo '<div class="cat-img-container">';
                    echo '<img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="'.$cat->url.'" class="cat-img lazy" alt="Adorable Cat">';
                    echo '<div class="img-overlay">';
                    echo '<button class="btn btn-light btn-sm rounded-circle zoom-btn" onclick="viewFullImage(\''.$cat->url.'\')">';
                    echo '<i class="fas fa-expand"></i>';
                    echo '</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="card-actions">';
                    echo '<a href="'.$cat->url.'" download class="btn btn-download btn-lg">';
                    echo '<i class="fas fa-download me-2"></i>Download';
                    echo '</a>';
                    echo '<button class="btn btn-favorite btn-lg" onclick="addFavorite(\''.$cat->url.'\')">';
                    echo '<i class="fas fa-heart me-2"></i>Add to Favorites';
                    echo '</button>';
                    echo '<div class="card-stats mt-3">';
                    echo '<span class="views"><i class="fas fa-eye me-1"></i>123</span>';
                    echo '<span class="likes"><i class="fas fa-heart me-1"></i>45</span>';
                    echo '</div>';
                    echo '</div>';
                    echo '</article>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>

    <!-- Modern Image Preview Modal -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0 position-relative">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    <img id="previewImage" class="img-fluid rounded shadow-lg" alt="Cat Preview">
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Loading Animation -->
    <div class="loading-container d-none">
        <div class="loading-spinner"></div>
        <p class="mt-3 loading-text">Finding the cutest cats...</p>
    </div>

    <!-- Modern Toast Notification -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080">
        <div id="toastNotification" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex align-items-center">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i>Added to favorites!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced loader
            const loader = {
                show: () => {
                    document.querySelector('.loading-container').classList.remove('d-none');
                    document.getElementById('cat-gallery').style.opacity = '0.5';
                },
                hide: () => {
                    document.querySelector('.loading-container').classList.add('d-none');
                    document.getElementById('cat-gallery').style.opacity = '1';
                }
            };

            // Form handling with validation
            const searchForm = document.getElementById('searchForm');
            searchForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const limit = document.getElementById('limit').value;
                if (limit > 20) {
                    alert('Maximum limit is 20 photos!');
                    return;
                }
                loader.show();
                searchForm.submit();
            });

            // Enhanced image preview
            window.viewFullImage = (url) => {
                const img = document.getElementById('previewImage');
                img.src = url;
                const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
                modal.show();
            };

            // Enhanced favorites system
            window.addFavorite = (url) => {
                let favorites = JSON.parse(localStorage.getItem('favorites')) || [];
                if (!favorites.includes(url)) {
                    favorites.push(url);
                    localStorage.setItem('favorites', JSON.stringify(favorites));
                    
                    const toast = new bootstrap.Toast(document.getElementById('toastNotification'));
                    toast.show();
                    
                    const heart = document.createElement('div');
                    heart.innerHTML = '<i class="fas fa-heart"></i>';
                    heart.className = 'floating-heart';
                    document.body.appendChild(heart);
                    
                    setTimeout(() => heart.remove(), 1000);
                }
            };

            // Enhanced dark mode
            const darkModeToggle = document.getElementById('darkModeToggle');
            const updateDarkMode = (isDark) => {
                document.body.classList.toggle('dark-mode', isDark);
                darkModeToggle.querySelector('i').className = isDark ? 'fas fa-sun' : 'fas fa-moon';
                localStorage.setItem('darkMode', isDark);
            };

            darkModeToggle.addEventListener('click', () => {
                updateDarkMode(!document.body.classList.contains('dark-mode'));
            });

            if (localStorage.getItem('darkMode') === 'true') {
                updateDarkMode(true);
            }

            // Enhanced lazy loading
            const lazyLoad = (target) => {
                const io = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            img.classList.add('loaded');
                            observer.disconnect();
                        }
                    });
                });

                io.observe(target);
            };

            document.querySelectorAll('.lazy').forEach(lazyLoad);

            // Smooth scroll enhancement
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            });

            // Masonry layout initialization
            const masonryGrid = document.querySelector('.masonry-grid');
            const masonryOptions = {
                itemSelector: '.col-lg-4',
                percentPosition: true
            };
        });
    </script>
</body>
</html>