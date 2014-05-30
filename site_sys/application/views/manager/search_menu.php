<script type="text/javascript" src="/js/search.js"></script>
<script type="text/javascript" >
var search_type='<?=$search_type?>';
var search_id='<?if(isset($f_id)){print($f_id);}?>';
</script>
<div class="search_block t3">
	<ul class="search_category">
		<li><a id='link_code' <?if($search_type=='code') {?> class="mark"<?}?>  href="#" onclick='SelType("code");return false' title="По номеру">По номеру</a></li>
		<li><a id='link_group'<?if($search_type=='group') {?> class="mark"<?}?> href="#" onclick='SelType("group");return false' title="По группам">По группам</a></li>
	<!--	<li><a id='link_auto'<?if($search_type=='auto') {?> class="mark"<?}?> href="#" onclick='SelType("auto");return false' title="По автомобилю">По автомобилю</a></li>
-->	</ul>

	<div class="search_form">

	<div id='div_group' <?if(!($search_type=='group')) {?> style='display:none'<?}?>>
						<div class="group_form_first">
							<select id="cat1" name="cat1"  >
							<option value=""></option>
							<?foreach($group as $val){?>
								<option value="<?=$val['group']?>"><?=$val['group']?></option>
							<?}?>
							</select>
							<select id="cat2" name="cat2"  >
							<option value=""></option>
								<?foreach($group_1 as $val){?>
								<option value="<?=$val['group']?>"><?=$val['group']?></option>
							<?}?>
							</select>
							<select id="cat3" name="cat3"  >
							<option value=""></option>
								<?foreach($group_2 as $val){?>
								<option value="<?=$val['group']?>"><?=$val['group']?></option>
							<?}?>
							</select>

						</div>
						<div class="group_form_second">
							<input type="text" id="search_field_group" name="search_field">
							<input type="submit" value="Найти" onclick='Search("group");return false' id="search_submit" name="search_submit">
						</div>
	</div>

     <div id='div_code' <?if(!($search_type=='code')) {?> style='display:none'<?}?>>
		<span class="example">
			Например, <a href="#" onclick='findRandKey("<?=$this->conf['key']?>")' title="<?=$this->conf['key']?>"><?=$this->conf['key']?></a>
		</span>
		<input type="text" name="search_field" id="search_field"> <input type="checkbox" value="1" id='only' <?if(isset($only)){?> checked="checked" <?}?> >  точное соответствие  
		<input type="submit" name="search_submit" id="search_submit"  onclick='Search("code");return false'  value="Найти">
     </div>
	</div>
</div>


