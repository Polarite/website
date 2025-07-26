<?php
// get_comments.php: Returns all comments as JSON
header('Content-Type: application/json');

// Get section parameter (default to 'main' for backward compatibility)
$section = isset($_GET['section']) ? $_GET['section'] : 'main';
$allowedSections = ['main', 'modpack1', 'modpack2'];
if (!in_array($section, $allowedSections)) {
    echo '[]';
    exit;
}

$commentsFile = __DIR__ . '/../data/comments_' . $section . '.json';
if (file_exists($commentsFile)) {
    $comments = file_get_contents($commentsFile);
    $json = json_decode($comments, true);
    if (!is_array($json)) {
        echo '[]';
    } else {
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
} else {
    echo '[]';
}
