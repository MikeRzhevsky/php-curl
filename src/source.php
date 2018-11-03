<?php
  $a = $_GET['a'];
  $b = $_GET['b'];
  if($a || $b) {
      echo $a + $b;
  }else {
      $arr = array(
          array(
              "region" => "Moscow",
              "price" => "10000"
          ),
          array(
              "region" => "Kaluga",
              "price" => "500"
          ),
          array(
              "region" => "Balashiha",
              "price" => "100"
          )
      );
      echo json_encode($arr);
  }
//Пример https://syn.su/testwork.php
