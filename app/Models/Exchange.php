<?php

function createExchange($db, $sumExchangeSpending, $sumExchangeRevenue, $assetCategoryIdSpending, $assetCategoryIdRevenue, $dateExchange)
{
    $queryPayment = mysqli_query($db, "INSERT INTO exchange
            (exchange_sum_spending, exchange_sum_revenue, asset_category_spending_id, asset_category_revenue_id, exchange_date)   
            VALUES 
            ('$sumExchangeSpending', '$sumExchangeRevenue', '$assetCategoryIdSpending', '$assetCategoryIdRevenue', '$dateExchange')");
            
        return true ? $queryPayment == true : false;
}

// - Найти всё из одной таблицы
function findAllExchange($iduser = null)
{/*
    $query = mysqli_query(db(), 
    "SELECT 
    *
    FROM exchange AS e
    LEFT JOIN payment AS p ON e.payment_idpayment_spending = p.idpayment
    LEFT JOIN payment AS pm ON e.payment_idpayment_revenue = pm.idpayment

    LEFT JOIN asset_category AS ac
    ON p.asset_category_id = ac.idasset_category
    
    ORDER BY idexchange DESC");

    return $query;  */
}

//модель перевода(обмена) с одного счёта на другой
/* 
    
    function findOne(){} - Найти одну сущность из одной таблицы
    Найти одину сущность и свойства её из нескольких таблиц
    Найти более одной сущности и своейства её из нескольких таблиц
    Найти по слову одну или более сущностей
    function update(){} - Редактировать одну сущность
    function deleteOne(){} - Удалить одну сущность      
    function deleteSelect(){} - Удалить одну и более сущностей 
*/