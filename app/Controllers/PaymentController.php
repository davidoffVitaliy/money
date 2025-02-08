<?php
// файл - контроллер платежей

// внести платеж 



function createPaymentController()
{
    //// приходят данные из формы - resources\views\payment\formPayment.php  стр.- 10-60
    // категория платежа
    $idPaymentCategory = $_POST['idPaymentCategory'];   
    // проверяю сумму: больше нуля, 
    $sumPayment        = validSumInput($_POST['payment-sum']);
    // категория актива, остаток которого надо будет корректировать
    $assetCategoryId   = $_POST['assetCategoryId'];
    // дата платежа
    $datePayment       = $_POST['date'];  
    
    // если переданы данные с полей формы
    if(isset($idPaymentCategory) and isset($assetCategoryId) and isset($sumPayment) and isset($datePayment)){
        $db = db();
        
        // начало транзакции 
        mysqli_begin_transaction($db);    

        try {
        
            // запись платежа в базу (в таблицу Payment)
            $queryPayment = createPayment($db, $sumPayment, $idPaymentCategory, $assetCategoryId, $datePayment);
            // определяю - платеж приход или расход - запрос в базу
            $idPaymentCategory = findOnePaymentIncomeOrExpenseCategory($idPaymentCategory);
            
             // select  суммы остатка актива - только сумма
            $lastAsset = findLastAssetOnlySum($assetCategoryId); 
            
             // если запись в активах(asset) уже есть 
            if($lastAsset !=null){
                        // если расход
                        if($idPaymentCategory == 2){
                            // если расход больше или равен остатку, тогда вношу ... отрицательное значение не допускается
                            if($lastAsset >= $sumPayment ){
                                // нахожу новый остаток актива, чтоб внести в таблицу asset
                                $sumNew = addAmount($idPaymentCategory, $lastAsset, $sumPayment);
                                // внесение нового остатка в Asset
                                $queryAsset = creatAsset($db, $sumNew, $assetCategoryId);
                                
                            }else{
                                session_start();
                                $_SESSION['comment'] = 5;
                                header("Location: cabinet");
                            }
                        }
                        // если приход
                        if($idPaymentCategory == 1){
                                // нахожу новый остаток актива, чтоб внести в таблицу asset
                                $sumNew = addAmount($idPaymentCategory, $lastAsset, $sumPayment);
                                // внесение нового остатка в Asset
                                $queryAsset = creatAsset($db, $sumNew, $assetCategoryId);
                            }
            }
            
             // если в активах ещё нет записи, то  
            if($lastAsset == null){ 
                // определяю к какой группе платеж относиться - приход или расход       
                if($idPaymentCategory == 1){ // елси $idPaymentCategory == 1, то это категория "приход"
                    //$sumNew = $sumPayment;// это первая сумма актива
                    $sumNew = addAmount($idPaymentCategory, $lastAsset, $sumPayment); 
                     // внесение нового остатка в Asset
                    $queryAsset = creatAsset($db, $sumNew, $assetCategoryId);
                }
                if($idPaymentCategory == 2){ 
                    // елси $idPaymentCategory == 2, то это категория "расход"
                    session_start();
                    // если в активах нет записи, то нелья сделать расход - выводится надпись , что надо внести сначала приход
                    $_SESSION['comment'] = 1;         
                    header("Location: cabinet");
                }   
            }
            // если что то не внеслось, то отменяю транзакцию
            if($queryAsset == false or $queryPayment == false){ 
                //
            throw new Exception('Транзакция не прошла!'); 
            } 
            mysqli_commit($db);
            header("Location: cabinet") ? $queryPayment == true and $queryAsset == true: header("Location: cabinet");      
        }catch (Exception $e) {
            $e->getMessage();
            mysqli_rollback($db);
            session_start();
            //  не известная ошибка
            $_SESSION['comment'] = 6;
            header("Location: cabinet");
        }  
    }
    if(empty($idPaymentCategory) or empty($assetCategoryId) or empty($sumPayment) or empty($datePayment)){
         // если не все поля формы заполнены
        session_start();
        $_SESSION['comment'] = 2;
        header("Location: cabinet");
    }  
}

// вывести файл редактирования платежа
function editPaymentController($idPayment)
{
    
    $cont = [
        // сумма выбраного платежа для внесения в форму для редактирования
        'findOneIdPayment'=>findOneIdPayment($idPayment)
        ];

    $content = render('payment/edit', $cont);
    return render('Template', ['title'=>'Редактирование платежа', 'content'=>$content]);
}

// вывести файл редактирования платежа
function editexchangePaymentController($idPayment)
{
    
    $cont = [
        // сумма выбраного платежа для внесения в форму для редактирования
        'findOneIdPayment'=>findOneIdPayment($idPayment)
        ];

    $content = render('payment/editexchange', $cont);
    return render('Template', ['title'=>'Редактирование обмена', 'content'=>$content]);
}


