<br><br><?if(sizeof($makelogo)>1){?>
<h2>найдено несколько производителей. Уточните производителя</h2>
<?}?>
         <h3>Производители</h3>
<table class="big_table table">
            <thead>
                <tr>
                        
    

    


                     <th class="maker"> MakeLogo </th>
                      <th class="maker"> name </th> 
                     <th class="maker"> state </th> 
                     <th class="maker"> поиск </th> 
                      

                </tr>
            </thead>

            <tbody>
             <?foreach($makelogo as $row){?>
                <tr class="table_check_row_prepare">
                    
                   <td><?=$row['MakeLogo']?></td>
                   <td><?=$row['name']?></td>
                   <td><?=$row['state']?></td>
                    <td><a href='/search/result/<?=$f_id?>/<?=$row['MakeLogo']?>'>Поиск>>></td> 
                   
                   </tr>
                   <?}?>
                    
         
                    
            </tbody>
        </table>

<br><br><h2>Найдено в таблице "emir_substs"(аналоги) </h2>
<br>
<table class="big_table table">
            <thead>
                <tr>
 
                     <th class="maker"> makelogo </th>
                      <th class="maker"> makelogofull </th> 
                     <th class="maker"> detailnum </th> 
                     <th class="maker"> makelogos </th> 
                     <th class="maker"> makelogofulls </th> 
                     <th class="maker"> detailnums </th> 
                     <th class="maker"> t </th> 
                      

                </tr>
            </thead>

            <tbody>
             <?foreach($tab1 as $row){?>
                <tr class="table_check_row_prepare">
                    
                   <td><?=$row['makelogo']?></td>
                   <td><?=$row['makelogofull']?></td>
                   <td><?=$row['detailnum']?></td>
                   <td><?=$row['makelogos']?></td>
                   <td><?=$row['makelogofulls']?></td>
                   <td><?=$row['detailnums']?></td>
                   <td><?=$row['t']?></td>
                   
                   </tr>
                   <?}?>
                    
         
                    
            </tbody>
        </table>
        Коды:<?print(implode(',',$analog))?><br>
               
        <br><br><h2>Найдено в таблице "emir_substs"(аналоги анаголов по кодах ) </h2>
<br>
<table class="big_table table">
            <thead>
                <tr>
 
                     <th class="maker"> makelogo </th>
                      <th class="maker"> makelogofull </th> 
                     <th class="maker"> detailnum </th> 
                     <th class="maker"> makelogos </th> 
                     <th class="maker"> makelogofulls </th> 
                     <th class="maker"> detailnums </th> 
                     <th class="maker"> t </th> 
                      

                </tr>
            </thead>

            <tbody>
             <?foreach($tab2 as $row){?>
                <tr class="table_check_row_prepare">
                    
                   <td><?=$row['makelogo']?></td>
                   <td><?=$row['makelogofull']?></td>
                   <td><?=$row['detailnum']?></td>
                   <td><?=$row['makelogos']?></td>
                   <td><?=$row['makelogofulls']?></td>
                   <td><?=$row['detailnums']?></td>
                   <td><?=$row['t']?></td>
                   
                   </tr>
                   <?}?>
                    
         
                    
            </tbody>
        </table>
        Коды:<?print(implode(',',$analog2))?><br>
        <br><br>
        
        <?if(isset($tab3)){?>
           
        <br><br><h2>Найдено мало аналогов, ищем еще раз </h2>
<br>
<table class="big_table table">
            <thead>
                <tr>
 
                     <th class="maker"> makelogo </th>
                      <th class="maker"> makelogofull </th> 
                     <th class="maker"> detailnum </th> 
                     <th class="maker"> makelogos </th> 
                     <th class="maker"> makelogofulls </th> 
                     <th class="maker"> detailnums </th> 
                     <th class="maker"> t </th> 
                      

                </tr>
            </thead>

            <tbody>
             <?foreach($tab3 as $row){?>
                <tr class="table_check_row_prepare">
                    
                   <td><?=$row['makelogo']?></td>
                   <td><?=$row['makelogofull']?></td>
                   <td><?=$row['detailnum']?></td>
                   <td><?=$row['makelogos']?></td>
                   <td><?=$row['makelogofulls']?></td>
                   <td><?=$row['detailnums']?></td>
                   <td><?=$row['t']?></td>
                   
                   </tr>
                   <?}?>
                    
         
                    
            </tbody>
        </table>
        
        <br><br>
        <?}?>
        
        Полный список кодов по которым ищем по талицах<?print(implode(',',$all_analog))?><br>
        
                <br><br><h2>Найдено в таблице "emir"( по кодах ) </h2>
<br>
<table class="big_table table">
            <thead>
                <tr>
                     
    

    

    

    

    

    

                     <th class="maker"> MakeLogo </th>
                      <th class="maker"> DetailNum </th> 
                     <th class="maker"> DetailPrice </th> 
                     <th class="maker"> DetailName </th> 
                     <th class="maker"> PriceLogo </th> 
                     <th class="maker"> Quantity </th> 
                     <th class="maker"> PackQuantity </th> 
                    <th class="maker"> t </th> 
                    <th class="maker"> t1 </th> 
                      

                </tr>
            </thead>

            <tbody>
             <?foreach($tab_emir as $row){?>
                <tr class="table_check_row_prepare">
                    
                   <td><?=$row['MakeLogo']?></td>
                   <td><?=$row['DetailNum']?></td>
                   <td><?=$row['DetailPrice']?></td>
                   <td><?=$row['DetailName']?></td>
                   <td><?=$row['PriceLogo']?></td>
                   <td><?=$row['Quantity']?></td>
                   <td><?=$row['PackQuantity']?></td>
                        <td><?=$row['t']?></td>
                        <td><?=$row['t1']?></td>
                   
                   </tr>
                   <?}?>
                    
         
                    
            </tbody>
        </table>