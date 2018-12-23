<?php
$file = fopen("input.txt", "r") or exit("Unable to open file");
// $file = fopen("input_test.txt", "r") or exit("Unable to open file");

while(!feof($file)) {
  $array[] = fgets($file);
}

fclose($file);

return array_map(function($str) {
  $str = preg_replace("/\r|\n/", "", $str);
  $re = "/pos=<(-?\d+),(-?\d+),(-?\d+)>, r=(\d+)/";
  [$x, $y, $z, $r] = preg_split($re, $str, NULL, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
  return ['x' => $x, 'y' => $y, 'z' => $z, 'r' => $r];
}, array_filter($array));
?>