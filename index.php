<?php

header('Content-type: application/json');

if (strtolower($_SERVER['REQUEST_METHOD']) == 'get') {
  echo json_encode([
    "slackUsername" => "codelikesuraj",
    "backend" => true,
    "age" => 22,
    "bio" => "Backend developer"
  ]);
  exit();
}

echo json_encode([
  'message' => 'What are you doing here?'
]);
