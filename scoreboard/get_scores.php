<?php
require_once('../config.php');

header('Content-Type: application/json');

$query = "SELECT u.name, COALESCE(SUM(s.score), 0) as total_score 
          FROM users u 
          LEFT JOIN scores s ON u.id = s.user_id 
          GROUP BY u.id, u.name 
          ORDER BY total_score DESC";

$result = $conn->query($query);
$scores = [];

while ($row = $result->fetch_assoc()) {
    $scores[] = [
        'name' => $row['name'],
        'total_score' => (int)$row['total_score']
    ];
}

echo json_encode($scores);