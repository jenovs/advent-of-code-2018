<?php
$file = fopen("input.txt", "r") or exit("Unable to open file");
// $file = fopen("input_test.txt", "r") or exit("Unable to open file");

while(!feof($file)) {
  $array[] = fgets($file);
}

fclose($file);

return array_map(function($str) {
  $str = preg_replace("/\r|\n/", "", $str);
  return str_split($str);
}, array_filter($array));
?>