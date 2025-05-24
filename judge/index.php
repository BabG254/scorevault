<?php
require_once('../config.php');
require_once('../includes/header.php');

$message = '';

// Fetch all users
$users_query = "SELECT * FROM users ORDER BY name";
$users_result = $conn->query($users_query);

// Fetch all judges
$judges_query = "SELECT * FROM judges ORDER BY name";
$judges_result = $conn->query($judges_query);

// Handle score submission
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
    <title>Judge Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Judge Portal</h2>
        
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header">
                <h4>Submit Score</h4>
            </div>
            <div class="card-body">
                <form method="POST" class="mb-4" id="scoreForm">
                    <div class="mb-3">
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
                    
                    <div class="mb-3">
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
                    
                    <div class="mb-3">
                        <label for="score" class="form-label">Score (1-100)</label>
                        <input type="number" class="form-control" id="score" name="score"
                               min="1" max="100" required>
                        <div class="form-text">Enter a score between 1 and 100</div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submit Score</button>
                </form>
            </div>
        </div>
    </div>

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