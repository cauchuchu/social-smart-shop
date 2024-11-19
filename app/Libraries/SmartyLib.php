<?php

namespace App\Libraries;

use Smarty;

class SmartyLib {
    protected $smarty;

    public function __construct() {
        // Đảm bảo đường dẫn đúng tới thư viện Smarty

        require_once APPPATH . 'ThirdParty/smarty/libs/Smarty.class.php'; // Đảm bảo thư mục ThirdParty và thư viện Smarty.class.php tồn tại

        $this->smarty = new Smarty();
 var_dump(345);die;
        // Thiết lập các đường dẫn thư mục cho Smarty
        $this->smarty->setTemplateDir(APPPATH . 'Views/templates');
        $this->smarty->setCompileDir(WRITEPATH . 'smarty/compiled');
        $this->smarty->setCacheDir(WRITEPATH . 'smarty/cache');
        $this->smarty->setConfigDir(APPPATH . 'Config');
        $this->smarty->caching = false;
    }

    public function view($template, $data = []) {
        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->display($template . '.tpl');
    }
}




