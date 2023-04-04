<?php
// файл работы с карегориями активов

// Найти все категории активов (asset) из одной таблицы
function findAllAssetCategory()
{
   return $sql = mysqli_query(db(), "SELECT * FROM asset_category AS a 
    LEFT JOIN currency AS c ON c.idcurrency = a.currency_idcurrency
    LEFT JOIN bank_cash AS bc ON bc.idbank_cash = a.bank_cash_id");

    //return $sql ? $sql == true : false;
}

/* 
    function creat(){}- Создать одну сущность
    function findOne(){} - Найти одну сущность из одной таблицы
    Найти одину сущность и свойства её из нескольких таблиц
    Найти более одной сущности и своейства её из нескольких таблиц
    Найти по слову одну или более сущностей
    function update(){} - Редактировать одну сущность
    function deleteOne(){} - Удалить одну сущность      
    function deleteSelect(){} - Удалить одну и более сущностей 
*/