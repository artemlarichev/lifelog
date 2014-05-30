<?if(!isset($action)){$action='';}?>
<?if(isset($_SESSION['manager'])){$this->load->view('page_elements/manager_menu');}?>


<div class="header" style="background: url('<?= $this->data->rand_banner() ?>') no-repeat scroll 50% 86px transparent !important;">
    <div class="header_wrap" 
         <?if(isset($top_image)){?>style='background: url('<?= $this->data->rand_banner() ?>') no-repeat scroll 50% 86px transparent;'<?}?>>

         <h1 class="logo_w"><a class="logo" href="/" title="Джапан Авто">Джапан Авто</a></h1>

        <div id='login'>
            <?php $this->load->view('page_elements/login_box'); ?>
        </div>
        <div class="tel">
            <span>(044)</span> 540-51-08, 540-79-55
        </div>
        <ul class="list_link">
            <li><a href="/shops" title="Наши магазины">Наши магазины</a>
                <?php if (isset($_SESSION['manager'])) { ?>     <a class="edit_ico" href="/manager/edit_page/shops" title=""></a> <?}?>
            </li>
            <li><a href="/order" title="Заказ и доставка">Заказ и доставка</a>
                <?php if (isset($_SESSION['manager'])) { ?>   <a class="edit_ico" href="/manager/edit_page/order" title=""></a><?}?>
            </li>
        </ul>
        <?php if ($action !== 'emir_work'): ?>
            <?php $this->load->view('page_elements/search_menu'); ?>
        <?php endif; ?>
        <!-- here was search menu -->

        <?php if (isset($_SESSION['user'])) { ?>

            <ul class="search_tabs" style="margin-top: 15px;">

            </ul>

        <?php } ?>


    </div>
</div>
