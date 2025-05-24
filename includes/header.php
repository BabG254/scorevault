<?php
function getActivePage() {
    $path = $_SERVER['PHP_SELF'];
    if (strpos($path, '/admin/') !== false) return 'admin';
    if (strpos($path, '/judge/') !== false) return 'judge';
    if (strpos($path, '/scoreboard/') !== false) return 'scoreboard';
    return 'home';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScoreVault - <?php echo ucfirst(getActivePage()); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .nav-link.active { font-weight: bold; }
        .top-scorer { background-color: #ffd700 !important; }
        .navbar-brand { font-size: 1.5rem; }
        .content-wrapper { margin-top: 2rem; }
        .score-badge {
            font-size: 1.2rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0,0,0,.075);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/ScoreVault/">ScoreVault</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo getActivePage() == 'scoreboard' ? 'active' : ''; ?>" 
                           href="/ScoreVault/scoreboard/">Scoreboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo getActivePage() == 'judge' ? 'active' : ''; ?>" 
                           href="/ScoreVault/judge/">Judge Portal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo getActivePage() == 'admin' ? 'active' : ''; ?>" 
                           href="/ScoreVault/admin/">Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container content-wrapper">