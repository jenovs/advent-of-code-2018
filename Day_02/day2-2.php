<?php
function compareTwo($str1, $str2) {
  $diffCount = 0;
  $result = '';

  for ($i=0; $i < strlen($str1); $i++) {
    if ($str1[$i] != $str2[$i]) {
      if ($diffCount == 0) {
        $diffCount++;
      } else {
        return NULL;
      }
    } else {
      $result = $result . $str1[$i];
    }
  }
  
  return $result;
}

$array = require 'readFile.php';

for ($i=0; $i < count($array); $i++) { 
  for ($j=$i+1; $j < count($array); $j++) {
    $result = compareTwo($array[$i], $array[$j]);
    if (!empty($result)) {
      echo $result;
      break 2;
    }
  }
}

?>