// редактирование данных платежа, баланса
function updatePaymentController()
{
    // из формы - resources\views\payment\edit.php
    $idPayment           = $_POST['idpayment'];// id редактируемого платежа idpayment
    $payment_new         = validSumInput($_POST['payment']);// новая сумма платежа  
    $payment_old         = $_POST['payment_old'];// старое значение платежа
    $idPaymentCategory   = $_POST['idincome_expense'];// вясняю - приход или расход
    $findIdAssetCategory = $_POST['asset_category_id'];
    $payment_date        = $_POST['payment_date']; // дата платежа
    
    // подключаюсь к базе данных
    $db = db();
    
    mysqli_begin_transaction($db);

    try {
    
    // нахожу сумму на которую надо скорректировать остаток актива
    $difference = difference($idPaymentCategory , $payment_new, $payment_old); 
    
    if($idPaymentCategory == 2){ // если редактируется расход
        
        $lastAsset = findLastAssetOnlySum($findIdAssetCategory); //остаток актива
        // если остаток актива больше или равна $difference, то вносится, если нет, то выводится ошибка - не может быть отрицательное значение
        if($lastAsset + $difference >= 0){
            // редактирую платёж
            $updatePayment = updatePayment($db, $payment_new, $idPayment, $payment_date);
            // корректирую остаток актива (assset)  
            $updateAsset = updateAsset($db, $difference, $findIdAssetCategory);
        }else{
            // комент - не может быть отрицательного значения
            session_start();
            $_SESSION['comment'] = 5;
            header("Location: cabinet");
        }
    }
        if($idPaymentCategory == 1){ // если редактируется приход
            // редактирую платёж
            $updatePayment = updatePayment($db, $payment_new, $idPayment, $payment_date);
            // редактирую актив
            $updateAsset = updateAsset($db, $difference, $findIdAssetCategory);
    }
     
            
    mysqli_commit($db);
    header("Location: cabinet") ? $updateAsset == true and $updatePayment == true: header("Location: cabinet");
    } catch (Exception $e) {
            echo $e->getMessage();
            mysqli_rollback($db);
        }
}

//Удалить одну запись  
function deleteOnePaymentController()
{
    // получаю из формы \resources\views\main\index.php  строки-46-59
    $idPayment           = $_POST['idpayment'];  // id payment на удаление
    $paymentSum          = $_POST['payment_sum']; // сумма удаленная (payment), на которую скорректирую актив
    $idPaymentCategory   = $_POST['idincome_expense']; // приход или расход - что выяснить уменьшать или увеличивать сумму актива
    $findIdAssetCategory = $_POST['asset_category_id'];  // id актива
    session_start();
    $_SESSION['debug'] = $paymentSum;
    if(!empty($idPayment and !empty($paymentSum) and $idPaymentCategory)){
        
        $db = db();

        // нахожу разницу на которую надо скорректировать остаток актива (asset)       
        $difference = difference($idPaymentCategory, $SumFirst = 0, $paymentSum);                
        //
        mysqli_begin_transaction($db);    
        
        try {
            // если удаляется приход
            if($idPaymentCategory == 1){
                $lastAsset = findLastAssetOnlySum($findIdAssetCategory); // 1.найти остаток актива 
                if($lastAsset - $paymentSum >= 0){ //если удаляемый приход не больше остатка - остаток не может быть отрицательным
                    // удаляю платеж
                    $deleteOnePayment = deleteOnePayment($db, $idPayment);
                    // коррекрирую остаток актива (asset) на сумму удаленного платежа
                    $updateAsset = updateAsset($db, $difference, $findIdAssetCategory); 
                }else{
                    session_start();
                    $_SESSION['comment'] = 5; // коментарий - "сумма не может быть отрицательной"
                    header("Location: cabinet");
                }
            }
            
            // елси удаляется расход
            if($idPaymentCategory == 2){
                // удаляю платеж
                $deleteOnePayment = deleteOnePayment($db, $idPayment);
                // коррекрирую остаток актива (asset) на сумму удаленного платежа
                $updateAsset = updateAsset($db, $difference, $findIdAssetCategory); 
            }
            
             // если что то не внеслось
            if($deleteOnePayment == false or $updateAsset == false){ 
                throw new Exception('Удаление не состояловь!'); 
            } 
            
            mysqli_commit($db);
            header("Location: cabinet") ? $deleteOnePayment == true and $updateAsset == true: header("Location: cabinet");
    
        }catch (Exception $e) {
            echo $e->getMessage();
            mysqli_rollback($db); 
        }  
    }
} 


