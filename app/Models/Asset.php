<?php
    // В этом файле работа с активами (asset) 

    // Создать актив
    function creatAsset($db, $sumNew, $assetCategoryId)
    {
        // внести новый остаток и платёж
        $query = mysqli_query($db, "INSERT INTO asset (asset_sum, asset_category_id) VALUES ('$sumNew', '$assetCategoryId')");

        return true?$query == true : false;     
    }

    // Найти всё активы
    function findAllAsset()
    {
        return mysqli_query(db(), "SELECT * FROM asset AS aORDER BY a.idasset DESC ");
    } 

    //последний актив. остаток. все свойства актива (остаток актива - assets)
    function findLastAsset($findAllAssetCategory = null)
    {
        $db = db();
        $query = mysqli_query($db, "SELECT * FROM asset AS a 
        LEFT JOIN asset_category AS ac ON ac.idasset_category = a.asset_category_id
        LEFT JOIN currency AS c ON c.idcurrency = ac.currency_idcurrency
        LEFT JOIN bank_cash AS bc ON bc.idbank_cash = ac.bank_cash_id
        WHERE `asset_category_id` = '$findAllAssetCategory'
        ORDER BY a.idasset DESC LIMIT 1");

        return $query;
    }

    // найти одину запись актива
    function findOneAsset($idAsset)
    {
        return mysqli_query(db(), "SELECT * FROM asset AS a WHERE a.idasset = '$idAsset'");
    }
    
    // редактирование актива (assets)
    function updateAsset($db, $difference, $findAllAssetCategory)
    {
       foreach(findLastAsset($findAllAssetCategory) as $res){
           $query = mysqli_query($db, 
           "UPDATE asset
           SET asset_sum = asset_sum + '$difference'
           WHERE idasset = '".$res['idasset']."'");
       }

       return true ? $query == true : false;
    }

/* 
    
    function findOneAsset(){} - Найти одну сущность из одной таблицы
    Найти одину сущность и свойства её из нескольких таблиц
    Найти более одной сущности и своейства её из нескольких таблиц
    Найти по слову одну или более сущностей
    function deleteOneAsset(){} - Удалить одну сущность      
    function deleteSelectAsset(){} - Удалить одну и более сущностей 
*/
    

