<?php
$input = 236021;

function calcNextPos($pos, $steps, $arrLen) {
  $newPos = $pos + $steps + 1;
  while($newPos >= $arrLen) {
    $newPos = $newPos % ($arrLen);
  }
  return $newPos;
}

function findNextTen($input) {
  $recipes = [3, 7];
  $elf1Pos = 0;
  $elf2Pos = 1;

  while(count($recipes) < $input + 10) {
    $elf1Recipe = $recipes[$elf1Pos];
    $elf2Recipe = $recipes[$elf2Pos];
    
    $newRecipe = $elf1Recipe + $elf2Recipe;
    if ($newRecipe > 9) {
      $recipes[] = 1;
    }
    $recipes[] = $newRecipe % 10;
    
    $elf1Pos = calcNextPos($elf1Pos, $elf1Recipe, count($recipes));
    $elf2Pos = calcNextPos($elf2Pos, $elf2Recipe, count($recipes));
  }
  return join(array_slice($recipes, $input, 10));
}

function countRecipesOnLeft($input) {
  $recipes = [3, 7];
  $elf1Pos = 0;
  $elf2Pos = 1;
  $str = join($recipes);

  while(true) {
    $elf1Recipe = $recipes[$elf1Pos];
    $elf2Recipe = $recipes[$elf2Pos];
    
    $newRecipe = $elf1Recipe + $elf2Recipe;

    if ($newRecipe > 9) {
      $recipes[] = 1;
      $str = $str . 1;
      
      strlen($str) > strlen($input) && $str = substr($str, strlen($str) - strlen($input));
      if ($str == $input) {
        return count($recipes) - strlen($input);
      }
    }
    $recipes[] = $newRecipe % 10;
    $str = $str . ($newRecipe % 10);

    strlen($str) > strlen($input) && $str = substr($str, strlen($str) - strlen($input));
    if ($str == $input) {
      return count($recipes) - strlen($input);
    }
  
    $elf1Pos = calcNextPos($elf1Pos, $elf1Recipe, count($recipes));
    $elf2Pos = calcNextPos($elf2Pos, $elf2Recipe, count($recipes));
  }
}

echo findNextTen($input) . "\n";
echo countRecipesOnLeft($input) . "\n";
?>