<?php

class Pages extends Controller{
    public function __construct(){
        
    }

    public function index(){


        $data = [
            'title' => 'Welcome',
        ];

        // Because we call the function view from Controller
        // there will make require_once
        // the last thing is that we pass $data
        $this->view('pages/index', $data);
    }

    public function about(){
        $data = [
            'title' => 'About us',
        ];

        $this->view('pages/about', $data);
    }
}