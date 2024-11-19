<?php



namespace App\Controllers;

use App\Libraries\SmartyLib;

class Home extends BaseController {
    public function index() {
    	
        $smarty = new SmartyLib();
var_dump( $smarty);die;
        $data = [
            'title' => 'Welcome to CodeIgniter with Smarty',
            'message' => 'This is a demo of Smarty integration.'
        ];
        $smarty->view('home', $data);
    }
}
