<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorite Cats - Meowgical Cat Gallery ✨</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <!-- Modern Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-cat me-2"></i>Meowgical
            </a>
            <div class="nav-actions">
                <button id="darkModeToggle" class="btn btn-icon">
                    <i class="fas fa-moon"></i>
                </button>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <!-- Modern Header with Floating Cats -->
        <div class="floating-cats mb-4">
            <span class="floating-cat">😺</span>
            <span class="floating-cat">😸</span>
            <span class="floating-cat">😻</span>
        </div>

        <h1 class="text-center page-title mb-4">
            <i class="fas fa-heart me-2"></i>My Favorite Cats<i class="fas fa-heart ms-2"></i>
        </h1>
        
        <div class="text-center mb-5">
            <a href="index.php" class="btn btn-primary btn-lg">
                <i class="fas fa-arrow-left me-2"></i>Back to Gallery
            </a>
        </div>

        <!-- Favorite Gallery with Loading State -->
        <div class="row g-4" id="favorite-gallery">
            <div class="col-12 text-center" id="loading">
                <div class="loading-container">
                    <div class="loading-spinner"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast for Notifications -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body"></div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize dark mode
            const darkModeToggle = document.getElementById('darkModeToggle');
            darkModeToggle.addEventListener('click', () => {
                document.body.classList.toggle('dark-mode');
                localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
                darkModeToggle.querySelector('i').classList.toggle('fa-moon');
                darkModeToggle.querySelector('i').classList.toggle('fa-sun');
            });

            // Check saved dark mode preference
            if (localStorage.getItem('darkMode') === 'true') {
                document.body.classList.add('dark-mode');
                darkModeToggle.querySelector('i').classList.replace('fa-moon', 'fa-sun');
            }

            // Animate floating cats
            const floatingCats = document.querySelectorAll('.floating-cat');
            floatingCats.forEach((cat, index) => {
                cat.style.animationDelay = `${index * 0.5}s`;
            });

            // Load favorites with animation
            setTimeout(() => {
                $('#loading').remove();
                let favorites = JSON.parse(localStorage.getItem('favorites')) || [];
                const gallery = $('#favorite-gallery');

                if (favorites.length === 0) {
                    gallery.html(`
                        <div class="col-12 text-center">
                            <div class="empty-state">
                                <i class="fas fa-heart-broken mb-3" style="font-size: 3rem; color: var(--primary)"></i>
                                <h3>No Favorite Cats Yet</h3>
                                <p class="text-muted">Go back to the gallery and find some cute cats to love!</p>
                            </div>
                        </div>
                    `);
                } else {
                    favorites.forEach((url, index) => {
                        const card = `
                            <div class="col-sm-6 col-md-4 col-lg-3" style="animation-delay: ${index * 0.1}s">
                                <div class="cat-card">
                                    <div class="cat-img-container">
                                        <img src="${url}" class="cat-img" alt="Favorite Cat">
                                    </div>
                                    <div class="card-actions">
                                        <button class="btn btn-favorite" onclick="removeFavorite('${url}')">
                                            <i class="fas fa-heart-broken me-2"></i>Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        gallery.append(card);
                    });
                }
            }, 1000);
        });

        function removeFavorite(url) {
            let favorites = JSON.parse(localStorage.getItem('favorites')) || [];
            favorites = favorites.filter(favUrl => favUrl !== url);
            localStorage.setItem('favorites', JSON.stringify(favorites));
            
            // Show toast notification
            const toast = new bootstrap.Toast(document.getElementById('liveToast'));
            document.querySelector('.toast-body').innerHTML = `
                <i class="fas fa-heart-broken me-2"></i>Removed from favorites
            `;
            toast.show();

            // Animate removal and reload
            const card = event.target.closest('.col-sm-6');
            card.style.animation = 'fadeOut 0.5s ease forwards';
            setTimeout(() => {
                location.reload();
            }, 500);
        }
    </script>
</body>

</html>