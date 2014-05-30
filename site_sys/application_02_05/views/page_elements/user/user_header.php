<?php
if(!isset($_SESSION['action'])) $action = "";
if(isset($_SESSION['user'])) $this->load->view('page_elements/manager_menu');
?>