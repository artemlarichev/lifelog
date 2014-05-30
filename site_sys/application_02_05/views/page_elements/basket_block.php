    
      <span <?if($_SESSION['basket_data']['count']>0){?>style="  background: url('/i/basket_full.png')"<?}else{?>style="   background: url('/i/basket.png')"<?}?> class="basket_ico"></span>
      <?if($_SESSION['basket_data']['count']>0){?>
    <span class="basket_link">В корзине <b><?=sizeof($_SESSION['basket'])?> артикулов</b> и</span>
    <div style="clear: both;"></div>
    <a   class="basket_link" href="/basket" title=" товаров на <?=$_SESSION['basket_data']['sum']?> <?=$_SESSION['basket_data']['val']?>.">
        <span  >
            <span><?=$_SESSION['basket_data']['count']?></span> товаров на <span><?=$_SESSION['basket_data']['sum']?></span>  <?=$_SESSION['basket_data']['val']?>.
        </span>
    </a>
    <?}else{?>
     <span class="basket_link">В корзине нет товаров 
    <?}?>




