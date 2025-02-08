<link rel="stylesheet" href="/resources/css/btn.css">
<link rel="stylesheet" href="/resources/css/cabinet-style.css">
<link rel="stylesheet" href="/resources/css/style.css">   
<div class="b-wrapper">
	<header class="b-header">
		<div class="div-exit">
		    <button class="btn btn-exit-link" onclick="document.location='/main'">Выход</button>
		</div>
	</header>
<!----end header---------------------------------------------------------------->	
	<main class="b-main">
		<div class="b-top">
			<!---------форма транзакций--------------------------------->
			<div class="b-form-payment" id="parent">
				<?php
				
				echo $categoryPayment; // вывожу форму транзакций . Присылаю из CabinetController.php  @CabinetController
				
				session_start();
				
				if(!empty($_SESSION['comment'])){
				// вывожу ошибку запаолнения полей платежа если они есть
				echo '<p class="red">'.comment($_SESSION['comment']).'</p>';
				session_destroy();
				header("Refresh: 3");
				}
				
				if(isset($_SESSION['debug']))
				Debug($_SESSION['debug']);
				
				?>
			</div>
			
			<!--остаток активов----------------------------------->
			<div class="top-block">
            <?php
            // вывожу все категории активов, чтоб найти остатки по кадому счёту актива
            foreach(findAllAssetCategory() as $findAllAssetCategory){
                // достаю по каждому счёту остатки актива
				foreach(findLastAsset($findAllAssetCategory['idasset_category']) as $lastAsset){ ?>
					<div class="block-asset">
						<div class="asset-sum">
							<?php echo $lastAsset['asset_category_name']; ?>
						</div>
						<div class="asset-category-name">
					        <?php echo $lastAsset['asset_sum']; ?>
						</div>
					</div>
				<?php }
            }
            ?>
        </div>
			<!---->
			<!---------разнеые записи------------------------------------------->
			<div class="different">
				<?php
				session_start();
				if(!empty($_SESSION['debug'])){
				$a = $_SESSION['debug'];
				echo Debug($a);
				}
				
				?>	

				<h3>Проблемы: </h3>
				<h3>Не нравится вывод ошибок и перегрузка всей страницы</h3>
				<h3> </h3>
				<h4>Задачи:</h4>
				<h4 class="red"></h4>
				<h4>1. Пагинацию - поставить под таблицей</h4>
				<h4>2. Модальное окно с ошибками (?)</h4>
				<a href="https://github.com/davidoffVitaliy/money" target="_blanc">https://github.com/davidoffVitaliy/money</a>
			</div>
			
		</div>
		

