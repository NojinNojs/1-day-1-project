<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><?= $langData['welcome']; ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><?= $langData['home']; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="leaderboard.php"><?= $langData['leaderboard']; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php"><?= $langData['about']; ?></a>
                </li>
            </ul>
            <form class="d-flex" method="get">
                <select name="lang" onchange="this.form.submit()" class="form-select">
                    <option value="en" <?= (isset($_SESSION['lang']) && $_SESSION['lang'] == 'en') ? 'selected' : ''; ?>>
                        English</option>
                    <option value="id" <?= (isset($_SESSION['lang']) && $_SESSION['lang'] == 'id') ? 'selected' : ''; ?>>
                        Bahasa Indonesia</option>
                </select>
            </form>
        </div>
    </div>
</nav>