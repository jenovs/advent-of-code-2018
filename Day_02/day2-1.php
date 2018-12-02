<?php
function filterVal($arr, $filter) {
  return array_filter(array_values($arr), function($val) use($filter) {
    return $val == $filter;
  });
}

function counter($str) {
  $counter = [];

  for($i = 0; $i < strlen($str); $i++) {
    $ch = $str[$i];

    $counter[$ch] = empty($counter[$ch]) ? 1 : ++$counter[$ch];
  }
  
  $two = filterVal($counter, 2);
  $three = filterVal($counter, 3);

  return array(!empty(count($two)), !empty(count($three)));
}

$array = require 'readFile.php';

$twoCount = 0;
$threeCount = 0;

foreach ($array as $value) {
  [$two, $three] = counter($value);
  $twoCount += $two;
  $threeCount += $three;
}

print_r($twoCount * $threeCount . "\n");
?>