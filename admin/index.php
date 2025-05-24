<?php
require_once('../config.php');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judge_id = $conn->real_escape_string($_POST['judge_id']);
    $name = $conn->real_escape_string($_POST['name']);
    
    $stmt = $conn->prepare("INSERT INTO judges (judge_id, name) VALUES (?, ?)");
    $stmt->bind_param("ss", $judge_id, $name);
    
    if ($stmt->execute()) {
        $message = "Judge added successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Judge Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Judge Management</h2>
            <a href="users.php" class="btn btn-outline-primary">User Management</a>
        </div>
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label for="judge_id" class="form-label">Judge ID</label>
                <input type="text" class="form-control" id="judge_id" name="judge_id" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Judge</button>
        </form>
    </div>
</body>
</html>