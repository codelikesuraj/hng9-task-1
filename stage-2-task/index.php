<?php

header('Content-type: application/json');

$request_method = strtolower($_SERVER['REQUEST_METHOD']);
$result = 0;
$operation = null;
$x = 0;
$y = 0;

if ($request_method == 'post') {
  if (isset($_POST) && array_key_exists('operation_type', $_POST)) {
    $data = $_POST;
  } else {
    $data = (array)json_decode(file_get_contents('php://input'));
  }

  // check operand
  if (!isset($data['operation_type'])) {
    echo json_encode(['error' => 'operation type cannot be empty']);
    exit();
  }

  $op_type = $data['operation_type'];
  if (strpos(strtolower($op_type), 'add') !== false || strpos(strtolower($op_type), 'sum') !== false || strpos(strtolower($op_type), 'plus') !== false || strpos(strtolower($op_type), '+') !== false) {
    $operation = 'addition';
  } else if (strpos(strtolower($op_type), 'subtract') !== false || strpos(strtolower($op_type), 'minus') !== false || strpos(strtolower($op_type), 'remove') !== false || strpos(strtolower($op_type), '-') !== false) {
    $operation = 'subtraction';
  } else if (strpos(strtolower($op_type), 'multipl') !== false || strpos(strtolower($op_type), 'times') !== false || strpos(strtolower($op_type), 'product') !== false || strpos(strtolower($op_type), '*') !== false) {
    $operation = 'multiplication';
  }

  if (is_null($operation)) {
    echo json_encode([
      'error' => 'invalid operation type'
    ]);
    exit();
  }

  // check if values are set
  $errors = [];
  if (!isset($data['x']) || empty(trim($data['x'])) || !is_numeric(trim($data['x']))) {
    $errors[] = 'invalid value for x';
  }
  if (!isset($data['y']) || empty(trim($data['y'])) || !is_numeric(trim($data['y']))) {
    $errors[] = 'invalid value for y';
  }
  if (count($errors)) {
    preg_match_all('!\d+!', $op_type, $numbers);
    if (is_null($numbers) || count($numbers[0]) !== 2) {
      $errors[] = 'values cannot be empty';
      echo json_encode([
        'errors' => $errors
      ]);
      exit();
    }

    if (strpos(strtolower($op_type), 'from')) {
      $y = $numbers[0][0];
      $x = $numbers[0][1];
    } else {
      $x = $numbers[0][0];
      $y = $numbers[0][1];
    }
  } else {
    $x = intval($data['x']);
    $y = intval($data['y']);
  }


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
