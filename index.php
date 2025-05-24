<?php require_once('includes/header.php'); ?>

<div class="row justify-content-center">
    <div class="col-md-8 text-center">
        <h1 class="display-4 mb-4">Welcome to ScoreVault</h1>
        <p class="lead mb-4">A comprehensive scoring system for competitions and evaluations</p>
        
        <div class="row g-4 py-4">
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Scoreboard</h5>
                        <p class="card-text">View real-time competition scores and rankings</p>
                        <a href="scoreboard/index.php" class="btn btn-primary">View Scores</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Judge Portal</h5>
                        <p class="card-text">Submit and manage participant scores</p>
                        <a href="judge/index.php" class="btn btn-primary">Judge Portal</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Administration</h5>
                        <p class="card-text">Manage judges and participants</p>
                        <a href="admin/index.php" class="btn btn-primary">Admin Panel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('includes/footer.php'); ?>