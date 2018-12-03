<?php
  function splitClaim($str) {
    return preg_split("/(#\d+)\s@\s(\d+),(\d+):\s(\d+)x(\d+)/", $str, NULL, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
  }

  function fillArray($str) {
    global $result;
    $x = splitClaim($str);
    for ($i=$x[2]; $i < $x[2] + $x[4]; $i++) { 
      for ($j=$x[1]; $j < $x[1] + $x[3]; $j++) {
        if (empty($result[$i][$j])) {
          $result[$i][$j] = $x[0];
        } else {
          $result[$i][$j] = "x";
        }
      }
    }
  }
  
  function checkArray($str, $result) {
    $x = splitClaim($str);
    for ($i=$x[2]; $i < $x[2] + $x[4]; $i++) { 
      for ($j=$x[1]; $j < $x[1] + $x[3]; $j++) {
        if ($result[$i][$j] == "x") {
          return false;
        }
      }
    }
    return $x[0];
  }

  $result = array();
  $array = require 'readFile.php';

  foreach ($array as $value) {
    fillArray($value);
  }

  foreach ($array as $value) {
    $res = checkArray($value, $result);
    if ($res) {
      echo $res . "\n";
      break;
    }
  }
?>