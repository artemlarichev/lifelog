                    <div class="big_table_wrap">
<h2>Пропущенные позиции</h2>
                    <table class="big_table table">
                            <thead>
                                <tr>
                                    
                                     <th class="marking">
                                         Артикул
                                    </th>
                                    <th class="maker"> Производитель </th>
                                    <th class="important"> Описание  </th>
                                   <th class="important"> Цена  </th>
                                   
                                </tr>
                            </thead>

                            <tbody>
                        <? $sup='';
                            foreach($data as $val){?>
                            
                             
                                <tr   > <td   ><?=$val['0']?></td>
                                <td   ><?=$val['3']?></td>
                                <td   ><?=$val['4']?></td>
                                <td   ><?=$val['2']?></td>
                                
 
                                </tr>
                                <?}?>
                                    
                            </tbody>
                        </table>



                   
                    </div>
                