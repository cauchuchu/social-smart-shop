<?php

namespace App\Controllers;

use App\Models\InputGoodsModel;
use App\Models\OrderModel;

class Income extends BaseController
{
    protected $inputGoodsModel;
    public function __construct()
    {
        // Khởi tạo đối tượng EmployeeModel
        $this->inputGoodsModel = new InputGoodsModel();
    }
    public function index()
    {
        $title = 'Phiếu nhập hàng';
        // get list nhan vien 
        $shopId = $_SESSION['shop_id'];
        if ($_SESSION['role'] == '2') {
            return "permission denied";
            die;
        }
        $roleadmin = $_SESSION['role'];

        $page = isset($_GET['page']) ? (int)$_GET['page'] : null;
        $name = isset($_GET['name']) ? (int)$_GET['name'] : null;
        $mobile = isset($_GET['mobile']) ? (int)$_GET['mobile'] : null;
        $requestConditions = [
            'shop_id' => $shopId,
            'page' => $page,
            'full_name' => $name,
            'mobile' => $mobile,
        ];

        $resutl =  $this->inputGoodsModel->getEmployeesList($requestConditions);
        $list_employee = $resutl['data'];
 
        // return view('welcome_message', ['title' => 'Welcome to CI 4']);
        return $this->smartyDisplay(
            view: 'templates/employee',
            params: compact('title', 'list_employee', 'roleadmin')
        );
    }

    public function add()
    {
        $title = 'Thêm phiếu nhập hàng';
        return $this->smartyDisplay(
            view: 'templates/income_add',
            params: compact('title')
        );
    }

