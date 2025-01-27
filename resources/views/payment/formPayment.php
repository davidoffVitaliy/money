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
                <form action="/createpayment" method="POST" id="myForm">
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
                <form action="/createpayment" method="POST">
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
                <form action="/exchange" method="POST"> 
                    <p>
                        <label for="date">Дата платежа: </label>
                        <input type="date" id="date" name="date">
                    </p>
                        <!-- Выбор счёта(кошелька) с которого расход-->
                        расход
	                 <p>
                      <select name="assetCategoryIdSpending" >
                        <option value="">Выбрать счёт</option>
                          <?php  foreach(findAllAssetCategory() as $res){ ?>
                        <option value="<?php echo $res['idasset_category']; ?>"> 
                          <?php echo $res['asset_category_name']; ?>
                        </option>
                          <?php } ?> 
                      </select>
                                                  
                        <!-- внесение суммы расхода -->
                       <input type="number" step="0.01" name="payment-sum-spending">
                     </p>

                        <!-- Выбор счёта(кошелька) на который приход-->
                        Приход
	                <p><select name="assetCategoryIdRevenue" >
                        <option value="">Выбрать счёт</option>
                          <?php  foreach(findAllAssetCategory() as $res){ ?>
                        <option value="<?php echo $res['idasset_category']; ?>"> 
                          <?php echo $res['asset_category_name']; ?>
                        </option>
                          <?php } ?> 
                      </select>
                       <!-- внесение суммы прихода -->
                       <input type="number" step="0.01" name="payment-sum-revenue"></p>

                        <button class="btn btn-payment">Внести обмен/перевод</button>
                    </p> 
                    </form>
            </div>
    </div>
    
</div>


<script src="/resources/js/script.js">
    // обраборка форма 
</script>