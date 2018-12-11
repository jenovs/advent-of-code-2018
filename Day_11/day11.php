<?php
$input = 1309;

function calcPower($x, $y, $sn) {
  $rackId = $x + 10;
  $powerLevel = $rackId * $y;
  $powerLevel += $sn;
  $powerLevel *= $rackId;
  $powerLevel = ($powerLevel / 100) % 10;
  return $powerLevel - 5;
}

$grid = [];
for ($y=1; $y <= 300; $y++) {
  for ($x=1; $x <= 300; $x++) {
    $grid[$y][$x] = calcPower($x, $y, $input);
  }
}

function getCoords($grid, $square = 3) {
  $maxPower = -INF;
  $maxX;
  $maxY;
  $maxSize;

  for ($size=3; $size <= $square; $size++) {
    for ($y=1; $y <= 300 - $size + 1; $y++) {
      $prevPower = NULL;
      for ($x=1; $x <= 300 - $size + 1; $x++) {
        $power = 0;
        $power1 = 0;
        $power2 = 0;
        if ($prevPower == NULL) {
          for ($bottom=0; $bottom < $size; $bottom++) {
            $power1 += $grid[$y + $bottom][$x];
          }
          for ($right=1; $right < $size; $right++) {
            for ($bottom=0; $bottom < $size; $bottom++) {
              $prevPower += $grid[$y + $bottom][$x + $right];
            }
          }
          $power = $power1 + $prevPower;
        } else {
          for ($bottom=0; $bottom < $size; $bottom++) {
             $power1 += $grid[$y + $bottom][$x];
           }
           for ($bottom=0; $bottom < $size; $bottom++) {
             $prevPower += $grid[$y + $bottom][$x + $size - 1];
           }
          $power = $prevPower;
          $prevPower -= $power1;
        }
  
        if ($power >= $maxPower) {
          $maxPower = $power;
          $maxX = $x;
          $maxY = $y;
          $maxSize = $size;
        }
      }
    }
  }
  $result = $maxX . "," . $maxY;
  $square > 3 && $result = $result . "," . $maxSize;
  return $result;
}

echo "Part 1: ";
echo getCoords($grid) . "\n";
echo "Part 2: ";
echo getCoords($grid, 300) . "\n";
?>