<?php
$file = fopen("input.txt", "r") or exit("Unable to open file");
// $file = fopen("input_test.txt", "r") or exit("Unable to open file");

while(!feof($file)) {
  $array[] = explode(", ", fgets($file));
}

fclose($file);

return array_filter(array_map(function($val) {
  return array((int)$val[0], (int)$val[1]);
}, $array));
?>