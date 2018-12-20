<?php
$input = require_once 'readFile.php';

function doReplace($arr) {
  $str = explode('|', preg_replace("/[\(\)]/", "", $arr[0]));

  $max = '';
  foreach ($str as $value) {
    if (strlen($value) > strlen($max)) {
      $max = $value;
    }
  }
  return $max;
}

function rec($str) {
  if (!strrpos($str, '|')) {
    return $str;
  }
  return rec(preg_replace_callback("/\([NEWS|]+\)/", 'doReplace', $str));
}

function partOne($input) {
  $str = preg_replace("/\([NEWS|]+\|\)/", "", substr($input, 1, strlen($input)-2));
  return strlen(rec($str));
}

echo partOne($input) . "\n";
?>