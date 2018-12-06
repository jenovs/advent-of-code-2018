<?php
$array = require_once 'readFile.php';

function calcDist($p1, $p2, $q1, $q2) {
  return abs($p1 - $q1) + abs($p2 - $q2);
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

$distances = [];
for ($i=$top; $i <= $bottom; $i++) {
  for ($j=$left; $j <= $right; $j++) {
    $index;
    $minDist = INF;
    $isUnique = true;
    foreach ($array as $key => $value) {
      $dist = calcDist($i, $j, $value[1], $value[0]);
      
      if ($dist == 0) {
        $index = $key;
      } else if ($dist == $minDist) {
        $isUnique = false;
        $index = '.';
      } else if ($dist < $minDist) {
        $isUnique = true;
        $minDist = $dist;
        $index = $key;
      }
    }
    
    $distances[$i][$j] = $index;
  }
}

function getEdges($array) {
  $firstRow = array_shift($array);
  $lastRow = array_pop($array);

  $edges = array_filter(array_merge($firstRow, $lastRow), function($val) {
    return $val != '.';
  });

  foreach ($array as $cols) {
    $first = array_shift($cols);
    $last = array_pop($cols);

    $first != '.' && $edges[] = $first;
    $last != '.' && $edges[] = $last;
  }
  return array_unique($edges);
}

$edges = getEdges($distances);

$max = 0;
$len = count($array);
for ($i=0; $i < $len; $i++) {
  if (in_array($i, $edges)) {
    continue;
  }

  $res = 0;

  foreach ($distances as $cols) {
    foreach ($cols as $val) {
      if ($val != '.' && $i == $val) {
        $res++;
      }
    }
  }

  if ($res > $max) {
    $max = $res;
  }
}
  
echo $max;
?>