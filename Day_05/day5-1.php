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
        if (canReact($polymer[$i], $polymer[$i + 1])) {
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

  do {
    global $hasReacted, $polymer;
    [$polymer, $hasReacted] = doReaction($polymer);
  } while ($hasReacted);

  echo strlen($polymer) . "\n";
?>