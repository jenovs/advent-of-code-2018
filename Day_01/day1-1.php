<?php
$sum = function($acc, $item) {
  return $acc += $item;
};

$array = require 'readFile.php';

$res = array_reduce($array, $sum, 0);

print_r($res);
print_r("\n");

?>