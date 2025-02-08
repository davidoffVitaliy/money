<div>
    <a href="/cabinet">На главную</a>
</div>
<!-- 
    .........
    форма редактирования платежа -exchange
    .........
-->
exchange
<p>Вид платежа - </p>
    <!-- прилетает из -app/Controllers/PaymentController.php  editPaymentController($idPayment)-->
    <?php foreach($findOneIdPayment as $result){ ?>
<div>
    <form action="/updatepayment" method="POST">
        <div >id -  <?php echo $result['idpayment']; ?></div> 
        <div >Категория платежа -  <?php echo $result['payment_category_name']; ?></div>
        <input type="text" value="<?php echo $result['payment_sum']; ?>" name="payment"> <!--  новый платеж -->
        <label for="date">Дата платежа: </label>
        <input type="date" id="date" name="payment_date"  value="<?php echo $result['payment_date'];?>"/>    <!-- дата платежа -->           
        <input type="hidden" name="idpayment" value="<?php echo $result['idpayment']; ?>"> <!--  id записи , которая редактируется -->
        <input type="hidden" name="idincome_expense" value="<?php echo $result['payment_category_idpayment_category']; ?>">
        <input type="hidden" name="payment_old" value="<?php echo $result['payment_sum']; ?>"> <!--старый платеж -->
        <input type="hidden" name="asset_category_id" value="<?php echo $result['asset_category_id']; ?>"> 
        <input type="hidden" name="assets_old" value="<?php //echo $result['asset']; ?>"> <!--старый assets -->
        <button type="submit">Отредактировать</button>
    </form>  
</div>
    <?php } ?>