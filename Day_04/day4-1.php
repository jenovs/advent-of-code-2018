<?php
  $array = require 'readFile.php';

  sort($array);

  $shifts = [];
  $fallsAsleepTime;
  $currentGuard;

  foreach ($array as $str) {
    global $currentGuard, $fallsAsleepTime, $shifts;

    [$seconds, $status] = preg_split("/\[.{11}.{3}(.{2})\]\s(.+)/", $str, NULL, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

    if ($status == "falls asleep") {
      $fallsAsleepTime = $seconds;
    } else if ($status == "wakes up") {
      $shifts[$currentGuard] = $seconds - $fallsAsleepTime;
    } else {
      [, $currentGuard] = preg_split("/.{6}#(\d+).+/", $status, NULL, PREG_SPLIT_DELIM_CAPTURE);
    }
  };

  $laziestGuardId = array_search(max($shifts), $shifts);
  $record = false;
  $lazyGuardSleeps = array_fill(0, 60, 0);

  foreach ($array as $str) {
    global $fallsAsleepTime, $record, $laziestGuardId, $lazyGuardSleeps;

    [$seconds, $status] = preg_split("/\[.{11}.{3}(.{2})\]\s(.+)/", $str, NULL, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

    if ($record && $status == "falls asleep") {
      $fallsAsleepTime = $seconds;
    } else if ($record && $status == "wakes up") {
      for ($i=(int)$fallsAsleepTime; $i < (int)$seconds; $i++) { 
        $lazyGuardSleeps[$i] = $lazyGuardSleeps[$i] + 1;
      }
      $record = false;
    }
    else if ($status != "falls asleep" && $status != "wakes up") {
      [, $currentGuardId] = preg_split("/.{6}#(\d+).+/", $status, NULL, PREG_SPLIT_DELIM_CAPTURE);
      if ($laziestGuardId == $currentGuardId) {
        $record = true;
      }
    }
  };

  $minute = array_search(max($lazyGuardSleeps), $lazyGuardSleeps);

  print_r($minute * $laziestGuardId . "\n");
?>