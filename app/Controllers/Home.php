<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $title = 'Trang chủ';

        // return view('welcome_message', ['title' => 'Welcome to CI 4']);
        $flashSuccess = session()->getFlashdata('success');
        $flasherror = session()->getFlashdata('error');
        $flashwarning = session()->getFlashdata('warning');
        return $this->smartyDisplay(
            view: 'templates/home',
            params: compact('title','flashSuccess','flasherror','flashwarning')
        );
    } 
}
