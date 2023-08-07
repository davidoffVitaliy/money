<div class="category_block">
    <!-- income expense exchange -->
    <div class="tab">
    <button class="tablinks" onclick="openCity(event, 'Income')">Приход</button>
    <button class="tablinks" onclick="openCity(event, 'expense')" id="defaultOpen">Расход</button>
    <button class="tablinks" onclick="openCity(event, 'exchange')">Перевод (Обмен)</button>
    </div>
    
    <!-- блок внесения операций (payment) -->
    <div class="income_expense_block">
            <div id="Income" class="tabcontent">
            <h3>Приход</h3>
                <!--- Форма отправляет данные для внесения прихода в - app\Controllers\PaymentController.php   @createPaymentController()--->
                <form action="/money2/createpayment" method="POST">
                    <p>
                        <label for="date">Дата платежа: </label>
                        <input type="date" id="date" name="date"/>
                    </p>
                    <!-- внесение суммы прихода -->
                    <p><input type="number" step="0.01" name="payment-sum"></p>
                    <!---- категорвии прихода---->
                    <select name="idPaymentCategory" id="select">
                      <option value="">Каьегории прихода</option>
                      <?php foreach($findAllIncome as $income){?>  
                      <option value="<?php echo $income['idpayment_category']; ?>"><?php echo $income['payment_category_name']; ?></option>  
                      <?}?>
                    </select>
                    <!-- Выбор счёта(кошелька) с котормы операция-->
                    <?php
	                echo showAllAssetCategory();
                    ?>
                    <button class="btn btn-payment">Внести доход</button>
                </form>
            </div>
            
            <!--- Форма отправляет данные для внесения расхода в - app\Controllers\PaymentController.php   @createPaymentController()--->
            <div id="expense" class="tabcontent">
            <h3>Расход</h3>
                <form action="/money2/createpayment" method="POST">
                    <div>
                    <p>
                        <label for="date">Дата платежа: </label>
                        <input type="date" id="date" name="date">
                    </p>    
                      <!-- внесение суммы расхода -->
                      <p><input type="number" step="0.01" name="payment-sum"></p>
                      <select name="idPaymentCategory" id="">
                      <option value="">Категории расходов</option>
                      <?php foreach($findAllExpense as $expense){ ?>
                      <option value="<?php echo $expense['idpayment_category']; ?>"><?php echo $expense['payment_category_name']; ?></option>
                      <?php } ?>
                      </select>

                      <!-- Выбор счёта(кошелька) с котормы операция-->
	                  <?php echo showAllAssetCategory();?>

                      <button class="btn btn-payment">Внести расход</button>
                    </div>
                </form>
            </div>
        
            <!--- Форма отправляет данные для внесения обмена/перевода со счёта на счёт в - app\Controllers\PaymentController.php   @createPaymentController()--->
            <div id="exchange" class="tabcontent">
            <h3>Обмен</h3>
            
                     <p>
                        <label for="date">Дата платежа: </label>
                        <input type="date" id="date" name="date">
                    </p>
                        <!-- Выбор счёта(кошелька) с которого расход-->
                        расход
	                 <p><?php echo showAllAssetCategory();?>
                        <!-- внесение суммы расхода -->
                       <input type="number" step="0.01" name="payment-sum"></p>

                        <!-- Выбор счёта(кошелька) на который приход-->
                        Приход
	                <p><?php echo showAllAssetCategory();?>
                       <!-- внесение суммы прихода -->
                       <input type="number" step="0.01" name="payment-sum"></p>

                        <button class="btn btn-payment">Внести обмен/перевод</button>
                    </p> 

            </div>
    </div>
    
</div>


<script src="/money2/resources/js/script.js">
    // обраборка форма 
</script>