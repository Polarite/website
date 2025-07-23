<?php
// save_comment.php: Receives POSTed comment data and appends to comments.json
header('Content-Type: application/json');
$commentsFile = __DIR__ . '/comments.json';

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['name']) || !isset($data['text'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing fields']);
    exit;
}
$name = trim(substr($data['name'], 0, 32));
$text = trim(substr($data['text'], 0, 300));
$time = gmdate('Y-m-d\TH:i:s\Z'); // Save as UTC ISO 8601

// Read existing comments
$comments = file_exists($commentsFile) ? json_decode(file_get_contents($commentsFile), true) : [];
if (!is_array($comments)) $comments = [];

// Add new comment
$comments[] = [
    'name' => $name ?: 'Anonymous',
    'text' => $text,
    'time' => $time // UTC ISO 8601
];

// Save back to file
file_put_contents($commentsFile, json_encode($comments, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo json_encode(['success' => true]);
