<?php

header('Content-type: application/json');

echo json_encode([
  "slackUsername" => "codelikesuraj",
  "backend" => true,
  "age" => 22,
  "bio" => "Backend developer"
]);
