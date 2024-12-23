<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'sb_order';

    protected $allowedFields = ['title', 'slug', 'body'];

    public function get($slug = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }


    public function updateAssignedEmpDelete($EmpId){
        $shop_id = $_SESSION['shop_id'];
        $shop_admin = $this->where('shop_id', $shop_id)->where('role_id', 1)->first();

        if($this->where(['assigned' => $EmpId])->first()){
            // update assgined to null
            $data = [
                'assigned' => $shop_admin['id'],  
            ];
            
            // Cập nhật tất cả các bản ghi trong bảng
            $updated = $this->where('shop_id', $shop_id)->where('assigned', $EmpId)->set($data)->update();
            if ($updated) {
                return true;
            } else {
                return false;
            }
        }
    }
}
