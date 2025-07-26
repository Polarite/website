<?php
// Visitor stats JSON API
$counter_file = '../data/count.txt';
$date = date('Y-m-d');
$counts = [
  'total' => 0,
  'daily' => []
];
if (file_exists($counter_file)) {
  $data = file_get_contents($counter_file);
  $parsed = json_decode($data, true);
  if (is_array($parsed)) {
    $counts = $parsed;
  }
}
// Increment total
$counts['total'] = isset($counts['total']) ? $counts['total'] + 1 : 1;
// Increment today's count
if (!isset($counts['daily'][$date])) {
  $counts['daily'][$date] = 1;
} else {
  $counts['daily'][$date]++;
}
// Save back
file_put_contents($counter_file, json_encode($counts));
// Output JSON
header('Content-Type: application/json');
echo json_encode([
  'total' => $counts['total'],
  'today' => $counts['daily'][$date]
]);
