<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'sb_customers';

    protected $allowedFields = ['customer_name', 'mobile', 'address', 'shop_id', 'is_black','created_at'];

    /**
     * Hàm lấy thông tin
     *
     * @param array
     * @return array các bản ghi có điều kiện thỏa mãn
     */

    public function getData(array $conditions = [])
    {
        
        $builder = $this->db->table($this->table);
        $builder->select($this->table . '.*');
        $where = '';

        if (!empty($conditions['shop_id'])) {
            $builder->where(' shop_id', $conditions['shop_id']);
            $where .= ' shop_id = ' . $conditions['shop_id'] . '';
        }

        if (!empty($conditions['from_date']) && !empty($conditions['to_date'])) {
            $builder->where('created_at >=', $conditions['from_date'])
            ->where('created_at <=', $conditions['to_date']);
            $where .= ' AND created_at >= "' . $conditions['from_date'] . '" AND created_at <= "' . $conditions['to_date'] . '"';
        } elseif (!empty($conditions['from_date'])) {
            $builder->where('created_at >=', $conditions['from_date']);
            $where .= ' AND created_at >= "' . $conditions['from_date'] . '"';
        } elseif (!empty($conditions['to_date'])) {
            $builder->where('created_at <=', $conditions['to_date']);
            $where .= ' AND created_at <= "' . $conditions['to_date'] . '"';
        }
        $builder->orderBy('created_at', 'DESC');
        $limit = isset($conditions['length']) ? $conditions['length'] : 20; 
        $start = isset($conditions['start']) ? $conditions['start'] : 0; 
        $offset = $start;
        $builder->limit($limit, $offset);
        // $sql = $builder->getCompiledSelect();
        // var_dump($sql);die;
        
        $results = $builder->get()->getResult();
       
        if($results){
            foreach($results as $result){
                $result->created_at = date('d-m-Y H-i', strtotime($result->created_at));
               
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
     * Hàm thêm mới phieeus thu
     *
     * @param array $data 
     * @return int|bool Id 
     */
    public function createBill(array $data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($this->insert($data)) {
            return $this->getInsertID();
        }
        return false;
    }
}
