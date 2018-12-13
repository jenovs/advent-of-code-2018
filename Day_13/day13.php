<?php
$input = require_once 'readFile.php';

function createGridAndCarts($input) {
  $carts = [];
  $grid = [];

  foreach ($input as $i => $str) {
    $gridLine = str_split(preg_replace('/\n/', '', $str));
    $cart = [];
    $isCart = ['>' => '-', 'v' => '|', '<' => '-', '^' => '|'];
    
    foreach ($gridLine as $key => $value) {
      if (in_array($value, array_keys($isCart))) {
        $carts[] = ['y' => $i, 'x' => $key, 'pos' => $value, 'cross' => 'right'];
        $gridLine[$key] = $isCart[$value];
      }
      $grid[$i] = $gridLine;
    }
  }
  return [$grid, $carts];
}

function move($cart, $grid) {
  $turnR = ['^' => '>', '>' => 'v', 'v' => '<', '<' => '^'];
  $turnL = ['^' => '<', '>' => '^', 'v' => '>', '<' => 'v'];
  $nextCross = ['left' => 'straight', 'straight' => 'right', 'right' => 'left'];

  $currentPath = $grid[$cart['y']][$cart['x']];
  $newPos = $cartPos = $cart['pos'];
  $cartUpDown = $cartPos == '^' || $cartPos == 'v';
  $cartLeftRihgt = $cartPos == '>' || $cartPos == '<';
  
  if ($currentPath == '+') {
    $lastCross = $cart['cross'];
    $cart['cross'] = $nextCross[$lastCross];
    
    if ($lastCross == 'right') {
      $newPos = $turnL[$cart['pos']];
    } else if ($lastCross == 'straight') {
      $newPos = $turnR[$cart['pos']];
    }
  } else if ($currentPath == '\\') {
    $cartUpDown && $newPos = $turnL[$cartPos];
    $cartLeftRihgt && $newPos = $turnR[$cartPos];
  } else if ($currentPath == '/') {
    $cartUpDown && $newPos = $turnR[$cartPos];
    $cartLeftRihgt && $newPos = $turnL[$cartPos];
  }
  $cart['pos'] = $cartPos = $newPos;

  $cartPos == '>' && $cart['x']++;
  $cartPos == '<' && $cart['x']--;
  $cartPos == '^' && $cart['y']--;
  $cartPos == 'v' && $cart['y']++;

  return $cart;
}

function sortCarts($carts) {
  usort($carts, function($c1, $c2) {
    $sortY = $c1['y'] <=> $c2['y'];
    if ($sortY == 0) {
      return $c1['x'] <=> $c2['x'];
    }
    return $sortY;
  });
  return $carts;
}

function hasCollided($cart, $carts): bool {
  $collidors = 0;
  foreach ($carts as $c) {
    if ($cart['x'] == $c['x'] && $cart['y'] == $c['y']) {
      $collidors++;
    }
  }
  return  $collidors > 1;
}

function findCollisionId($carts, $ownId) {
  $cart = $carts[$ownId];
  foreach ($carts as $key => $val) {
    if ($key != $ownId && $cart['x'] == $val['x'] && $cart['y'] == $val['y']) {
      return $key;
    }
  }
  return NULL;
}

function findFirstCollision($grid, $carts) {
  $collision = false;

  while(!$collision) {
    foreach ($carts as $i => $cart) {
      $cart = move($cart, $grid);
      
      $carts[$i] = $cart;

      $collision = hasCollided($cart, $carts);
      if ($collision) {
        return $cart['x'] . "," . $cart['y'];
      }
      
    }
  }
}

function findLastCartStanding($grid, $carts) {
  while(count($carts) > 1) {
    foreach ($carts as $i => &$cart) {
      if ($cart == NULL) {
        continue;
      }
      
      $cart = move($cart, $grid);
      $carts[$i] = $cart;

      $collision = hasCollided($cart, $carts);
      if ($collision) {
        $id = findCollisionId($carts, $i);
        $carts[$id] = NULL;
        $carts[$i] = NULL;
      }
    }
    $carts = sortCarts(array_filter($carts));
  }
  return $carts[0];
}

[$grid, $carts] = createGridAndCarts($input);

echo "First collision at \t" . findFirstCollision($grid, $carts) . "\n";
$cart = findLastCartStanding($grid, $carts);
echo "Last cart stands at \t" . $cart['x'] . "," . $cart['y'] . "\n";
?>