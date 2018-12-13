<?php
$file = fopen("input.txt", "r") or exit("Unable to open file");
// $file = fopen("input_test_1.txt", "r") or exit("Unable to open file");
// $file = fopen("input_test_2.txt", "r") or exit("Unable to open file");

while(!feof($file)) {
  $array[] = fgets($file);
}

fclose($file);

return array_filter($array);
?>