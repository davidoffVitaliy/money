<?php

// главная страница
function MainController()
{
    $db = db();
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
         
    $content = render('main/index', $cont);

    return render('Template', ['title'=>'Главная Money', 'content'=>$content]);
}

// вторая страница с урока
function opened_productController()
{
    $cont = [];
    $content = render('main/opened_product', $cont);

    return render('Template', ['title'=>'Главная Money', 'content'=>$content]);
}

// третья страница с урока
function checkoutController()
{
    $cont = [];
    $content = render('main/checkout', $cont);

    return render('Template', ['title'=>'CheckoutPage', 'content'=>$content]);
}