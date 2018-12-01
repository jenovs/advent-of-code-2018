<?php
$file = fopen("input.txt", "r") or exit("Unable to open file");

while(!feof($file)) {
  $array[] = (int)fgets($file);
}

fclose($file);

array_pop($array);

return $array;
?>