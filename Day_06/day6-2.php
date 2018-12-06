<?php
$array = require_once 'readFile.php';

define("TOTAL_DIST", 10000);
// define("TOTAL_DIST", 32);

function calcDist($p, $q) {
  return abs($p[0] - $q[0]) + abs($p[1] - $q[1]);
}

$top = INF;
$right = 0;
$bottom = 0;
$left = INF;

foreach ($array as $value) {
  $top = (int)min($value[1], $top);
  $right = (int)max($value[0], $right);
  $bottom = (int)max($value[1], $bottom);
  $left = (int)min($value[0], $left);
}

$distances = 0;

for ($i=$top; $i <= $bottom; $i++) {
  for ($j=$left; $j <= $right; $j++) {
    $dist = 0;
    foreach ($array as $key => $value) {
      $dist += calcDist([$i, $j], [(int)$value[1], (int)$value[0]]);
    }
    if ($dist < TOTAL_DIST) {
      $distances++;
    }
  }
}

echo $distances;
?>