<div class="table-wrapper">
			<!--id="table payment"--->
	<table class="table payment"  id="paymentTable" title="pagination"> 
		<caption>
        <h4>Платежи</h4>
		</caption>
		<colgroup>
			<col width="5%">
			<col tidth="15%">
			<col width="30%">
			<col width="5%">
			<col width="5%">
			<col width="15%">
			<col width="15%">
			<col width="10%">
		</colgroup>
		<thead>    
			<tr>
				<th>id</th>
				<th>Дата</th>
				<th>Вид платежа</th>
				<th>сумма прихода</th>
				<!--<th>Приход</th>-->
				<th>Расход</th>
				<th>счёт</th>
				<th>редактировать</th>
				<th>удалить</th>
			</tr>
		</thead>
		<tbody >
		<!--  -->
			<!-- Из app\Controllers\CabinetController.php   @CabinetController  строка-4-22   -->
		<?php foreach($findAllPayment as $transaction){ ?>
			<tr >
				<th><?php echo $transaction['idpayment']; ?></th>
				<td><?php echo $transaction['payment_date']; ?></td>
				<td><?php echo $transaction['payment_category_name']; ?></td>
				<td><?php if($transaction['payment_category_idpayment_category'] == 1){ ?>
				<?php echo $transaction['payment_sum'] ?>
				<?php } ?></td>
				<td><?php if($transaction['payment_category_idpayment_category'] == 2){ ?>
				<?php echo $transaction['payment_sum'] ?>
				<?php } ?></td>
				<td><?php echo $transaction['asset_category_name'] ?></td>
				<td>
				<?php if($transaction['payment_category_id'] != 4 AND $transaction['payment_category_id'] !=5){?>	
				<a class="update" href="editpayment/<?php echo $transaction['idpayment']; ?>" >редактировать</a>
				<?php } else { ?>
					<a class="update" href="editexchange/<?php echo $transaction['idpayment']; ?>" >редактировать</a>
				<?php } ?>	
				</td>
				<td>
				<form action="/deletepayment" method="POST">
					<!--  id записи , которая редактируется -->
					<input type="hidden" name="idpayment" value="<?php echo $transaction['idpayment']; ?>"> 
					<input type="hidden" name="payment_sum" value="<?php echo $transaction['payment_sum']; ?>"> 
					<input type="hidden" name="asset_category_id" value="<?php echo $transaction['asset_category_id']; ?>"> 
					<input type="hidden" name="idincome_expense" value="<?php echo $transaction['payment_category_idpayment_category']; ?>">
					<button class="btn btn-payment" type="submin" onclick="del(event)">удалить</button>
				</form>
				</td>
			</tr>
		<?php } ?>
		</tbody>
		<!-- -->
		
		<tfoot>
			<tr>
				<th>#</th>
				<th></th>
				<th>sum</th>
				<th> - </th>
				<th> - </th>
				<th> - </th>
				<th> - </th>
				<th></th>
			</tr>
		</tfoot>
		
	
	</table>
	
    </div>
	<div id="pagination"></div>
	</main>
	<footer class="b-footer"></footer>
	
</div>




<script>
const rowsPerPage = 5;
const table = document.getElementById('paymentTable');
const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
const totalPages = Math.ceil(rows.length / rowsPerPage);
let currentPage = 1;

function displayPage(page) {
    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    for (let i = 0; i < rows.length; i++) {
        rows[i].style.display = (i >= start && i < end) ? '' : 'none';
    }
}

function createPagination() {
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = '';

    for (let i = 1; i <= totalPages; i++) {
        const button = document.createElement('button');
        button.innerText = i;
        button.addEventListener('click', () => {
            currentPage = i;
            displayPage(currentPage);
        });
        pagination.appendChild(button);
    }
}

displayPage(currentPage);
createPagination();



// удаление записи
function del(event){
	if(confirm('delete?')){
         return true;
	}else{
		event.preventDefault();
	}
};


	// Получаем ссылку на форму
var form = document.getElementById('myForm');

// Добавляем обработчик события отправки формы
form.addEventListener('submit', function(event) {
  // Проверяем, заполнены ли все поля формы
  if (!validateForm()) {
    // Если не все поля заполнены, отменяем отправку формы
    event.preventDefault();
    // Отображаем модальное окно
    showModal();
  }
});

// Функция для проверки заполнения всех полей формы
function validateForm() {
  var inputs = form.getElementsByTagName('input');
  for (var i = 0; i < inputs.length; i++) {
    if (inputs[i].value === '') {
      return false;
    }
  }
  return true;
}

// Функция для отображения модального окна
function showModal() {
	///////////
	var parentElement = document.getElementById('parent');
    //var newElement = document.createElement('p');
    //parentElement.appendChild(newElement);
	//////////////////
	// let = modal.  b-form-payment
  // Создаем элемент модального окна
  var modal = document.createElement('div');
  modal.classList.add('modal');
  
  // Добавляем содержимое модального окна
  modal.innerHTML = '<h2>Ошибка!</h2><p>Не все поля формы заполнены.</p>';
  
  // Добавляем модальное окно на страницу
  parentElement.appendChild(modal);
}


</script>

