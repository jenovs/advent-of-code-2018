<?php
  function fillArray($str) {
    global $result;
    $x = preg_split("/(#\d+)\s@\s(\d+),(\d+):\s(\d+)x(\d+)/", $str, NULL, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
    for ($i=$x[2]; $i < $x[2] + $x[4]; $i++) { 
      for ($j=$x[1]; $j < $x[1] + $x[3]; $j++) {
        if (empty($result[$i][$j])) {
          $result[$i][$j] = 1;
        } else {
          $result[$i][$j] = $result[$i][$j] + 1;
        }
      }
    }
  }

  $result = array();
  $array = require 'readFile.php';

  foreach ($array as $value) {
    fillArray($value);
  }

  $res = array_reduce($result, function($acc, $item) {
    return $acc + array_reduce($item, function($acc2, $item2) {
      if ($item2 > 1) {
        $acc2++;
      }
      return $acc2;
    }, 0);
  }, 0);

  echo $res . "\n";
?>