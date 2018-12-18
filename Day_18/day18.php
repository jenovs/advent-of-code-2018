<?php
$input = require_once 'readFile.php';

function calcNext($area) {
  $next = [];
  for ($y=0; $y < count($area); $y++) {
    for ($x=0; $x < count($area[0]); $x++) {
      $adjacent = [];
      $tl = $tm = $tr = $cl = $cr = $bl = $bc = $br = false;
      $curr = $area[$y][$x];
      
      !empty($area[$y-1][$x-1]) && $adjacent[] = $area[$y-1][$x-1];
      !empty($area[$y-1][$x]) && $adjacent[] = $area[$y-1][$x];
      !empty($area[$y-1][$x+1]) && $adjacent[] = $area[$y-1][$x+1];
      !empty($area[$y][$x-1]) && $adjacent[] = $area[$y][$x-1];
      !empty($area[$y][$x+1]) && $adjacent[] = $area[$y][$x+1];
      !empty($area[$y+1][$x-1]) && $adjacent[] = $area[$y+1][$x-1];
      !empty($area[$y+1][$x]) && $adjacent[] = $area[$y+1][$x];
      !empty($area[$y+1][$x+1]) && $adjacent[] = $area[$y+1][$x+1];

      $count = array_reduce($adjacent, function($acc, $var) {
        $acc[$var]++;
        return $acc;
      }, ['.' => 0, '|' => 0, '#' => 0]);
      
      if ($curr == '.') {
        $next[$y][$x] = $count['|'] >= 3 ? '|' : '.';
      } else if ($curr == '|') {
        $next[$y][$x] = $count['#'] >= 3 ? '#' : '|';
      } else if ($curr == '#') {
        $next[$y][$x] = $count['#'] >= 1 && $count['|'] >= 1 ? '#' : '.';
      }
    }
  }
  return $next;
}
  
function countWood($area) {
  $wood = $lumber = 0;
  for ($y=0; $y < count($area); $y++) {
    for ($x=0; $x < count($area[0]); $x++) {
      $area[$y][$x] == '|' && $wood++;
      $area[$y][$x] == '#' && $lumber++;
    }
  }
  return $wood * $lumber;
}

function generateTen($area, $time = 10) {
  $next = $area;
  for ($i=0; $i < $time; $i++) {
    $next = calcNext($next);
  }
  return countWood($next);
}

function generateMany($input) {
  $next = $input;
  $count = $countRep = $repeats = 0;

  for ($i=0; ; $i++) {
    $next = calcNext($next);
    $count = countWood($next);
    if ((1000000000 - 1 - $i) % 28 == 0 && $count) {
      $countRep == $count && $repeats++;
      $countRep = $count;
      if ($repeats > 1) {
        return $countRep;
      }
    }
  }
}

echo "Part 1: " . generateTen($input) . "\n";
echo "Part 2: " . generateMany($input) . "\n";
?>