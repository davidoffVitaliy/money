<?php
// приходят данные из формы - resources\views\payment\formPayment.php  стр.- 10-60
function createExchangeController()
{
    
    // дата платежа
    $dateExchange             = $_POST['date'];    
    //категория расхода
    $assetCategoryIdSpending  = $_POST['assetCategoryIdSpending'];
    // сумма расхода
    $sumExchangeSpending      = validSumInput($_POST['payment-sum-spending']); 
    //категории прихода 
    $assetCategoryIdRevenue   = $_POST['assetCategoryIdRevenue'];
    // сумма прихода
    $sumExchangeRevenue       = validSumInput($_POST['payment-sum-revenue']);

    // если все значения присланы из формы, то начинается внесение данных:
    if(!empty($dateExchange) and !empty($assetCategoryIdSpending) and !empty($sumExchangeSpending) and !empty($assetCategoryIdRevenue) and !empty($sumExchangeRevenue)){
        $db = db();

        mysqli_begin_transaction($db);  
        
        try {
            //нахожу один последний актив который расходуется(остаток), только сумму
            $lastAssetSumSpending = findLastAssetOnlySum($assetCategoryIdSpending);
            // Если расход не больше остатка актива, то вношу в таблицы
            if($lastAssetSumSpending >= $sumExchangeSpending){
                // создаю запись -расход в таблице payment
        
                $createPaymentSpendig = createPayment($db, $sumExchangeSpending, 4, $assetCategoryIdSpending, $dateExchange); 
                // 
                $createPaymentRevenue = createPayment($db, $sumExchangeRevenue, 5, $assetCategoryIdRevenue, $dateExchange); 
                
                // нахожу новый остаток актива расхода, чтоб внести его в таблицу asset
                $sumNewSpending = $lastAssetSumSpending - $sumExchangeSpending;  
                
                // сумма последнего актива к которому будет приход (остаок). только сумма
                $lastAssetSumRevenue = findLastAssetOnlySum($assetCategoryIdRevenue);
                // внесение нового остатка в Asset расходуемого актива
                $queryAssetSpending = creatAsset($db, $sumNewSpending, $assetCategoryIdSpending);
                
                // обновленная сумма актива по приходу которую надо вносить 
                $sumNewRevenue = $sumExchangeRevenue + $lastAssetSumRevenue;
                // внесение нового остатка в asset по приходу
                $queryAssetRevenue = creatAsset($db, $sumNewRevenue, $assetCategoryIdRevenue);
            
            }else{
                session_start();
                $_SESSION['comment'] = 5; //"сумма расхода не может быть больше остатка"
                header("Location: cabinet");
            }
            
            // если что то не внеслось, то отменяю транзакцию
            if($createPaymentSpendig == false or $createPaymentRevenue == false or $queryAssetSpending == false or $queryAssetRevenue == false){ 
                //
            throw new Exception('Транзакция не прошла!'); 
            } 
            //
            mysqli_commit($db);
            header("Location: cabinet") ?$createPaymentSpendig == true and $createPaymentRevenue == true and $queryAssetSpending == true and $queryAssetRevenue == true: header("Location: cabinet");
        }catch (Exception $e) {
            $e->getMessage();
            mysqli_rollback($db);
            session_start();
            //  не известная ошибка
            $_SESSION['comment'] = 6;
            header("Location: cabinet");
         }  
    }
    
    if(empty($dateExchange) or empty($assetCategoryIdSpending) or empty($sumExchangeSpending) or empty($assetCategoryIdRevenue) or empty($sumExchangeRevenue)){
        session_start();
        $_SESSION['comment'] = 2; // надо внести все значения платежа
        header("Location: cabinet");
    }
}


// операции по обмену
/* 
    function findAllExchangeController(){} //- Найти всё из одной таблицы
    function findOne(){} - Найти одну сущность из одной таблицы
    Найти одину сущность и свойства её из нескольких таблиц
    Найти более одной сущности и своейства её из нескольких таблиц
    Найти по слову одну или более сущностей
    function edit()
    function update(){} - Редактировать одну сущность
    function deleteOne(){} - Удалить одну сущность      
    function deleteSelect(){} - Удалить одну и более сущностей 
*/