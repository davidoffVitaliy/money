<?php

function CabinetController()
{
    // собираю детали, чтоб показать их на главной странице
    // собираю форму для внесения платежей (payment) - resources\views\payment\formPayment.php
    $categoryPayment = render('payment/formPayment', 
        [
        // вес категории расхода
        'findAllExpense'=>findAllExpense(), 

        // все категории прихода
        'findAllIncome' =>findAllIncome(),
        ]);

    $cont = [
        // остаток активов
        'findLastAsset'  =>findLastAsset(),

        // все платежи  
        'findAllPayment' =>findAllPayment(), 
        
        // справочник категорий расхода
        'categoryPayment'=>$categoryPayment, 
         ];
         
    $content = render('cabinet/index', $cont);

    return render('Template', ['title'=>'cabinet Money', 'content'=>$content]);
}