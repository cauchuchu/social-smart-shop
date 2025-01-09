<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\ShopModel;

class Product extends BaseController
{
    protected $productModel;
    public function __construct()
    {
        $this->productModel = new ProductModel();
    }
    public function index()
    {
        // $shopId = $_SESSION['shop_id'];
        
        // $page = isset($_GET['page']) ? (int)$_GET['page'] : null;
        // $name = isset($_GET['name']) ? (int)$_GET['name'] : null;
        // $status = isset($_GET['status']) ? (int)$_GET['status'] : null;
        // $from_date = isset($_GET['from_date']) ? (int)$_GET['from_date'] : null;
        // $to_date = isset($_GET['to_date']) ? (int)$_GET['to_date'] : null;
        // $requestConditions = [
        //     'shop_id' => $shopId,
        //     'page' => $page,
        //     'product_name' => $name,
        //     'status' => $status,
        //     'from_date' => $from_date,
        //     'to_date' => $to_date,
        // ];
        // $listProduct =  $this->productModel->getProductList($requestConditions);
        $data = [
            'title' => 'Danh sách sản phẩm'
        ];
        // return view('news/index', $data);
        return $this->smartyDisplay(
            view: 'templates/product',
            params: $data
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
        // if($this->request->getGet('from_date')){
        //     $params['from_date'] = date('Y-m-d 00:00:00', strtotime($this->request->getGet('from_date')));
        // }
        // if($this->request->getGet('to_date')){
        //     $params['to_date'] = date('Y-m-d 23:59:00', strtotime($this->request->getGet('to_date')));
        // }
        // if($this->request->getGet('in_by')){
        //     $params['in_by'] = $this->request->getGet('in_by');
        // }
       
        $list =   $this->productModel->getData($params);
        return $this->response->setJSON($list);
    }

    public function detail()
    {
        $id = $this->request->getGet('id');
        if(!$id){
            return "Dữ liệu không hợp lệ hoặc đã bị xóa!";die;
        }
        $product =  $this->productModel->find($id);
        if (!$product) {
            return "Dữ liệu không hợp lệ hoặc đã bị xóa!";
        }
        $shopId = $_SESSION['shop_id'];
        $shopModel = new ShopModel();
        $listUnit = $shopModel->getUnitByShopId($shopId);
        $title = 'Chi tiết sản phẩm';
        return $this->smartyDisplay(
            view: 'templates/product_detail',
            params: compact('title','product','listUnit')
        );
    }

    public function add()
    {
        $shopId = $_SESSION['shop_id'];
        $shopModel = new ShopModel();
        $listUnit = $shopModel->getUnitByShopId($shopId);

        $data = [
            'title' => 'Tạo mới sản phẩm',
            'listUnit' => $listUnit
        ];
        return $this->smartyDisplay(
            view: 'templates/product_add',
            params: $data
        );
    }

    public function store()
    {
        $shopId = $_SESSION['shop_id'];
        // Kiểm tra xem sản phẩm đã tồn tại chưa
        $requestConditions = [
            'product_name' => $this->request->getPost('name'),
            'shop_id' => $shopId
        ];
        $product =  $this->productModel->CheckExistProductByName($requestConditions);
        if($product){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Đã tồn tại sản phẩm cùng tên!'
            ]);
        }

        // Xử lý ảnh upload
        $imageFile = $this->request->getFile('image');
        $imageUrl = ''; // Khởi tạo biến chứa URL ảnh
        if($imageFile){
            $imageName = $imageFile->getName();

            
            $uploadPath = FCPATH . 'assets/img/img_' . $shopId . '/'; 

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true); 
            }

            if (!file_exists($uploadPath . $imageName)) {
                $imageFile->move($uploadPath, $imageName);
            }

            // URL của ảnh sau khi upload
            $imageUrl = 'assets/img/img_' . $shopId . '/' . $imageName;
        }

        $product_name = $this->request->getPost('name');
        $status = $this->request->getPost('status');
        $unit = $this->request->getPost('unit');
        $price = str_replace(",", "", $this->request->getPost('price'));
        $description = $this->request->getPost('description');
        $data = [
            'product_name' => $product_name,
            'status' => $status,
            'unit' => $unit,
            'price' => $price,
            'shop_id' => $shopId,
            'description' => $description,
            'image' => $imageUrl, 
            'sold' => 0
        ];

        // Gọi model và lưu dữ liệu
        $PId = $this->productModel->createProduct($data);
        
        if($PId){
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Tạo sản phẩm thành công!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Có lỗi khi tạo sản phẩm!'
            ]);
        }
    }

    public function edit()
    {
        $id = $this->request->getGet('id');
        if(!$id){
            return "Dữ liệu không hợp lệ hoặc đã bị xóa!";die;
        }
        $product =  $this->productModel->find($id);
        if (!$product) {
            return "Dữ liệu không hợp lệ hoặc đã bị xóa!";
        }

        $shopId = $_SESSION['shop_id'];
        $shopModel = new ShopModel();
        $listUnit = $shopModel->getUnitByShopId($shopId);
        $data = [
            'title' => 'Chỉnh sửa sản phẩm',
            'listUnit' => $listUnit,
            'product' => $product,
        ];
        return $this->smartyDisplay(
            view: 'templates/product_edit',
            params: $data
        );
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        if(!$id){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ!'
            ]);
        }
        $shopId = $_SESSION['shop_id'];
        // Kiểm tra xem sản phẩm đã tồn tại chưa
        $requestConditions = [
            'product_name' => $this->request->getPost('name'),
            'shop_id' => $shopId,
            'id' => $id
        ];
        $product =  $this->productModel->CheckExistProductByNameById($requestConditions);
        if($product){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Đã tồn tại sản phẩm cùng tên!'
            ]);
        }

        // Xử lý ảnh upload
        $imageFile = $this->request->getFile('image');
        $imageUrl = ''; // Khởi tạo biến chứa URL ảnh
        if($imageFile){
            $imageName = $imageFile->getName();
            $uploadPath = FCPATH . 'assets/img/img_' . $shopId . '/'; 

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true); 
            }

            if (!file_exists($uploadPath . $imageName)) {
                $imageFile->move($uploadPath, $imageName);
            }

            // URL của ảnh sau khi upload
            $imageUrl = 'assets/img/img_' . $shopId . '/' . $imageName;
        }

        $product_name = $this->request->getPost('name');
        $status = $this->request->getPost('status');
        $unit = $this->request->getPost('unit');
        $price = str_replace(",", "", $this->request->getPost('price'));
        $description = $this->request->getPost('description');
        $data = [
            'product_name' => $product_name,
            'status' => $status,
            'unit' => $unit,
            'price' => $price,
            'description' => $description
        ];
        if($imageUrl){
            $data['image'] = $imageUrl;
        }

        // Gọi model và lưu dữ liệu
        $PId = $this->productModel->update($id,$data);
        
        if($PId){
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Cập nhật sản phẩm thành công!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Có lỗi khi Cập nhật sản phẩm!'
            ]);
        }
    }


    public function delete()
    {
        $id = $this->request->getPost('id');
        if($id){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ!'
            ]);
        }
        $employee =  $this->productModel->find($id);
        if (!$employee) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ hoặc đã bị xóa!'
            ]);
        }
        $del =  $this->productModel->delete($id);
        if($del){
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Delete product successful!'
            ]);
        } else{
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Delete product Error!'
            ]);
        }
    }
}
