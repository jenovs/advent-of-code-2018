<?php
  require_once 'doReactions.php';
  $polymer = require 'readFile.php';

  $newPolymer = doReactions($polymer);

  echo strlen($newPolymer) . "\n";
?>