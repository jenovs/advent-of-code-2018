<?php
$input = require_once 'readFile.php';

function findInitSteps($array) {
  $initSteps = [];
  foreach ($array as $value) {
    $finalSteps[] = $value[1];
  }
  foreach ($array as $value) {
    if (!in_array($value[0], $finalSteps) && !in_array($value[0], $initSteps)) {
      $initSteps[] = $value[0];
    }
  }
  sort($initSteps);
  return $initSteps;
}

$steps = array_map(function($str) {
  [, $first, $last] = preg_split("/.{5}(.).{30}(.).+/", $str, NULL, PREG_SPLIT_DELIM_CAPTURE);
  return [$first, $last];
}, $input);

$initSteps = findInitSteps($steps);

$completedSteps[] = array_shift($initSteps);

function findNextStep($steps, $completed) {
  $res = [];
  $incomplete = [];

  foreach ($steps as $key => [$mustBe, $nextStep]) {
    if (in_array($mustBe, $completed) && !in_array($nextStep, $completed)) {
      $res[] = $nextStep;
    } else {
      $incomplete[] = $nextStep;
    }
  }

  $cleanRes = [];
  foreach ($res as $value) {
    if (!in_array($value, $incomplete)) {
      $cleanRes[] = $value;
    }
  }
  if (count($cleanRes)) {
    sort($cleanRes);
    return $cleanRes[0];
  }
}

do {
  $next = findNextStep($steps, $completedSteps);
  
  if (count($initSteps)) {
    $temp = array_filter(array_merge($initSteps, [$next]));
    sort($temp);
    $temp2 = array_shift($temp);
    if ($next != $temp2) {
      $key = array_keys($initSteps, $temp2);
      array_splice($initSteps, $key[0], 1);
      $next = $temp2;
    }
  }

  $next && $completedSteps[] = $next;
} while ($next);

echo join($completedSteps) . "\n";
?>