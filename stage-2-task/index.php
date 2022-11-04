<?php

header('Content-type: application/json');

$request_method = strtolower($_SERVER['REQUEST_METHOD']);

function check_fields(array $keys, array $array)
{
  foreach($keys as $key)
  {
    if(!array_key_exists($key, $array)){
      return false;
    }
  }
  return true;
}

if ($request_method == 'post') {
  if(isset($_POST) && check_fields(['operation_type', 'x', 'y'], $_POST))
  {
    $data = $_POST;
  } else {
    $data = (array)json_decode(file_get_contents('php://input'));
  }

  // check operand
  if (!isset($data['operation_type'])) {
    echo json_encode(['error' => 'invalid operation type']);
    exit();
  }

  if (!in_array(strtolower($data['operation_type']), ['addition', 'subtraction', 'multiplication'])) {
    echo json_encode(['error' => 'invalid operation type']);
    exit();
  }

  // check if values are set
  if (!isset($data['x']) || empty(trim($data['x'])) || !is_numeric(trim($data['x']))) {
    echo json_encode(['error' => 'invalid value for x']);
    exit();
  }
  if (!isset($data['y']) || empty(trim($data['y'])) || !is_numeric(trim($data['y']))) {
    echo json_encode(['error' => 'invalid value for y']);
    exit();
  }

  $result = 0;
  $operation = $data['operation_type'];
  $x = intval($data['x']);
  $y = intval($data['y']);

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
    "result" => intval($result),
    "operation_type" => $operation
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
