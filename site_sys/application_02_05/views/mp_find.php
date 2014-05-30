
    <?
       foreach($result as $k=>$val){
           if($val->bitOldNum and $val->PercentSupped <51 ){
                     // echo "<h3>Этот номер <b>{$code_key}</b> устарел,закажите по замене</h3>";
                      unset($result[$k]);}
                      elseif($val->bitOldNum and $val->PercentSupped <100 ) unset($result[$k]);
                      elseif($val->PriceLogo!='FAST')  unset($result[$k]);
       }
       
    if(sizeof($result)>0){    
        
        
        ?>
<div class="content_row">
<div class="scroll_hor">
                <h2 style="margin: 10px;"> Дальний заказ</h2><br />
                <?if(!isset($_SESSION['user'])){?>
                <i>Для получения дополнительной скидки нужно зарегистрироваться на сайте.</i>
                <?}?>
                <?if(sizeof($result)>0){
                  if($result[0]->bitOldNum and $result[0]->PercentSupped <51 ){
                      echo "<h3>Этот номер <b>{$code_key}</b> устарел,закажите по замене</h3>";
                      unset($result[0]);
                      
                  }  
                }?>
                    <table class="small_table table" id='main_tab'>
                        <thead>
                            <tr>
                                <th style='' > Артикул </th>                   
               
                                <th style='' > Описание </th>                   
                                <th  style=''  class="amount"> Производитель </th>
                                <th  style=''  class="amount"> Поставщик </th>
                                <th class="" > Выполнение, %</th>                   
                                <th class=""> Ориентировочный<br /> cрок поставки,<br /> дней </th>                   
                                <th class="" > В наличии,<br /> шт. </th>                               
                                <th class="" > Ориентировочный вес </th>                                
                                <th class="" > Ориентировочная <br />стоимость доставки,<br /> долл</th>    
                                <th  class=""  class="amount"><b> Цена, долл.</b></th>   
                                <th class="" > Ориентировочная <br />цена с доставкой, долл</th>   
                                <th> </th>
                            </tr>
                        </thead>

                        <tbody>
                             <?
                             $count2=0;
                            
                             foreach($result as $val){
                                  if($val->bitOldNum and $val->PercentSupped <100 ) continue;
                                  if($val->PriceLogo!='FAST')continue;
                                 //echo   $val->Price." " ;      
                                  $val->Price = number_format($val->Price*$this->conf['nacenka_emir'],2,'.','');                            
                                  //echo   $val->Price." ";
                                  if($_SESSION['valuta']=='грн') $price = $val->Price*$this->conf['kurs'];else $price =$val->Price; 
                                   //echo   $price." ";
                                   if(!isset($_SESSION['user'])){
                                    if($_SESSION['valuta']=='грн') $price = number_format(($this->conf['DostPtrice']*$val->WeightGr/1000*$this->conf['kurs']+$price),2,'.','');   
                                    else                          $price   = number_format(($this->conf['DostPtrice']*$val->WeightGr/1000+$price),2,'.',''); 
                                   }
                                   // echo   $price." ";
                                 $count2++;?>
                            <tr> 
                                 <td class="  "><?=str_replace($code_key,"<b>{$code_key}</b>",$val->DetailNum) ?> 
                                 <?if($val->bitOldNum ) echo '<br><b style="color: red;">номер устарел</b> ';?> 
                                   </td>   
 

                                 <td class=""><?=$val->PartNameRus ?> <?=$val->PartNameEng ?> </td>   
                                 <td class=""> <?=$val->Make ?>  <?=$val->MakeName ?> </td>   
                                 <td class=""><?=$val->PriceLogo ?> </td>
                                 <td class="numeric"><?=$val->PercentSupped ?> </td>
                                 <td class="numeric"><?=$val->Delivery+10 ?> </td>
                                 <td class="numeric"><?=$val->Available ?> </td>
                                 <td class="numeric"><?=weight($val->WeightGr) ?></td>
                                 <td class="numeric"><?=number_format($this->conf['DostPtrice']*$val->WeightGr/1000,2,'.','')?>  </td>
                                 <td class="numeric"><b><?=$val->Price ?></b> </td>   
                                  <td class="numeric"><?=number_format(($this->conf['DostPtrice']*$val->WeightGr/1000+$val->Price),2,'.','')?>  </td>
                                <td class="f_buy">
                                  
                                 <input type="hidden" name='id_mp_<?=$count2?>'  id='id_mp_<?=$count2?>' value='<?=$val->PriceId?>'>
                                     <input type="hidden" name='price_mp_<?=$count2?>'  id='price_mp_<?=$count2?>'
                                      
                                      value='<?=$price?>'>
                                     <input type="hidden" name='text_mp_<?=$count2?>'  id='text_mp_<?=$count2?>'
                                      value='<?echo str_replace("'",'',$val->DetailNum.' '.$val->MakeName.' '.$val->PartNameRus)?>'>
                                      <input type="hidden" name='amount_mp_<?=$count2?>'  id='amount_mp_<?=$count2?>' value='<?=$val->Available?>'>
                                     <a title="" href="#" onclick='Show_add_block(<?=$count2?>,"mp");return false' class="edit_ico"></a> 
                                
                                 </td>   
                               </tr>  
                                    <?}?>                                                                                     
                                                         
                        </tbody>
                    </table>

                </div>
            </div>

 
     <script src="/js/ui.tablesorter.js" type="text/javascript"></script>

<script type="text/javascript">
                                

  $("#main_tab").tablesorter({  widgets: ['zebra']       }) ;
   var p_count_mp=<?=$count2?>;
</script>
   <div align="left" style="text-align: left;">
 </div>
 
 <?}?>     
 

 
 