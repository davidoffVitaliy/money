<?php
// файл - контроллер платежей

// внести платеж 
function createPaymentController()
{
   
    // приходят данные из формы - resources\views\payment\formPayment.php  стр.- 10-60
    // категория платежа
    $idPaymentCategory = $_POST['idPaymentCategory'];
    // проверяю сумму: больше нуля, 
    $sumPayment       = $_POST['payment-sum'];
    $assetCategoryId  = $_POST['assetCategoryId'];
    // дата платежа
    $datePayment      = $_POST['date'];   
    $_SESSION['date'] = $datePayment;
    $sumPayment = validSumInput($_POST['payment-sum']);
    // если переданы данные с полей формы
    if($sumPayment == true and !empty($idPaymentCategory and !empty($assetCategoryId))){
         
        $db = db();
        // начало транзакции 
        mysqli_begin_transaction($db);    

        try {
        
            // запись платежа в базу (в таблицу Payment)
            $queryPayment = createPayment($db, $sumPayment, $idPaymentCategory, $assetCategoryId, $datePayment);

            // определяю - платеж приход или расход
            $IncomeOrExpense = findOnePaymentIncomeOrExpenseCategory($idPaymentCategory);
            foreach($IncomeOrExpense as $findOnePayment){
                $idPaymentCategory = $findOnePayment['payment_category_idpayment_category'];
            }
            
             // select  суммы остатка актива
             $findLastAssets = findLastAsset($assetCategoryId);
             // есть ли уже записи в таблице активов
             $row_cnt = mysqli_num_rows($findLastAssets);
             // если запись в активах(asset) уже есть 
            if($row_cnt !== 0){
                //
                foreach($findLastAssets as $findLastAsset){
                    //
                    foreach($IncomeOrExpense as $findOnePayment){
                        // высчитываю сумму на которую надо будет скорректирвать остаток актива (asset) в creatAsset($db, $sumNew); строка 63
                        // если операция приход - надо написать !!!!!!!!!!!!!!
                        // !!!!!!!!!  если операция расход !!!!!!!!!!!!
                        // если сумма остатка на счёту больше или равна присланной сумме из формы
                        if($idPaymentCategory == 2){
                        if($findLastAsset['asset_sum'] >= $sumPayment ){
                            //$ostatokAktiv = $findLastAsset['asset_sum'];
                            //$summfPrihod = $sumPayment;
                            // 
                            $sumNew = addAmount($idPaymentCategory, $findLastAsset['asset_sum'], $sumPayment);
                            // внесение нового остатка в Asset
                            $queryAsset = creatAsset($db, $sumNew, $assetCategoryId);
                            
                        }else{
                            session_start();
                            $_SESSION['comment'] = 5;
                        }
                        }

                        if($idPaymentCategory == 1){
                                // 
                                $sumNew = addAmount($idPaymentCategory, $findLastAsset['asset_sum'], $sumPayment);
                                // внесение нового остатка в Asset
                                $queryAsset = creatAsset($db, $sumNew, $assetCategoryId);
                            
                            }
                    }
                } 
            }
            
             // если в активах ещё нет записи, то  
            if($row_cnt == 0){ 
                // определяю к какой группе платеж относиться - приход или расход       
                if($idPaymentCategory == 1){ // елси $idPaymentCategory == 1, то это категория "приход"
                    //$sumNew = $sumPayment;// это первая сумма актива
                    $sumNew = addAmount($idPaymentCategory, $findLastAsset['asset_sum'], $sumPayment); 
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
             ///$_SESSION['comment'] = 6;
            // $_SESSION['test'] = $ostatokAktiv;
             header("Location: cabinet");
         }  
    }
    
    // если не все поля формы заполнены
    if(empty($sumPayment) or empty($idPaymentCategory)){
       session_start();
       $_SESSION['comment'] = 2;
       $_SESSION['date'] = $idPaymentCategory;
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

// редактирование данных платежа, баланса
function updatePaymentController()
{
    // из формы - resources\views\payment\edit.php
    $idPayment         = $_POST['idpayment'];// id редактируемого платежа idpayment
    $payment_new       = $_POST['payment'];// новая сумма платежа  
    $payment_old       = $_POST['payment_old'];// старое значение платежа
    $idPaymentCategory = $_POST['idincome_expense'];// вясняю - приход или расход
    $findAllAssetCategory = $_POST['asset_category_id'];
    $payment_date = $_POST['payment_date']; // дата платежа
    
    // подключаюсь к базе данных
    $db = db(); 

    mysqli_begin_transaction($db);

    try {
    // 
    $updatePayment = updatePayment($db, $payment_new, $idPayment, $payment_date);

    // нахожу сумму на которую надо скорректировать остаток актива
    echo $difference = difference($idPaymentCategory , $payment_new, $payment_old); 
     // корректирую остаток актива (assset)  
    $updateAsset = updateAsset($db, $difference, $findAllAssetCategory);
            
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
    $idPayment         = $_POST['idpayment'];  // id payment на удаление
    $paymentSum        = $_POST['payment_sum']; // сумма удаленная (payment), на которую скорректирую актив
    $idPaymentCategory = $_POST['idincome_expense']; // приход или расход - что выяснить уменьшать или увеличивать сумму актива
    $findAllAssetCategory = $_POST['asset_category_id'];  // id актива

    if(!empty($idPayment and !empty($paymentSum) and $idPaymentCategory)){
        
        $db = db();

        // нахожу разницу на которую надо скорректировать остаток актива (asset)       
        $difference = difference($idPaymentCategory, $SumFirst = 0, $paymentSum);                
        //
        mysqli_begin_transaction($db);    
        
        try {
            // найти остаток по счёту
            // findLastAsset($findAllAssetCategory)  // 1.найти остаток актива - ффорич 2. сравнить остаток актива с удаляемой суммой - актив должет быть равен или больше
            // сравнить остаток и удаляемую сумму - если сумма будет меньше нуля (отрицательная), то отменять удаление и вывести уведомление
            // удаляю платеж
            $deleteOnePayment = deleteOnePayment($db, $idPayment);
            
            // коррекрирую остаток актива (asset) на сумму удаленного платежа
            $updateAsset = updateAsset($db, $difference, $findAllAssetCategory); 
         
             //
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
 