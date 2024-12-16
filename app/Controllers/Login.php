<?php

namespace App\Controllers;
use App\Models\EmployeeModel;   
use App\Models\ShopModel;
use CodeIgniter\Database\Config;
use Config\Database;
class Login extends BaseController
{
    public function index()
    {
        $title = 'Đăng nhập';
        $login = 'register';
        $flasherror = session()->getFlashdata('error');   
        // return view('welcome_message', ['title' => 'Welcome to CI 4']);
        return $this->smartyDisplay(
            view: 'templates/login',
            params: compact('title','login','flasherror')
        );
    } 


    public function checkLogin()
    {
        // Lấy dữ liệu từ Ajax
        $mobile = $this->request->getPost('mobile');
        $password = $this->request->getPost('password');

        // Giả sử bạn kiểm tra với database
        $EmployeeModel = new EmployeeModel();
        $user = $EmployeeModel->where('mobile', $mobile)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Đăng nhập thành công
            $session = session();
            $session->set([
                'isLoggedIn' => true,
                'userId' => $user['id'],
                'username' => $user['mobile'],
                'role' => $user['role_id'], 
                'shop_id' => $user['shop_id'], 
            ]);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Login successful!'
            ]);
        } else {
            // Đăng nhập thất bại
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Số điện thoại hoặc mật khẩu chưa đúng!'
            ]);
        }
    }
    
}
