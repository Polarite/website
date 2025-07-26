<?php
// save_comment.php: Receives POSTed comment data and appends to comments.json
header('Content-Type: application/json');

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['name']) || !isset($data['text'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing fields']);
    exit;
}

// Get section parameter (default to 'main' for backward compatibility)
$section = isset($data['section']) ? $data['section'] : 'main';
$allowedSections = ['main', 'modpack1', 'modpack2'];
if (!in_array($section, $allowedSections)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid section']);
    exit;
}

$commentsFile = __DIR__ . '/../data/comments_' . $section . '.json';
$name = trim(substr($data['name'], 0, 32));
$text = trim(substr($data['text'], 0, 300));

// Check if text is empty after trimming
if (empty($text)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Comment text cannot be empty']);
    exit;
}

$time = gmdate('Y-m-d\TH:i:s\Z'); // Save as UTC ISO 8601

// Check if data directory is writable
if (!is_writable(__DIR__ . '/../data/')) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Data directory not writable']);
    exit;
}

// Read existing comments
$comments = file_exists($commentsFile) ? json_decode(file_get_contents($commentsFile), true) : [];
if (!is_array($comments)) $comments = [];

// Add new comment
$newComment = [
    'name' => $name ?: 'Anonymous',
    'text' => $text,
    'time' => $time // UTC ISO 8601
];

// Include clientTime if provided
if (isset($data['clientTime'])) {
    $newComment['clientTime'] = $data['clientTime'];
}

$comments[] = $newComment;

// Save back to file with error checking
$result = file_put_contents($commentsFile, json_encode($comments, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

if ($result === false) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to write to file: ' . $commentsFile]);
    exit;
}

echo json_encode(['success' => true, 'debug' => ['section' => $section, 'file' => $commentsFile]]);
?>
