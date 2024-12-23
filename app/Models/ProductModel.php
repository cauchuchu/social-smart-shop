<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

class ProductModel extends Model
{
    protected $table = 'sb_products'; 
    protected $primaryKey = 'id';

    protected $allowedFields = ['product_name','status', 'image','unit','price'];


    public function getProductList(array $conditions = [])
    {
        $builder = $this->db->table($this->table);
        // Áp dụng các điều kiện nếu tồn tại
        if (!empty($conditions['product_name'])) {
            $builder->like('product_name', $conditions['product_name']);
        }
        if (!empty($conditions['shop_id'])) {
            $builder->where('shop_id', $conditions['shop_id']);
        }
        if (!empty($conditions['status'])) {
            $builder->where('status', $conditions['status']);
        }
        // Tìm kiếm theo khoảng thời gian của created_at
        if (!empty($conditions['from_date']) && !empty($conditions['to_date'])) {
            $builder->whereBetween('created_at', [$conditions['from_date'], $conditions['to_date']]);
        } 
        if (!empty($conditions['from_date']) && empty($conditions['to_date'])) {
            $builder->where('created_at >=', $conditions['created_at_from']);
        } 
        if (empty($conditions['from_date']) && !empty($conditions['to_date'])) {
            $builder->where('created_at <=', $conditions['created_at_to']);
        }

        $limit = 20;
        $page = 1;
        if(!empty($conditions['page'])){
        $page = $conditions['page'];
        }
        $builder->paginate($limit, 'default', $page);

        // Trả về kết quả phân trang
        return $builder->paginate($limit, 'default', $page);
    }


    public function CheckExistProductByName(array $conditions = [])
    {
        $builder = $this->db->table($this->table);
        // Áp dụng các điều kiện nếu tồn tại
        if (!empty($conditions['product_name'])) {
            $$builder->where('product_name', $conditions['product_name']);
        }
        if (!empty($conditions['shop_id'])) {
            $builder->where('shop_id', $conditions['shop_id']);
        }
        
        $limit = 20;
        $page = 1;
        if(!empty($conditions['page'])){
        $page = $conditions['page'];
        }
        $builder->paginate($limit, 'default', $page);

        // Trả về kết quả phân trang
        return $builder->paginate($limit, 'default', $page);
    }

    /**
     * Hàm thêm mới sp
     *
     * @param array $data 
     * @return int|bool ID 
     */
    public function createProduct(array $data)
    {
        $data['created_at'] = date("Y-m-d H:i:s");
        // Kiểm tra dữ liệu hợp lệ
        if ($this->insert($data)) {
            return $this->getInsertID();
        }
        return false;
    }

    


}
