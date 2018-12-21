<?php
$input = require_once 'readFile.php';

$ip = (int)explode(' ', array_shift($input))[1][0];
$programm = array_values(array_map(function($str) {
  [$opcode, $a, $b, $c] = explode(' ', preg_replace("/\r|\n/", "", $str));
  return [$opcode, (int)$a, (int)$b, (int)$c];
}, $input));

function executeOnce($r, $programm, $ip) {
  $asm = require 'opcodes.php';
  while (true) {
    [$opcode, $a, $b, $c] = $programm[$r[$ip]];
    $r = $asm[$opcode]($r, $a, $b, $c);
    $r[$ip]++;
    if ($r[1] == 28) {
      return $r[5];
    }
  }
}

$r = [0, 0, 0, 0, 0, 0];

$r[0] = executeOnce($r, $programm, $ip);
echo "Part 1: " . $r[0] . "\n";
?>