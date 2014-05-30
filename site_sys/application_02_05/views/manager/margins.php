<!DOCTYPE HTML>
<html lang="ru-RU">
<?php  $this->load->view('page_elements/head');  ?>
<body class="main_page">
<div class="wrapper">
<script type="text/javascript" src="/js/upload.js"></script>
	<div class="base" id="wrapper">
		<?php  $this->load->view('user/header');  ?>
		<div class="main_row">

			<? if (isset($msg)) { ?>	<h3 style='color:red;margin:10px;'><?=$msg?></h3> <? }?>

      		<div class="content_row suppliers_page">

				<div class="suppliers_addi_info">


					<input id="add_provider" type="button"  type="button"style='width:90px' value="Сохранить" onclick='document.forms.forma.submit()'>


				</div>

			</div>      <form action='/manager/margins/'  name ='forma' method='post'>
           				<div class="big_table_wrap">

                        <table class="big_table table" id='main_tab'>
                        <thead>
                                <tr>
                                    <th> Розница</th>
                                    <th> СТО и магазины</th>
                                    <th>Мелкий опт </th>
                                    <th> Средний опт</th>
                                    <th> Крупный опт</th>


                                </tr>
                            </thead>

                            <tbody>

                            <tr class="table_edit_row">
                                        <td>

                                                 <input type="text" class='w100' name="rozn"   value="<?=$margins['rozn']?>">    %


                                        </td>
                                        <td>

                                                 <input type="text" name="sto"  class='w100' value="<?=$margins['sto']?>">    %
         </td>
                                        <td>
                                                  <input type="text" name="l_opt" class='w100'  value="<?=$margins['l_opt']?>">  %

                                        </td>
                                        <td>
                                                  <input type="text" name="m_opt" class='w100'  value="<?=$margins['m_opt']?>">   %


                                        </td>
                                        <td>
                                         <input type="text" name="s_opt" class='w100'  value="<?=$margins['s_opt']?>">    %


                                        </td>
                                    </tr>



                            </tbody>
                        </table>
                        <BR><br>
                        
                        <table class="big_table table" id='main_tab'>
                        <thead>
                                <tr>                                                      
                                    <th width="50px"> Для незарегистрированных</th>
                                    <th width="20px"> Для незарегистрированных EMIR</th>
                                    <th width="50px"> Курс валют</th>
                                    <th>  </th>
                                    

                                </tr>
                            </thead>

                            <tbody>

                            <tr class="table_edit_row">
                        <td>
                <input type="text" class='w100' name="nacenka"  style="width: 50px;"  value="<?=$nacenka?>">    %
                


                </td> <td>
                <input type="text" class='w100' name="nacenka_emir"  style="width: 50px;"  value="<?=$nacenka_emir?>"> 


                </td>  <td> 
                <input type="text" class='w100' name="kurs"  style="width: 50px;"  value="<?=$kurs?>">  грн


                </td>
                 <td>
                  </td>
                                    
                                    </tr>



                            </tbody>
                        </table>


			</div>
   </form>

<style>
 .w100{width:90%;text-align:right;}
</style>

 	 	</div>

	</div>
	<?php  $this->load->view('page_elements/footer');  ?>
</div>
</body>
</html>