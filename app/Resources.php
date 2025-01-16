<?php
// корректироване суммы остатка актива (asset) при удалении или редактировании платежа (payment)
function difference($idPaymentCategory, $payment_new, $payment_old)
{
    // сумма на которую надо будет скорректирвать остаток актива asset
    if($idPaymentCategory == 1){ // елси $idPaymentCategory == 1, то это категория "приход"
        $differenceSum = $payment_new - $payment_old; // если скорректирована запись "приход", то от актива надо будет отнять
        return $differenceSum;
     }
     if($idPaymentCategory == 2){ // елси $idPaymentCategory == 2, то это категория "расход"
      $differenceSum = $payment_old - $payment_new; // если скорректирована запись "расход", то к остатку актива надо будет прибавить эту сумму
      return $differenceSum;
     }
}

// корректироване суммы актива (asset) при внесении платежа
function addAmount($idPaymentCategory, $findLastAsset, $sumPayment)
{
   if($idPaymentCategory == 1){ // елси $idPaymentCategory == 1, то это категория "приход"
      return $findLastAsset + $sumPayment;// прибавляю остаток актва (asset) и приход (payment)
   }
   if($idPaymentCategory == 2){ // елси $idPaymentCategory == 2, то это категория "расход"
      return $findLastAsset - $sumPayment; //отнимаю от остатка актива (asset) платеж расход (payment)
   }
}

// категорвии активов с вападающим списком для внесения платежей
function showAllAssetCategory()
{
	echo '
	      <select name="assetCategoryId" >
		   <option value="">Выбрать счёт</option>';
		   foreach(findAllAssetCategory() as $res){
	echo '<option value='; echo $res['idasset_category']; 
   echo '>'; 
	echo $res['asset_category_name']; 
	echo '</option>';
	    } 
   echo '</select>';
}