    public function createEmployee()
    {
      
        if ($_SESSION['role'] == '2') {
            return "permission denied";
            die;
        }
        // kiểm tra xem sđt đã đăng ký tk mấy lần trong shop nay rồi
        $shop_id = $_SESSION['shop_id'];
        $requestConditions = [
            'mobile' => $this->request->getPost('mobile'),
            'shop_id' => $shop_id
        ];

        $employees =  $this->employeeModel->getEmployeesByConditions($requestConditions);
        if ($employees) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Số điện thoại đã được sử dụng!'
            ]);
        }
        // Xử lý ảnh upload
        $imageFile = $this->request->getFile('avatar');
     
        $imageUrl = ''; // Khởi tạo biến chứa URL ảnh

        if ($imageFile) {
            $imageUrl = ''; // Khởi tạo biến chứa URL ảnh
            $imageName = $imageFile->getName(); // Lấy tên gốc của file ảnh

            $uploadPath = FCPATH . 'assets/img/img_' . $shop_id . '/'; 

            // Kiểm tra nếu thư mục chưa tồn tại thì tạo nó
            if (!is_dir($uploadPath)) {
                // Tạo thư mục nếu chưa tồn tại
                mkdir($uploadPath, 0777, true); // - 0777: cấp quyền đọc/ghi cho tất cả mọi người, true để tạo tất cả các thư mục con
            }

            // Kiểm tra nếu file đã tồn tại trong thư mục
            if (!file_exists($uploadPath . $imageName)) {
                // Di chuyển file vào thư mục lưu trữ
                $imageFile->move($uploadPath, $imageName);
            }
            // URL của ảnh sau khi upload
            $imageUrl = 'assets/img/img_' . $shop_id . '/' . $imageName;
        }

        $name = $this->request->getPost('full_name');
        $mobile = $this->request->getPost('mobile');
        $password = $this->request->getPost('password');
        $role_id = $this->request->getPost('role_id');
        $status = $this->request->getPost('status');
        $description = $this->request->getPost('description');
        $price_pay = str_replace(",", "", $this->request->getPost('price_pay'));
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $data = [
            'mobile'     => $mobile,
            'full_name' => $name,
            'password'    => $hashedPassword,
            'role_id'    => $role_id,
            'status'    => $status,
            'shop_id'  => $shop_id,
            'description'  => $description,
            'price_pay'  => $price_pay,
            'avatar'  => $imageUrl,
        ];

        // Gọi model và lưu dữ liệu
        $eId =   $this->employeeModel->createEmployee($data);
        if ($eId) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Create employee successful!'
            ]);
        }
    }

    public function detailEmployee()
    {
        $title = 'Chi tiết nhân viên';
        $id = $this->request->getGet('id');
        if (!$id) {
            return "Dữ liệu không hợp lệ hoặc đã bị xóa!";
            die;
        }

        // Sử dụng phương thức find để lấy nhân viên theo ID
        $employee =  $this->employeeModel->find($id);

        if (!$employee) {
            return "Dữ liệu không hợp lệ hoặc đã bị xóa!";
        }

        return $this->smartyDisplay(
            view: 'templates/employee_detail',
            params: compact('title', 'employee')
        );
    }

    public function deleteEmployee()
    {
        if ($_SESSION['role'] == '2') {
            return "permission denied";
            die;
        }
        $id = $this->request->getPost('id');
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ!'
            ]);
        }
        
        $employee =  $this->employeeModel->find($id);
       
        if (!$employee) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ hoặc đã bị xóa!'
            ]);
        }
        // delete in sb_employee
       
        $del =  $this->employeeModel->delete($id);
       
        if ($del) {
            // add assigned to admin shop in sb_order

            $order_model = new OrderModel();
            $rmAssigned = $order_model->updateAssignedEmpDelete($id);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Delete employee successful!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Delete employee Error!'
            ]);
        }
    }

    public function edit()
    {
        $title = 'Chỉnh sửa nhân viên';
        $id = $this->request->getGet('id');
        if (!$id) {
            return "Dữ liệu không hợp lệ hoặc đã bị xóa!";
            die;
        }

        // Sử dụng phương thức find để lấy nhân viên theo ID
        $employee =  $this->employeeModel->find($id);
        if (!$employee) {
            return "Dữ liệu không hợp lệ hoặc đã bị xóa!";
        }
        return $this->smartyDisplay(
            view: 'templates/employee_edit',
            params: compact('title', 'employee')
        );
    }

    public function updateEmployee()
    {
        if ($_SESSION['role'] == '2') {
            return "permission denied";
            die;
        }

        $id = $this->request->getPost('id');
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ hoặc đã bị xóa!'
            ]);
        }
        $shop_id = $_SESSION['shop_id'];
        $requestConditions = [
            'mobile' => $this->request->getPost('mobile'),
            'shop_id' => $shop_id
        ];
       
        $employees = $this->employeeModel->getEmployeesByConditions($requestConditions);

        if($employees[0]['mobile'] != $this->request->getPost('mobile')){
            if ($employees) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Số điện thoại ' . $this->request->getPost('mobile') . ' đã được sử dụng!'
                ]);
            }
        }
        
        // Xử lý ảnh upload
        $imageFile = $this->request->getFile('avatar');

        if ($imageFile) {
            $imageUrl = ''; // Khởi tạo biến chứa URL ảnh
            $imageName = $imageFile->getName(); // Lấy tên gốc của file ảnh

            $uploadPath = FCPATH . 'assets/img/img_' . $shop_id . '/'; 

            // Kiểm tra nếu thư mục chưa tồn tại thì tạo nó
            if (!is_dir($uploadPath)) {
                // Tạo thư mục nếu chưa tồn tại
                mkdir($uploadPath, 0777, true); // - 0777: cấp quyền đọc/ghi cho tất cả mọi người, true để tạo tất cả các thư mục con
            }

            // Kiểm tra nếu file đã tồn tại trong thư mục
            if (!file_exists($uploadPath . $imageName)) {
                // Di chuyển file vào thư mục lưu trữ
                $imageFile->move($uploadPath, $imageName);
            }
            // URL của ảnh sau khi upload
            $imageUrl = 'assets/img/img_' . $shop_id . '/' . $imageName;
        }
       
        $name = $this->request->getPost('full_name');
        $role = $this->request->getPost('role_id');
        $status = $this->request->getPost('status');
        $description = $this->request->getPost('description');
        $price_pay = $numberWithoutCommas = str_replace(",", "", $this->request->getPost('price_pay'));
        $mobile = $this->request->getPost('mobile');
        $id = $this->request->getPost('id');
        $data = [
            'full_name' => $name,
            'role_id' => $role,
            'status' => $status,
            'mobile' => $mobile,
        ];
        if ($description) {
            $data['description'] = $description;
        }
        if ($price_pay) {
            $data['price_pay'] = $price_pay;
        }
        if ($imageFile) {
            $data['avatar'] = $imageUrl;
        }
        $up = $this->employeeModel->update($id, $data);
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Update employee successful!'
        ]);
    }
}
