<?php

// В этом файле работа с справочником категорий 

// 
function findAllIncome()
{
    return mysqli_query(db(), "SELECT * FROM payment_category WHERE payment_category_idpayment_category = 1");
}



function findAllExpense()
{
    return mysqli_query(db(), "SELECT * FROM payment_category WHERE payment_category_idpayment_category = 2");
}

// достать категории платежей (payment) - для определения - "приход или расход"
function findOnePaymentIncomeOrExpenseCategory($idPaymentCategory)
{
    $query = mysqli_query(db(), "SELECT * FROM payment_category WHERE idpayment_category = '$idPaymentCategory'");

    foreach($query as $result){
        $paymentCategory = $result['payment_category_idpayment_category'];
    }
    return $paymentCategory;
}
/* 
    function creat(){}- Создать одну сущность
    function findAll(){} - Найти всё из одной таблицы
    function findOne(){} - Найти одну сущность из одной таблицы
    Найти одину сущность и свойства её из нескольких таблиц
    Найти более одной сущности и своейства её из нескольких таблиц
    Найти по слову одну или более сущностей
    function update(){} - Редактировать одну сущность
    function deleteOne(){} - Удалить одну сущность      
    function deleteSelect(){} - Удалить одну и более сущностей 
*/

