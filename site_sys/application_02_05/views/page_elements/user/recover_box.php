<h2 class="content_h2" style="border-bottom:1px solid #ccc; padding-left:20px">Восстановление пароля</h2>
<div class="reg_hold">

    <div class="reg_tabs">

        <div class="search_block" style="padding-top:0px">								
            <div class="field_5">
                <div class="field_h">
                    <div class="field_w">
                        <label for="num_carcass" class="bold">Электронная почта</label>
                        <input type="text" id="recover_email" name="recover_email" class="inp_num_carcass" placeholder="admin@sysauto.ua">
                    </div>
                </div> 
            </div>
            <div class="reg_message errors recover_error"></div>							
        </div>
        <br>
        <input onclick="Recover();" type='submit' name='save' class="reg_but" value='Восстановить'>
        <ul class="reg_form">
            <li><a href="http://<?=$_SERVER['HTTP_HOST']?>/user/enter" >Вход</a></li>

            <li><span>&nbsp;|&nbsp;</span><a href="http://<?=$_SERVER['HTTP_HOST']?>/user/register" >Регистрация</a></li>
        </ul>
    </div>
</div>