<?php

namespace App\Controllers;
use App\Models\EmployeeModel;   
use App\Models\OrderModel;
class Employee extends BaseController
{
    protected $employeeModel;
    public function __construct()
    {
        // Khởi tạo đối tượng EmployeeModel
        $this->employeeModel = new EmployeeModel();
    }
    public function index()
    {
        $title = 'Nhân viên'; 
        // get list nhan vien 
        $shopId = $_SESSION['shop_id'];
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

        $resutl =  $this->employeeModel->getEmployeesList($requestConditions);
        $list_employee = $resutl['data'];

        // var_dump($list_employee[0]);die;
        // return view('welcome_message', ['title' => 'Welcome to CI 4']);
        return $this->smartyDisplay(
            view: 'templates/employee',
            params: compact('title','list_employee','roleadmin')
        );
    } 

    public function add(){
        $title = 'Thêm nhân viên'; 
        return $this->smartyDisplay(
            view: 'templates/employee_add',
            params: compact('title')
        );
    }

    public function createEmployee(){
        if($_SESSION['role'] =='2'){
            return "permission denied";die;
        }
        // kiểm tra xem sđt đã đăng ký tk mấy lần trong shop nay rồi
        $shop_id = $_SESSION['shop_id'];
        $requestConditions = [
            'mobile' => $this->request->getPost('mobile'),
            'shop_id' => $shop_id
        ];

        $employees =  $this->employeeModel->getEmployeesByConditions($requestConditions);
        if($employees){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Số điện thoại đã được sử dụng!'
            ]);
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
        ];

        // Gọi model và lưu dữ liệu
        $eId =   $this->employeeModel->createEmployee($data);
        if($eId){
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Create employee successful!'
            ]);
        }
    }

    public function detailEmployee(){
        $id = $this->request->getGet('id');
        if($id){
            return "Dữ liệu không hợp lệ hoặc đã bị xóa!";die;
        }

        // Sử dụng phương thức find để lấy nhân viên theo ID
        $employee =  $this->employeeModel->find($id);

        if (!$employee) {
            return "Dữ liệu không hợp lệ hoặc đã bị xóa!";
        }

        return $this->smartyDisplay(
            view: 'templates/employeeDetail',
            params: compact('title','employee')
        );
    }

    public function deleteEmployee(){
        $id = $this->request->getPost('id');
        if($id){
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
        if($del){
            // add assigned to admin shop in sb_order
            $order_model = new OrderModel();
            $rmAssigned = $order_model->updateAssignedEmpDelete($id);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Delete employee successful!'
            ]);
        } else{
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Delete employee Error!'
            ]);
        }
    }

    public function updateEmployee(){
        $id = $this->request->getPost('id');
        if($id){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ hoặc đã bị xóa!'
            ]);
        }

        $employee = $this->employeeModel->find($id);
        if (!$employee) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ hoặc đã bị xóa!'
            ]);
        }
        $name = $this->request->getPost('name');
        $role = $this->request->getPost('role');
        $data = [
            'full_name' => $name,
            'role_id' => $role,
        ];
        $up = $this->employeeModel->update($id,$data);
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Update employee successful!'
        ]);
    }

    // lay cac unit cua shop
    // public function getUnitByShopId(){
    //     $shopId = $_SESSION['shop_id'];
    //     $employeeUnit =  $this->employeeModel->getUnitByShopId($shopId);
    //     return $employeeUnit;
    // }
}
