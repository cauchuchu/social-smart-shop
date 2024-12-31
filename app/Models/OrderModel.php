<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'sb_orders';

    protected $allowedFields = ['order_name', 'customer_id', 'status_delivery'];

    // public function get($slug = false)
    // {
    //     if ($slug === false) {
    //         return $this->findAll();
    //     }

    //     return $this->where(['slug' => $slug])->first();
    // }


    public function updateAssignedEmpDelete($EmpId){
       
        $shop_id = $_SESSION['shop_id'];
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM sb_employee WHERE shop_id = ? AND role_id = ?", [$shop_id, 1]);
        $shop_admin = $query->getRow();
        if($this->where(['assigned' => $EmpId])->first()){
            // update assgined to null
            $data = [
                'assigned' =>  $shop_admin->id,  
            ];
            
            $builder = $this->builder();

            $updated = $builder->where('shop_id', $shop_id)
            ->where('assigned', $EmpId)
            ->set($data)
            ->update();
            if ($updated) {
                return true;
            } else {
                return false;
            }
        }
    }
}
