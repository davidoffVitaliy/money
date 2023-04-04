<div>
    <a href="/money2/main">На главную</a>
</div>


<p>Вид платежа - </p>
    <!-- прилетает из -app/Controllers/PaymentController.php  editPaymentController($idPayment)-->
    <?php foreach($findOneIdPayment as $result){ ?>
<div>
    <form action="/money2/updatepayment" method="POST">
        <div >id -  <?php echo $result['idpayment']; ?></div> 
        <div >Категория платежа -  <?php echo $result['payment_category_name']; ?></div>
        <input type="text" value="<?php echo $result['payment_sum']; ?>" name="payment"> <!--  новый платеж -->
        <input type="hidden" name="idpayment" value="<?php echo $result['idpayment']; ?>"> <!--  id записи , которая редактируется -->
        <input type="hidden" name="idincome_expense" value="<?php echo $result['payment_category_idpayment_category']; ?>">
        <input type="hidden" name="payment_old" value="<?php echo $result['payment_sum']; ?>"> <!--старый платеж -->
        <input type="hidden" name="asset_category_id" value="<?php echo $result['asset_category_id']; ?>"> 
        <input type="hidden" name="assets_old" value="<?php //echo $result['asset']; ?>"> <!--старый assets -->
        <button type="submit">Отредактировать</button>
    </form>  
</div>
    <?php } ?>