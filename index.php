<?php

header('Content-type: application/json');

$request_method = strtolower($_SERVER['REQUEST_METHOD']);

if ($request_method == 'post') {
  $data = json_decode(file_get_contents('php://input'));

  // check operand
  if (!isset($data->operation_type)) {
    echo json_encode(['error' => 'invalid operation type']);
    exit();
  }

  // if (!in_array(strtolower($data->operation_type), ['addition', 'subtraction', 'multiplication'])) {
  //   echo json_encode(['error' => 'invalid operation type']);
  //   exit();
  // }

  // check if values are set
  if (!isset($data->x) || empty(trim($data->x))){
    echo json_encode(['error' => 'invalid value for x']);
    exit();
  }
  if (!isset($data->y) || empty(trim($data->y))){
    echo json_encode(['error' => 'invalid value for y']);
    exit();
  }

  $result = 0;
  $operation = $data->operation_type;
  $x = intval(trim($data->x));
  $y = intval(trim($data->y));

  switch ($operation) {
    case 'addition':
      $result = $x + $y;
      break;
    case 'subtraction':
      $result = $x - $y;
      break;
    case 'multiplication':
      $result = $x * $y;
      break;
    
    default:
      $result = $x + $y;
      break;
  }

  echo json_encode([
    "slackUsername" => "codelikesuraj",
    "operation_type" => $operation,
    "result" => intval($result)
  ]);
  exit();
}

if ($request_method == 'get') {
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
