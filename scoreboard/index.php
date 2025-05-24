<?php
require_once('../config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scoreboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .top-scorer {
            background-color: #ffd700;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Scoreboard</h2>
        <div id="scoreboard"></div>
    </div>

    <script>
    function updateScoreboard() {
        fetch('get_scores.php')
            .then(response => response.json())
            .then(data => {
                let html = '<table class="table table-striped">';
                html += '<thead><tr><th>Rank</th><th>Name</th><th>Total Score</th></tr></thead><tbody>';
                
                data.forEach((user, index) => {
                    const rowClass = index === 0 ? 'top-scorer' : '';
                    html += `<tr class="${rowClass}">`;
                    html += `<td>${index + 1}</td>`;
                    html += `<td>${user.name}</td>`;
                    html += `<td>${user.total_score}</td>`;
                    html += '</tr>';
                });
                
                html += '</tbody></table>';
                document.getElementById('scoreboard').innerHTML = html;
            });
    }

    // Initial update
    updateScoreboard();

    // Auto-refresh every 10 seconds
    setInterval(updateScoreboard, 10000);
    </script>
</body>
</html>