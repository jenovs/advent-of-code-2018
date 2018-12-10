<?php
$input = require_once 'readFile.php';

$array = array_map(function($str) {
  $re = "/position=<\s?(-?\d+),\s+(-?\d+)>\svelocity=<\s?(-?\d+),\s+(-?\d+).+/";
  return preg_split($re, $str, NULL, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
}, $input);


function caclcMinHeight($array) {
  $min = INF;
  $max = 0;
  foreach ($array as $value) {
    if ($value[1] < $min) {
      $min = $value[1];
    }
    if ($value[1] > $max) {
      $max = $value[1];
    }
  }
  return $max - $min;
}

function calcPosition($array, $seconds) {
  return array_map(function($data) use($seconds) {
    $posX = $data[0] + $data[2] * $seconds;
    $posY = $data[1] + $data[3] * $seconds;
    return [$posX, $posY];
  }, $array);
}

$positions = [];
$height = INF;
$seconds = 1;
while (true) {
  $positions = calcPosition($array, $seconds);
  
  $newHeight = caclcMinHeight($positions, $height);
  if ($newHeight > $height) {
    $seconds--;
    $positions = calcPosition($array, $seconds);
    break;
  } else {
    $height = $newHeight;
    $seconds++;
  }
}

$pixels = [];
foreach ($positions as $value) {
  $pixels[$value[0]][$value[1]] = true;
}

$minY = INF;
$maxY = 0;
$minX = INF;
$maxX = 0;

foreach ($positions as $value) {
  if ($value[0] > $maxX) {
    $maxX = $value[0];
  }
  if ($value[0] < $minX) {
    $minX = $value[0];
  }
  if ($value[1] > $maxY) {
    $maxY = $value[1];
  }
  if ($value[1] < $minY) {
    $minY = $value[1];
  }
}

for ($y=$minY - 1; $y <= $maxY + 1; $y++) { 
  for ($x=$minX - 1; $x <= $maxX + 1; $x++) { 
    echo !empty($pixels[$x][$y]) ? "#" : " ";
  }
  echo "\n";
}
echo "Done in " . $seconds . " \"seconds\"\n\n";
?>