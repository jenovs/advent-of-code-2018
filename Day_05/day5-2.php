<?php
  require_once 'doReactions.php';
  $polymer = require 'readFile.php';

  $bestResult = strlen($polymer);

  for ($i=ord('A'); $i <= ord('Z'); $i++) { 
    $stripped = str_ireplace(chr($i), '', $polymer);

    $newPolymer = doReactions($stripped);
    
    if (strlen($newPolymer) < $bestResult) {
      $bestResult = strlen($newPolymer);
    }
  }

  echo $bestResult . "\n";
?>