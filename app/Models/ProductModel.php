<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

class ProductModel extends Model
{
    protected $table = 'sb_products'; 
    protected $primaryKey = 'id';

    protected $allowedFields = ['product_name','status', 'image','unit','price','sold','description','created_at','shop_id'];

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
        $sql = "SELECT * FROM sb_products WHERE shop_id = :shop_id: AND product_name = :product_name:";

        // Thực thi truy vấn
        $query = $this->db->query($sql, [
            'shop_id' => $conditions['shop_id'],
            'product_name' => $conditions['product_name']
        ]);
        
        // Lấy kết quả
        $result =  $query->getResult();
        return $result;
    }

    public function CheckExistProductByNameById(array $conditions = [])
    {
        $sql = "SELECT * FROM sb_products WHERE id !=:id: AND shop_id = :shop_id: AND product_name = :product_name: AND status=1";
        // Thực thi truy vấn
        $query = $this->db->query($sql, [
            'id' => $conditions['id'],
            'shop_id' => $conditions['shop_id'],
            'product_name' => $conditions['product_name']
        ]);
       
        // Lấy kết quả
        $result =  $query->getResult();

        return $result;
    }

    public function getData(array $conditions = [])
    {
        
        $builder = $this->db->table($this->table);
        $builder->select($this->table . '.*');
        $where = '';

        if (!empty($conditions['shop_id'])) {
            $builder->where(' sb_products.shop_id', $conditions['shop_id']);
            $where .= ' sb_products.shop_id = ' . $conditions['shop_id'] . '';
        }

        // if (!empty($conditions['from_date']) && !empty($conditions['to_date'])) {
        //     $builder->where('date_in >=', $conditions['from_date'])
        //     ->where('date_in <=', $conditions['to_date']);
        //     $where .= ' AND date_in >= "' . $conditions['from_date'] . '" AND date_in <= "' . $conditions['to_date'] . '"';
        // } elseif (!empty($conditions['from_date'])) {
        //     $builder->where('date_in >=', $conditions['from_date']);
        //     $where .= ' AND date_in >= "' . $conditions['from_date'] . '"';
        // } elseif (!empty($conditions['to_date'])) {
        //     $builder->where('date_in <=', $conditions['to_date']);
        //     $where .= ' AND date_in <= "' . $conditions['to_date'] . '"';
        // }
        $builder->orderBy('id', 'DESC');
        $limit = isset($conditions['length']) ? $conditions['length'] : 20; 
        $start = isset($conditions['start']) ? $conditions['start'] : 0; 
        $offset = $start;
        $builder->limit($limit, $offset);
        // $sql = $builder->getCompiledSelect();
        // var_dump($sql);die;
        
        $results = $builder->get()->getResult();
       
        if($results){
            foreach($results as $result){
                $result->price =  number_format($result->price);
               
            }
        }
       
        // Lấy tổng số bản ghi để tính toán phân trang
        $total = $this->db->table($this->table)
            ->where($where)
            ->countAllResults();
        return [
            'draw' => isset($conditions['draw']) ? $conditions['draw'] : 1,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $results,
        ];
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
