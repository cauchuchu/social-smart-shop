<?php

namespace App\Controllers;

use App\Models\InputGoodsModel;
use App\Models\EmployeeModel;
use App\Models\ShopModel;
use App\Models\OrderModel;

class Income extends BaseController
{
    protected $inputGoodsModel;
    protected $employeeModel;
    protected $shopModel;
    public function __construct()
    {
        $this->inputGoodsModel = new InputGoodsModel();
        $this->employeeModel = new EmployeeModel();
        $this->shopModel = new ShopModel();
    }
    public function index()
    {
        $title = 'Phiếu nhập hàng';
        $requestConditions = [
            'shop_id' =>$_SESSION['shop_id'],
            'status' => 1
        ];
        $listEmplOn =  $this->employeeModel->getEmployeesList($requestConditions);
        if($listEmplOn){
            $employeeList = $listEmplOn['data'];
        }
        
        return $this->smartyDisplay(
            view: 'templates/income',
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
        if($this->request->getGet('in_by')){
            $params['in_by'] = $this->request->getGet('in_by');
        }
       
        $list =   $this->inputGoodsModel->getData($params);
        return $this->response->setJSON($list);
    }

    public function add()
    {
        $title = 'Thêm phiếu nhập hàng';
        $shopId = $_SESSION['shop_id'];
        $ranId = rand(100, 9999);
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
        return $this->smartyDisplay(
            view: 'templates/income_add',
            params: compact('title', 'employeeList', 'listUnit', 'ranId')
        );
    }

    public function store()
    {
        if ($_SESSION['role'] == '2') {
            return "permission denied";
            die;
        }
        $shopId = $_SESSION['shop_id'];
        $id_bill = $this->request->getPost('id_bill');
        $date_in = date('Y-m-d H-i:s', strtotime($this->request->getPost('date_in')));
        $detail_product = $this->request->getPost('detail_product');
        $in_by = $this->request->getPost('in_by');
        $total_in = str_replace(",", "", $this->request->getPost('total_in'));
        $description = $this->request->getPost('description');

        $data = [
            'shop_id' => $shopId,
            'id_bill'     => $id_bill,
            'date_in' => $date_in,
            'detail'    => $detail_product,
            'total'    => $total_in,
            'in_by'    => $in_by,
            'description'  => $description
        ];
        // var_dump($data);die;
        $eId =   $this->inputGoodsModel->createBill($data);
        if ($eId) {
            return $this->response->setJSON([
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

    public function detail()
    {
        $title = 'Chi tiết phiếu nhập hàng';
        $id = $this->request->getGet('id');
        $shopId = $_SESSION['shop_id'];
        if (!$id) {
            return "Dữ liệu không hợp lệ hoặc đã bị xóa!";
            die;
        }

        $bill =  $this->inputGoodsModel->find($id);
        if (!$bill) {
            return "Dữ liệu không hợp lệ hoặc đã bị xóa!";
        }
        $detail_product = json_decode(html_entity_decode($bill['detail']), true);
        $productList = $detail_product['list_detail'];
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
        return $this->smartyDisplay(
            view: 'templates/income_detail',
            params: compact('title', 'bill','employeeList','listUnit','productList')
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
        $title = 'Chỉnh sửa phiếu nhập hàng';
        $id = $this->request->getGet('id');
        $shopId = $_SESSION['shop_id'];
        if (!$id) {
            return "Dữ liệu không hợp lệ hoặc đã bị xóa!";
            die;
        }

        $bill =  $this->inputGoodsModel->find($id);
        if (!$bill) {
            return "Dữ liệu không hợp lệ hoặc đã bị xóa!";
        }
        $detail_product = json_decode(html_entity_decode($bill['detail']), true);
        $productList = $detail_product['list_detail'];
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
        return $this->smartyDisplay(
            view: 'templates/income_edit',
            params: compact('title', 'bill', 'employeeList', 'listUnit','productList')
        );
    }

    public function update()
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
        $date_in = $this->request->getPost('date_in');
        $detail = $this->request->getPost('detail');
        $in_by = $this->request->getPost('in_by');
        $total_in = str_replace(",", "", $this->request->getPost('total_in'));
        $description = $this->request->getPost('description');
        $id = $this->request->getPost('id');
        $data = [
            'date_in' => $date_in,
            'detail' => $detail,
            'in_by' => $in_by,
            'total' => $total_in,
            'description' => $description,
        ];

        $up = $this->inputGoodsModel->update($id, $data);
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Update bill successful!'
        ]);
    }
}
