<?php

$done = false;

function check($val, $done) {
  global $results;
  if (empty($results[$val])) {
    $results[$val] = true;
    return false;
  } else {
    echo $val;
    echo "\n";
    return true;
  }
  return;
};

$sum = function($acc, $item) {
  global $done;
  $acc += $item;
  if (!$done) {
    $done = check($acc, $done);
  }
  return $acc;
};

$array = require 'readFile.php';

$results = [];

$res = 0;
$init = 0;

while(!$done) {
  global $res;
  global $init;
  $res = array_reduce($array, $sum, $init);
  $init = $res;
}
?>