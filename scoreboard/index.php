<?php
require_once('../config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScoreVault - Scoreboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
        }
        body {
            background-color: #f8f9fa;
        }
        .scoreboard-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .top-scorer {
            background-color: #ffd70033 !important;
            animation: glow 2s infinite alternate;
        }
        @keyframes glow {
            from { box-shadow: 0 0 5px #ffd700; }
            to { box-shadow: 0 0 20px #ffd700; }
        }
        .score-badge {
            background: var(--secondary-color);
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }
        .score-badge:hover {
            transform: scale(1.1);
        }
        .table {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .table th {
            background-color: var(--primary-color);
            color: white;
        }
        tr {
            transition: transform 0.2s ease;
        }
        tr:hover {
            transform: translateX(5px);
        }
        .nav-link {
            color: white;
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: var(--accent-color);
        }
    </style>
</head>
<body>
    <div class="scoreboard-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-0">Live Scoreboard</h1>
                <nav>
                    <a href="../index.php" class="nav-link">Home</a>
                    <a href="../judge/index.php" class="nav-link">Judge Portal</a>
                </nav>
            </div>
        </div>
    </div>

    <div class="container animate__animated animate__fadeIn">
        <div id="scoreboard"></div>
    </div>

    <script>
    function updateScoreboard() {
        fetch('get_scores.php')
            .then(response => response.json())
            .then(data => {
                let html = '<table class="table table-hover animate__animated animate__fadeIn">';
                html += '<thead><tr><th>Rank</th><th>Name</th><th>Total Score</th></tr></thead><tbody>';
                
                data.forEach((user, index) => {
                    const rowClass = index === 0 ? 'top-scorer' : '';
                    const rank = index + 1;
                    const rankBadge = rank === 1 ? '🏆' : rank === 2 ? '🥈' : rank === 3 ? '🥉' : rank;
                    
                    html += `<tr class="${rowClass}">`;
                    html += `<td>${rankBadge}</td>`;
                    html += `<td>${user.name}</td>`;
                    html += `<td><span class="badge score-badge">${user.total_score}</span></td>`;
                    html += '</tr>';
                });
                
                html += '</tbody></table>';
                const scoreboard = document.getElementById('scoreboard');
                scoreboard.innerHTML = html;
            });
    }

    updateScoreboard();
    setInterval(updateScoreboard, 10000);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>