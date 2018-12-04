<?php
  $array = require 'readFile.php';

  sort($array);

  $asleep = [];
  $currentGuard;
  $fallsAsleep;

  foreach ($array as $str) {
    global $asleep, $currentGuard, $fallsAsleep;

    [$seconds, $status] = preg_split("/\[.{11}.{3}(.{2})\]\s(.+)/", $str, NULL, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

    if ($status == "falls asleep") {
      $fallsAsleep = (int)$seconds;
    } else if ($status == "wakes up") {
      for ($i=$fallsAsleep; $i < (int)$seconds; $i++) { 
        $asleep[$currentGuard][$i] = $asleep[$currentGuard][$i] + 1;
      }
    } else {
      [, $guardId] = preg_split("/.{6}#(\d+).+/", $status, NULL, PREG_SPLIT_DELIM_CAPTURE);
      
      if (empty($asleep[$guardId])) {
        $asleep[$guardId] = array_fill(0, 60, 0);
      }
    }

    $currentGuard = $guardId;
  }

  $laziestGuardId;
  $sleepiestMinute = -1;
  $sleepiestMinuteVal = 0;

  foreach ($asleep as $key => $value) {
    global $laziestGuardId, $sleepiestMinute, $sleepiestMinuteVal;

    $maxVal = max($value);
    $maxMinute = array_search($maxVal, $value);

    if ($maxVal > $sleepiestMinuteVal) {
      $sleepiestMinute = $maxMinute;
      $laziestGuardId = $key;
      $sleepiestMinuteVal = $maxVal;
    }
  }

  print_r($laziestGuardId * $sleepiestMinute . "\n");
?>