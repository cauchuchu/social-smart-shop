<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\EmployeeModel;
use App\Models\ShopModel;
use App\Models\OrderModel;
use App\Models\OrderDetailModel;
use App\Models\CustomerModel;

class Order extends BaseController
{
    protected $orderModel;
    protected $employeeModel;
    protected $shopModel;
    protected $productModel;
    protected $customerModel;
    protected $orderDetailModel;
    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->employeeModel = new EmployeeModel();
        $this->shopModel = new ShopModel();
        $this->productModel = new ProductModel();
        $this->customerModel = new CustomerModel();
        $this->orderDetailModel = new OrderDetailModel();
    }
    public function index()
    {
        $title = 'Đơn hàng';
        $requestConditions = [
            'shop_id' =>$_SESSION['shop_id'],
            'status' => 1
        ];
        $listEmplOn =  $this->employeeModel->getEmployeesList($requestConditions);
        if($listEmplOn){
            $employeeList = $listEmplOn['data'];
        }
        
        return $this->smartyDisplay(
            view: 'templates/order',
            params: compact('title','employeeList')
        );
    }

    public function list()
    {
        $params = [
            'shop_id' => $_SESSION['shop_id'],
            'draw' => $this->request->getGet('draw'),
            'start' => $this->request->getGet('start'),
            'length' => $this->request->getGet('length')
        ];
        if($this->request->getGet('from_date')){
            $params['from_date'] = date('Y-m-d 00:00:00', strtotime($this->request->getGet('from_date')));
        }
        if($this->request->getGet('to_date')){
            $params['to_date'] = date('Y-m-d 23:59:00', strtotime($this->request->getGet('to_date')));
        }
        
        $params['status'] = ORDER_ACTIVE_STATUS;
        if($this->request->getGet('status_delivery')){
            $params['status_delivery'] = $this->request->getGet('status_delivery');
        }
        if($this->request->getGet('status_payment')){
            $params['status_payment'] = $this->request->getGet('status_payment');
        }
       
        if($this->request->getGet('assigned_to')){
            $params['assigned_to'] = $this->request->getGet('assigned_to');
        }
        if($this->request->getGet('day')){
            $params['from_date'] = date('Y-m-d 00:00:00');
            $params['to_date'] = date('Y-m-d 23:59:59');
        }
        if($this->request->getGet('week')){
            $currentDate = date('Y-m-d');
            $startOfWeek = date('Y-m-d 00:00:00', strtotime('last monday', strtotime($currentDate)));
            $endOfWeek = date('Y-m-d 23:59:59', strtotime('next sunday', strtotime($currentDate)));
            $params['from_date'] = $startOfWeek;
            $params['to_date'] = $endOfWeek;
        }
        if($this->request->getGet('month')){
            $currentDate = date('Y-m-d');
            $startOfMonth = date('Y-m-01 00:00:00', strtotime($currentDate));
            $endOfMonth = date('Y-m-t 23:59:59', strtotime($currentDate));
            $params['from_date'] = $startOfMonth;
            $params['to_date'] = $endOfMonth;
        }

       
        $list =   $this->orderModel->getData($params);
        return $this->response->setJSON($list);
    }

    public function add()
    {
        $title = 'Tạo đơn hàng';
        $shopId = $_SESSION['shop_id'];
        //
        $requestConditions = [
            'shop_id' => $shopId,
            'status' => 1
        ];
        $listEmplOn =  $this->employeeModel->getEmployeesList($requestConditions);
        if($listEmplOn){
            $employeeList = $listEmplOn['data'];
        }
        //
        $paramUnit = [
            'shop_id' => $shopId
        ];
        $listUnit = $this->shopModel->getUnitByShopId($paramUnit);
        //
        $listProduct = $this->productModel->getProductShopActive($shopId);
        //
        $lastOrder = $this->orderModel->getLastIdOrder();

        return $this->smartyDisplay(
            view: 'templates/order_add',
            params: compact('title', 'employeeList', 'listUnit','listProduct','lastOrder')
        );
    }

    public function store()
    {
        if ($_SESSION['role'] == ROLE_USER) {
            return "permission denied";
            die;
        }
        $shopId = $_SESSION['shop_id'];

        $orderName = $this->request->getPost('order_name');
        $customerId = '';
        if( $this->request->getPost('customer_id') !='newC'){
            $customerId = $this->request->getPost('customer_id');
        } else {
            // add new customer
            $dataCustomer = [
                'customer_name' => $this->request->getPost('customer_name'),
                'mobile' => $this->request->getPost('mobile') ? $this->request->getPost('mobile') : '',
                'address' => $this->request->getPost('address') ? $this->request->getPost('address') : '',
                'shop_id' => $shopId,
            ];
            $customerId = $this->customerModel->createCustomer($dataCustomer);
        }
        $dateOrder = date('Y-m-d H-i:s', strtotime($this->request->getPost('date_order')));
        $assignedTo = $this->request->getPost('assigned_to');
        $totalPrice = str_replace(",", "", $this->request->getPost('total'));
        $description = $this->request->getPost('description');

        $data = [
            'shop_id' => $shopId,
            'order_name'     => $orderName,
            'date_order' => $dateOrder,
            'total'    => $totalPrice,
            'assigned_to'    => $assignedTo,
            'status_deliveri'    => $this->request->getPost('status_deliveri') ? $this->request->getPost('status_deliveri') : ORDER_STATUS_PROCESSING,
            'status_payment'    => $this->request->getPost('status_payment') ? $this->request->getPost('status_payment') : ORDER_STATUS_PAYMENT_NOTYET,
            'status'  => ORDER_ACTIVE_STATUS,
            'customerId'  => $customerId,
            'description'  => $description
        ];

        $OId = $this->orderModel->createOrder($data);
        if ($OId) {
            // add order detail
            $detail_product = json_decode(html_entity_decode($this->request->getPost('detail_product')), true);
            if($detail_product['list_detail']){
                foreach($detail_product['list_detail'] as $key=>$value){
                    $dataDetail = [
                        'product_id' => $value['product_id'],
                        'quantity' => $value['quantity'],
                        'unit' => $value['unit'],
                        'price_unit' => $value['price_unit'],
                        'order_id' => $OId,
                        'shop_id' => $shopId
                    ];
                    $this->orderDetailModel->createOrderDetail($dataDetail);
                }
            }
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Create Order successful!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Create Order false!'
            ]);
        }
    }

    public function detail()
    {
        $title = 'Chi tiết đơn hàng';
        $id = $this->request->getGet('id');
        $shopId = $_SESSION['shop_id'];
        if (!$id) {
            return "Dữ liệu không hợp lệ hoặc đã bị xóa!";
            die;
        }

        $order =  $this->orderModel->find($id);
        if (!$order) {
            return "Dữ liệu không hợp lệ hoặc đã bị xóa!";  die;
        }

        $detail_product = $this->orderDetailModel->getDetailByOrderId($id);

        $requestConditions = [
            'shop_id' => $shopId,
            'status' => 1
        ];
        $listEmplOn =  $this->employeeModel->getEmployeesList($requestConditions);
        if($listEmplOn){
            $employeeList = $listEmplOn['data'];
        }
        //
        $paramUnit = [
            'shop_id' => $shopId
        ];
        $listUnit = $this->shopModel->getUnitByShopId($paramUnit);
        $listProduct = $this->productModel->getProductShopActive($shopId);
        return $this->smartyDisplay(
            view: 'templates/order_detail',
            params: compact('title', 'order', 'employeeList', 'listUnit','productList','detail_product')
        );
    }

    public function delete()
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

        $bill =  $this->inputGoodsModel->find($id);
        if (!$bill) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ hoặc đã bị xóa!'
            ]);
        }

        $del =  $this->inputGoodsModel->delete($id);

        if ($del) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Delete successful!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Delete Error!'
            ]);
        }
    }

    public function edit()
    {
        $title = 'Chỉnh sửa đơn hàng';
        $id = $this->request->getGet('id');
        $shopId = $_SESSION['shop_id'];
        if (!$id) {
            return "Dữ liệu không hợp lệ hoặc đã bị xóa!";
            die;
        }

        $order =  $this->orderModel->find($id);
        if (!$order) {
            return "Dữ liệu không hợp lệ hoặc đã bị xóa!";  die;
        }

        $detail_product = $this->orderDetailModel->getDetailByOrderId($id);

        $requestConditions = [
            'shop_id' => $shopId,
            'status' => 1
        ];
        $listEmplOn =  $this->employeeModel->getEmployeesList($requestConditions);
        if($listEmplOn){
            $employeeList = $listEmplOn['data'];
        }
        //
        $paramUnit = [
            'shop_id' => $shopId
        ];
        $listUnit = $this->shopModel->getUnitByShopId($paramUnit);
        $productList = $this->productModel->getProductShopActive($shopId);
        return $this->smartyDisplay(
            view: 'templates/order_edit',
            params: compact('title', 'order', 'employeeList', 'listUnit','productList','detail_product')
        );
    }

    public function update()
    {
        if ($_SESSION['role'] == ROLE_USER) {
            return "permission denied";
            die;
        }
        $shopId = $_SESSION['shop_id'];
        $id = $this->request->getPost('id');
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ hoặc đã bị xóa!'
            ]);
        }
        $customerId = '';
        if( $this->request->getPost('customer_id') !='newC'){
            $customerId = $this->request->getPost('customer_id');
        } else {
            // add new customer
            $dataCustomer = [
                'customer_name' => $this->request->getPost('customer_name'),
                'mobile' => $this->request->getPost('mobile') ? $this->request->getPost('mobile') : '',
                'address' => $this->request->getPost('address') ? $this->request->getPost('address') : '',
                'shop_id' => $shopId,
            ];
            $customerId = $this->customerModel->createCustomer($dataCustomer);
        }
        $dateOrder = date('Y-m-d H-i:s', strtotime($this->request->getPost('date_order')));
        $assignedTo = $this->request->getPost('assigned_to');
        $totalPrice = str_replace(",", "", $this->request->getPost('total'));
        $description = $this->request->getPost('description');

        $data = [
            'date_order' => $dateOrder,
            'total'    => $totalPrice,
            'assigned_to'    => $assignedTo,
            'status_deliveri'    => $this->request->getPost('status_deliveri') ? $this->request->getPost('status_deliveri') : ORDER_STATUS_PROCESSING,
            'status_payment'    => $this->request->getPost('status_payment') ? $this->request->getPost('status_payment') : ORDER_STATUS_PAYMENT_NOTYET,
            'customerId'  => $customerId,
            'description'  => $description
        ];

        $this->orderModel->update($id, $data);
        //delete
        $delDetail = $this->orderDetailModel->deleteByOrderId($id);
        if($delDetail){
            // add order detail
            $detail_product = json_decode(html_entity_decode($this->request->getPost('detail_product')), true);
            if($detail_product['list_detail']){
                foreach($detail_product['list_detail'] as $key=>$value){
                    $dataDetail = [
                        'product_id' => $value['product_id'],
                        'quantity' => $value['quantity'],
                        'unit' => $value['unit'],
                        'price_unit' => $value['price_unit'],
                        'order_id' => $id,
                        'shop_id' => $shopId
                    ];
                    $this->orderDetailModel->createOrderDetail($dataDetail);
                }
            }
        }
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Update order successful!'
        ]);
    }

    
}
