<?php
$input = require_once 'readFile.php';

[, $init] = explode(": ", $input[0]);
$comb = [];
for ($i=2; $i < count($input); $i++) {
  [$pat, $res] = explode(" => ", $input[$i]);
  $comb[$pat] = $res[0];
}

$pots = str_split($init);
array_pop($pots);

$gen = 1;

while($gen <= 20) {
  $temp = [];
  $minVal = min(array_values(array_keys($pots)));
  $maxVal = max(array_values(array_keys($pots)));

  if ($pots[$minVal] != '.' || $pots[$minVal + 1] != '.') {
    $pots[$minVal - 1] = '.';
    $pots[$minVal - 2] = '.';
  }
  if ($pots[$maxVal] != '.' || $pots[$maxVal - 1] != '.') {
    $pots[$maxVal + 1] = '.';
    $pots[$maxVal + 2] = '.';
  }

  foreach ($pots as $key => $c) {
    $l1 = empty($pots[$key - 1]) ? '.' : $pots[$key - 1];
    $l2 = empty($pots[$key - 2]) ? '.' : $pots[$key - 2];
    $r1 = empty($pots[$key + 1]) ? '.' : $pots[$key + 1];
    $r2 = empty($pots[$key + 2]) ? '.' : $pots[$key + 2];

    $searchKey = $l2 . $l1 . $c . $r1 . $r2;
    
    $next = empty($comb[$searchKey]) ? '.' : $comb[$searchKey];
    $temp[$key] = $next;
  }
  $pots = $temp;
  $gen++;
}

$sum = 0;
foreach ($pots as $key => $value) {
  if ($value == '#') {
    $sum += $key;
  }
}

$afterBillions = 23 * (50000000000 - 72) + 2014;

echo "Part 1: " . $sum . "\n";
echo "Part 2: " . $afterBillions . "\n";
?>