<?php

function comment($id)
{
    switch ($id) {
        case 0:
            //return  "надо внести приход";
            break;
        case 1:
            return  "надо внести приход";
            break;
        case 2:
            return "надо внести все значения платежа";
            break;
        case 3:
            return "ошибка с payment";
            break;
        case 4:
            return "Сумма не может быть отрицательной или равна нулю";
            break;
        case 5:
            return "сумма расхода не может быть больше остатка";
            break;
    }
    
}