<?php

namespace App\Controllers;

use App\Models\ShopModel;
class Shop extends BaseController
{
    protected $shopModel;
    public function __construct()
    {
        $this->shopModel = new ShopModel();
    }
    public function createUnit()
    {
        if ($_SESSION['role'] == '2') {
            return "permission denied";
            die;
        }
        $shopId = $_SESSION['shop_id'];
        $data = [
            'shop_id' => $shopId,
            'value'     => $this->createSlug($this->request->getPost('value')),
            'title' => $this->request->getPost('value'),
        ];
        $uId =   $this->shopModel->createShopUnit($data);
        if ($uId) {
            return $this->response->setJSON([
                'id' => $uId,
                'success' => true,
                'message' => 'Create Bill successful!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Create Bill false!'
            ]);
        }
    }

    function createSlug($input) {
        // Định nghĩa một mảng thay thế các ký tự có dấu thành không dấu
        $trans = array(
            'à' => 'a', 'á' => 'a', 'ả' => 'a', 'ã' => 'a', 'ạ' => 'a',
            'â' => 'a', 'ấ' => 'a', 'ầ' => 'a', 'ẩ' => 'a', 'ẫ' => 'a', 'ậ' => 'a',
            'ă' => 'a', 'ắ' => 'a', 'ằ' => 'a', 'ẳ' => 'a', 'ẵ' => 'a', 'ặ' => 'a',
            'è' => 'e', 'é' => 'e', 'ẻ' => 'e', 'ẽ' => 'e', 'ẹ' => 'e',
            'ê' => 'e', 'ế' => 'e', 'ề' => 'e', 'ể' => 'e', 'ễ' => 'e', 'ệ' => 'e',
            'ì' => 'i', 'í' => 'i', 'ỉ' => 'i', 'ĩ' => 'i', 'ị' => 'i',
            'ò' => 'o', 'ó' => 'o', 'ỏ' => 'o', 'õ' => 'o', 'ọ' => 'o',
            'ô' => 'o', 'ố' => 'o', 'ồ' => 'o', 'ổ' => 'o', 'ỗ' => 'o', 'ộ' => 'o',
            'ơ' => 'o', 'ớ' => 'o', 'ờ' => 'o', 'ở' => 'o', 'ỡ' => 'o', 'ợ' => 'o',
            'ù' => 'u', 'ú' => 'u', 'ủ' => 'u', 'ũ' => 'u', 'ụ' => 'u',
            'ô' => 'o', 'ồ' => 'o', 'ổ' => 'o', 'ỗ' => 'o', 'ộ' => 'o',
            'ư' => 'u', 'ứ' => 'u', 'ừ' => 'u', 'ử' => 'u', 'ữ' => 'u', 'ự' => 'u',
            'ỳ' => 'y', 'ý' => 'y', 'ỷ' => 'y', 'ỹ' => 'y', 'ỵ' => 'y',
            'đ' => 'd', 'Đ' => 'D'
        );
        
        // Thay thế tất cả các ký tự có dấu trong chuỗi bằng ký tự không dấu
        $output = strtr($input, $trans);
        
        // Xóa tất cả các khoảng trắng (space)
        $output = str_replace(' ', '', $output);
        
        return $output;
    }
}
