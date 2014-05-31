<div class="order_box_w">
	<div class="order_box">
		<h3 class="ob_hline">Вы заказываете <span class="ob_close"></span></h3>


		<div class="ob_form">
			 
				<h2 class="obf_product"  id="obf_title"></h2>

				<div class="obf_count">
					<label for="obf_count">Количество: </label>
					<input class="obf_inp" type="text" id="obf_count" value="1" onkeyup="RefreshPrice()">
                    <input  type="hidden" id="part_num">
                    <input class="part_id" type="hidden" id="part_id">
                    <input class="part_id" type="hidden" id="part_price">
                    <input class="part_type" type="hidden" id="part_type">
                    <span>Сумма: <span id='obf_summ'></span> <?=$_SESSION['valuta']?>.</span>
				</div>
				<div class="obf_data">
					<div class="obf_types hide_element"  >
						<label class="ob_title" >Тип отгрузки</label>
						<br>
						 <select name="type_shipment"  id="Destinationlogo" >
						 
							<option value="EMEW" selected>воздухом</option>
							<option value="CNTE">морем</option> 
						</select> 
						<br>
					<!--	<label class="ob_title" id="type_packaging">Тип упаковки</label>
						<br>
						<select name="type_packaging">
							<option></option>
							<option value="1">Упаковка 1</option>
							<option value="2">Упаковка 2</option>
							<option value="3">Упаковка 3</option>
						</select>
                        -->
					</div>
					<ul class="obf_details">
						<!--<li><label><input type="checkbox" id="bitOnly" value="1">Только этот артикул</label></li>-->
						<li><label><input type="checkbox" id="OnlyThisBrand" value="2">Только этот производитель</label></li>
						<li><label><input type="checkbox" id="bitAgree" value="4">Согласен на увеличение стоимости</label> </li>
						<li class='hide_element'><label><input type="checkbox" id="bitWait" value="5">Могу ждать месяц</label></li>
					</ul>
				</div>

				<!--
                <div class="obf_caution hide_element"  >
					Стоимость доставки хрупких и крупногабаритных грузов (капот, стекло, молдинг и т.п.), может возрасти
					в
					несколько раз.
				</div>
                -->
				<div class="obf_submit_w">
					<input   type="button" onclick="AddToBassNew()" class="obf_submit" value="В корзину">
				</div>
			 
		</div>
	</div>
</div>
