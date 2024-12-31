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
            params: compact('title', 'login', 'flasherror')
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
            if ($user['status'] == 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Tài khoản đã tạm ngừng hoạt động, vui lòng liên hệ chủ shop!'
                ]);
            }
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $data['login_time'] = date('Y-m-d H:i:s');
            $up = $EmployeeModel->update($user['id'], $data);
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

    public function logout()
    {
        session_start();
        // Xóa tất cả các biến session
        $_SESSION = [];
        session_unset();
        // Hủy session
        session_destroy();
        // Xóa cookie session (nếu có)
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }

        return redirect()->to('/SmartShop/public/signin');  // Chuyển hướng đến trang đăng nhập
    }
}
