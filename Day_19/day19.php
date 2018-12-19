<?php
$input = require_once 'readFile.php';

$ip = explode(' ', array_shift($input))[1][0];
$programm = array_values(array_map(function($str) {
  return explode(' ', preg_replace("/\r|\n/", "", $str));
}, $input));

function execute($r, $programm, $ip) {
  $asm = require_once 'opcodes.php';
  while (true) {
    [$opcode, $a, $b, $c] = $programm[$r[$ip]];
    $r = $asm[$opcode]($r, $a, $b, $c);
    $r[$ip]++;
  
    if (empty($programm[$r[$ip]])) {
      return $r[0];
    }
  }
}

function executeOptimized($r) {
  [$r0, $r1, $r2, $r3, $r4, $r5] = $r;

  $r1 = 6 * 22 + 6;
  $r3 = 2 * 2 * 19 * 11 + $r1;

  if ($r0 == 1) {
    $r1 = (27 * 28 + 29) * 30 * 14 * 32;
    $r3 += $r1;
    $r0 = 0;
  }

  while($r4 <= $r3) {
    $r5 = 1;

    while ($r5 <= $r3) {
      $r1 = $r4 * $r5;
      if ($r1 > $r3) {
        break;
      }
      if($r1 == $r3) {
        $r0 += $r4;
      }
      $r5++;
    }
    $r4++;
  }
  return $r0;
}

$r = [0, 0, 0, 0, 0, 0];

// echo "Part 1: " . execute($r, $programm, $ip) . "\n";
echo "Part 1: " . executeOptimized($r) . "\n";
$r[0] = 1;
echo "Part 2: " . executeOptimized($r) . "\n";
?>