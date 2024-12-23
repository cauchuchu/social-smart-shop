<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\ShopModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Product extends BaseController
{
    protected $productModel;
    public function __construct()
    {
        // Khởi tạo đối tượng EmployeeModel
        $this->productModel = new ProductModel();
    }
    public function index()
    {
        $shopId = $_SESSION['shop_id'];
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : null;
        $name = isset($_GET['name']) ? (int)$_GET['name'] : null;
        $status = isset($_GET['status']) ? (int)$_GET['status'] : null;
        $from_date = isset($_GET['from_date']) ? (int)$_GET['from_date'] : null;
        $to_date = isset($_GET['to_date']) ? (int)$_GET['to_date'] : null;
        $requestConditions = [
            'shop_id' => $shopId,
            'page' => $page,
            'product_name' => $name,
            'status' => $status,
            'from_date' => $from_date,
            'to_date' => $to_date,
        ];
        $listProduct =  $this->productModel->getProductList($requestConditions);
        $data = [
            'listProduct'  => $listProduct,
            'title' => 'Danh sách sản phẩm'
        ];
        // return view('news/index', $data);
        return $this->smartyDisplay(
            view: 'templates/product',
            params: $data
        );
    }

    public function ProductDetail()
    {
        $id = $this->request->getGet('id');
        if($id){
            return "Dữ liệu không hợp lệ hoặc đã bị xóa!";die;
        }
        $product =  $this->productModel->find($id);
        if (!$product) {
            return "Dữ liệu không hợp lệ hoặc đã bị xóa!";
        }
        return $this->smartyDisplay(
            view: 'templates/productDetail',
            params: compact('title','product')
        );
    }

    public function create()
    {
        $shopId = $_SESSION['shop_id'];
        $shopModel = new ShopModel();
        $listUnit = $shopModel->getUnitByShopId($shopId);

        $data = [
            'title' => 'Tạo mới sản phẩm',
            'listUnit' => $listUnit
        ];
        return $this->smartyDisplay(
            view: 'templates/createProduct',
            params: $data
        );
    }

    public function store()
    {
        $shopId = $_SESSION['shop_id'];
        // Kiểm tra xem sản phẩm đã tồn tại chưa
        $requestConditions = [
            'product_name' => $this->request->getPost('product_name'),
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
            $imageName = $imageFile->getName(); // Lấy tên gốc của file ảnh

            $uploadPath = WRITEPATH . 'uploads/img_' . $shopId . '/'; // Đường dẫn đến thư mục của shop

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
            $imageUrl = '/uploads/img_' . $shopId . '/' . $imageName;
        }

        $product_name = $this->request->getPost('product_name');
        $status = $this->request->getPost('status');
        $unit = $this->request->getPost('unit');
        $price = $this->request->getPost('price');
        $description = $this->request->getPost('description');
        $data = [
            'product_name' => $product_name,
            'status' => $status,
            'unit' => $unit,
            'price' => $price,
            'description' => $description,
            'image' => $imageUrl, 
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
        if($id){
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
            view: 'templates/editProduct',
            params: $data
        );
    }

    public function update()
    {
        $id = $this->request->getGet('id');
        if($id){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ!'
            ]);
        }
        $shopId = $_SESSION['shop_id'];
        // Kiểm tra xem sản phẩm đã tồn tại chưa
        $requestConditions = [
            'product_name' => $this->request->getPost('product_name'),
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
        $imageUrl = $this->request->getPost('imageUrl');

        if($imageFile){
            $imageName = $imageFile->getName(); // Lấy tên gốc của file ảnh

            $uploadPath = WRITEPATH . 'uploads/img_' . $shopId . '/'; // Đường dẫn đến thư mục của shop

            // Kiểm tra nếu thư mục chưa tồn tại thì tạo nó
            if (!is_dir($uploadPath)) {
                // Tạo thư mục nếu chưa tồn tại
                mkdir($uploadPath, 0777, true); 
            }

            // Kiểm tra nếu file đã tồn tại trong thư mục
            if (!file_exists($uploadPath . $imageName)) {
                // Di chuyển file vào thư mục lưu trữ
                $imageFile->move($uploadPath, $imageName);
            }

            // URL của ảnh sau khi upload
            $imageUrl = '/uploads/img_' . $shopId . '/' . $imageName;
        }

        $product_name = $this->request->getPost('product_name');
        $status = $this->request->getPost('status');
        $unit = $this->request->getPost('unit');
        $price = $this->request->getPost('price');

        $data = [
            'product_name' => $product_name,
            'status' => $status,
            'unit' => $unit,
            'price' => $price,
            'image' => $imageUrl,
        ];

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
