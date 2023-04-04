<?php
session_start();
?>
<div class="top-block">
<?php
echo $_SERVER['PHP_SELF'];
    echo $categoryPayment; // вывожу форму транзакций . Присылаю из MainController.php @MainController

if(isset($_SESSION['comment'])){
	// вывожу ошибку запаолнения полей платежа если они есть
	echo '<p>'.comment($_SESSION['comment']).'</p>';
	session_destroy();
}

?>
</div>
<div class="top-block">
<?php
// вывожу все категории активов, чтоб найти остатки по кадому счёту актива
foreach(findAllAssetCategory() as $findAllAssetCategory){
    // достаю по каждому счёту остатки актива
	foreach(findLastAsset($findAllAssetCategory['idasset_category']) as $sumAsset){
        echo '<h2>Деньги - '. $sumAsset['asset_sum'].' '. $sumAsset['asset_category_name'].'</h2>';
	}
}
?>
</div>
<table class="table">
	<caption>Платежи</caption>
	<colgroup>
		<col width="5%">
		<col width="45%">
		<col width="10%">
		<col width="10%">
		<col width="20%">
		<col width="10%">
	</colgroup>
	<thead>    
		<tr>
			<th>id</th>
			<th>Вид платежа</th>
			<th>сумма платежа</th>
			<th>счёт</th>
			<th>редактировать</th>
			<th>удалить</th>
		</tr>
	</thead>
	<tbody> 
		<!-- Из app\Controllers\MainController.php   @MainController  строка-4-22   -->
	<?php foreach($findAllPayment as $transaction){ ?>
		<tr>
			<th><?php echo $transaction['idpayment']; ?></div>
			<td><?php echo $transaction['payment_category_name']; ?></td>
			<td><?php echo $transaction['payment_sum'] ?></td>
			<td><?php echo $transaction['asset_category_name'] ?></td>
			<td><a href="editpayment/<?php echo $transaction['idpayment']; ?>" >редактировать</a></td>
			<td>
			<form action="/money2/deletepayment" method="POST">
                <!--  id записи , которая редактируется -->
				<input type="hidden" name="idpayment" value="<?php echo $transaction['idpayment']; ?>"> 
				<input type="hidden" name="payment_sum" value="<?php echo $transaction['payment_sum']; ?>"> 
				<input type="hidden" name="asset_category_id" value="<?php echo $transaction['asset_category_id']; ?>"> 
				<input type="hidden" name="idincome_expense" value="<?php echo $transaction['payment_category_idpayment_category']; ?>">
				<button type="submin" onclick="del(event)">удалить</button>
			</form>
		    </td>
		</tr>
    <?php } ?>
	</tbody> 
	<tfoot>
		<tr>
			<th>#</th>
			<th>sum</th>
			<th> - </th>
			<th> - </th>
			<th> - </th>
			<th><input type="button" id="upd" value="del"></th>
		</tr>
	</tfoot>
</table>


<script>


function del(event){
	if(confirm('delete?')){
         return true;
	}else{
		event.preventDefault();
	}
};
</script>
<input type="button" value="test2" id="ts">
<div id="div2" hidden>
	<select name="" id="select">
        <option value="">info ------</option>
		<option value="1">info 1</option>
		<option value="2">info 2</option>
		<option value="3">info 3</option>
		<option value="4">info 4</option>
		<option value="5">info 5</option>
	</select>
</div>

<script>
const select = document.getElementById('select');	
	ts.onclick = function(){
        if(confirm('open the notice?')){
			document.getElementById('div2').hidden = false;
		}else{
			preventDefault();
		}
	};
</script>
