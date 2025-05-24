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
        .admin-header {
            background: var(--primary-color);
            color: white;
            padding: 1rem 0;
            margin-bottom: 2rem;
        }
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .btn-primary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }
        .alert {
            animation: fadeIn 0.5s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-0">Admin Panel</h1>
                <a href="users.php" class="btn btn-outline-light">User Management</a>
            </div>
        </div>
    </div>

    <div class="container">
        <?php if ($message): ?>
            <div class="alert alert-info animate__animated animate__fadeIn"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <div class="card animate__animated animate__fadeInUp">
            <div class="card-body">
                <h2 class="card-title mb-4">Add New Judge</h2>
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
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
require_once('../includes/header.php');