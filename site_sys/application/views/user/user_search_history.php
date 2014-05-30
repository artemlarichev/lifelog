<form action="" method='post'>
    <?php if(isset($msg)){?>	<h3 style='color:red;margin:10px;'>Изменение сохранены</h3> <?}?>
    <div class="content_row">
        <div class="small_table_wrap">

            <table class="small_table table" id='main_tab'>
                <thead>
                    <tr>
                        <th style='cursor:pointer;text-decoration:underline'> Фраза </th>
                        <?php if(isset($_SESSION['manager'])): ?>
                        <th style='width:150px;cursor:pointer;text-decoration:underline'> Время </th>
                        <th class="amount" style='cursor:pointer;text-decoration:underline'> Количество </th>    							
                        <?php endif; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($result as $val): ?>
                    <tr>
                        <td>
                            <a title="Количество" href="#" onclick="HistorySearch('<?=$val['title'] ?>'); return false;">
                                <?= $val['title'] ?>
                            </a>
                        </td>
                        <?php if(isset($_SESSION['manager'])): ?>
                        <td><?=$val['time'];?></td>
                        <td class="numeric"><?=$val['cnt'];?></td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br>
            <input type='submit' name='save' value='Сохранить'>
        </div>
    </div>
    <script src="/js/ui.tablesorter.js" type="text/javascript"></script>

    <script type="text/javascript">
        $("#main_tab").tablesorter({widgets: ['zebra']});
    </script>
</form>