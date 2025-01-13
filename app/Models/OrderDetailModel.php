<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderDetailModel extends Model
{
    protected $table = 'sb_order_details';

    protected $allowedFields = ['order_id', 'product_id', 'quantity','unit_price'];


    public function getDetailByOrderId($id){
        $builder = $this->db->table('sb_order_details'); 
        $builder->where('order_id', $id);
        $query = $builder->get();
        $results = $query->getResult();
        $details = [];
        foreach ($results as $item) {
            $details[] = (array) $item;
        }
        return $details;
    }
    public function createOrderDetail(array $data)
    {
        if ($this->insert($data)) {
            return $this->getInsertID();
        }
        return false;
    }
    public function deleteByOrderId($orderId) {
        $builder = $this->db->table('sb_order_details');
        $builder->where('order_id', $orderId);
        $builder->delete();
        if ($this->db->affectedRows() > 0) {
            return true; 
        }
    
        return false;
    }

}
