<?if(isset($_SESSION['manager'])  ){
    
    if(!isset($ajax)){?>
<link rel="stylesheet" href="/js/jquery.autocomplete.css" type="text/css" />
<script type="text/javascript" src="/js/jquery.bgiframe.min.js"></script>
<script type="text/javascript" src="/js/jquery.dimensions.js"></script>
<script type="text/javascript" src="/js/jquery.autocomplete.js"></script>
<script>
$(document).ready(function(){
var data = "<? foreach($this->user_names as $user) {echo str_replace('"',"'",$user)."! ";}; ?>".split("! ");
$("#manager_field").autocomplete(data,{onItemSelect:selectItem});
});
function selectItem(text)
{     // alert("/manager/to_user/"+$("#manager_field").val()) ;
	 location.replace("/manager/to_user/"+$("#manager_field").val());
}
function Clear()
{
	$("#manager_field").select();
}
</script>
<?}?>
<div class="manager_form">
					<div class="manager_block">

						<input type="text"  onclick="Clear()"  value="<?=$_SESSION['user']['card']?> <?=$_SESSION['user']['name']?> <?=$_SESSION['user']['fullname']?>"
					  id="manager_field"    >

						<input type="submit" value="Выйти" id="exit_butt" name="exit_butt" onclick='location.replace("/client/logout")' >
					</div>
					<div class="m_f_addi_wrap">
						<?
						if( isset($this->conf['page'])){?>
						<a title="На сайт" href="/" class="to_cabinet2">На сайт<span  ></span></a>
						<?}else{?>
						<a title="В кабинет" href="/client/orders/0/1" class="to_cabinet">В кабинет<span></span></a>
						<?}?>
						<span class="balance">Баланс: <span><?=$_SESSION['user']['balans']?></span> <?=$_SESSION['user']['valuta']?>.</span>
                        
 
                         <a  href="/register" title="Как стать клиентом">Как стать клиентом</a>
                           <a class="edit_ico" href="/manager/edit_page/register" title=""></a></li>           
                        
					</div>
				</div>

<?}elseif(isset($_SESSION['user'])){?>
<div class="user_form">
					<div class="user_field_wrap">
 			   <span class="user_block">
						<?=$_SESSION['user']['card']?> <?=$_SESSION['user']['name']?> <?=$_SESSION['user']['fullname']?>
						</span>

						<input type="submit" value="Выйти" id="exit_butt" name="exit_butt" onclick='location.replace("/client/logout")' >
					</div>
					<div class="m_f_addi_wrap">
						<?
						if( isset($this->conf['page'])){?>
						<a title="На сайт" href="/" class="to_cabinet2">На сайт<span  ></span></a>
						<?}else{?>
						<a title="В кабинет" href="/client/orders/0/1" class="to_cabinet">В кабинет<span></span></a>
						<?}?>
						<span class="balance">Баланс: <span><?=$_SESSION['user']['balans']?></span> <?=$_SESSION['user']['valuta']?>.</span>
					</div>
				</div>
<?}else{?>
<script type="text/javascript">
function Login()
{
	 $.blockUI({message: $('#modal_dialog'), css: {width: '200px'}});
		 $.post("/catalog/ajax_login/",{
		card:$("#pass").val(),
		pass:$("#card").val()
	 },function(data){
  	  $.unblockUI();
  	  if(data=='0') {alert('Неверный логин пароль!');return false;}
  	 // if(data=='1') {window.location.reload(true);return false;}
  	   // $("#login").html(data);

  	    window.location.reload(true);return false;
  	  });
}

</script>

		<div class="enter_form">
					<div class="enter_field_wrap">
						<input type="text"  name="pass"  placeholder="№ карты" value="№ карты" onblur="javascriipt:if(this.value=='') this.value='№ карты'" onfocus="javascript:this.value=''"  id="pass" onkeydown='javascript:if(13==event.keyCode){Login();}'>
						<input type="password"  title="Пароль" name="card" onblur="javascriipt:if(this.value=='') this.value=''"  placeholder="Пароль" onfocus="javascript:this.value=''"  placeholder="Пароль"  id="card" onkeydown='javascript:if(13==event.keyCode){Login();}'>

						<input type="submit" name="enter_butt" id="enter_butt" value="Войти" onclick='Login()'>
					</div>
					<a class="how_become_customer" href="/register" title="Как стать клиентом">Как стать клиентом</a>
				</div>

<?}?>