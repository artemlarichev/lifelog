<div class="field_23">
    <div class="field_h">
        <div class="field_w" style="padding-bottom:10px">	
            <input id='num_carcass' name='num_carcass' type="checkbox"></td>
            <label for="num_carcass">Отображать полный артикул при поиске</label>
        </div>
        <div class="field_w" style="padding-bottom:10px">
            <input id='num_carcass' name='num_carcass' type="checkbox"></td>
            <label for="num_carcass">Отображать выбор по группам при поиске</label>
        </div>
        <div class="field_w" style="padding-bottom:10px">
            <input id='num_carcass' name='num_carcass' type="checkbox"></td>
            <label for="num_carcass">Отображать ссылку на прайс в кабинете</label>
        </div>
        <div class="field_w" style="padding-bottom:10px">
            <input id='num_carcass' name='num_carcass' type="checkbox"></td>
            <label for="num_carcass">Отправлять оповещения с сайта по почте</label>
        </div>
    </div>
</div>

<div class="content_row">
<div class="tiny_table_wrap">
    <form action='' method='post'>
        <table class="table">
            <thead>
                <tr>
                    <th>
                        Название
                    </th>
                    <th class="check">
                        <input type="checkbox" id='all' onclick='SelAll()'>
                    </th>
                </tr>
            </thead>

            <tbody>
                <?foreach($fields_keys as $key){?>
                <tr>
                    <td>
                        <?= $fields[$key] ?>
                    </td>
                    <td>
                        <input id='<?= $key ?>' class='sel'  name='<?= $key ?>' type="checkbox" <?if(isset($user_fields[$key])){echo"checked";}?>></td>
                </tr>
                <?}?>
            </tbody>
        </table>
        <br>
        <input type='submit' name='save' value='Сохранить'>
        </div>
</div>