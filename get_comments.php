<?php
// get_comments.php: Returns all comments as JSON
header('Content-Type: application/json');
$commentsFile = __DIR__ . '/comments.json';
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
