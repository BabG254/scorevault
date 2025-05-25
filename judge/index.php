<?php
require_once('../config.php');

$message = '';
$users_query = "SELECT * FROM users ORDER BY name";
$users_result = $conn->query($users_query);
$judges_query = "SELECT * FROM judges ORDER BY name";
$judges_result = $conn->query($judges_query);

// Get all scores with user and judge names
$scores_query = "SELECT s.*, u.name as user_name, j.name as judge_name 
                FROM scores s 
                JOIN users u ON s.user_id = u.id 
                JOIN judges j ON s.judge_id = j.id 
                ORDER BY s.timestamp DESC";
$scores_result = $conn->query($scores_query);

// Store results for reuse
$users = [];
$judges = [];
while ($user = $users_result->fetch_assoc()) {
    $users[] = $user;
}
while ($judge = $judges_result->fetch_assoc()) {
    $judges[] = $judge;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    $judge_id = filter_input(INPUT_POST, 'judge_id', FILTER_VALIDATE_INT);
    $score = filter_input(INPUT_POST, 'score', FILTER_VALIDATE_INT);
    
    // Input validation
    if ($user_id === false || $judge_id === false || $score === false) {
        $message = "Invalid input data";
    } elseif ($score < 1 || $score > 100) {
        $message = "Score must be between 1 and 100";
    } else {
        // Check if score exists
        $check_stmt = $conn->prepare("SELECT id FROM scores WHERE user_id = ? AND judge_id = ?");
        $check_stmt->bind_param("ii", $user_id, $judge_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            // Update existing score
            $stmt = $conn->prepare("UPDATE scores SET score = ?, timestamp = CURRENT_TIMESTAMP WHERE user_id = ? AND judge_id = ?");
            $stmt->bind_param("iii", $score, $user_id, $judge_id);
        } else {
            // Insert new score
            $stmt = $conn->prepare("INSERT INTO scores (user_id, judge_id, score) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $user_id, $judge_id, $score);
        }
        
        if ($stmt->execute()) {
            $message = "Score saved successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
        $check_stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Judge Portal - ScoreVault</title>
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
        .judge-header {
            background: linear-gradient(135deg, var(--secondary-color), var(--accent-color));
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }
        .btn-primary {
            background-color: var(--secondary-color);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        .nav-link {
            color: white;
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="judge-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-0">Judge Portal</h1>
                <nav>
                    <a href="../index.php" class="nav-link">Home</a>
                    <a href="../scoreboard/index.php" class="nav-link">Scoreboard</a>
                </nav>
            </div>
        </div>
    </div>

    <div class="container">
        <?php if ($message): ?>
            <div class="alert alert-info animate__animated animate__fadeIn"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <div class="card animate__animated animate__fadeInUp">
            <div class="card-body p-4">
                <h2 class="card-title mb-4">Submit Score</h2>
                <form method="POST" id="scoreForm">
                    <div class="mb-4">
                        <label for="judge_id" class="form-label">Select Judge</label>
                        <select class="form-select" id="judge_id" name="judge_id" required>
                            <option value="">Choose a judge...</option>
                            <?php while ($judge = $judges_result->fetch_assoc()): ?>
                                <option value="<?php echo $judge['id']; ?>">
                                    <?php echo htmlspecialchars($judge['name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="user_id" class="form-label">Select Participant</label>
                        <select class="form-select" id="user_id" name="user_id" required>
                            <option value="">Choose a participant...</option>
                            <?php while ($user = $users_result->fetch_assoc()): ?>
                                <option value="<?php echo $user['id']; ?>">
                                    <?php echo htmlspecialchars($user['name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="score" class="form-label">Score (1-100)</label>
                        <input type="number" class="form-control" id="score" name="score"
                               min="1" max="100" required>
                        <div class="form-text">Enter a score between 1 and 100</div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Submit Score</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container data-section">
        <div class="row">
            <!-- Judges List -->
            <div class="col-md-4">
                <div class="card data-card animate__animated animate__fadeInLeft">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Active Judges</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($judges as $judge): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($judge['id']); ?></td>
                                            <td><?php echo htmlspecialchars($judge['name']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users List -->
            <div class="col-md-4">
                <div class="card data-card animate__animated animate__fadeInUp">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Participants</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Scores -->
            <div class="col-md-4">
                <div class="card data-card animate__animated animate__fadeInRight">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Recent Scores</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Participant</th>
                                        <th>Judge</th>
                                        <th>Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($score = $scores_result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($score['user_name']); ?></td>
                                            <td><?php echo htmlspecialchars($score['judge_name']); ?></td>
                                            <td>
                                                <span class="score-badge">
                                                    <?php echo htmlspecialchars($score['score']); ?>
                                                </span>
                                                <div class="timestamp">
                                                    <?php echo date('M d, Y H:i', strtotime($score['timestamp'])); ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.getElementById('scoreForm').addEventListener('submit', function(e) {
        const score = parseInt(document.getElementById('score').value);
        if (score < 1 || score > 100) {
            e.preventDefault();
            alert('Score must be between 1 and 100');
        }
    });
    </script>
</body>
</html>