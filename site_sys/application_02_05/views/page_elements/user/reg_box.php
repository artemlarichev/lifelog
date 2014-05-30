<h2 class="content_h2" style="border-bottom:1px solid #ccc; padding-left:20px">Регистрация</h2>
<div class="reg_hold">

    <div class="reg_tabs">
        
        <!-- email input -->
        <div class="search_block" style="padding-top:0px">								
            <div class="field_5">
                <div class="field_h">
                    <div class="field_w">
                        <label for="num_carcass" class="bold">Эл. почта</label>
                        <input type="text" id="reg_email" name="reg_email" class="inp_num_carcass reg_email" placeholder="admin@sysauto.ua">
                    </div>
                </div> 
            </div>
            <div class="reg_message errors reg_email_error"></div>							
        </div>
        
        <!-- password input -->
        <div class="search_block" style="padding-top:15px">								
            <div class="field_5">
                <div class="field_h">
                    <div class="field_w">
                        <label for="num_carcass" class="bold">Пароль</label>
                        <input type="password" id="reg_pass" name="reg_pass" class="inp_num_carcass reg_pass" placeholder="*******">
                    </div>
                </div> 
            </div>
            <div class="reg_message errors reg_password1_error"></div>							
        </div>
        
        <!-- password repeat input -->
        <div class="search_block" style="padding-top:15px">								
            <div class="field_5">
                <div class="field_h">
                    <div class="field_w">
                        <label for="num_carcass" class="bold">Пароль</label>
                        <input type="password" id="reg_pass2" name="reg_pass2" class="inp_num_carcass reg_pass2" placeholder="******">
                    </div>
                </div> 
            </div>
            <div class="reg_message errors reg_password2_error"></div>							
        </div>
        
        <!-- count input -->
        <div class="search_block" style="padding-top:15px">								
            <div class="field_5">
                <div class="field_h">
                    <div class="field_w">
                        <label for="num_carcass" class="bold">Объем закупок в месяц, грн</label>
                        <input type="text" id="reg_count" name="reg_count" class="inp_num_carcass reg_count" placeholder="50 000">
                    </div>
                </div> 
            </div>
            <div class="reg_message errors reg_count_error"></div>							
        </div>
        
        <br>
        
        <input type='submit' name='registration' class="reg_but" value='Зарегистрироваться' onclick="Register();">;
        
        <ul class="reg_form">
            <li><a href="http://<?=$_SERVER['HTTP_HOST'];?>/user/enter" >Вход</a></li>

            <li><span>&nbsp;|&nbsp;</span><a href="http://<?=$_SERVER['HTTP_HOST'];?>/user/recover" >Восстановление пароля</a></li>
        </ul>
        
    </div>
</div>