<?php
$input = require_once('readFile.php');


function calcDistance($base, $target) {
  return abs($base['x'] - $target['x']) + abs($base['y'] - $target['y']) + abs($base['z'] - $target['z']);
}

function countNanobots($input) {
  $maxR = 0;
  $maxInd = -1;
  foreach ($input as $key => $value) {
    if ($value['r'] > $maxR) {
      $maxR = $value['r'];
      $maxInd = $key;
    }
  }
  
  $count = 0;
  foreach ($input as $key => $value) {
    $distance = calcDistance($input[$maxInd], $value);
    if ($distance <= $maxR) {
      $count++;
    }
  }
  
  return $count;
}

$count = countNanobots($input);
echo "Part1 : {$count}\n";
?>