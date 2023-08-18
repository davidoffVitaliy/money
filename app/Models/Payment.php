<?php
    // файл (модель) работы с платежами (payment)

    // создаю запись платежа в базу - приход
    function createPayment($db, $sumPayment, $idPaymentCategory, $assetCategoryId, $datePayment) 
    {        
        $queryPayment = mysqli_query($db, "INSERT INTO payment 
            (payment_sum, payment_category_id, asset_category_id, payment_date)   
            VALUES 
            ('$sumPayment', '$idPaymentCategory', '$assetCategoryId', '$datePayment')");
            
        return true ? $queryPayment == true : false;
    }
    
    // Найти всё из одной таблицы
    function findAllPayment()
    {
        return mysqli_query(db(), "SELECT * FROM payment AS p
        LEFT JOIN payment_category AS pc ON pc.idpayment_category = p.payment_category_id
        LEFT JOIN asset_category AS ac ON ac.idasset_category = p.asset_category_id
        ORDER BY payment_date DESC");
    } 

    //- найти одну категорвию, чтоб определить - она относиться к приходу или расходу
    function findOnePayment($idPaymentCategory)
    {
        $db = db();
        return mysqli_query($db, "SELECT * FROM payment_category WHERE payment_category_idpayment_category = '$idPaymentCategory'");
    } 
    
    // сумма выбраного платежа для внесения в форму для редактирования
    function findOneIdPayment($idPayment)
    {
        return mysqli_query(db(), "SELECT * FROM payment AS p
        LEFT JOIN payment_category AS pc ON pc.idpayment_category = p.payment_category_id
        WHERE idpayment = '$idPayment'");
    }

    function updatePayment($db, $payment_new, $idPayment, $payment_date)
    {
        $queryPayment = mysqli_query($db, "UPDATE payment 
        SET `payment_sum` = '$payment_new',
        `payment_date` = '$payment_date'  
        WHERE `idpayment` = '$idPayment'");

        return true ? $queryPayment == true : false;
    }
    
    //Удалить одну запись  
    function deleteOnePayment($db, $idPayment)
    {
        $queryPayment = mysqli_query($db, "DELETE FROM `payment` WHERE `idpayment` = '$idPayment'");
        return true ? $queryPayment == true : false;
    } 

/* 
    function creat(){}//- Создать одну сущность
    function findAll(){} - Найти всё из одной таблицы
    function findOne(){} - Найти одну сущность из одной таблицы
    Найти одину сущность и свойства её из нескольких таблиц
    Найти более одной сущности и своейства её из нескольких таблиц
    Найти по слову одну или более сущностей
    function update(){} - Редактировать одну сущность
    
    function deleteSelect(){} - Удалить одну и более сущностей 
*/
