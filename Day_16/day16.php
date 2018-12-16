<?php
$rawInput = require_once 'readFile.php';

$input = [];
$testInput = [];

function parseRegStr($str) {
  return array_values(array_filter(str_split(explode(": ", $str)[1]), function($val) {
    return is_numeric($val);
  }));
}

function parseInStr($str) {
  $str = preg_replace("/\r|\n/", "", $str);
  return explode(" ", $str);
}

for ($i=0; true;) {
  if (empty($rawInput[$i])) {
    break;
  }
  if (explode(": ", $rawInput[$i])[0] != 'Before') {
    if (empty($rawInput[$i])) {
      break;
    }
    $testInput[] = explode(" ", preg_replace("/\r|\n/", "", $rawInput[$i]));
    $i++;
  } else {
    $input[] = ['b' => parseRegStr($rawInput[$i]), 'i' => parseInStr($rawInput[$i+1]), 'a' => parseRegStr($rawInput[$i+2])];
    $i += 4;
  }
}

$testInput = array_values(array_filter($testInput, function($val) {
  return count($val) > 1;
}));

$asm = [
  'addr' => function($r, $a, $b, $c) {
    $r[$c] = $r[$a] + $r[$b];
    return $r;
  },
  'addi' => function($r, $a, $b, $c) {
    $r[$c] = $r[$a] + $b;
    return $r;
  },
  'mulr' => function($r, $a, $b, $c) {
    $r[$c] = $r[$a] * $r[$b];
    return $r;
  },
  'muli' => function($r, $a, $b, $c) {
    $r[$c] = $r[$a] * $b;
    return $r;
  },
  'banr' => function($r, $a, $b, $c) {
    $r[$c] = $r[$a] & $r[$b];
    return $r;
  },
  'bani' => function($r, $a, $b, $c) {
    $r[$c] = $r[$a] & $b;
    return $r;
  },
  'borr' => function($r, $a, $b, $c) {
    $r[$c] = $r[$a] | $r[$b];
    return $r;
  },
  'bori' => function($r, $a, $b, $c) {
    $r[$c] = $r[$a] | $b;
    return $r;
  },
  'setr' => function($r, $a, $b, $c) {
    $r[$c] = $r[$a];
    return $r;
  },
  'seti' => function($r, $a, $b, $c) {
    $r[$c] = $a;
    return $r;
  },
  'gtir' => function($r, $a, $b, $c) {
    $r[$c] = $a > $r[$b] ? 1 : 0;
    return $r;
  },
  'gtri' => function($r, $a, $b, $c) {
    $r[$c] = $r[$a] > $b ? 1 : 0;
    return $r;
  },
  'gtrr' => function($r, $a, $b, $c) {
    $r[$c] = $r[$a] > $r[$b] ? 1 : 0;
    return $r;
  },
  'eqir' => function($r, $a, $b, $c) {
    $r[$c] = $a == $r[$b] ? 1 : 0;
    return $r;
  },
  'eqri' => function($r, $a, $b, $c) {
    $r[$c] = $r[$a] == $b ? 1 : 0;
    return $r;
  },
  'eqrr' => function($r, $a, $b, $c) {
    $r[$c] = $r[$a] == $r[$b] ? 1 : 0;
    return $r;
  },
];

function countThree($input, $asm) {
  $count = 0;
  foreach ($input as $value) {
    [$opcode, $a, $b, $c] = $value['i'];

    $samples = 0;
    foreach ($asm as $key => $val) {
      $result = $asm[$key]($value['b'], $a, $b, $c) == $value['a'];
      $result && $samples++;
    }
    $samples >= 3 && $count++;
  }
  return $count;
}

function getOpcodesTable($input, $asm) {
  $found = [];
  $table = [];
  foreach ($input as $value) {
    [$opcode, $a, $b, $c] = $value['i'];
  
    $samples = [];
    foreach (array_keys($asm) as $key) {
      $x = $asm[$key]($value['b'], $a, $b, $c) == $value['a'];
      if ($x) {
        $samples[$key] = $opcode;
      }
    }
    foreach ($samples as $k => $v) {
      if ($v != NULL && (empty($found[$k]) || !in_array($v, $found[$k]))) {
        $found[$k][] = $opcode;
      }
    }
  }

  while(count($found)) {
    foreach ($found as $key => $value) {
      if (count($value) == 1) {
        $opcode = $value[0];
        $table[$opcode] = $key;
        $found[$key] = NULL;
        foreach ($found as $key => $value) {
          if (!empty($found[$key])) {
            $found[$key] = array_values(array_filter($value, function($v) use($opcode) {
              return $v != $opcode;
            }));
          }
        }
      }
    }
    $found = array_filter($found);
  }
  return $table;
}

function runProgramm($input, $opcodes, $asm) {
  $r = [0, 0, 0, 0];
  foreach ($input as $v) {
    $r = $asm[$opcodes[$v[0]]]($r, $v[1], $v[2], $v[3]);
  }
  return $r[0];
}

function partTwo($input, $testInput, $asm) {
  $opcodes = getOpcodesTable($input, $asm);
  return runProgramm($testInput, $opcodes, $asm);
}

echo "Part 1: ". countThree($input, $asm) . "\n";
echo "Part 2: ". partTwo($input, $testInput, $asm) . "\n";
?>