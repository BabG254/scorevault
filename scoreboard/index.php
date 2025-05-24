<?php
require_once('../config.php');
require_once('../includes/header.php');
?>

<h2 class="mb-4">Live Scoreboard</h2>
<div id="scoreboard"></div>

<script>
function updateScoreboard() {
    fetch('get_scores.php')
        .then(response => response.json())
        .then(data => {
            let html = '<table class="table table-hover table-striped">';
            html += '<thead class="table-dark"><tr><th>Rank</th><th>Name</th><th>Total Score</th></tr></thead><tbody>';
            
            data.forEach((user, index) => {
                const rowClass = index === 0 ? 'top-scorer' : '';
                html += `<tr class="${rowClass}">`;
                html += `<td>${index + 1}</td>`;
                html += `<td>${user.name}</td>`;
                html += `<td><span class="badge bg-primary score-badge">${user.total_score}</span></td>`;
                html += '</tr>';
            });
            
            html += '</tbody></table>';
            document.getElementById('scoreboard').innerHTML = html;
        });
}

updateScoreboard();
setInterval(updateScoreboard, 10000);
</script>

<?php require_once('../includes/footer.php'); ?>