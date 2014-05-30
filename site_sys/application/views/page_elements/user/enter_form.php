<h2 class="content_h2" style="border-bottom:1px solid #ccc; padding-left:20px">Вход</h2>
<div class="reg_hold">

    <div class="reg_tabs">

        <div class="search_block" style="padding-top:0px">								
            <div class="field_5">
                <div class="field_h">
                    <div class="field_w">
                        <label for="enter_card" class="bold">Номер карточки </label>
                        <input onkeydown="javascript:if (13 == event.keyCode){Login();}" type="text" id="enter_card" name="card" class="inp_num_carcass" placeholder="Ваш номер карточки">
                    </div>
                </div> 
            </div>
            <div class="reg_message errors"></div>							
        </div>
        
        <div class="search_block" style="padding-top:15px">								
            <div class="field_5">
                <div class="field_h">
                    <div class="field_w">
                        <label for="enter_pass" class="bold">Пароль </label>
                        <input onkeydown="javascript:if (13 == event.keyCode){Login();}" type="password" id="enter_pass" name="pass" class="inp_num_carcass" placeholder="Ваш пароль">
                    </div>
                </div> 
            </div>
            <div class="reg_message"></div>									
        </div>
        <br>
        
        
        <input onclick="Login();" type='submit' name='enter_butt' id="enter_butt" class="reg_but" value='Войти'>
        <ul class="reg_form">
            <li><a href="http://<?=$_SERVER['HTTP_HOST'];?>/user/recover" >Восстановление пароля</a></li>

            <li><span>&nbsp;|&nbsp;</span><a href="http://<?=$_SERVER['HTTP_HOST'];?>/user/register" >Регистрация</a></li>
        </ul>
    </div>
</div>