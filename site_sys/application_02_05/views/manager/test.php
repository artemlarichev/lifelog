<?php

class Test extends Controller {
    public function Controller() {
        parent::Controller();
    }
    
    public function index() {
        $data['name'] = "VASYA";
        $this->load->view('user/test', $data);
    }
}