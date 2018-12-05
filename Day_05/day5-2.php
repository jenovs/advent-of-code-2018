<?php
  $polymer = require 'readFile.php';

  function canReact($el1, $el2) {
    return abs(ord($el1) - ord($el2)) == 32;
  }

  function doReaction($polymer) {
    $hasReacted = false;
    $newPolymer = [$polymer[0]];
    for ($i=1; $i < strlen($polymer); $i++) { 
      if (canReact($polymer[$i], $polymer[$i - 1])) {
        $hasReacted = true;
        array_pop($newPolymer);
        if ($i + 1 < strlen($polymer) && canReact($polymer[$i], $polymer[$i + 1])) {
          $newPolymer[] = $polymer[$i + 1];
          $i++;
        }
      } else {
        $newPolymer[] = $polymer[$i];
      }
    }
    return [join($newPolymer), $hasReacted];
  }

  $hasReacted;
  $bestResult = strlen($polymer);

  for ($i=ord('A'); $i <= ord('Z'); $i++) { 
    global $bestResult;
    $stripped = str_ireplace(chr($i), '', $polymer);

    do {
      global $hasReacted, $stripped;
      [$stripped, $hasReacted] = doReaction($stripped);
    } while ($hasReacted);
    if (strlen($stripped) < $bestResult) {
      $bestResult = strlen($stripped);
    }
  }

  echo $bestResult . "\n";
?>