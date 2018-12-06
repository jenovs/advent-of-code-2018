<?php
$array = require_once 'readFile.php';

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


$distances = [];
for ($i=$top; $i <= $bottom; $i++) {
  for ($j=$left; $j <= $right; $j++) {
    $index;
    $minDist = INF;
    $isUnique = true;
    foreach ($array as $key => $value) {
      $dist = calcDist([$i, $j], [(int)$value[1], (int)$value[0]]);
      
      if ($dist == 0) {
        $index = $key;
      } else if ($dist == $minDist) {
        $isUnique = false;
      } else if ($dist < $minDist) {
        $isUnique = true;
        $minDist = $dist;
        $index = $key;
      }
    }
    
    $distances[$i][$j] = $isUnique ? $index : '.';
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
for ($i=0; $i < count($array); $i++) {
  if (in_array($i, $edges)) {
    continue;
  }

  $res = 0;

  foreach ($distances as $row => $cols) {
    $filtered = array_filter($cols, function($val) use($i) {
      return $val != '.' ? $i == $val : false;
    });
    $res += count($filtered);
  }

  if ($res > $max) {
    $max = $res;
  }
}
  
echo $max;
?>