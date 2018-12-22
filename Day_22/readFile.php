<?php
$file = fopen("input.txt", "r") or exit("Unable to open file");

while(!feof($file)) {
  $array[] = fgets($file);
}

fclose($file);

return array_filter($array);
?>