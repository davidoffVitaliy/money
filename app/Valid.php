<?php

function validSumInput($sum)
{
  // не должно быть пустым
  if(varEmpty($sum)){
    $sum = varEmpty($sum);
  }else{
    return null;
  }
  // значение должно быть больше нуля (не минус)
  $sum = MoreThanNull($sum);

  return $sum;
}

// проверка числа - число должно быть больше нуля (не минус)
function MoreThanNull($sum)
{
    if($sum > 0){
      
    return $sum;
   }else{
    session_start();
    $_SESSION['comment'] = 4;
    return false;
   }
}

function varEmpty($sum)
{
    if($sum != null){
       return $sum;
    }
    if($sum == null){
      session_start();
      $_SESSION['comment'] = 2;
      return false;
    }
}

// не больше двух цифр справа от запятой
function NoMoreThanTwoCharactersAfterComma($sum)
{
    return $sum;
}

/* if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $website = test_input($_POST["website"]);
    $comment = test_input($_POST["comment"]);
    $gender = test_input($_POST["gender"]);
  }
  
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  } */

  
  