<!DOCTYPE HTML>
<html lang="ru-RU">

    <?php $this->load->view('page_elements/head'); ?>
    <body class="main_page">

        <!-- Wrapper -->
        <div class="wrapper">

            <!-- Base -->
            <div class="base" id="wrapper">
                
                <?php $this->load->view('page_elements/user/user_header'); ?>
                <!-- Header -->
                <div class="header" style="background: url('/i/banners/19_3.jpg') no-repeat scroll 50% 86px transparent !important;height:280px;">

                    <!-- Header Wrap -->
                    <div class="header_wrap" style="background: url('i/banners/1_02.jpg') no-repeat scroll 50% 86px transparent; " >

                        <h1 class="logo_w"><a class="logo" href="/" title="Джапан Авто">Джапан Авто</a></h1>
                        <?php
                        if(isset($_SESSION['user'])) {
                            header('Location: /');
                        }
                        ?>
                        <!-- Login -->
                        <div id="login">
                            <?php $this->load->view('page_elements/login_box'); ?>
                        </div><!-- End Login -->
                        <!-- Telephone -->
                        <div class="tel">
                            <span>(044)</span> 540-51-08, 540-79-55
                        </div><!-- End Telephone -->

                        <!-- Links -->
                        <ul class="list_link">
                            <li><a href="/shops" title="Наши магазины">Наши магазины</a></li>
                            <li><a href="/order" title="Заказ и доставка">Заказ и доставка</a></li>
                        </ul><!-- End Links -->


                        <div style="clear: both;"></div> 



                    </div><!-- End Header Wrap -->

                </div><!-- End Header -->

                <!-- Registration Block -->
                <div class="reg_block">
                    <?php $this->load->view('page_elements/user/recover_box'); ?>
                </div>
                <!-- End Registration Block -->
                <!-- Footer -->
                <div class="footer">
                    <div class="footer_wrap">
                        <div class="footer_wrap_wrap">
                            <!-- I.UA counter -->
                            <a  href="http://www.i.ua/" target="_blank" onclick="this.href = 'http://i.ua/r.php?24073';" title="Rated by I.UA">
                            </a><!-- End of I.UA counter -->

                            <div class="copyright">
                                <span class="rights">Все права принадлежат «<a href="/" title="Джапан Авто">Джапан
                                        Авто</a>»</span>
                            </div>
                            <div class="developer">
                                Сделано в <a href="http://trikoz.com" title="Студии Максима Трикоза">Студии Максима Трикоза</a>
                            </div>
                        </div>
                    </div>
                </div><!-- End Footer -->

                <!-- Modal Dialog -->
                <div id="modal_dialog" style="display:none; cursor: default" class="dialog">
                    <div class="dialog_title_bar"></div>

                    <div class="dialog_pane">
                        <div>Подождите  ...</div>
                        <div style="margin-top: 10px;">
                            <img src='/i/ajax.gif'>
                        </div>
                    </div>
                </div><!-- End Modal Dialog -->

            </div><!-- End Base -->

        </div><!-- End Wrapper -->

    </body>
</html>