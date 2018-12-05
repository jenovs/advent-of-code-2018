<?php
  function canReact($el1, $el2) {
    return abs(ord($el1) - ord($el2)) == 32;
  }

  function doReactions($polymer, $hasReacted = true) {
    if (!$hasReacted) {
      return join($polymer);
    }

    if (!is_array($polymer)) {
      $polymer = str_split($polymer);
    }

    $hasReacted = false;
    $newPolymer = [];
    
    $len = count($polymer);
    for ($i=0; $i < $len; $i++) {
      $nextChar = $i + 1 < $len ? $polymer[$i + 1] : false;
      if ($nextChar && canReact($polymer[$i], $nextChar)) {
        $hasReacted = $i++;
      } else {
        $newPolymer[] = $polymer[$i];
      }
    }

    return doReactions($newPolymer, $hasReacted);
  }
?>