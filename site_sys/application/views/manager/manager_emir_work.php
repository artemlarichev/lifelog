<form action="" method="post">

    <?php if (isset($msg) && $msg == 1): ?>
        <h3 style='color:green;margin:10px; margin-left: 20px;'>Изменение сохранены</h3>
    <?php endif; ?>

    <?php if (isset($msg) && $msg == 2): ?>
        <h3 style='color:green;margin:10px; margin-left: 20px;'>Ошибка сохранения</h3>
    <?php endif; ?>
    <div class="emir_work" style="margin-left: 20px; margin-top: 15px;">
        <div class="search_block" style="padding-top:0px">								

            <div class="field_22">
                <div class="field_h">
                    <div class="field_w">
                        <label for="mp_coef" class="bold">Коэфицент доставки</label>
                        <input type="text" id="mp_coef" name="mp_coef" class="inp_num_carcass" placeholder="7,5">
                    </div>
                </div>
            </div>

        </div>

        <div class="search_block" style="padding-top:15px">								

            <div class="field_22">
                <div class="field_h">
                    <div class="field_w">
                        <label for="mp_code" class="bold">Номер Мегпартс</label>
                        <input type="text" id="mp_code" name="mp_code" class="inp_num_carcass" placeholder="127">
                    </div>
                </div>
            </div>

        </div>

        <div class="search_block" style="padding-top:15px">								

            <div class="field_22">
                <div class="field_h">
                    <div class="field_w">
                        <label for="mp_login" class="bold">Имя Мегпартс</label>
                        <input type="text" id="mp_login" name="mp_login" class="inp_num_carcass" placeholder="avtosys">
                    </div>
                </div>
            </div>

        </div>

        <div class="search_block" style="margin-bottom:30px; padding-top:15px">								

            <div class="field_22">
                <div class="field_h">
                    <div class="field_w">
                        <label for="mp_password" class="bold">Пароль Мегпартс</label>
                        <input type="text" id="mp_password" name="mp_password" class="inp_num_carcass" placeholder="s0h908w3">
                    </div>
                </div>
            </div>

        </div>
        <br>
        <input type='submit' name='save' value='Сохранить'>
    </div>
</form>