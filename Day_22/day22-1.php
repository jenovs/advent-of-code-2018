<?php
$target = [10, 725];
$depth = 8787;

function calcErosion($geoInd, $depth) {
  return ($geoInd + $depth) % 20183;
}

function exploreCave($depth, $target) {
  $cavern = [];
  $erosion = calcErosion(0, $depth);
  $cavern[0][0] = $erosion;
  $cavernType[0][0] = $erosion % 3;
  $cavern[$target[1]][$target[0]] = $erosion;
  $cavernType[$target[1]][$target[0]] = $erosion % 3;
  
  for ($y=0; $y <= $target[1]; $y++) {
    for ($x=0; $x <= $target[0]; $x++) {
      $geoInd = 0;
      $startOrTarget = (!$x && !$y) || ($x == $target[0] && $y == $target[1]);

      if ($startOrTarget) {
        continue;
      }
      if (!$y && $x) {
        $geoInd = $x * 16807;
      } else if (!$x && $y) {
        $geoInd = $y * 48271;
      } else {
        $geoInd = $cavern[$y][$x-1] * $cavern[$y-1][$x];
      }
      $erosion = calcErosion($geoInd, $depth);
      $cavern[$y][$x] = $erosion;
      $cavernType[$y][$x] = $erosion % 3;
    }
  }
  return $cavernType;
}

$cavernType = exploreCave($depth, $target);

$count = array_reduce($cavernType, function($acc, $y) {
  return $acc += array_reduce($y, function($acc, $x) {
    return $acc + $x;
  }, 0);
}, 0);

echo "Part 1: {$count}\n";
?>