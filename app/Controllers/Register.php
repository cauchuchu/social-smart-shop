<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\ShopModel;

class Register extends BaseController
{
    public function index()
    {
        $title = 'Đăng ký tài khoản';
        $login = 'register';
        $flasherror = session()->getFlashdata('error');
        // return view('welcome_message', ['title' => 'Welcome to CI 4']);
        return $this->smartyDisplay(
            view: 'templates/register',
            params: compact('title', 'login', 'flasherror')
        );
    }

    public function new()
    {
        if ($this->request->getPost('shop_name')) {
            // kiểm tra xem sđt đã đăng ký tk mấy lần rồi
            $employeeModel = new EmployeeModel();
            $requestConditions = [
                'mobile' => $this->request->getPost('mobile')
            ];

            $employees = $employeeModel->getEmployeesByConditions($requestConditions);
            if ($employees) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Số điện thoại ' . $this->request->getPost('mobile') . ' đã được sử dụng!'
                ]);
            }
            $shopData = [
                'shop_name'    => $this->request->getPost('shop_name'),
                'package_id' => 1,
            ];

            $shopModel = new ShopModel();
            $shopId = $shopModel->createShop($shopData);
            if ($shopId) {
                $name = $this->request->getPost('name');
                $mobile = $this->request->getPost('mobile');
                $password = $this->request->getPost('password');
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $data = [
                    'mobile'     => $mobile,
                    'full_name' => $name,
                    'password'    => $hashedPassword,
                    'role_id'    => 1,
                    'shop_id'  => $shopId,
                    'status'  => 1,
                ];
                // Gọi model và lưu dữ liệu
                $employeeModel = new EmployeeModel();
                $eId =  $employeeModel->createEmployee($data);
                if ($eId) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Tạo tài khoản thành công!'
                    ]);
                }
            }
        }
    }
}
